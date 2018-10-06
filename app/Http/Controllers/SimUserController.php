<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SimUser;
use App\Sim;
use App\SimResidual;
use App\User;
use App\Carrier;
use App\Helpers;
//use Yajra\Datatables\Datatables;

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


        // $sim_users_query = \DB::table('sim_users')->join('users', 'sim_users.user_id', '=', 'users.id')
        //     ->select(['sim_users.sim_number', 'users.company', 'users.name']);

        //     //dd($sim_users_query);

        //     $query = Datatables::of($sim_users_query)->make(true);

        //     dd($query);

        // $query = Datatables::of($sim_users_query)
        //     ->editColumn('title', '{!! str_limit($title, 60) !!}')
        //     ->editColumn('name', function ($model) {
        //         return \HTML::mailto($model->email, $model->name);
        //     })
        //     ->make(true);


// $results = \DB::select( \DB::raw(
//     "SELECT sim_users.sim_number, carriers.name, users.company 
//     FROM sim_users, carriers, users WHERE sim_users.user_id = :user_id AND sim_users.carrier_id = carriers.id AND sim_users.user_id = users.id"), array(
//    'user_id' => 12,
//  ));

// dd($results);

// $results = \DB::select( DB::raw("SELECT `sim_number` FROM 'sim_users' WHERE 'user_id' = :somevariable"), array(
//    'somevariable' => $someVariable,
//  ));





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

        if (! $data) {
            session()->flash('danger', 'No Sims were found.');
            return redirect('find-sims');
        }

        $exploded = explode("\r\n", $data);

        $sim_list = implode('-', $exploded);

        return redirect('/list-sims/' . $sim_list);
    }

    /**
    * Process sim phone serch
    */
    public function find_sims_phone(Request $request)
    {
        $data = $request->phones_paste;

        if (! $data) {
            session()->flash('danger', 'No Sims were found.');
            return redirect('find-sims');
        }

        $exploded = explode("\r\n", $data);

        $phone_list = implode('-', $exploded);

        return redirect('/list-sims-phone/' . $phone_list);
    }

    public function show_list($sims)
    {
        $sims_array = explode('-', $sims);

        $list_array = [];

        $sims_found = false;

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

            if ($sim_user_result || $sim_spiff_result || $sim_residual_result) 
            {
                $sims_found = true;


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
        }

        if (! $sims_found)
        {
            session()->flash('danger', 'No Sims were found.');
            return redirect('find-sims');
        }


        return view('sim_users.list', compact('list_array'));
    }

    public function show_list_phone($sims)
    {
        $phones_array = explode('-', $sims);

        $list_array = [];

        $sims_found = false;

        foreach( $phones_array as $phone ) {

            $sim = false;

            $sim_spiff_result = Sim::where(['mobile_number' => $phone])->orderBy('upload_date', 'DESC')->first();

            $sim_residual_result = SimResidual::where(['mobile_number' => $phone])->orderBy('upload_date', 'DESC')->first();


            if ($sim_spiff_result)
            {
                $sim = $sim_spiff_result->sim_number;
            }
            elseif($sim_residual_result)
            {
                $sim = $sim_residual_result->sim_number;
            }

            if($sim)
            {
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
            } else {
                $user_data = false;
                $sim_user_result = false;
            }

            $monthly_data = [];

            if ($sim_user_result || $sim_spiff_result || $sim_residual_result) 
            {
                $sims_found = true;

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



        }

        if (! $sims_found)
        {
            session()->flash('danger', 'No Sims were found.');
            return redirect('find-sims');
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

        if (! $request->sims_paste)
        {
            session()->flash('danger', 'Please enter sims to remove.');
            return redirect('/delete-sims');
        }

        $data = $request->sims_paste;

        $exploded = explode("\r\n", $data);

        $removed_array = [];
        $not_removed_array = [];

        foreach( $exploded as $item ) {

            if (SimUser::where('sim_number', $item)->delete())
            {

                $removed_array[] = $item;

            } 
            else
            {

                $not_removed_array[] = $item;

            }

        }

        if (count($removed_array)) {
            session()->flash('removed', $removed_array);
        }

        if (count($not_removed_array)) {
            session()->flash('not_removed', $not_removed_array);
        }

        return redirect('/delete-sims');
    }

}
