<?php

namespace App\Http\Controllers\Admin;
use App\Jobs\OwnerCsvProcess;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOwnerRequest;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Owner;
use App\Models\User;
use App\Models\Project;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OwnerController extends Controller {
  use MediaUploadingTrait;
    public function index() {
        abort_if(Gate::denies('owner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $owners = Owner::query()
                ->filterByAuth()
                ->with(['assign'])
                ->get();
        $users = User::all();
        return view('admin.owners.index', compact('owners', 'users'));
    }

    public function create() {
        abort_if(Gate::denies('owner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assigns = User::onlyListings()->get()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $projects = Project::pluck('title', 'id');
        return view('admin.owners.create', compact('assigns','projects'));
    }

    public function store(StoreOwnerRequest $request) {

        $owner = Owner::create($request->all());
        foreach ($request->input('files', []) as $file) {
            $owner->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
        }
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $owner->id]);
        }
         if ($request->input('projects[]', false)) {
            $request->projects = implode(" ",$projects);
        }
        return redirect()->route('admin.owners.index');
    }

    public function edit(Owner $owner) {
        abort_if(Gate::denies('owner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assigns = User::onlyListings()->get()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owner->load('assign');
        $projects = Project::pluck('title', 'id');
        return view('admin.owners.create', compact('assigns','projects','owner'));
    }

    public function update(UpdateOwnerRequest $request, Owner $owner) {
        $owner->update($request->all());

        if (count($owner->files) > 0) {
            foreach ($owner->files as $media) {
                if (!in_array($media->file_name, $request->input('files', []))) {
                    $media->delete();
                }
            }
        }
        $media = $owner->files->pluck('file_name')->toArray();
        foreach ($request->input('files', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $owner->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
            }
        }
        if ($request->input('projects[]', false)) {
            $request->projects = implode(" ",$projects);
        }
        return redirect()->route('admin.owners.index');
    }

    public function show(Owner $owner) {
        abort_if(Gate::denies('owner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owner->load('assign', 'listings');

        return view('admin.owners.show', compact('owner'));
    }

    public function destroy(Owner $owner) {
        abort_if(Gate::denies('owner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owner->delete();

        return back();
    }

    public function massDestroy(MassDestroyOwnerRequest $request) {
        Owner::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function upload_csv_records(Request $request) {
         
       if ($request->has('csv')) {
            $chunks = array_chunk(file($request->csv), 100);
            $header = [];

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                
                dispatch(new OwnerCsvProcess($data, $header));
            }
        }

        return back();
       
    }
    public function multi_update(UpdateOwnerRequest $request, Owner $owner){
         abort_if(
            !auth()->user()->canManageOwner($owner) || Gate::denies('owner_edit'), 
            Response::HTTP_FORBIDDEN, 
            '403 Forbidden'
        );
        if (is_array(request('item'))){
            
            foreach(request('item')as $owner->id){
              $person_update= Owner::find($owner->id);
              $person_update->assign_id= $request->user_id;
              $person_update->save();
            }
        }
    }

    public function massAssignUser(Request $request)
    {
        if($selectedOwnersIds = explode(',', $request->input('selected_owners_id'))) {
            Owner::whereIn('id', $selectedOwnersIds)->update([
                'assign_id' => $request->input('user_id')
            ]);
        }

        return back();
    }

}
