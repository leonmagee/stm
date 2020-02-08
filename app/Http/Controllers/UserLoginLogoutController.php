<?php

namespace App\Http\Controllers;

use App\User;
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
        //$logs = UserLoginLogout::orderBy('id', 'DESC')->get();
        return view('login_tracker.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLoginLogout  $userLoginLogout
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $logs = UserLoginLogout::where('user_id', $user->id)->get();
        $data = true;
        if ($logs->isEmpty()) {
            $data = false;
        }
        return view('login_tracker.show', compact('user', 'data'));
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
