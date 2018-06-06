<?php

namespace App\Http\Controllers;

use App\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    /**
    * Only Logged In Users can see this
    **/
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
        $carriers = Carrier::all();
        return view('carriers.index', compact('carriers'));
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
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function show(carrier $carrier)
    {
        return view('carriers.show', compact('carrier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function edit(carrier $carrier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, carrier $carrier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function destroy(carrier $carrier)
    {
        //
    }
}
