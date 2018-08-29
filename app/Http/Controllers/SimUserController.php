<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SimUser;
use App\User;
use App\Carrier;

class SimUserController extends AuthorizedController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sims_user = SimUser::where('user_id', auth()->id())->get();
        // $sims = SimUser::latest()->get();
        //return view('sim_users.index', compact('sims', 'sims_user'));
        return view('sim_users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $carriers = Carrier::all();
        //dd($users);
        return view('sim_users.assign-sims', compact('users', 'carriers'));
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
            'carrier' => 'required',
            'user_id' => 'required', // how to make this have to be a user id?
        ]);

        SimUser::create([
            'sim_number' => $request->sim_number,
            'user_id' => $request->user_id,
            'carrier_id' => $request->carrier
        ]);

        return redirect('/sim-users'); //@todo create new route for sims assigned to users
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
    * Show the form for deleting sims
    */
    public function delete()
    {
        return view('sim_users.delete');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->sims_paste;

        $exploded = explode("\r\n", $data);

        $data_array = [];

        foreach( $exploded as $item ) {

            SimUser::where('sim_number', $item)->delete();

            $data_array[] = $item;
        }

        if (count($data_array)) {
            session()->flash('removed', $data_array);
        }

        return redirect('/user-sims');
    }

}
