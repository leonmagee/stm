<?php

namespace App\Http\Controllers;

use App\CartProduct;
//use App\Product;
use App\Mail\PurchaseEmail;
use App\ProductVariation;
use App\Purchase;
use App\PurchaseProduct;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchase_complete()
    {
        return view('purchases.complete');
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
    public function store_test(Request $request)
    {
        $request->sub_total = 777;
        $request->total = 812;
        $request->type = 'paypal';
        $request->testers = true;
        //dd($request->type);
        $this->store($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //\Log::debug($request);
        // 0. Get logged in user
        $user = \Auth::user();

        // 1. Create purchase record
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'sub_total' => $request->sub_total,
            'total' => $request->total,
            'type' => $request->type,
            'status' => 2, // pending
        ]);

        $cart_items = CartProduct::where('user_id', $user->id)->get();
        foreach ($cart_items as $item) {
            // 2. Add PuchaseProduct records (for each product)
            $final_cost = $item->product->discount_cost() * $item->quantity;
            PurchaseProduct::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
                'variation' => $item->variation,
                'discount' => $item->product->discount,
                'unit_cost' => $item->product->cost,
                'final_cost' => $final_cost,
            ]);
            // 3. Update item quantity
            $product_variation = ProductVariation::where([
                'product_id' => $item->product_id,
                'text' => $item->variation,
            ])->first();
            $new_quantity = $product_variation->quantity - $item->quantity;
            if ($new_quantity < 0) {
                $new_quantity = 0;
            }
            $product_variation->quantity = $new_quantity;
            $product_variation->save();
            // 4. Clear out cart item
            /**
             * @todo delete conditional when done testing
             */
            if (!$request->testers) {
                $item->delete();
            }
        }

        // 5. Email user who made purchse
        \Mail::to($user)->send(new PurchaseEmail(
            $user,
            $purchase
        ));

        // 6. Email admins (admins and managers)
        $admins = User::getAdminManageerUsers();
        foreach ($admins as $admin) {
            if (!$admin->notes_email_disable) {
                \Mail::to($admin)->send(new PurchaseEmail(
                    $user,
                    $purchase,
                    $admin
                ));
            }
        }

    }

    /**
     * Update shipping info. Set status to shipped.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_shipping(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        if ($purchase) {
            $purchase->tracking_number = $request->tracking_number;
            $purchase->save();
        }
        session()->flash('message', 'Tracking Number Updated - Emails Sent.');
        return redirect()->back();
    }

    /**
     * Update status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        if ($purchase) {
            $purchase->status = $request->status;
            $purchase->save();
        }
        //session()->flash('message', 'status has been updated');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
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
