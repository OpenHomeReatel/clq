@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.owner.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.owners.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.id') }}
                        </th>
                        <td>
                            {{ $owner->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.ref') }}
                        </th>
                        <td>
                            {{ $owner->ref }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.salutation') }}
                        </th>
                        <td>
                            {{ $owner->salutation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.firstname') }}
                        </th>
                        <td>
                            {{ $owner->firstname }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.lastname') }}
                        </th>
                        <td>
                            {{ $owner->lastname }}
                        </td>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.owner.fields.emirate_id_number') }}
                        </th>
                        <td>
                            {{ $owner->emirate_id_number}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.source') }}
                        </th>
                        <td>
                            {{ $owner->source ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.email') }}
                        </th>
                        <td>
                            {{ $owner->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.nationality') }}
                        </th>
                        <td>
                            {{ $owner->nationality }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.assign') }}
                        </th>
                        <td>
                            {{ $owner->assign->fullname ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.mobile') }}
                        </th>
                        <td>
                            {{ $owner->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.alternate_mobile') }}
                        </th>
                        <td>
                            {{ $owner->alternate_mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.projects') }}
                        </th>
                        <td>
                            {{  implode(" , ",$owner->projects) ?? '' }}
                        </td>
                    </tr>
                     <tr>
                        <th>
                            Files
                        </th>
                        <td>
                            @foreach($owner->files as $key => $media)
                            <a href="{{ $media->getUrl() }}" target="_blank">
                                {{ trans('global.view_file') }} {{$media->file_name}}
                            </a></br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.owners.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
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
                            {{ trans('cruds.listing.fields.emirate') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.community') }}
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
                            {{ trans('cruds.listing.fields.plot_area') }}
                        </th>
                        <th>
                            {{ trans('cruds.listing.fields.area') }}
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

                        <th>
                            {{ trans('cruds.listing.fields.owner') }}
                        </th>
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
                    @foreach($owner->listings as $key => $listing)
                    <tr data-entry-id="{{ $listing->id }}">
                        <td>

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
                            {{ App\Models\Listing::TYPE_SELECT[$listing->type] ?? '' }}
                        </td>
                        <td>
                            {{ App\Models\Listing::PURPOSE_SELECT[$listing->purpose] ?? '' }}
                        </td>
                        <td>
                            {{ $listing->location ?? '' }}
                        </td>
                        <td>
                            {{ $listing->emirate ?? '' }}
                        </td>
                        <td>
                            {{ $listing->community ?? '' }}
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
                            {{ $listing->plot_area ?? '' }}
                        </td>
                        <td>
                            {{ $listing->area ?? '' }}
                        </td>
                        <td>
                            {{ $listing->developer ?? '' }}
                        </td>

                        <td>

                            @if( $listing->state == 'signature' )
                            <h5> <span class="badge me-1 bg-success">Signature</span></h5>
                            @elseif( $listing->state == 'hot' )
                            <h5> <span class="badge me-1 bg-danger">Hot</span></h5>
                            @else
                            <h5> <span class="badge me-1 bg-secondary">Normal</span></h5>
                            @endif
                        </td>
                        <td class="description">
                            {{ $listing->description ?? '' }}
                        </td>

                        <td>
                            {{ $listing->owner->salutation ?? '' }} {{ $listing->owner->firstname ?? '' }} {{ $listing->owner->lastname ?? '' }}
                        </td>
                        <td>
                            {{ $listing->user->firstname ?? '' }} {{ $listing->user->lastname ?? '' }} 
                        </td>
                        <td>
                            {{ $listing->project->name ?? '' }} 
                        </td>


                        <td>
                            @can('listing_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.listings.show', $listing->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @can('listing_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.listings.edit', $listing->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('listing_delete')
                            <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete listing Ref : {{ $listing->ref  }} ?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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