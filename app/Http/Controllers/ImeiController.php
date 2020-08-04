<?php

namespace App\Http\Controllers;

use App\Imei;
use Illuminate\Http\Request;

class ImeiController extends Controller
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
        Imei::create([
            'purchase_product_id' => $request->purchase_product_id,
            'imei' => $request->imei_number,
        ]);
        session()->flash('message', 'IMEI Number added.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Imei  $imei
     * @return \Illuminate\Http\Response
     */
    public function show(Imei $imei)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Imei  $imei
     * @return \Illuminate\Http\Response
     */
    public function edit(Imei $imei)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Imei  $imei
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imei $imei)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Imei  $imei
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imei $imei)
    {
        $imei->delete();
        session()->flash('danger', 'IMEI number removed');
        return redirect()->back();
    }
}
