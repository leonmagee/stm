<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        return view('settings.index', compact('months', 'years'));
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
    public function update(Request $request, Settings $settings)
    {
        //dd($request->current_month);
        //dd($request->current_year);
        $new_current_date = $request->current_month . '_' . $request->current_year;

        $settings = Settings::first();
        $settings->current_date = $new_current_date;
        $settings->save();
        //dd($settings->current_date);


        // $this->validate(request(), [
        //     'sim_number' => 'required|min:13',
        //     'value' => 'required',
        //     'activation_date' => 'required',
        //     'mobile_number' => 'required',
        //     'report_type_id' => 'required',
        // ]);

        // Sim::(request([
        //     'sim_number', 
        //     'value', 
        //     'activation_date', 
        //     'mobile_number', 
        //     'report_type_id'
        // ]));

        return redirect('/settings');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update_mode(Request $request, Settings $settings)
    {
        $mode = $request->mode; //@todo validation?
        $settings = Settings::first();
        $settings->mode = $mode;
        $settings->save();


        return redirect('/settings');
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
