<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;
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
        * @todo where to put this?
        */
        $date_array = [
            '1_2018',
            '2_2018',
            '3_2018',
            '4_2018',
            '5_2018',
            '6_2018',
            '7_2018',
            '8_2018',
            '9_2018',
            '10_2018',
            '11_2018',
            '12_2018',
            '1_2019',
            '2_2019',
            '3_2019',
            '4_2019',
            '5_2019',
            '6_2019',
            '7_2019',
            '8_2019',
            '9_2019',
            '10_2019',
            '11_2019',
            '12_2019',
            '1_2020',
            '2_2020',
            '3_2020',
            '4_2020',
            '5_2020',
            '6_2020',
            '7_2020',
            '8_2020',
            '9_2020',
            '10_2020',
            '11_2020',
            '12_2020',
            '1_2021',
            '2_2021',
            '3_2021',
            '4_2021',
            '5_2021',
            '6_2021',
            '7_2021',
            '8_2021',
            '9_2021',
            '10_2021',
            '11_2021',
            '12_2021',
            '1_2022',
            '2_2022',
            '3_2022',
            '4_2022',
            '5_2022',
            '6_2022',
            '7_2022',
            '8_2022',
            '9_2022',
            '10_2022',
            '11_2022',
            '12_2022',
            '1_2023',
            '2_2023',
            '3_2023',
            '4_2023',
            '5_2023',
            '6_2023',
            '7_2023',
            '8_2023',
            '9_2023',
            '10_2023',
            '11_2023',
            '12_2023',
            '1_2024',
            '2_2024',
            '3_2024',
            '4_2024',
            '5_2024',
            '6_2024',
            '7_2024',
            '8_2024',
            '9_2024',
            '10_2024',
            '11_2024',
            '12_2024',
            '1_2025',
            '2_2025',
            '3_2025',
            '4_2025',
            '5_2025',
            '6_2025',
            '7_2025',
            '8_2025',
            '9_2025',
            '10_2025',
            '11_2025',
            '12_2025',
            '1_2026',
            '2_2026',
            '3_2026',
            '4_2026',
            '5_2026',
            '6_2026',
            '7_2026',
            '8_2026',
            '9_2026',
            '10_2026',
            '11_2026',
            '12_2026',
            '1_2027',
            '2_2027',
            '3_2027',
            '4_2027',
            '5_2027',
            '6_2027',
            '7_2027',
            '8_2027',
            '9_2027',
            '10_2027',
            '11_2027',
            '12_2027',
            '1_2028',
            '2_2028',
            '3_2028',
            '4_2028',
            '5_2028',
            '6_2028',
            '7_2028',
            '8_2028',
            '9_2028',
            '10_2028',
            '11_2028',
            '12_2028',
            '1_2029',
            '2_2029',
            '3_2029',
            '4_2029',
            '5_2029',
            '6_2029',
            '7_2029',
            '8_2029',
            '9_2029',
            '10_2029',
            '11_2029',
            '12_2029',
            '1_2030',
            '2_2030',
            '3_2030',
            '4_2030',
            '5_2030',
            '6_2030',
            '7_2030',
            '8_2030',
            '9_2030',
            '10_2030',
            '11_2030',
            '12_2030',
        ];


        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_month_ago = $date_array[$array_index - 2];

        $date_array_final = [
            $two_month_ago,
            $one_month_ago, 
            $current_date
        ];

        $date_name_array = [
            Helpers::get_date_name($two_month_ago),
            Helpers::get_date_name($one_month_ago),
            Helpers::current_date_name()
        ];

        $report_types_array = ReportType::where('spiff',1)->get();

        foreach( $report_types_array as $report_type ) {

            $name = $report_type->name;

            $carrier = $report_type->carrier->name;

            $array_item['title'] = $carrier . " " . $name;

            foreach( $date_array_final as $date ) {

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

        return view('index', compact('data_array', 'date_name_array'));

    }
}
