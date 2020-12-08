<?php

namespace App\Http\Controllers;

use App\CartProduct;
use App\ProductSave;
use Illuminate\Http\Request;

class ProductSaveController extends Controller
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
    public function store($product_id, $item_id)
    {
        //dd($product_id . " - " . $item_id);

        $user_id = \Auth::user()->id;

        $saved = ProductSave::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        if (!$saved) {
            $save = ProductSave::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
            ]);
        }

        if ($save || $saved) {
            $cart_item = CartProduct::find($item_id);
            $cart_item->delete();

            session()->flash('message', 'Product added to saved list.');
            return redirect()->back();

        }

        // $save = ProductSave::where(['user_id' => $user_id, 'product_id' => $request->id])->first();
        // if ($save) {
        //     $save->delete();
        //     return 'un-favorited';
        // } else {
        //     ProductFavorite::create([
        //         'user_id' => $user_id,
        //         'product_id' => $request->id,
        //     ]);
        //     return 'favorited';
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductSave  $productSave
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSave $productSave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductSave  $productSave
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSave $productSave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductSave  $productSave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductSave $productSave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductSave  $productSave
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $user_id = \Auth::user()->id;
        $product_saved = ProductSave::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        $product_saved->delete();
        session()->flash('message', 'Saved product has been removed.');
        return redirect()->back();
    }
}
