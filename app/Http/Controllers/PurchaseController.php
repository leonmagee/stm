<?php

namespace App\Http\Controllers;

use App\CartCoupon;
use App\CartProduct;
use App\Helpers;
use App\Mail\PurchaseEmail;
use App\ProductVariation;
use App\Purchase;
use App\PurchaseProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

class PurchaseController extends Controller
{
    private $shipping_charge;
    /**
     * Only Logged In Users can see this
     **/
    public function __construct()
    {
        $this->middleware('auth');
        $this->shipping_charge = config('app.stm_shipping');
        $this->shipping_max = config('app.stm_min_total');
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
    public function index_dealer()
    {
        return view('purchases.index-dealer');
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

        if (floatval(strval($balance)) < floatval(strval($total))) {
            // if ($current_user->isAdmin()) {
            //     dd('not enough');
            // }
            session()->flash('danger', 'You do not have sufficent funds in your balance for this purchase');
            return redirect()->back();
        }
        // if ($current_user->isAdmin()) {
        //     dd('so far...');
        // }
        $request->type = 'STM Balance';
        $request->sub_total = $total;
        if ($total < $this->shipping_max) {
            $total = $total + $this->shipping_charge;
        }
        if ($request->discount) {
            $request->total = ($total - $request->discount);
        } else {
            $request->total = $total;
        }

        /**
         * Store purchase
         */
        $this->store($request);
        /**
         * Update user balance
         */
        $new_balance = $balance - $request->total;
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

        if ($request->sub_total < $this->shipping_max) {
            //$total = $request->total + $this->shipping_charge;
            $shipping = $this->shipping_charge;
        } else {
            //$total = $request->total;
            $shipping = null;
        }

        // 1. Create purchase record
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'sub_total' => $request->sub_total,
            'total' => $request->total,
            'shipping' => $shipping,
            'discount' => $request->discount,
            'type' => $request->type,
            'status' => 2, // pending
            // 'address' => $request->address,
            // 'address2' => $request->address2,
            // 'city' => $request->city,
            // 'state' => $request->state,
            // 'zip' => $request->zip,
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

        //dd($purchase);

        \Mail::to($user)->send(new PurchaseEmail(
            $user,
            $purchase,
            $header_text,
            'Sales Receipt # GSW-' . $purchase->id,
            true
        ));

        // 6. Email to master agent if one exists
        if ($master_agent = $user->getMasterAgent()) {
            $header_text = "<strong>Hello " . $master_agent->name . "!</strong><br />A new purchase order has been placed by " . $user->company . " - " . $user->name;
            \Mail::to($master_agent)->send(new PurchaseEmail(
                $user,
                $purchase,
                $header_text,
                'New Purchase Order Placed',
                true,
                false,
                $master_agent
            ));
        }

        // 7. Email admins (admins and managers)
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

        $discount_coupon = CartCoupon::where('user_id', $user->id)->first();
        if ($discount_coupon) {
            $discount_coupon->delete();
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
    public function show_dealer(Purchase $purchase)
    {
        $site_id = \Auth::user()->isMasterAgent();
        if ($site_id) {
            $user = User::find($purchase->user_id);
            $user_site_id = Helpers::get_site_id($user->role_id);
            if ($site_id == $user_site_id) {
                return view('purchases.show-dealer', compact('purchase'));
            }
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function your_purchase(Purchase $purchase)
    {
        //$users = User::orderBy('company')->get();
        $user = \Auth::user();
        $show_imei = true;

        if ($user->isAdminManagerEmployee()) {
            return view('purchases.your-purchase', compact('purchase', 'user', 'show_imei'));
        }
        if ($site_id = $user->isMasterAgent()) {

            $purchase_user = User::find($purchase->user_id);
            if ($purchase_user) {
                $user_site_id = Helpers::get_site_id($purchase_user->role_id);
                //dd($user_site_id);
                if ($site_id == $user_site_id) {
                    return view('purchases.your-purchase', compact('purchase', 'user', 'show_imei'));
                }
            }
        }
        if ($user->id == $purchase->user_id) {
            return view('purchases.your-purchase', compact('purchase', 'user', 'show_imei'));
        }

        return redirect('/');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request, $agent = false)
    {
        if ($request->starting_date) {
            $start_input = $request->starting_date;
            $starting_date = Carbon::createFromFormat('M d, Y', $start_input);
            $start = $starting_date->toDateString();
        } else {
            $start_input = '';
            $start = '2020-08-01';
        }

        if ($request->ending_date) {
            $end_input = $request->ending_date;
            $ending_date = Carbon::createFromFormat('M d, Y', $end_input);
            $end = $ending_date->toDateString();
        } else {
            $end_input = '';
            $end = Carbon::now()->toDateTimeString();
        }

        $now = Carbon::now()->toDateString();
        $period = CarbonPeriod::create('2020-08-01', $now)->month();
        $months = collect($period)->map(function (Carbon $date) {
            return [
                'month' => $date->month,
                'name' => $date->format('F'),
                'days' => $date->daysInMonth,
                'string' => $date->toDateString(),
                'select' => $date->format('F Y'),

            ];
        });

        $default_query = DB::table('purchases')->select(DB::raw('SUM(purchases.total) as total'), DB::raw('count(purchases.id) as `data`'), DB::raw("DATE_FORMAT(purchases.created_at, '%m-%Y') new_date"), DB::raw('YEAR(purchases.created_at) year, MONTH(purchases.created_at) month'))
            ->join('users', 'users.id', 'purchases.user_id')
            ->groupby('new_date', 'year', 'month')
            ->orderby('new_date', 'DESC');

        $user = \Auth::user();
        $agent_user = false;
        $agents = [];
        if (($site_id = $user->isMasterAgent()) || $agent) {
            if ($agent) {
                $agent_user = User::find($agent);
                $site_id = $agent_user->master_agent_site;
                if (!$site_id) {
                    return redirect('/');
                }
            }
            $role_id = Helpers::get_role_id($site_id);
            $updated_query = $default_query
                ->where('users.role_id', $role_id)
                ->whereBetween('purchases.created_at', [$start, $end]);
            $users = User::where('role_id', $role_id)->orderBy('company', 'ASC')->get();
        } elseif ($user->isAdmin()) {
            $updated_query = $default_query
                ->whereBetween('purchases.created_at', [$start, $end]);
            $users = User::getAgentsDealersActive();
            $agents = User::getAgents();
        } else {
            return redirect('/');
        }
        $user_id = 0;
        if ($user_id = $request->user_id) {
            if (strpos($user_id, 'agent-') !== false) {
                $master_agent_id = intval(str_replace('agent-', '', $user_id));
                if ($master_agent_id) {
                    $agent_user = User::find($master_agent_id);
                    $site_id = $agent_user->master_agent_site;
                    $role_id = Helpers::get_role_id($site_id);
                    $updated_query = $default_query
                        ->where('users.role_id', $role_id);

                    if (!$site_id) {
                        return redirect('/');
                    }

                } else {
                    return redirect('/');
                }
            } else {
                $updated_query = $updated_query
                    ->where('users.id', $user_id);
            }
        }
        $monthly_data = $updated_query->get();

        $purchases = Purchase::all();
        $total_sales = 0;
        foreach ($monthly_data as $purchase) {
            $total_sales += $purchase->total;
        }

        return view('purchases.sales', compact(
            'monthly_data',
            'months',
            'now',
            'purchases',
            'total_sales',
            'user',
            'start_input',
            'end_input',
            'users',
            'user_id',
            'agent_user',
            'agents'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function sales_agents()
    {
        $agents = User::where('role_id', 3)->get();
        return view('purchases.sales-agents', compact('agents'));
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
