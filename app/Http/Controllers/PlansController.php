<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $carriers = Carrier::whereNotIn('id', [3])->get();
        return view('plans.edit', compact('plan', 'carriers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {

        $this->validate($request, [
            'value' => 'required',
            'spiff_1' => 'required',
            'spiff_2' => 'required',
            'spiff_3' => 'required',
            'rtr' => 'required',
            'rtr_d' => 'required',
            'life' => 'required',
            'life_d' => 'required',
        ], [
            //'cc_manual_email.email' => 'Must be a valid email address.',
        ]);

        $plan->update([
            'value' => $request->value,
        ]);

        session()->flash('message', 'Plan has been updtaed');

        return redirect('/');

        //dd($plan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
