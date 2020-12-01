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
        $carriers = Carrier::whereNotIn('id', [3])->get();
        return view('plans.create', compact('carriers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            //'life_d.required' => 'This shit is required',
        ]);

        Plan::create([
            'value' => $request->value,
            'spiff_1' => $request->spiff_1,
            'spiff_2' => $request->spiff_2,
            'spiff_3' => $request->spiff_3,
            'spiff_4' => $request->spiff_4,
            'feature_1' => $request->feature_1,
            'feature_2' => $request->feature_2,
            'feature_3' => $request->feature_3,
            'feature_4' => $request->feature_4,
            'feature_5' => $request->feature_5,
            'feature_6' => $request->feature_6,
            'rtr' => $request->rtr,
            'rtr_d' => $request->rtr_d,
            'life' => $request->life,
            'life_d' => $request->life_d,
            'port' => $request->port,
            'carrier_id' => $request->carrier_id,
        ]);
        session()->flash('message', 'Plan Has Been Created.');
        return redirect('/');
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

        if (!$request->spiff_4) {
            $request->spiff_4 = 0;
        }

        $plan->update([
            'value' => $request->value,
            'spiff_1' => $request->spiff_1,
            'spiff_2' => $request->spiff_2,
            'spiff_3' => $request->spiff_3,
            'spiff_4' => $request->spiff_4,
            'feature_1' => $request->feature_1,
            'feature_2' => $request->feature_2,
            'feature_3' => $request->feature_3,
            'feature_4' => $request->feature_4,
            'feature_5' => $request->feature_5,
            'feature_6' => $request->feature_6,
            'rtr' => $request->rtr,
            'rtr_d' => $request->rtr_d,
            'life' => $request->life,
            'life_d' => $request->life_d,
            'port' => $request->port,
            'carrier_id' => $request->carrier_id,
        ]);
        session()->flash('message', 'Plan Data Has Been Updated.');
        return redirect('/plans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        session()->flash('message', 'Plan Has Been Deleted');
        return redirect('/');
    }
}
