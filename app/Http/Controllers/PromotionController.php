<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::all();
        return view('promotions.index', compact('promotions'));
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
        Promotion::create([
            'text' => $request->text,
        ]);

        session()->flash('message', 'Promotion has been saved.');
        return redirect()->back();

    }

    /**
     * Start Promotion
     */
    public function start_promotion(Promotion $promotion)
    {
        $actives = Promotion::where('active', 1)->get();
        foreach ($actives as $active) {
            $active->active = 0;
            $active->save();
        }
        $promotion->active = 1;
        $promotion->save();
        session()->flash('message', 'Promotion Actived!');
        return redirect()->back();
    }

    /**
     * End Promotion
     */
    public function end_promotion(Promotion $promotion)
    {
        $promotion->active = 0;
        $promotion->save();
        session()->flash('message', 'Promotion Deactivated.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        //
    }
}
