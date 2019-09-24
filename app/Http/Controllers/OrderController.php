<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Mail\EmailOrder;
use App\Order;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
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
        $carriers = Carrier::all();
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
        $order = new Order([
            'user_id' => $user_id,
            'sims' => $request->sims,
            'carrier_id' => $request->carrier_id,
        ]);
        $order->save();

        $date = \Carbon\Carbon::now()->toDateTimeString();

        // 2. Email Managers
        $admin_users = User::getAdminManageerEmployeeUsers();
        foreach ($admin_users as $admin) {
            \Mail::to($admin)->send(new EmailOrder(
                $user,
                number_format($request->sims),
                $order->carrier->name,
                $date,
            ));
        }

        // 3. Flash and redirect
        /**
         * @todo change this for actual users
         */
        session()->flash('message', 'New Order Added');
        return redirect('/orders');
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
        //
    }
}
