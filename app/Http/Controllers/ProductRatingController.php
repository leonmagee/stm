<?php

namespace App\Http\Controllers;

use App\ProductRating;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Log;

class ProductRatingController extends Controller
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
        $rating = ProductRating::where([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ])->first();
        //$rating->stars = $request->stars;
        // Log::debug($rating);
        // dd($rating);
        if ($rating) {
            $rating->stars = $request->stars;
            $rating->save();
            //Log::debug($rating);
            //Log::debug('this far?');
        } else {
            ProductRating::create([
                'stars' => $request->stars,
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
            ]);
        }
        // Log::debug($request->stars);
        // Log::debug($request->user_id);
        // Log::debug($request->product_id);
        // Log::debug('just a debug test');
        //dd('working');
        return response('Rating Updated', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRating $productRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRating $productRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRating $productRating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRating $productRating)
    {
        //
    }
}
