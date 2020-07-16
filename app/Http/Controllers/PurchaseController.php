<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\User;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Only Logged In Users can see this
     **/
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
        return view('purchases.index');
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
    //public function store(User $user)
    public function store(Request $request)
    {
        /**
         * Auth doesn't work because I'm using an API route?
         * But is there a reason to use an API route? It might be better to not use it, then
         * authenitcation would be required, which should be the case, then the user would need to be
         * logged in for it to work, and then I wouldn't need to pass in any data from JavaScript (except for the total) which should make sense.
         */
        //dd($request);
        \Log::debug($request->name);
        \Log::debug($request->address);
        \Log::debug('from purchase controller working');
        $user_id = \Auth::user()->id;
        Purchase::create([
            'user_id' => $user_id,
            'total' => 789,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
