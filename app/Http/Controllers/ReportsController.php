<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Settings;
use App\Site;
use App\Helpers;
use App\ReportType;
use App\ReportData;
use App\ReportUserCSV;
use App\Archive;
use \DB;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
        * @todo here's where we get the report data - so this should probably be its own class.
        * for now, we'll just omit the per user spiff and residual settings and credit or bonus
        * features. 
        */
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $report_data_object = new ReportData($site_id, $current_date);
        $report_data_array = $report_data_object->report_data;
        //dd($report_data_array);

        return view('reports.index', compact(
            'site_name', 
            'current_site_date', 
            'report_data_array'
        ));
    }

    /**
    * Report Totals Page
    */
    public function totals()
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $report_types = ReportType::all();
        $current_date = Helpers::current_date();
        $report_type_totals_array = [];
        $total_count_final = 0;

        foreach($report_types as $report_type) {

            if ($report_type->spiff ){

                $matching_sims_count = DB::table('sims')
                ->select('sims.value', 'sims.report_type_id')
                ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                ->where('sims.report_type_id', $report_type->id)
                ->where('sims.upload_date', $current_date)
                ->count();

                $name = $report_type->carrier->name . ' ' . $report_type->name;

                $report_type_totals_array[$name] = $matching_sims_count;
                $total_count_final += $matching_sims_count;

            } 

            // else { // residual query

            //     $matching_sims_count = DB::table('sim_residuals')
            //     ->select('sim_residuals.value', 'sim_residuals.report_type_id')
            //     ->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
            //     ->where('sim_residuals.report_type_id', $report_type->id)
            //     ->where('sim_residuals.upload_date', $current_date)
            //     ->count();
            // }

        }

        return view('reports.totals', compact(
            'site_name', 
            'current_site_date', 
            'report_type_totals_array',
            'total_count_final'
        ));
    }

    public function recharge()
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $users = User::where('role', $site_id)->get();
        $recharge_data_array = [];

        $config_array = [ // this can be changed for different report types
            'current' => 1, // H2O Month
            'recharge' => 5, // H2O 2nd Recharge
        ];

        $report_type_current = ReportType::find($config_array['current']);
        $report_type_recharge = ReportType::find($config_array['recharge']);

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_months_ago = $date_array[$array_index - 2];
        $three_months_ago = $date_array[$array_index - 3];

        $recarge_search_array = [
            [
                [
                    'rt_id' => $report_type_current->id,
                    'date' => $one_month_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'date' => $current_date,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'date' => $two_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'date' => $one_month_ago,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'date' => $three_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'date' => $two_months_ago,
                ],
            ]
        ];

        foreach($users as $user)
        {

            $data = [];

            foreach($recarge_search_array as $item) {

                $matching_sims_count_activation = DB::table('sims')
                ->select('sims.value')
                ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                ->where('sims.report_type_id', $item[0]['rt_id'])
                ->where('sim_users.user_id', $user->id)
                ->where('sims.upload_date', $item[0]['date'])
                ->count();

                $matching_sims_count_recharge = DB::table('sims')
                ->select('sims.value')
                ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                ->where('sims.report_type_id', $item[1]['rt_id'])
                ->where('sim_users.user_id', $user->id)
                ->where('sims.upload_date', $item[1]['date'])
                ->count();

                if ($matching_sims_count_activation && $matching_sims_count_recharge)
                {
                    $recharge_percent = number_format( ( ( $matching_sims_count_recharge / $matching_sims_count_activation ) * 100), 2);
                } else {
                    $recharge_percent = '0.00';
                }

                if ( $recharge_percent >= 70 ) {
                    $percent_class = 'best';
                } elseif ( $recharge_percent >= 60 ) {
                    $percent_class = 'good';
                } elseif ( $recharge_percent >= 50 ) {
                    $percent_class = 'ok';
                } else {
                    $percent_class = 'bad';
                }

                $data[] = [
                    'act_name' => Helpers::get_date_name($item[0]['date']) . ' Activations',
                    'act_count' => $matching_sims_count_activation,
                    'rec_name' => Helpers::get_date_name($item[1]['date']) . ' Recharges',
                    'rec_count' => $matching_sims_count_recharge,
                    'percent' => $recharge_percent,
                    'class' => $percent_class
                ];
            }

            $recharge_data_array[] = [
                'name' => $user->name,
                'company' => $user->company,
                'data' => $data
            ];

        }

        //dd($recharge_data_array);

        return view('reports.recharge', compact(
            'site_name', 
            'current_site_date', 
            'recharge_data_array'
        ));
    }

    public function download_csv(Request $request, $id) 
    {
        $user = User::find($id);
        ReportUserCSV::process_csv_download($user);
    }

    public function save_archive()
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $report_data_object = new ReportData($site_id, $current_date);
        $report_data_array = $report_data_object->report_data;

        foreach($report_data_array as $report_data) {

            $save_data = serialize($report_data);
            //dd($report_data->user_id);

            //Archive::create('')

            Archive::create([
                'user_id' => $report_data->user_id,
                'date' => $current_date, 
                'archive_data' => $save_data
            ]);
        }

        $save_data = serialize($report_data_array);
        $retrieve_data = unserialize($save_data);
        dd($retrieve_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
