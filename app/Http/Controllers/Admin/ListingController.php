<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ListingCsvProcess;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyListingRequest;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Models\Owner;
use App\Models\User;
use App\Models\Project;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use App\Models\Contact;
use \Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ListingController extends Controller {

    use MediaUploadingTrait;

    public function index() {
        abort_if(Gate::denies('listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listings = Listing::query()
                //->filterByAuth()
                ->with(['owner', 'user', 'project', 'media'])
                ->whereSearch(request()->all())
                ->wherePriceBetween(request()->get('pricemin'), request()->get('pricemax'))
                ->get();

        $totals_hot = Listing::where('state', 'Hot')->count();
        $totals_signature = Listing::where('state', 'Signature')->count();
        $totals_basic = Listing::where('state', 'Basic')->count();
        return view('admin.listings.index', compact('listings', 'totals_hot', 'totals_signature', 'totals_basic'));
    }

    public function create() {
        abort_if(Gate::denies('listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
             
        $owners = Owner::query()->filterByAuth()->get()->pluck('fullnameID', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::onlyListings()->get()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.listings.create', compact('owners', 'users', 'projects'));
    }

    public function store(StoreListingRequest $request) {
        $listing = Listing::create($request->all());
        foreach ($request->input('files', []) as $file) {
            $listing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
        }
        if ($request->input('thumbnail', false)) {
            $listing->addMedia(storage_path('tmp/uploads/' . basename($request->input('thumbnail'))))->toMediaCollection('thumbnail');
        }

        foreach ($request->input('images', []) as $file) {
            $listing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $listing->id]);
        }

        return redirect()->route('admin.listings.index');
    }

    public function edit(Listing $listing) {
        abort_if(!auth()->user()->canEditListing($listing), 403);

        abort_if(Gate::denies('listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::all()->pluck('fullnameID', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::onlyListings()->get()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $listing->load('owner', 'user', 'project');

        return view('admin.listings.edit', compact('owners', 'users', 'projects', 'listing'));
    }

    public function update(UpdateListingRequest $request, Listing $listing) {
        abort_if(!auth()->user()->canEditListing($listing), 403);

        $listing->update($request->all());
        if (count($listing->files) > 0) {
            foreach ($listing->files as $media) {
                if (!in_array($media->file_name, $request->input('files', []))) {
                    $media->delete();
                }
            }
        }
        $media = $listing->files->pluck('file_name')->toArray();
        foreach ($request->input('files', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $listing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
            }
        }
        if ($request->input('thumbnail', false)) {
            if (!$listing->thumbnail || $request->input('thumbnail') !== $listing->thumbnail->file_name) {
                if ($listing->thumbnail) {
                    $listing->thumbnail->delete();
                }
                $listing->addMedia(storage_path('tmp/uploads/' . basename($request->input('thumbnail'))))->toMediaCollection('thumbnail');
            }
        } elseif ($listing->thumbnail) {
            $listing->thumbnail->delete();
        }

        if (count($listing->images) > 0) {
            foreach ($listing->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $listing->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $listing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.listings.index');
    }

    public function show(Listing $listing) {
        abort_if(Gate::denies('listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listing->load('owner', 'user', 'project');

        return view('admin.listings.show', compact('listing'));
    }

    public function destroy(Listing $listing) {
        abort_if(!auth()->user()->canDeleteListing($listing), 403);

        abort_if(Gate::denies('listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$image_path = public_path($listing->thumbnail->absolute_path);
        //if (File::exists($image_path)) {
        //   File::delete($image_path);
        //}
        $listing->delete();
        return back();
    }

    public function massDestroy(MassDestroyListingRequest $request) {
        Listing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request) {
        abort_if(Gate::denies('listing_create') && Gate::denies('listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Listing();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function upload_csv_records(Request $request) {
        $request->validate([
            'csv' => 'required|mimes:csv,txt',
        ]);

        if ($request->has('csv')) {
            $chunks = array_chunk(file($request->csv), 1000);
            $header = [];
            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                dispatch(new ListingCsvProcess($data, $header));
            }
        }

        return back();
    }

    public function exportPdf(Listing $listing) {
        abort_if(Gate::denies('listing_export_pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listing->load('owner', 'user', 'project');

        return PDF::loadView('admin.listings.pdf', compact('listing'))->download("listing_$listing->ref.pdf");
    }

}
