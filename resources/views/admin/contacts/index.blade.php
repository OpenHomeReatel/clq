@extends('layouts.admin')
@section('content')


<div style="margin-bottom: 10px;" class="row">
    @can('contact_create')


    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="{{ route('admin.contacts.create') }}"><i class="fas fa-plus"></i>
            {{ trans('global.add') }} {{ trans('cruds.contact.title_singular') }}
        </a>
    </div>


    @endcan
    @if(!auth()->user()->isSales() && !auth()->user()->isListings())
    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="{{ route('admin.exports.csv.contacts') }}">
            Export CSV <i class="fas fa-download"></i>
        </a>
    </div>

    <div class="col-lg-4">
        <button type="button" class="btn btn-import form-control" data-toggle="modal" data-target="#exampleModal" >
            Import Contacts <i class="fas fa-upload"></i>
        </button>
    </div>

   
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <form action="{{ url('admin/import/contacts') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv">
                        <input type="submit" value="submit">
                    </form>
                </div>
                <div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-triangle"></i>

                    Please make sure that the file you wish to import from matches with the schema !
                    <br>
                    Download the csv schema from
                    <a href="{{asset('schema-import/contacts schema.csv')}}">Here!</a>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>

<div class="card"  oncontextmenu="myFunction()" contextmenu="mymenu">
    <div class="card-header">
        {{ trans('cruds.contact.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Contact">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.ref') }}
                        </th> 
                        <th>
                            {{ trans('cruds.contact.fields.salutation') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.firstname') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.lastname') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.nationality') }}
                        </th>

                        <th>
                            {{ trans('cruds.contact.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.contact.fields.mobile') }}
                        </th>
                        
                        <th>
                            Added By
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $key => $contact)
                    <tr data-entry-id="{{ $contact->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $contact->id ?? '' }}
                        </td>
                        <td>
                            {{ $contact->ref ?? '' }}
                        </td>
                        <td>
                            {{  $contact->salutation ?? '' }}
                        </td>
                        <td>
                            {{ $contact->firstname ?? '' }}
                        </td>
                        <td>
                            {{ $contact->lastname ?? '' }}
                        </td>
                        <td>
                            {{ $contact->email ?? '' }}
                        </td>
                        <td>
                            {{ $contact->nationality ?? '' }}
                        </td>

                        <td>
                            @if( $contact->status== 'Basic' )
                            <h5> <span class="badge me-1 bg-info">Basic</span></h5>
                            @else
                            <h5> <span class="badge me-1 bg-success">Open Lead</span></h5>
                            @endif
                        </td>
                        <td>
                            {{ $contact->user->full_name ?? '' }}
                        </td>
                        <td id="mobile">
                           <p id="{{ $contact->id }}" class="mobile" style="opacity: 0;"> {{ $contact->mobile ?? '' }} </p>
                        </td>
                       
                        <td>
                            {{ $contact->CreatedBy() ?? '' }}
                        </td>
                        <td>
                            @can('contact_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.contacts.show', $contact->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endcan

                            @can('contact_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.contacts.edit', $contact->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('followup_create')
                            <a class="btn btn-xs btn-success" href="{{ route('admin.followups.create.from_contact', $contact->id) }}">
                             <i class="fas fa-comment-alt"></i>
                            </a>
                            @endcan

                            @can('contact_delete')
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete Contact {{ $contact->salutation }} {{ $contact->firstname }} {{ $contact->lastname }} ?');" style="display: inline-block;">
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
            <form action="{{ route('admin.contacts.assign_user') }}" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Assign user</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="selected_contacts_id" id="selected_contacts_id">
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
            @can('contact_delete')
            @if (auth()->user()->isAdmin())
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
            text: deleteButtonTrans,
                    url: "{{ route('admin.contacts.massDestroy') }}",
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
                    url: "{{ route('admin.contacts.massDestroy') }}",
                    className: 'btn-success',
                    action: function (e, dt, node, config) {
                        var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                            return $(entry).data('entry-id')
                        });
                        
                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')
                            return
                        }

                        $('#selected_contacts_id').val(ids.join(','))
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
            let table = $('.datatable-Contact:not(.ajaxTable)').DataTable({ buttons: dtButtons })
                    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $('#btn-assign-users').click(function () {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                console.log(ids);
            })
    })

</script>
<script>
            //show and hide dropdown list item on button click
                    function show_hide() {
                    var click = document.getElementById("list-items");
                    if (click.style.display === "none") {
                    click.style.display = "block";
                    } else {
                    click.style.display = "none";
                    }
                    }
            function myFunction() {
            $("[data-toggle='modal']").on("contextmenu", function(e) {
            e.preventDefault();
            var targetModal = $(this).data('target');
            $(targetModal).modal("show");
            })
            }
</script>

@endsection
@section('styles')
<style>
   
    .mobile:hover {
        opacity: 1 !important;
    }
    
   
</style>
@endsection
