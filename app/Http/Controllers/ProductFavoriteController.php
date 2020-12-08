<?php

namespace App\Http\Controllers;

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
            session()->flash('message', 'Favorite removed.');
        }
        return redirect()->back();
    }
}
