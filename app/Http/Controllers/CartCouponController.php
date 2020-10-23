<?php

namespace App\Http\Controllers;

use App\CartCoupon;
use App\Coupon;
use Illuminate\Http\Request;

class CartCouponController extends Controller
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
        $user = \Auth::user();
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        // error if coupon does not match
        if (!$coupon) {
            session()->flash('danger', 'Coupon not found.');
            return redirect()->back();
        }
        // see if user has a coupon applied
        $current = CartCoupon::where('user_id', $user->id)->first();
        if ($current) {
            $current->delete();
        }
        CartCoupon::create([
            'user_id' => $user->id,
            'coupon_id' => $coupon->id,
        ]);
        session()->flash('message', 'Coupon applied.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartCoupon  $cartCoupon
     * @return \Illuminate\Http\Response
     */
    public function show(CartCoupon $cartCoupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartCoupon  $cartCoupon
     * @return \Illuminate\Http\Response
     */
    public function edit(CartCoupon $cartCoupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartCoupon  $cartCoupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartCoupon $cartCoupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartCoupon  $cartCoupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartCoupon $coupon)
    {
        $coupon->delete();
        session()->flash('message', 'Coupon removed.');
        return redirect()->back();
    }
}
