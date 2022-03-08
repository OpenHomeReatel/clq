@extends('layouts.admin')
@section('content')


<div style="margin-bottom: 10px;" class="row">

    @can('owner_create')

    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="{{ route('admin.owners.create') }}"><i class="fas fa-plus"></i>
            {{ trans('global.add') }} Landlord
        </a>
    </div>

    @endcan
    @if(!auth()->user()->isSales() && !auth()->user()->isListings())
    <div class="col-lg-4">
        <a type="button" class="btn btn-success form-control" href="{{ route('admin.exports.csv.owners') }}">
            Export CSV <i class="fas fa-download"></i>
        </a>
    </div>

    <div class="col-lg-4">

        <button type="button" class="btn-import form-control" data-toggle="modal" data-target="#exampleModal">
            Import Landlords <i class="fas fa-upload"></i>
        </button>   

    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <form action="{{ url('admin/import/owners') }}" method="POST" enctype="multipart/form-data">
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
                        <a href="{{asset('schema-import/owners schema.csv')}}">Here!</a>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.owner.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Owner">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.owner.fields.id') }}
                        </th>
                       
                        <th>
                            {{ trans('cruds.owner.fields.salutation') }}
                        </th>
                        <th>
                            {{ trans('cruds.owner.fields.firstname') }}
                        </th>

                        <th>
                            {{ trans('cruds.owner.fields.lastname') }}
                        </th>
                       
                        <th>
                            {{ trans('cruds.owner.fields.nationality') }}
                        </th>
                        <th>
                            {{ trans('cruds.owner.fields.assign') }}
                        </th>
                        <th>
                            {{ trans('cruds.owner.fields.mobile') }}
                        </th>
                         <th>
                            {{ trans('cruds.owner.fields.projects') }}
                        </th>
                      
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($owners as $key => $owner)
                    <tr data-entry-id="{{ $owner->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $owner->id ?? '' }}
                        </td>
                       
                        <td>
                            {{ $owner->salutation ?? '' }}
                        </td>
                        <td>
                            {{ $owner->firstname ?? '' }}
                        </td>

                        <td>
                            {{ $owner->lastname ?? '' }}
                        </td>
                       
                        
                        <td>
                            {{ $owner->nationality ?? '' }}
                        </td>
                        <td>
                            {{ $owner->assign->fullname ?? '' }}
                        </td>
                        <td>
                           <p id="{{ $owner->id }}" class="mobile" style="opacity: 0;"> {{ $owner->mobile ?? '' }} </p>
                        </td>
                        <td>
                            {{  implode(" , ",$owner->projects) ?? '' }}
                        </td>
                      
                        <td>
                            @can('owner_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.owners.show', $owner->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endcan

                            @can('owner_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.owners.edit', $owner->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('owner_delete')
                            <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure want to delete Owner {{ $owner->salutation }} {{ $owner->firstname }} {{ $owner->lastname }} ?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-xs btn-danger">
                                   <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endcan

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-assign-to-users" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <form action="{{ route('admin.owners.assign_user') }}" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Assign user</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="selected_owners_id" id="selected_owners_id">
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select class="form-control" required name="user_id" id="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('owner_delete')
            @if (auth()->user()->isAdmin())
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
            text: deleteButtonTrans,
                    url: "{{ route('admin.owners.massDestroy') }}",
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
            
            let assignUserTrans = 'Assign to user'
            let assignUser = {
            text: assignUserTrans,
                    url: "{{ route('admin.owners.massDestroy') }}",
                    className: 'btn-success',
                    action: function (e, dt, node, config) {
                        var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                            return $(entry).data('entry-id')
                        });
                        
                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')
                            return
                        }

                        $('#selected_owners_id').val(ids.join(','))
                        $('#modal-assign-to-users').modal('show');
                        console.log(ids.join(','))
                    }
            }
            dtButtons.push(assignUser)
            @endif
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 100,
            });
    let table = $('.datatable-Owner:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
    $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    })

</script>
@endsection
@section('styles')
<style>
   
    .mobile:hover {
        opacity: 1 !important;
    }
    
   
</style>
@endsection
