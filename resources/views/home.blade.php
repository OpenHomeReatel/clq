@extends('layouts.admin')

@section('content')
<div class="content">


    <div class="card">
        <div class="card-header">
            Dashboard
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info text-center">
                                            <div class="icon icon-primary">
                                                <i class="now-ui-icons ui-2_chat-round"></i>
                                            </div>
                                            <h3 class="info-title">
                                                @if(!auth()->user()->isSales() && !auth()->user()->isListings())
                                                <a href="{{ route('admin.listings.index') }}" style="color: #0e85a5;"> 
                                                    @endif
                                                    {{ $totals_listings }}
                                                </a> 
                                            </h3>
                                            <h6 class="stats-title">Total Listings</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info  text-center">
                                            <div class="icon icon-primary">
                                                <i class="now-ui-icons ui-2_chat-round"></i>
                                            </div>
                                            <h3 class="info-title">
                                                @if(!auth()->user()->isSales() && !auth()->user()->isListings())
                                                <a href="{{ route('admin.projects.index') }}" style="color: #0e85a5;"> 
                                                    @endif
                                                    {{ $totals_projects }}
                                                </a> 
                                            </h3>
                                            <h6 class="stats-title">Total Projects</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info  text-center">
                                            <div class="icon icon-success">
                                                <i class="now-ui-icons business_money-coins"></i>
                                            </div>
                                            <h3 class="info-title">
                                                @if(!auth()->user()->isSales() && !auth()->user()->isListings())
                                                <a href="{{ route('admin.contacts.index') }}" style="color: #0e85a5;">
                                                    @endif
                                                    {{ $totals_leads }}
                                                </a>
                                            </h3>
                                            <h6 class="stats-title">Total Open Leads</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info  text-center">
                                            <div class="icon icon-info">
                                                <i class="now-ui-icons users_single-02"></i>
                                            </div>
                                            <h3 class="info-title">
                                                @if(!auth()->user()->isSales() && !auth()->user()->isListings())
                                                <a href="{{ route('admin.users.index') }}" style="color: #0e85a5;">
                                                    @endif
                                                    {{ $totals_users }}
                                                </a>
                                            </h3>
                                            <h6 class="stats-title">Total Active Users</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="card col-md-6" >

            <div class="card-header">
                <h3>{!! $chart1->options['chart_title'] !!}</h3>
            </div>
            <div class="card-body">
                @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif


                <div class="{{ $chart1->options['column_class'] }}">

                    {!! $chart1->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="card col-md-6">
            <div class="card-header">
                {{-- Widget - latest entries --}} <h3>{{ $settings2['chart_title'] }}</h3>
            </div>
            <div class="card-body">

                <div class="{{ $settings2['column_class'] }}" style="overflow-x: auto;">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                @foreach($settings2['fields'] as $key => $value)
                                <th>
                                    {{ trans(sprintf('cruds.%s.fields.%s', $settings2['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings2['data'] as $entry)
                            <tr>
                                @foreach($settings2['fields'] as $key => $value)
                                <td>
                                    @if($value === '')
                                    {{ $entry->{$key} }}
                                    @elseif(is_iterable($entry->{$key}))
                                    @foreach($entry->{$key} as $subEentry)
                                    <span class="label label-info">{{ $subEentry->{$value} }}</span>
                                    @endforeach
                                    @else
                                    {{ data_get($entry, $key . '.' . $value) }}
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($settings2['fields']) }}">{{ __('No entries found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6">
            <div class="card-header">
                <h3>{!! $chart3->options['chart_title'] !!}</h3>
            </div>

            <div class="card-body">
                </br>
                <div class="{{ $chart3->options['column_class'] }} " >
                    <div class=" text-center"> {!! $chart3->renderHtml() !!}
                    </div>

                </div>
            </div>
        </div>
        <div class="card col-md-6 col">
            <div class="card-header">
                <h3>{!! $chart4->options['chart_title'] !!}</h3>
            </div>

            <div class="card-body">
                <div class="{{ $chart4->options['column_class'] }}">

                    {!! $chart4->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>



@endsection

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
{!! $chart1->renderJs() !!}
{!! $chart3->renderJs() !!}
{!! $chart4->renderJs() !!}
@endsection