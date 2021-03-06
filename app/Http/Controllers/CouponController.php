<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
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
        $coupons = Coupon::all();
        return view('coupons.index', compact('coupons'));
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
        Coupon::create([
            'code' => $request->code,
            'percent' => $request->percent,
            'expiration' => $request->expiration,
        ]);

        session()->flash('message', 'Coupon has been saved.');
        return redirect()->back();
    }

    /**
     * Start Promotion
     */
    public function start_promotion(Coupon $coupon)
    {
        $actives = Coupon::where('active', 1)->get();
        foreach ($actives as $active) {
            $active->active = 0;
            $active->save();
        }
        $coupon->active = 1;
        $coupon->save();
        session()->flash('message', 'Promotion Actived!');
        return redirect()->back();
    }

    /**
     * End Promotion
     */
    public function end_promotion(Coupon $coupon)
    {
        $coupon->active = 0;
        $coupon->save();
        session()->flash('message', 'Promotion Deactivated.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        session()->flash('danger', 'Coupon has been deleted.');
        return redirect()->back();
    }
}
