<?php

namespace App\Http\Controllers;

use App\CartProduct;
use App\Mail\PurchaseEmail;
use App\ProductVariation;
use App\Purchase;
use App\PurchaseProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function your_purchases()
    {
        $user_id = \Auth::user()->id;
        $purchases = Purchase::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view('purchases.your-purchases', compact('purchases'));
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
    // public function store_test(Request $request)
    // {
    //     $request->sub_total = 777;
    //     $request->total = 812;
    //     $request->type = 'paypal';
    //     $request->testers = true;
    //     //dd($request->type);
    //     $this->store($request);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay_with_balance(Request $request)
    {
        $current_user = \Auth::user();
        $balance = $current_user->balance;
        $user_id = $current_user->id;
        $items = CartProduct::where('user_id', $user_id)->get();
        $total = 0;
        foreach ($items as $item) {
            $total += $item->product->discount_cost() * $item->quantity;
            $variation = ProductVariation::where(['product_id' => $item->product_id, 'text' => $item->variation])->first();
            if ($variation->quantity < $item->quantity) {
                session()->flash('danger', 'Quantity Discrepancy. Please refresh and try again.');
                return redirect()->back();
            }
        }

        if (floatval($balance) < floatval($total)) {
            session()->flash('danger', 'You do not have sufficent funds in your balance for this purchase');
            return redirect()->back();
        }
        $request->type = 'STM Balance';
        $request->sub_total = $total;
        $request->total = $total;

        /**
         * Store purchase
         */
        $this->store($request);
        /**
         * Update user balance
         */
        $new_balance = $balance - $total;
        $current_user->balance = $new_balance;
        $current_user->save();
        /**
         * Go to confirmation page
         */
        return redirect('purchase-complete');
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
            $item->delete();

            // 4. Clear out cart item
            /**
             * @todo delete conditional when done testing
             */
            // if (!$request->testers) {
            //     $item->delete();
            // }
        }

        // 5. Email user who made purchse
        $header_text = "<strong>Hello " . $user->name . "!</strong><br />Thanks for giving us the opportunity to serve you. We truly appreciate your business, and we're grateful for the trust you've placed in us. Your tracking number will be provided ASAP when it becomes available. CHEERS!!";

        \Mail::to($user)->send(new PurchaseEmail(
            $user,
            $purchase,
            $header_text,
            'Sales Receipt # GSW-' . $purchase->id,
            true
        ));

        // 6. Email admins (admins and managers)
        $admins = User::getAdminManageerUsers();
        foreach ($admins as $admin) {
            if (!$admin->notes_email_disable) {
                $header_text = "<strong>Hello " . $admin->name . "!</strong><br />A new purchase order has been placed by " . $user->company . " - " . $user->name;

                \Mail::to($admin)->send(new PurchaseEmail(
                    $user,
                    $purchase,
                    $header_text,
                    'New Purchase Order Placed',
                    false
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
            //$purchase->tracking_number = $request->tracking_number;
            //$purchase->shipping_type = $request->shipping_type;
            $purchase->status = 3;
            $purchase->save();
        }

        // $header_text = "<strong>Hello " . $purchase->user->name . "!</strong><br />Your order has shipped. Here is your <strong>" . $purchase->shipping_type . "</strong> tracking number: <strong>" . $purchase->tracking_number ."</strong>.";
        $header_text = "<div class='margin-bottom-10'><div><strong>Hello " . $purchase->user->name . "!</strong><br />Your order has shipped. Here is your tracking information:</div>";
        foreach ($purchase->tracking_numbers as $tracking_number) {
            $header_text .= "<div><strong>" . $tracking_number->tracking_number . "</strong> - <strong>" . $tracking_number->shipping_type . "</strong></div>";
        }
        $header_text .= "</div>";

        $email_subject = 'Purchase Order GSW-' . $purchase->id . ' has Shipped';

        \Mail::to($purchase->user)->send(new PurchaseEmail(
            $purchase->user,
            $purchase,
            $header_text,
            $email_subject,
            true,
            true
        ));

        if ($cc_user_id = $request->cc_user_1) {

            $cc_user = User::find($cc_user_id);

            \Mail::to($cc_user->email)->send(new PurchaseEmail(
                $purchase->user,
                $purchase,
                $header_text,
                $email_subject,
                false,
                true
            ));
        }
        if ($cc_user_2_email = $request->cc_user_2) {
            \Mail::to($cc_user_2_email)->send(new PurchaseEmail(
                $purchase->user,
                $purchase,
                $header_text,
                $email_subject,
                false,
                true
            ));

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
        $users = User::orderBy('company')->get();
        return view('purchases.show', compact('purchase', 'users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function your_purchase(Purchase $purchase)
    {
        $users = User::orderBy('company')->get();
        $user = \Auth::user();
        $show_imei = true;

        return view('purchases.your-purchase', compact('purchase', 'user', 'show_imei'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function sales()
    {
        $monthly_data = DB::table('purchases')->select(DB::raw('SUM(total) as total'), DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('new_date', 'year', 'month')
            ->get();
        //dd($monthly_data);

        $user = \Auth::user();
        if ($user->isAdmin()) {
            $purchases = Purchase::all();
            $total_sales = 0;
            foreach ($purchases as $purchase) {
                $total_sales += $purchase->total;
            }
            //dd($total_sales);
        } else {
            dd('not admin');
        }
        return view('purchases.sales', compact('total_sales', 'monthly_data', 'purchases', 'user'));
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
