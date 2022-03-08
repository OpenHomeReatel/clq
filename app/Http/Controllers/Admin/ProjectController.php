<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ProjectCsvProcess;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Owner;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller {

    use MediaUploadingTrait;

    public function index() {
        
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::with(['owner', 'media'])->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create() {
        abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::get()->pluck('fullnameID', 'id')->prepend(trans('global.pleaseSelect'), '');
        

        return view('admin.projects.create', compact('owners'));
    }

    public function store(StoreProjectRequest $request) {
        //dd($request->all());
        
        $project = Project::create($request->all());

        foreach ($request->input('files', []) as $file) {
            $project->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
        }
        if ($request->input('thumbnail', false)) {
            $project->addMedia(storage_path('tmp/uploads/' . basename($request->input('thumbnail'))))->toMediaCollection('thumbnail');
        }
        if ($request->input('property_type[]', false)) {
            $request->property_type = implode(" ",$property_type);
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $project->id]);
        }

        return redirect()->route('admin.projects.index');
    }

    public function edit(Project $project) {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::all()->pluck('fullnameID', 'id')->prepend(trans('global.pleaseSelect'), '');
       
        $project->load('owner');

        return view('admin.projects.edit', compact('owners', 'project'));
    }

    public function update(UpdateProjectRequest $request, Project $project) {
        $project->update($request->all());
        if (count($project->files) > 0) {
            foreach ($project->files as $media) {
                if (!in_array($media->file_name, $request->input('files', []))) {
                    $media->delete();
                }
            }
        }
        $media = $project->files->pluck('file_name')->toArray();
        foreach ($request->input('files', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $project->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
            }
        }
        if ($request->input('thumbnail', false)) {
            if (!$project->thumbnail || $request->input('thumbnail') !== $project->thumbnail->file_name) {
                if ($project->thumbnail) {
                    $project->thumbnail->delete();
                }
                $project->addMedia(storage_path('tmp/uploads/' . basename($request->input('thumbnail'))))->toMediaCollection('thumbnail');
            }
        } elseif ($project->thumbnail) {
            $project->thumbnail->delete();
        }

        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project) {
        abort_if(Gate::denies('project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->load('owner');

        return view('admin.projects.show', compact('project'));
    }

    public function destroy(Project $project) {
        abort_if(Gate::denies('project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request) {
        Project::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request) {
        abort_if(Gate::denies('project_create') && Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Project();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function upload_csv_records(Request $request) {
        if ($request->has('csv')) {
            $chunks = array_chunk(file($request->csv), 1000);
            $header = [];

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                dispatch(new ProjectCsvProcess($data, $header));
            }
        }

        return back();
    }

}
