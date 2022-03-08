@extends('layouts.admin')
@section('content')
@can('followup_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.followups.create') }}"><i class="fas fa-plus"></i>
                add followup
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.followup.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Followup">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            id
                        </th>
                        <th>
                            activity
                        </th>
                        <th>
                            contact firstname
                        </th>
                        <th>
                          contact lastname
                        </th>
                        <th>
                          Created At 
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($followups as $key => $followup)
                        <tr data-entry-id="{{ $followup->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $followup->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Followup::ACTIVITY_SELECT[$followup->activity] ?? '' }}
                            </td>
                            <td>
                                {{ $followup->contact->firstname ?? '' }}
                            </td>
                            <td>
                                {{ $followup->contact->lastname ?? '' }}
                            </td>
                            <td>
                                {{ $followup->created_at ?? '' }}
                            </td>
                            <td>
                                @can('followup_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.followups.show', $followup->id) }}">
                                         <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('followup_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.followups.edit', $followup->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('followup_delete')
                                    <form action="{{ route('admin.followups.destroy', $followup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('followup_delete')
 @if(auth()->user()->isAdmin())
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.followups.massDestroy') }}",
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
  let table = $('.datatable-Followup:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection

