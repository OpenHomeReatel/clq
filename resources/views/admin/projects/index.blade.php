@extends('layouts.admin')
@section('content')

<div style="margin-bottom: 10px;" class="row">
    @can('project_create')
    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="{{ route('admin.projects.create') }}"><i class="fas fa-plus"></i>
            {{ trans('global.add') }} {{ trans('cruds.project.title_singular') }}
        </a>
    </div>
   @if(!auth()->user()->isSales() && !auth()->user()->isListings())
    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="{{ route('admin.exports.csv.projects') }}">
            Export CSV <i class="fas fa-download"></i>
        </a>
    </div>

    <div class="col-lg-4">

        <button type="button" class="btn-import form-control" data-toggle="modal" data-target="#exampleModal">
            Import Projects <i class="fas fa-upload"></i>
        </button>  

    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <form action="{{ url('admin/import/projects') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv">
                        <input type="submit" value="submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-triangle"></i>

                        Please make sure that the file you wish to import from matches with the schema !
                        <br>
                        Download the csv schema from
                        <a href="{{asset('schema-import/projects schema.csv')}}">Here!</a>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>

@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.project.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Project">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.project.fields.thumbnail') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.ref') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.name') }}
                        </th>
                        
                        <th>
                            {{ trans('cruds.project.fields.community') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.developer') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.emirate') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.state') }}
                        </th>
                        
                        <th>
                            {{ trans('cruds.project.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.property_type') }}
                        </th>
                       
                        
                         @if(!auth()->user()->isSales())
                        <th>
                            {{ trans('cruds.project.fields.owner') }}
                        </th>
                        @endif
                        

                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $key => $project)
                    <tr data-entry-id="{{ $project->id }}">
                        <td>

                        </td>
                        <td>
                            @if($project->thumbnail)
                            <a href="{{ $project->thumbnail->getUrl() }}" target="_blank" style="display: inline-block">
                                <img src="{{ $project->thumbnail->getUrl() }}" width="120px" height="100px" alt="image">
                            </a>
                            @endif
                        </td>
                        <td>
                            {{ $project->id ?? '' }}
                        </td>
                        <td>
                            {{ $project->ref ?? '' }}
                        </td>
                        <td>
                            {{ $project->name ?? '' }}
                        </td>
                        
                        
                        <td>
                            {{ $project->community ?? '' }}
                        </td>
                        <td class="description">
                            {{ $project->description }}
                        </td>
                        <td>
                            {{ $project->developer ?? '' }}
                        </td>
                        <td>
                            {{ $project->emirate ?? '' }}
                        </td>
                        <td>
                            {{ $project->state ?? '' }}
                        </td>
                       
                       <td>
                            {{ $project->title ?? '' }}
                        </td>
                        <td>
                            {{  implode("\n",$project->property_type) ?? '' }}
                          
                          
                        </td>
                       
                       
                         @if(!auth()->user()->isSales())
                        <td>
                            {{ $project->owner->salutation ?? '' }} {{ $project->owner->firstname ?? '' }}{{ $project->owner->lastname ?? '' }}
                        </td>
                        @endif
                        

                        <td>
                            @can('project_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.projects.show', $project->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endcan

                            @if(auth()->user()->canEditProject($project))
                            @can('project_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.projects.edit', $project->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @endif

                            @if(auth()->user()->canDeleteProject($project))
                            @can('project_delete')
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete Project Ref : {{ $project->ref  }} ?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-xs btn-danger">
                                   <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endcan
                            @endif

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('project_delete')
             
            @if(auth()->user()->isAdmin())
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
            text: deleteButtonTrans,
                    url: "{{ route('admin.projects.massDestroy') }}",
                    className: 'btn-danger',
                    action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                    });
                    if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                    headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                    }
            }
    dtButtons.push(deleteButton)
            @endif
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 100,
            });
    let table = $('.datatable-Project:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
    $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    })

</script>
@endsection


@section('styles')
<style>

    .description {
        display: block;
        width: 200px;
        
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }    


</style>