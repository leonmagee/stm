<?php

namespace App\Http\Controllers;

use App\UserLoginLogout;
use Illuminate\Http\Request;

class UserLoginLogoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = UserLoginLogout::orderBy('id', 'DESC')->get();
        return view('login_tracker.index', compact('logs'));
        // 1. Create a custom view for this...
        // 2. Use datatables? There will eventually be a lot of these, but not so many it can't be queried at once.
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
        // if ($logout) {
        //     dd('this is a logout?');
        // } else {
        //     dd('this is a login!');
        // }
        // $user_id = \Auth::user()->id;
        // $session_id = $request->cookie('stm_session');
        // $time = Carbon::now();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLoginLogout  $userLoginLogout
     * @return \Illuminate\Http\Response
     */
    public function show(UserLoginLogout $userLoginLogout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLoginLogout  $userLoginLogout
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLoginLogout $userLoginLogout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLoginLogout  $userLoginLogout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLoginLogout $userLoginLogout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLoginLogout  $userLoginLogout
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLoginLogout $userLoginLogout)
    {
        //
    }
}
