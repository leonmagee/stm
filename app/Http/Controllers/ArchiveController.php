<?php

namespace App\Http\Controllers;

use App\Archive;
use App\Settings;
use App\Helpers;
use App\Site;
use App\User;
use Illuminate\Http\Request;

class ArchiveController extends Controller
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
        * how to change date? Query string? redirect?
        */

        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        //$report_data_object = new ReportData($site_id, $current_date);
        $archive_data = Archive::where('date', $current_date)->get();

        dd($archive_data);

        $report_data_array = [];
        foreach($archive_data as $data)
        {
            // only output for current site
            $user = User::find($data->user_id);
            if ($user->role === $site_id)
            {
                $report_data_array[] = unserialize($data->archive_data);
            }
        }
        //dd($report_data_array);


        //dd($report_data_array);

        return view('archive.index', compact(
            'site_name', 
            'current_site_date', 
            'report_data_array'
        ));
        //return view('archive.index');
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
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(Archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function edit(Archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archive $archive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        //
    }
}
