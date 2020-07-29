<?php

namespace App\Http\Controllers;

use App\Rma;
use Illuminate\Http\Request;

class RmaController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function your_rmas()
    {
        $user_id = \Auth::user()->id;
        $rmas = Rma::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view('rmas.your-rmas', compact('rmas'));
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
        Rma::create(
            [
                'user_id' => \Auth::user()->id,
                'purchase_product_id' => $request->purchase_product_id,
                'quantity' => $request->quantity,
                'explanation' => $request->explanation,
            ]
        );
        session()->flash('message', 'An RMA request has been submitted. You will receive an email with more details. <a href="/your-rmas">View RMA</a>.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function show(Rma $rma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function edit(Rma $rma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rma $rma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rma $rma)
    {
        //
    }
}
