<?php

namespace App\Http\Controllers;

use App\TrackingNumber;
use Illuminate\Http\Request;

class TrackingNumberController extends Controller
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
        //dd($request);
        TrackingNumber::create([
            'purchase_id' => $request->purchase_id,
            'tracking_number' => $request->tracking_number,
            'shipping_type' => $request->shipping_type,
        ]);
        session()->flash('message', 'Tracking Number added.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrackingNumber  $trackingNumber
     * @return \Illuminate\Http\Response
     */
    public function show(TrackingNumber $trackingNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrackingNumber  $trackingNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(TrackingNumber $trackingNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrackingNumber  $trackingNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrackingNumber $trackingNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrackingNumber  $trackingNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrackingNumber $trackingNumber)
    {
        $trackingNumber->delete();
        session()->flash('danger', 'Tracking Number removed.');
        return redirect()->back();

    }
}
