<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SimUser;
use App\Sim;
use App\SimResidual;
use App\User;
use App\Carrier;
use App\Helpers;

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
    * Process sim search
    */
    public function find_sims(Request $request)
    {
        $data = $request->sims_paste;


        $exploded = explode("\r\n", $data);

        //$data_array = [];

        // I can hash this list maybe - not sure if it matters
        $sim_list = implode('-', $exploded);

        return redirect('/list-sims/' . $sim_list);


        //dd($sim_query);


        foreach( $exploded as $item ) {

            //$sim = SimUser::where('sim_number', $item)->first();

            if ($sim)
            {
                $data_array[] = $sim->id;
            } else {
                // maybe look in monthly sims?
            }
        }

        // foreach( $exploded as $item ) {

        //     $sim = SimUser::where('sim_number', $item)->first();

        //     if ($sim)
        //     {
        //         $data_array[] = $sim->id;
        //     } else {
        //         // maybe look in monthly sims?
        //     }
        // }


        if (count($data_array))
        {
            $sim_query = implode('-', $data_array);
            return redirect('/list-sims/' . $sim_query);

        } else {
            session()->flash('danger', 'No Sims were found.');
            return redirect('/find-sims');
        }

        /**
        * So the problem is that you will need the actual sim number (not the id which will differ depending on what type of sim number it is, when you get to the results page? - so what I could do is pass in the actual sim number as a list to the results page and then loop through and have a sim bio box which lists monthly, residual, and sim users sims in an organized fashion. Should I also have sims controlls for this - like the ability to delete sims? Probably not, but this could be an item to add in the future.)

        * so I could redirect first, and then the controller for the list page will take the array of sims and search based on that?
        */
    }

    /**
    * Process sim phone serch
    */
    public function find_sims_phone(Request $request)
    {
        dd($request);
    }

    public function show_list($sims)
    {

        // $current_date = Helpers::current_date();
        // dd($current_date);


        //dd($sims);

        $sims_array = explode('-', $sims);


        //dd($sims_array);

        /**
        * @todo maybe getting the 'first' of the residual or spiff is good enough, assuming that will get the most recent residual record? For the spiff activations, it will probably only find one, but that should be good enough...
        */

        $list_array = [];

        foreach( $sims_array as $sim ) {

           $sim_user_result = SimUser::where('sim_number', $sim)->first();
           
           $sim_spiff_result = Sim::where(['sim_number' => $sim])->first();

           $sim_value = false;
           $sim_phone = false;
           $sim_report_type;

           if ($sim_spiff_result) {

            $sim_spiff = true;
            $sim_value = $sim_spiff_result->value;
            $spiff_report_type = $sim_spiff_result->report_type->name;
            //dd($spiff_report_type);

           } else {

            $sim_spiff = false;
           
           }
           
           $sim_residual_result = SimResidual::where(['sim_number' => $sim])->first();

            if ($sim_residual_result) {

            $sim_residual = true;
           
           } else {

            $sim_residual = false;
           
           }

           if ($sim_user_result)
           {
               $list_array[] = [
                    'id' => $sim_user_result->id,
                    'sim_number' => $sim,
                    'carrier' => $sim_user_result->carrier->name,
                    'user' => $sim_user_result->user->company . ' > ' . $sim_user_result->user->name,
                    'spiff' => $sim_spiff,
                    'residual' => $sim_residual,
                    'value' => $sim_value
               ];
           }
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
