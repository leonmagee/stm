<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Mail\EmailOrder;
use App\Mail\EmailOrderConfirm;
use App\Order;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $orders = Order::orderBy('created_at', 'DESC')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$carriers = Carrier::all();
        $carriers = Carrier::whereNotIn('id', [3])->get();
        return view('orders.create', compact('carriers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Store new order
        $user = \Auth()->user();
        $user_id = $user->id;
        $carriers = Carrier::all();
        $sims_array = [];
        $no_sims_added = true;
        foreach ($carriers as $carrier) {
            $key = 'sims-' . $carrier->id;
            if ($request->{$key}) {
                $sims_array[$carrier->name . ' Sims'] = number_format($request->{$key});
                $no_sims_added = false;
            }
            $key2 = 'brochures-' . $carrier->id;
            if ($request->{$key2}) {
                $sims_array[$carrier->name . ' Brochures'] = number_format($request->{$key2});
                $no_sims_added = false;
            }

        }
        if ($no_sims_added) {
            return \Redirect::back()->withErrors(['You must add some sims or brochures.']);
        }

        $order = new Order([
            'user_id' => $user_id,
            'data' => json_encode($sims_array),
        ]);
        $order->save();

        $date = \Carbon\Carbon::now()->toDateTimeString();

        /**
         * Send confirmation email
         */
        \Mail::to($user)->send(new EmailOrderConfirm(
            $user,
            $sims_array,
            $date
        ));

        /**
         * Admin email
         */
        $admin_users = User::getAdminUsers();
        //dd($admin_users);
        //$admin_users = User::whereIn('id', [1, 2])->get();
        foreach ($admin_users as $admin) {
            \Mail::to($admin)->send(new EmailOrder(
                $user,
                $sims_array,
                $date,
                $admin
            ));
        }

        // 3. Flash and redirect
        /**
         * @todo change this for actual users
         */
        session()->flash('message', 'Thank you! Your order has been submitted.');
        return redirect('/order-sims');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        session()->flash('danger', 'Order Deleted');
        return redirect('/orders');
    }
}
