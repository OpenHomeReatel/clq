@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row"> 
    @can('listing_create')
    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="{{ route('admin.listings.create') }}"><i class="fas fa-plus"></i>
            {{ trans('global.add') }} {{ trans('cruds.listing.title_singular') }}
        </a>
    </div>
    @endcan
    @if(!auth()->user()->isSales() && !auth()->user()->isListings())
    <div class="col-lg-4">
        <a class="btn btn-success form-control" href="exports/listings-csv" class="">
            Export CSV <i class="fas fa-download"></i>
        </a>
    </div>
    <div class="col-lg-4">
        <button type="button" class="btn-import form-control" data-toggle="modal" data-target="#exampleModal">
            Import Listings <i class="fas fa-upload"></i>
        </button> 
    </div>
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <p class="text-center">
                        {{ $error }}
                    </p>
                </div>
                @endforeach
                @endif
                <div class="modal-body">
                    <form action="{{ url('admin/import/listings') }}" method="POST" enctype="multipart/form-data">
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
                        <a href="{{asset('schema-import/listings schema.csv')}}">Here!</a>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Search </h3> 
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('admin.listings.index') }}">
                    <div class="row">
                        <div class="form-group col-md-3">    
                            <label for="purpose">Purpose:</label>
                            <select id="purpose" name="purpose" class="form-control form-control-lg">
                                <option value="">Any</option>
                                <option {!! request('purpose') == 'sale' ? 'selected' : '' !!} value="sale">For Sale</option>
                                <option {!! request('purpose') == 'rent' ? 'selected' : '' !!} value="rent">For Rent</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="type">type:</label>
                            <select id="type" name="type" class="form-control form-control-lg">
                                <option value="">Any</option>
                                @foreach(App\Models\Listing::TYPE_SELECT as $type)
                                <option {!! request('type') == $type ? 'selected' : '' !!} value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div> 
                         <div class="form-group col-md-3">    
                            <label for="price">price from:</label>
                            <div class="input-group mb-3"><span class="input-group-text">AED</span>
                                <input  name="pricemin" value="{{ request('pricemin') }}" class="form-control form-control-lg" type="text" ><span class="input-group-text">.00</span>
                            </div>
                        </div> 
                        <div class="form-group col-md-3"> 
                            <label for="price">price to:</label>
                            <div class="input-group mb-3"><span class="input-group-text">AED</span>
                                <input  name="pricemax" value="{{ request('pricemax') }}" class="form-control form-control-lg" type="text" ><span class="input-group-text">.00</span>
                            </div>
                        </div> 
                       
                       
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">    
                            <label for="community">community:</label>
                            <input type="text" class="form-control form-control-lg" name="community" value="{{ request('community') }}"/>
                        </div>
                        <div class="form-group col-md-3">    
                            <label for="beds">beds:</label>
                            <select id="beds" name="beds" class="form-control form-control-lg">
                                <option value="">Any</option>
                                <option value="studio">Studio</option>
                                @foreach(range(1, 20) as $val)
                                <option {!! request('beds') == $val ? 'selected' : '' !!} value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">    
                            <label for="baths">baths:</label>
                            <select id="baths" name="baths" class="form-control form-control-lg">
                                <option value="">Any</option>
                                @foreach(range(1, 20) as $val)
                                <option {!! request('baths') == $val ? 'selected' : '' !!} value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class=" form-group col-md-3">
                             <label style="color:#FFFFFF">Search   </label>
                        <button class="form-control form-control-lg btn btn-success" type="submit">Search</button>
                    </div>
                    </div>
                   
                </form> 
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="statistics">
                                <div class="info">
                                    <div class="icon icon-primary">
                                        <i class="now-ui-icons ui-2_chat-round"></i>
                                    </div>
                                    <h3 class="info-title"> {{ $totals_hot }}</h3>
                                    <h3 class="stats-title"><span class="badge me-1 bg-danger">Hot</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="statistics">
                                <div class="info">
                                    <div class="icon icon-success">
                                        <i class="now-ui-icons business_money-coins"></i>
                                    </div>
                                    <h3 class="info-title">{{ $totals_signature }}</h3>
                                    <h3 class="stats-title"><span class="badge me-1 bg-success">Signature</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="statistics">
                                <div class="info">
                                    <div class="icon icon-primary">
                                        <i class="now-ui-icons ui-2_chat-round"></i>
                                    </div>
                                    <h3 class="info-title"> {{ $totals_basic }}</h3>
                                    <h3 class="stats-title"><span class="badge me-1 bg-info">Basic</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.listing.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Listing">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.thumbnail') }}
                        </th>

                        <th>
                            {{ trans('cruds.listing.fields.ref') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.purpose') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.location') }}
                        </th>

                        <th>
                            {{ trans('cruds.listing.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.beds') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.baths') }}
                        </th>
                        <th>
                            Plot Area size
                        </th>
                        <th>
                            Area size
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.developer') }}
                        </th>

                        <th>
                            {{ trans('cruds.listing.fields.state') }}
                        </th>
                        <th >
                            {{ trans('cruds.listing.fields.description') }}
                        </th>
                        @if(!auth()->user()->isSales())
                        <th>
                            {{ trans('cruds.listing.fields.owner') }}
                        </th>
                        @endif
                        <th>
                            {{ trans('cruds.listing.fields.user') }}
                        </th>
                        <th>
                            Project
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listings as $key => $listing)
                    <tr data-entry-id="{{ $listing->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $listing->id ?? '' }}
                        </td>
                        <td>
                            @if($listing->thumbnail)
                            <a href="{{ $listing->thumbnail->getUrl() }}" target="_blank" style="display: inline-block">
                                <img src="{{ $listing->thumbnail->getUrl() }}" width="120px" height="100px" alt="image">
                            </a>
                            @endif
                        </td>
                        <td>
                            {{ $listing->ref ?? '' }}
                        </td>
                        <td>
                            {{ $listing->title ?? '' }}
                        </td>
                        <td>
                            {{ $listing->type ?? '' }}
                        </td>
                        <td>
                            {{ $listing->purpose ?? '' }}
                        </td>
                        <td>
                            {{ $listing->community ?? '' }} {{ $listing->emirate ?? '' }}
                        </td>

                        <td>
                            {{ $listing->price ?? '' }}
                        </td>
                        <td>
                            {{ $listing->beds ?? '' }}
                        </td>
                        <td>
                            {{ $listing->baths ?? '' }}
                        </td>
                        <td>
                            {{ $listing->plotarea_size ?? '' }} {{ $listing->plotarea_size_postfix ?? '' }}
                        </td>
                        <td>
                            {{ $listing->area_size ?? '' }} {{ $listing->area_size_postfix ?? '' }}
                        </td>
                        <td>
                            {{ $listing->developer ?? '' }}
                        </td>
                        <td>

                            @if( $listing->state == 'Signature' || $listing->state == 'signature' )
                            <h5> <span class="badge me-1 bg-success">Signature</span></h5>
                            @elseif( $listing->state == 'Hot' || $listing->state == 'hot')
                            <h5> <span class="badge me-1 bg-danger">Hot</span></h5>
                            @else
                            <h5> <span class="badge me-1 bg-info">Basic</span></h5>
                            @endif
                        </td>
                        <td class="description">
                            {{ $listing->description }}
                        </td>
                        @if(!auth()->user()->isSales())
                        <td>
                            {{ $listing->owner->salutation ?? '' }} {{ $listing->owner->firstname ?? '' }} {{ $listing->owner->lastname ?? '' }}
                        </td>
                        @endif
                        <td>
                            {{ $listing->user->firstname ?? '' }} {{ $listing->user->lastname ?? '' }} 
                        </td>
                        <td>
                            {{ $listing->project->name ?? '' }} 
                        </td>
                        <td>
                            @can('listing_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.listings.show', $listing->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endcan
                            @if(auth()->user()->canEditListing($listing))
                            @can('listing_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.listings.edit', $listing->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @endif
                            @if(auth()->user()->canDeleteListing($listing))
                            @can('listing_delete')
                            <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete listing Ref : {{ $listing->ref  }} ?');" style="display: inline-block;">
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
            @can('listing_delete')
            @if (auth()->user()->isAdmin())
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
            text: deleteButtonTrans,
                    url: "{{ route('admin.listings.massDestroy') }}",
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
    let table = $('.datatable-Listing:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
@endsection