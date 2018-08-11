<?php

namespace App\Http\Controllers;

use App\User;
use App\Site;
use App\Settings;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_id = Settings::first()->site_id;
        $site_name = Site::find($site_id)->name;
        $users = User::where('role', $site_id)->get();
        return view('users.index', compact('users', 'site_name'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $amount = 33;
        $credit = '$' . number_format($amount, 2);
        $role = $user->role;
        if ( $role == 'admin' ) {
            $role = 'Admin';
        } else {
            $role = Site::find($role)->name;
        }
        return view('users.show', compact('user', 'credit', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
