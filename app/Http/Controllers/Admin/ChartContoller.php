 <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Charts;
use App\Models\User;
use DB;

class ChartController extends Controller
{
    //
    public function index()
    {
    	$users = Listing::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
    				->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
			      ->title("Monthly new Register Users")
			      ->elementLabel("Total Listings")
			      ->dimensions(1000, 500)
			      ->responsive(false)
			      ->groupByMonth(date('Y'), true);
        return view('chart',compact('chart'));
    }
}

