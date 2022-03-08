<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\User;
use App\Models\Listing;
use App\Models\Contact;
use App\Models\Project;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController {

    public function index() {
        
        $settings1 = [
            'chart_title' => 'Listings by months',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Listing',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'translation_key' => 'listing',
        ];

        $chart1 = new LaravelChart($settings1);

        $settings2 = [
            'chart_title' => 'Latest listings',
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Listing',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_days' => '7',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'fields' => [
                'title' => '',
                'type' => '',
                'purpose' => '',
                'price' => '',
                'beds' => '',
                'baths' => '',
                'area_size' => '',
                'developer' => '',
                'created_at' => '',
            ],
            'translation_key' => 'listing',
        ];

        $settings2['data'] = [];
        if (class_exists($settings2['model'])) {
            $settings2['data'] = $settings2['model']::latest()
                    ->take($settings2['entries_number'])
                    ->get();
        }

        if (!array_key_exists('fields', $settings2)) {
            $settings2['fields'] = [];
        }
        
        $settings3 = [
            'chart_title' => 'Data percentage',
            'chart_type' => 'pie',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Listing',
            'group_by_field' => 'type',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-9',
            'entries_number' => '5',
            'translation_key' => 'listing',
        ];

        $chart3 = new LaravelChart($settings3);

        $settings4 = [
            'chart_title' => 'Listing locations',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Listing',
            'group_by_field' => 'community',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'translation_key' => 'listing',
        ];

        $chart4 = new LaravelChart($settings4);
        
        
        
        return view('/home', [
            'totals_listings' => Listing::count(), 
            'totals_projects' => Project::count(),
            'totals_contacts' => Contact::count(),
            'totals_users' => User::count(),
            'totals_leads' => Contact::where('status', 'open lead')->count(),
            'chart1' => $chart1,
            'settings2' => $settings2,
            'chart3' => $chart3,
            'chart4' => $chart4,
        ]);
    }

}
