@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.project.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.id') }}
                        </th>
                        <td>
                            {{ $project->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.ref') }}
                        </th>
                        <td>
                            {{ $project->ref }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.name') }}
                        </th>
                        <td>
                            {{ $project->name }}
                        </td>
                    </tr>
                   
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.community') }}
                        </th>
                        <td>
                            {{ $project->community }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.description') }}
                        </th>
                        <td>
                            {!! $project->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.developer') }}
                        </th>
                        <td>
                            {{ $project->developer }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.emirate') }}
                        </th>
                        <td>
                            {{ $project->emirate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.state') }}
                        </th>
                        <td>
                            {{ $project->state }}
                        </td>
                    </tr>
                   
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.note') }}
                        </th>
                        <td>
                            {!! $project->note !!}
                        </td>
                    </tr>
                    
                   
                    
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.title') }}
                        </th>
                        <td>
                            {{ $project->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.property_type') }}
                        </th>
                        <td>
                            {{  implode(" , ",$project->property_type) ?? '' }}
                        </td>
                    </tr>
                   
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.floor_number') }}
                        </th>
                        <td>
                            {{ $project->floor_number }}
                        </td>
                    </tr>
                    @if(!auth()->user()->isSales())
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.owner') }}
                        </th>
                        <td>
                            {{ $project->owner->salutation ?? '' }}  {{ $project->owner->firstname ?? '' }} {{ $project->owner->lastname ?? '' }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.thumbnail') }}
                        </th>
                        <td>
                            @if($project->thumbnail)
                            
                                <img src="{{ $project->thumbnail->getUrl() }}"  width="220px" height="200px">
                            
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Files
                        </th>
                        <td>
                            @foreach($project->files as $key => $media)
                            <a href="{{ $media->getUrl() }}" target="_blank">
                                {{ trans('global.view_file') }} {{$media->file_name}}
                            </a></br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection