<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use App\Site;
use App\ReportType;
use App\Sim;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $current_date = Settings::first()->current_date;

    // $data_array = [
    //  [
    //      'title' => 'H2O Wireless Month',
    //      'counts' => [
    //          '200',
    //          '133',
    //          '144'
    //      ]
    //  ],
    //  [
    //      'title' => 'H2O Wireless Minute',
    //      'counts' => [
    //          '170',
    //          '153',
    //          '114'
    //      ]
    //  ],
    // ];

    $data_array = [];

    $array_item = [];

        /**
        * @todo data array - get this to pull automatically based on current date
        * & with prior 3 - 5 months? Create a array with many possible dates and then 
        * get the index of the current date. 
        */
        $date_array = ['4_2018','5_2018','6_2018'];

        $report_types_array = ReportType::where('spiff',1)->get();

        foreach( $report_types_array as $report_type ) {

            $name = $report_type->name;

            $carrier = $report_type->carrier->name;

            $array_item['title'] = $carrier . " " . $name;

            foreach( $date_array as $date ) {

                $sims = Sim::where([
                    'upload_date' => $date, 
                    'report_type_id' => $report_type->id
                ])->latest()->get();

                $number = count($sims);

                $array_item['counts'][] = $number;
            }

            $data_array[] = $array_item;
            $array_item = [];
        }

        return view('index', compact('data_array'));

    }
}
