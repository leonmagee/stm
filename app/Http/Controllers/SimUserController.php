<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SimUser;
use App\User;
use App\Carrier;

class SimUserController extends AuthorizedController
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
        // $sims_user = SimUser::where('user_id', auth()->id())->get();
        // $sims = SimUser::latest()->get();
        //return view('sim_users.index', compact('sims', 'sims_user'));
        return view('sim_users.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_user(User $user)
    {
        return view('sim_users.index_user', compact('user'));
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
    * Show the form for finding sims
    */
    public function find()
    {
        return view('sim_users.find');
    }

    /**
    * Show the form for finding sims
    */
    public function find_sims(Request $request)
    {

        // query for sims that have been listed - cross refernce with monthly sims?
        // so query 3 tables?
        // give option to delete?

        $data = $request->sims_paste;

        $exploded = explode("\r\n", $data);

        $data_array = [];

        foreach( $exploded as $item ) {

            $sim = SimUser::where('sim_number', $item)->first();

            if ( $sim ) {
                $data_array[] = $sim->id;
            } else {
                // maybe look in monthly sims?
            }

        }

        $sim_query = implode('-', $data_array);

        // if (count($data_array)) {
        //     session()->flash('found', $data_array);
        // }

        return redirect('/list-sims/' . $sim_query);
    }

    public function show_list($sims)
    {

        $sims_array = explode('-', $sims);

        $list_array = [];

        foreach( $sims_array as $sim ) {

           $sim_result = SimUser::where('id', $sim)->first();

           $list_array[] = [
                'id' => $sim,
                'sim_number' => $sim_result->sim_number,
                'carrier' => $sim_result->carrier->name,
                'user' => $sim_result->user->company . ' ' . $sim_result->user->name
           ];
        }

        return view('sim_users.list', compact('list_array'));
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
