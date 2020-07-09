<?php

namespace App\Http\Controllers;

use App\CartProduct;
use Illuminate\Http\Request;

class CartProductController extends Controller
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
        $user_id = \Auth::user()->id;
        $items = CartProduct::where('user_id', $user_id)->get();
        // get cart data for user
        return view('products.cart', compact('items'));
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
        $user_id = \Auth::user()->id;

        // $existing = CartProduct::where([
        //     'product_id' => $request->product_id,
        //     'user_id' => $user_id,
        // ])->first();
        // if ($existing) {
        //     $existing->delete();
        // }

        CartProduct::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'variation' => $request->variation,
            'user_id' => $user_id,
        ]);
        session()->flash('message', 'Your Cart Has Been Updated');
        return redirect('/cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CartProduct $cartProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartProduct $item)
    {
        $item->variation = $request->variation;
        $item->quantity = $request->quantity ? $request->quantity : 1;
        $item->save();

        //session()->flash('message', 'update');
        return redirect('/cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartProduct $item)
    {
        $item->delete();
        session()->flash('danger', 'Item Has Been Removed');
        return redirect('/cart');
    }
}
