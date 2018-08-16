<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Settings;
use App\Site;
use App\Helpers;
use App\ReportType;
use App\ReportData;

class ReportsController extends Controller
{
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
        //$sims = Sim::where('upload_date', $current_date)->latest()->get();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $users = User::where('role', $site_id)->get();

        // $report_data_array = array();

        // $report_types = ReportType::all();

        // foreach($report_types as $report_type) {
        //     $report_data_array[] = array(
        //         'name' => $report_type->name,
        //         'number' => '33',
        //         'payment' => '$1,223.00'
        //     );
        // }


        $report_data = new ReportData($site_id, $current_date);
        $report_data_array = $report_data->get_data();










        return view('reports.index', compact(
            'users', 
            'site_name', 
            'current_site_date', 
            'report_data_array'
        ));
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
