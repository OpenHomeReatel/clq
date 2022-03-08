<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFollowupRequest;
use App\Http\Requests\StoreFollowupRequest;
use App\Http\Requests\UpdateFollowupRequest;
use App\Models\Contact;
use App\Models\Followup;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FollowupController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('followup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followups = Followup::with(['contact'])->get();

        return view('admin.followups.index', compact('followups'));
    }

    public function create($contactId = null)
    {
        abort_if(Gate::denies('followup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacts = Contact::all()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.followups.create', compact('contacts', 'contactId'));
    }

    public function store(StoreFollowupRequest $request)
    {
        $followup = Followup::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $followup->id]);
        }

        return redirect()->route('admin.contacts.index');
    }

    public function edit(Followup $followup)
    {
        abort_if(Gate::denies('followup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacts = Contact::pluck('firstname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followup->load('contact');

        return view('admin.followups.edit', compact('contacts', 'followup'));
    }

    public function update(UpdateFollowupRequest $request, Followup $followup)
    {
        $followup->update($request->all());

        return redirect()->route('admin.followups.index');
    }

    public function show(Followup $followup)
    {
        abort_if(Gate::denies('followup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followup->load('contact');

        return view('admin.followups.show', compact('followup'));
    }

    public function destroy(Followup $followup)
    {
        abort_if(Gate::denies('followup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followup->delete();

        return back();
    }

    public function massDestroy(MassDestroyFollowupRequest $request)
    {
        Followup::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('followup_create') && Gate::denies('followup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Followup();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}