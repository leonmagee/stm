<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SimUser;

use App\User;

class SimUserController extends AuthorizedController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sims_user = SimUser::where('user_id', auth()->id())->get();
        $sims = SimUser::latest()->get();
        return view('sim_users.index', compact('sims', 'sims_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        //dd($users);
        return view('sim_users.assign-sims', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'sim_number' => 'required|min:13',
            'user_id' => 'required', // how to make this have to be a user id?
        ]);

        SimUser::create(request(['sim_number', 'user_id']));

        return redirect('/sim_users'); //@todo create new route for sims assigned to users
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SimUser $sim)
    {
        return view('sim_users.show', compact('sim'));
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
