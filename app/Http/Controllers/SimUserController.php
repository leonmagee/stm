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

        $sim_list = implode('-', $exploded);

        return redirect('/list-sims/' . $sim_list);

        // foreach( $exploded as $item ) {

        //     //$sim = SimUser::where('sim_number', $item)->first();

        //     if ($sim)
        //     {
        //         $data_array[] = $sim->id;
        //     } else {
        //         // maybe look in monthly sims?
        //     }
        // }

        // if (count($data_array))
        // {
        //     $sim_query = implode('-', $data_array);
        //     return redirect('/list-sims/' . $sim_query);

        // } else {
        //     session()->flash('danger', 'No Sims were found.');
        //     return redirect('/find-sims');
        // }
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

        $sims_array = explode('-', $sims);

        $list_array = [];

        foreach( $sims_array as $sim ) {

            $sim_user_result = SimUser::where('sim_number', $sim)->first();

            $user_data = [];
            if ($sim_user_result)
            {
                $user_data = [
                    'id' => $sim_user_result->id,
                    'sim_number' => $sim,
                    'carrier' => $sim_user_result->carrier->name,
                    'company' => $sim_user_result->user->company,
                    'user' => $sim_user_result->user->name,
                ];
            }
            else
            {
                $user_data = false;    
            }

            $sim_spiff_result = Sim::where(['sim_number' => $sim])->orderBy('upload_date', 'DESC')->first();

            $sim_residual_result = SimResidual::where(['sim_number' => $sim])->orderBy('upload_date', 'DESC')->first();

            $monthly_data = [];

            if ($sim_spiff_result)
            {
                $monthly_data = [
                    'sim_number' => $sim,
                    'value' => $sim_spiff_result->value,
                    'date' => $sim_spiff_result->activation_date,
                    'mobile' => $sim_spiff_result->mobile_number,
                    'report_type' => $sim_spiff_result->report_type->carrier->name . ' ' . $sim_spiff_result->report_type->name,
                    'upload_date' => Helpers::get_date_name($sim_spiff_result->upload_date)

                ];

            }
            elseif ($sim_residual_result)
            {
                $monthly_data = [
                    'sim_number' => $sim,
                    'value' => $sim_residual_result->value,
                    'date' => $sim_residual_result->activation_date,
                    'mobile' => $sim_residual_result->mobile_number,
                    'report_type' => $sim_residual_result->report_type->carrier->name . ' ' . $sim_residual_result->report_type->name,
                    'upload_date' => Helpers::get_date_name($sim_residual_result->upload_date)

                ];
            }
            else
            {
                $monthly_data = false;
            }

           
           $list_array[] = [
            'user_data' => $user_data,
            'monthly_data' => $monthly_data
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
