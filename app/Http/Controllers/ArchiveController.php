<?php

namespace App\Http\Controllers;

use App\Archive;
use App\Settings;
use App\Helpers;
use App\Site;
use App\User;
use \DB;
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
    public function index(Request $request)
    {

        if ($request->date) {
            $current_date = $request->date;
        } else {
            $current_date = Settings::first()->current_date;
        }

        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $archive_data = Archive::where('date', $current_date)->get();

        $report_data_array = [];

        foreach($archive_data as $data)
        {
          //dd($data);

            if($user = User::find($data->user_id))
            {
                $user_site_id = Helpers::get_site_id($user->role_id);

                if (intval($user_site_id) === intval($site_id))
                {
                    $report_data_array[] = unserialize($data->archive_data);
                }
            }
        }

        // get date array for dropdown select
        $archive_dates = DB::table('archives')
            ->select('date')
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $date_select_array = [];

        foreach($archive_dates as $date)
        {
            $date_select_array[$date->date] = Helpers::get_date_name($date->date);
        }

        return view('archive.index', compact(
            'site_name',
            'current_date',
            'report_data_array',
            'date_select_array'
        ));
    }

    public function change_archive_date(Request $request) {

        return redirect('archives?date=' . $request->archive_date);
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
