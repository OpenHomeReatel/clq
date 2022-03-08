@extends('layouts.admin')
@section('content')



<div class="form-group">
    <a class="btn btn-default" href="{{ route('admin.listings.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
    <a class="btn btn-success" href="{{ route('admin.listings.exportPdf',$listing->id) }}">
        Download PDF
    </a>
</div>

<div class="card">
    <div class="card-header text-center">
        <h2>{{ $listing->title }}</h2>
    </div>

    <div class="card-body">
        <div class="form-group">

            <div class=" row col-md-12 ">
                <div class="card text-center col-md-8">

                    <div class="card-body">
                        <div class="col-xs-7 well">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active"> 
                                        <img class="d-block w-100"  src="{{ $listing->thumbnail->getUrl() }}" alt="First slide">
                                    </div>
                                    @foreach($listing->images as $key => $media)
                                    <div class="carousel-item"> 
                                        <img class="d-block w-100"  src="{{ $media->getUrl() }}" alt="First slide">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <table class="table">
                            <tbody  class=" text-center">
                                <tr>
                                <tr>
                                    <td>
                                        @foreach($listing->images as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $media->getUrl('thumb') }}">
                                        </a>
                                        @endforeach


                                    </td>     
                                </tr>  
                            </tbody>    
                        </table>


                    </div>

                </div>
                <div class="card text-center col-md-4">

                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.listing.fields.user') }}
                                </th>
                                <td>
                                    {{ $listing->user->firstname ?? '' }} {{ $listing->user->lastname ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    E-mail :
                                </th>
                                <td>
                                    {{ $listing->user->email ?? '' }} 
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Project 
                                </th>
                                <td>
                                    {{ $listing->project->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                        <th>
                            Developer By :
                        </th>
                        <td>
                            {{ $listing->developer }}
                        </td>
                    </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <table class="table">
                <tbody  class=" text-center">
                   
                    <tr>
                        <td><h3> {{ App\Models\Listing::TYPE_SELECT[$listing->type] ?? '' }}
                                For  {{ App\Models\Listing::PURPOSE_SELECT[$listing->purpose] ?? '' }}
                            </h3>
                        </td>    
                    </tr>

                </tbody>
            </table>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            <i class="fas fa-bookmark"></i> {{ trans('cruds.listing.fields.id') }}
                        </th>
                        <td>
                            {{ $listing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <i class="far fa-bookmark"></i>  {{ trans('cruds.listing.fields.ref') }}
                        </th>
                        <td>
                            {{ $listing->ref }}
                        </td>
                    </tr>

                    
                    <tr>
                        <th>
                            <i class="fas fa-map-marked-alt"></i> {{ trans('cruds.listing.fields.location') }}
                        </th>
                        <td>
                            {{ $listing->community }} {{ $listing->emirate }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <i class="fas fa-money-bill-wave"></i> {{ trans('cruds.listing.fields.price') }}
                        </th>
                        <td>
                            {{ $listing->price }} AED {{ $listing->rent_pricing_duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-bed"></i> {{ trans('cruds.listing.fields.beds') }}
                        </th>
                        <td>
                            {{ $listing->beds }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-bath"></i> {{ trans('cruds.listing.fields.baths') }}
                        </th>
                        <td>
                            {{ $listing->baths }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           <img style="height: 15px; width: 15px" src="{{ asset('storage/icons/sqft.png') }}" alt=""> {{ trans('cruds.listing.fields.plot_area') }} Size
                        </th>
                        <td>
                            {{ $listing->plotarea_size }} {{ $listing->plotarea_size_postfix }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                             <img style="height: 15px; width: 15px" src="{{ asset('storage/icons/sqft.png') }}" alt=""> {{ trans('cruds.listing.fields.area') }} Size
                        </th>
                        <td>
                            {{ $listing->area_size }} {{ $listing->area_size_postfix }}
                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                            <i class="far fa-sticky-note"></i> {{ trans('cruds.listing.fields.note') }}
                        </th>
                        <td>
                            {!! $listing->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-clipboard"></i> {{ trans('cruds.listing.fields.description') }}
                        </th>
                        <td>
                            {!! $listing->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-thermometer-three-quarters"></i> {{ trans('cruds.listing.fields.state') }}
                        </th>
                        <td>
                            {{ $listing->state }}
                        </td>
                    </tr>


                    @if(!auth()->user()->isSales())
                    <tr>
                        <th>
                           <i class="fas fa-user-secret"></i> Landlord
                        </th>
                        <td>
                            {{ $listing->owner->salutation ?? '' }} {{ $listing->owner->firstname ?? '' }} {{ $listing->owner->lastname ?? '' }}
                        </td>
                    </tr>
                    @endif
                   
                    <tr>
                        <th>
                            <i class="fas fa-folder-open"></i> Files
                        </th>
                        <td>
                            @foreach($listing->files as $key => $media)
                            <a href="{{ $media->getUrl() }}" target="_blank">
                                {{ trans('global.view_file') }} {{$media->file_name}}
                            </a></br>
                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>

        </div> 

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.listings.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
</div>



@endsection