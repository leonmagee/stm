<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Site;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $current_site_id = session('current_site_id', 1);
        // echo 'site id: ' . $current_site_id;

        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );
        $years = array(2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025);
        $sites = Site::all();
        $settings = Settings::first();
        $mode = $settings->mode;
        //$current_site = $settings->site_id;
        $current_site = session('current_site_id', 1);
        $date_array = explode('_', $settings->current_date);
        $current_month = $date_array[0];
        $current_year = $date_array[1];
        return view('settings.index', compact(
            'months',
            'years',
            'sites',
            'mode',
            'current_site',
            'current_month',
            'current_year')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_site()
    {
        $settings = Settings::first();
        $site_name = $settings->site->name;
        $site = Site::find($settings->site_id);
        $spiff = $site->default_spiff_amount;
        $residual = $site->default_residual_percent;
        return view('settings.site-settings', compact('site_name', 'spiff', 'residual'));
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
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update_date(Request $request, Settings $settings)
    {
        $new_current_date = $request->current_month . '_' . $request->current_year;

        $settings = Settings::first();
        $settings->current_date = $new_current_date;
        $settings->save();

        return redirect('/settings');
    }

    public function update_mode(Request $request, Settings $settings)
    {
        $mode = $request->mode;
        $settings = Settings::first();
        $settings->mode = $mode;
        $settings->save();


        return redirect('/settings');
    }

    public function update_site(Request $request, Settings $settings)
    {
        $site = $request->site;
        $settings = Settings::first();
        $settings->site_id = $site;



        //session('current_site_id') = $site;

    // Specifying a default value...
    //$value = session('key', 'default');

    // Store a piece of data in the session...
    session(['current_site_id' => $site]);



        $settings->save();

        return redirect('/settings');
    }

    public function update_spiff(Request $request, Settings $settings)
    {
        $spiff = $request->default_spiff;
        $settings = Settings::first();
        $site = Site::find(session('current_site_id', 1));
        $site->default_spiff_amount = $spiff;
        $site->save();

        session()->flash('message', 'Spiff value updated.');

        return redirect('/site-settings');
    }

    public function update_residual(Request $request, Settings $settings)
    {
        $residual = $request->default_percent;
        $settings = Settings::first();
        $site = Site::find(session('current_site_id', 1));
        $site->default_residual_percent = $residual;
        $site->save();

        session()->flash('message', 'Residual percent updated.');

        return redirect('/site-settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
