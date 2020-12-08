<?php

namespace App\Http\Controllers;

use App\CartProduct;
use App\ProductFavorite;
use Illuminate\Http\Request;

class ProductFavoriteController extends Controller
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
        $user_id = \Auth::user()->id;
        $favorite = ProductFavorite::where(['user_id' => $user_id, 'product_id' => $request->id])->first();
        if ($favorite) {
            $favorite->delete();
            return 'un-favorited';
        } else {
            ProductFavorite::create([
                'user_id' => $user_id,
                'product_id' => $request->id,
            ]);
            return 'favorited';
        }
    }

    public function store_from_cart($product_id, $item_id)
    {
        $user_id = \Auth::user()->id;

        $favorited = ProductFavorite::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        $favorite = false;
        if (!$favorited) {
            $favorite = ProductFavorite::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
            ]);
        }

        if ($favorite || $favorited) {
            $cart_item = CartProduct::find($item_id);
            $cart_item->delete();

            session()->flash('message', 'Product added to Wish List.');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function show(ProductFavorite $productFavorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductFavorite $productFavorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductFavorite $productFavorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $user_id = \Auth::user()->id;
        $favorite = ProductFavorite::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        if ($favorite) {
            $favorite->delete();
            session()->flash('message', 'Product was removed from Wish List.');
        }
        return redirect()->back();
    }
}
