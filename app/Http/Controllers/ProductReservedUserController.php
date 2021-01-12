<?php

namespace App\Http\Controllers;

use App\ProductReservedUser;
use Illuminate\Http\Request;

class ProductReservedUserController extends Controller
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
        ProductReservedUser::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);
        session()->flash('message', 'User Reserved.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductReservedUser  $productReservedUser
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReservedUser $productReservedUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductReservedUser  $productReservedUser
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReservedUser $productReservedUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductReservedUser  $productReservedUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductReservedUser $productReservedUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductReservedUser  $productReservedUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReservedUser $productReservedUser)
    {
        $productReservedUser->delete();
        session()->flash('message', 'Reserved User Removed.');
        return redirect()->back();

    }
}
