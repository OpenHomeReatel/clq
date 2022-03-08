

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
        <title>Listing details</title>
    </head>
    <body>
        <div class="card text-center">
            <table class="table table-bordered table-striped">
                <tbody>

                    <tr> 
                        <td>
                            <img style="height: 100px; width: 170px" src="{{ public_path('storage/icons/Open-Home-Properties-logo.png') }}" alt="">


                        </td>
                    </tr> 
                    <tr> 
                        <td>


                            <h5>[Listing REF: {{ $listing->ref }} ] <br>{{ $listing->title }}</h5>
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            {{ App\Models\Listing::TYPE_SELECT[$listing->type] ?? '' }}
                            For  {{ App\Models\Listing::PURPOSE_SELECT[$listing->purpose] ?? '' }}
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            @if($listing->thumbnail)
                            <img class="mt-4" style="width: 500px ; height:250px" src="{{ public_path($listing->thumbnail->absolute_path) }}">
                            @endif 
                        </td>
                    </tr> 
                </tbody>
            </table>  
        </div>
   
    <div class="text-center">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th> <img style="height: 30px; width: 30px" src="{{ public_path('storage/icons/location.png') }}" alt=""></th>
                    <th>{{ $listing->location }}, {{ $listing->community }}</th>
                </tr>  

                <tr>
                    <th><img style="height: 30px; width: 30px" src="{{ public_path('storage/icons/price.png') }}" alt=""></th>
                    <th>{{ $listing->price }} AED</th>
                </tr>

                <tr>
                    <th><img style="height: 30px; width: 30px" src="{{ public_path('storage/icons/bed.png') }}" alt=""></th>
                    <th>{{ $listing->beds }}</th>
                </tr>

                <tr>
                    <th><img style="height: 30px; width: 30px" src="{{ public_path('storage/icons/bath.png') }}" alt=""></th>
                    <th> {{ $listing->baths }}</th>
                </tr>

              
                <tr>
                    <th><img style="height: 30px; width: 30px" src="{{ public_path('storage/icons/sqft.png') }}" alt="">  {{ $listing->area_size }} {{ $listing->area_size_postfix }}</th>
                    <th><img style="height: 30px; width: 30px" src="{{ public_path('storage/icons/sqft.png') }}" alt="">  {{ $listing->plotarea_size }} {{ $listing->plotarea_size_postfix }}</th>
                        
                  
                </tr>
                <tr>
                    <th>Developed by:</th>
                    <th>{{ $listing->developer }}</th>
                </tr>

                <tr>
                    <th>Affiliate with the project</th>
                    <th> {{ $listing->project->name ?? '' }}</th>
                </tr>
            </tbody> 
        </table>
    </div>
    <div>
        <table class="table table-bordered table-striped" style="height: 1000px;">
            <tbody>
                <tr><td>
                        <h4>{{ trans('cruds.listing.fields.description') }}</h4>
                    </td></tr>
                <tr><td>
                        {!! $listing->description !!}
                    </td></tr>
            </tbody>
        </table>  
    </div>

    <h5> Property Gallery:</h5>
    @foreach($listing->images as $key => $media)  

    <img class="mt-5" style="width: 700px ; height:450px;" src="{{ public_path($media->absolute_path) }}">

    @endforeach




</body>
</html>