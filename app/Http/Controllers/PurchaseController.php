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
            // 'address' => $request->address,
            // 'address2' => $request->address2,
            // 'city' => $request->city,
            // 'state' => $request->state,
            // 'zip' => $request->zip,
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
        $header_text = "<strong>Hello " . $user->name . "!</strong><br />Thanks for giving us the opportunity to serve you. We truly appreciate your business, and we're grateful for the trust you've placed in us. Your tracking number will be provided ASAP when it becomes available. CHEERS!!";

        \Mail::to($user)->send(new PurchaseEmail(
            $user,
            $purchase,
            $header_text,
            'Sales Receipt # GSW-' . $purchase->id
        ));

        // 6. Email admins (admins and managers)
        $admins = User::getAdminManageerUsers();
        foreach ($admins as $admin) {
            if (!$admin->notes_email_disable) {
                $header_text = "<strong>Hello " . $admin->name . "!</strong><br />A new purchase order has been submitted by " . $user->company . " - " . $user->name;

                \Mail::to($admin)->send(new PurchaseEmail(
                    $user,
                    $purchase,
                    $header_text,
                    'New Purchase Order Placed'
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
            $purchase->shipping_type = $request->shipping_type;
            $purchase->status = 3;
            $purchase->save();
        }
        $header_text = "<strong>Hello " . $purchase->user->name . "!</strong><br />Your order was shipped by <strong>" . $purchase->shipping_type . "</strong>, the tracking number is <strong>" . $purchase->tracking_number . "</strong>.";

        //$email_subject = 'Order Shipped - Tracking Number: ' . $purchase->tracking_number;
        $email_subject = 'Purchase Order GSW-' . $purchase->id . ' has Shipped';

        \Mail::to($purchase->user)->send(new PurchaseEmail(
            $purchase->user,
            $purchase,
            $header_text,
            $email_subject
        ));

        if ($cc_user_id = $request->cc_user_1) {

            $cc_user = User::find($cc_user_id);

            \Mail::to($cc_user->email)->send(new PurchaseEmail(
                $purchase->user,
                $purchase,
                $header_text,
                $email_subject
            ));
        }
        if ($cc_user_2_email = $request->cc_user_2) {
            \Mail::to($cc_user_2_email)->send(new PurchaseEmail(
                $purchase->user,
                $purchase,
                $header_text,
                $email_subject
            ));

        }

        // $admins = User::getAdminManageerUsers();
        // foreach ($admins as $admin) {
        //     if (!$admin->notes_email_disable) {
        //         $header_text = "<strong>Hello " . $admin->name . "!</strong><br />Purchase order has shipped. The tracking number is " . $purchase->tracking_number . " shipped via " . $purchase->shipping_type . ".";

        //         \Mail::to($admin)->send(new PurchaseEmail(
        //             $purchase->user,
        //             $purchase,
        //             $header_text,
        //             'Purchase Order Shipped: ' . $purchase->tracking_number
        //         ));
        //     }
        // }

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
        $users = User::orderBy('company')->get();
        return view('purchases.show', compact('purchase', 'users'));
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
