<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Helpers;
use App\Sim;
use App\SimResidual;
use App\SimUser;
use App\User;
use App\UserSimsCSV;
use Illuminate\Http\Request;

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
        $user = \Auth::user();

        if ($user->isAdmin() || $user->isManager()) {
            $user_title = 'Users';
        } else {
            $user_title = $user->company . ' - ' . $user->name;
        }

        return view('sim_users.index', compact('user_title'));
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
            'carrier_id' => $request->carrier,
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

        if (!$data) {
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

        if (!$data) {
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

        foreach ($sims_array as $sim) {

            if (Helpers::is_normal_user()) {
                $user = \Auth::user();
                //dd($user);
                $sim_user_result = SimUser::where([
                    'sim_number' => $sim,
                    'user_id' => $user->id,
                ])->first();

            } else {
                $sim_user_result = SimUser::where('sim_number', $sim)->first();
            }

            $user_data = [];
            if ($sim_user_result) {
                $user_data = [
                    'id' => $sim_user_result->id,
                    'sim_number' => $sim,
                    'carrier' => $sim_user_result->carrier->name,
                    'company' => $sim_user_result->user->company,
                    'user' => $sim_user_result->user->name,
                ];
            } else {
                $user_data = false;
            }

            $sim_spiff_result = Sim::where(['sim_number' => $sim])->orderBy('upload_date', 'DESC')->first();

            $sim_residual_result = SimResidual::where(['sim_number' => $sim])->orderBy('upload_date', 'DESC')->first();

            $monthly_data = [];

            if ($sim_user_result || $sim_spiff_result || $sim_residual_result) {
                $sims_found = true;

                if ($sim_spiff_result) {
                    $monthly_data = [
                        'sim_number' => $sim,
                        'value' => $sim_spiff_result->value,
                        'date' => $sim_spiff_result->activation_date,
                        'mobile' => $sim_spiff_result->mobile_number,
                        'report_type' => $sim_spiff_result->report_type->carrier->name . ' ' . $sim_spiff_result->report_type->name,
                        'upload_date' => Helpers::get_date_name($sim_spiff_result->upload_date),

                    ];

                } elseif ($sim_residual_result) {
                    $monthly_data = [
                        'sim_number' => $sim,
                        'value' => $sim_residual_result->value,
                        'date' => $sim_residual_result->activation_date,
                        'mobile' => $sim_residual_result->mobile_number,
                        'report_type' => $sim_residual_result->report_type->carrier->name . ' ' . $sim_residual_result->report_type->name,
                        'upload_date' => Helpers::get_date_name($sim_residual_result->upload_date),
                    ];
                } else {
                    $monthly_data = false;
                }

                $list_array[] = [
                    'user_data' => $user_data,
                    'monthly_data' => $monthly_data,
                ];

            }
        }

        if (!$sims_found) {
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

        foreach ($phones_array as $phone) {

            $sim = false;

            $sim_spiff_result = Sim::where(['mobile_number' => $phone])->orderBy('upload_date', 'DESC')->first();

            $sim_residual_result = SimResidual::where(['mobile_number' => $phone])->orderBy('upload_date', 'DESC')->first();

            if ($sim_spiff_result) {
                $sim = $sim_spiff_result->sim_number;
            } elseif ($sim_residual_result) {
                $sim = $sim_residual_result->sim_number;
            }

            if ($sim) {

                if (Helpers::is_normal_user()) {
                    $user = \Auth::user();
                    $sim_user_result = SimUser::where([
                        'sim_number' => $sim,
                        'user_id' => $user->id,
                    ])->first();
                } else {
                    $sim_user_result = SimUser::where('sim_number', $sim)->first();
                }

                $user_data = [];
                if ($sim_user_result) {
                    $user_data = [
                        'id' => $sim_user_result->id,
                        'sim_number' => $sim,
                        'carrier' => $sim_user_result->carrier->name,
                        'company' => $sim_user_result->user->company,
                        'user' => $sim_user_result->user->name,
                    ];
                } else {
                    $user_data = false;
                }
            } else {
                $user_data = false;
                $sim_user_result = false;
            }

            $monthly_data = [];

            if ($sim_user_result || $sim_spiff_result || $sim_residual_result) {
                $sims_found = true;

                if ($sim_spiff_result) {
                    $monthly_data = [
                        'sim_number' => $sim,
                        'value' => $sim_spiff_result->value,
                        'date' => $sim_spiff_result->activation_date,
                        'mobile' => $sim_spiff_result->mobile_number,
                        'report_type' => $sim_spiff_result->report_type->carrier->name . ' ' . $sim_spiff_result->report_type->name,
                        'upload_date' => Helpers::get_date_name($sim_spiff_result->upload_date),

                    ];

                } elseif ($sim_residual_result) {
                    $monthly_data = [
                        'sim_number' => $sim,
                        'value' => $sim_residual_result->value,
                        'date' => $sim_residual_result->activation_date,
                        'mobile' => $sim_residual_result->mobile_number,
                        'report_type' => $sim_residual_result->report_type->carrier->name . ' ' . $sim_residual_result->report_type->name,
                        'upload_date' => Helpers::get_date_name($sim_residual_result->upload_date),

                    ];
                } else {
                    $monthly_data = false;
                }

                $list_array[] = [
                    'user_data' => $user_data,
                    'monthly_data' => $monthly_data,
                ];
            }

        }

        if (!$sims_found) {
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

        if (!$request->sims_paste) {
            session()->flash('danger', 'Please enter sims to remove.');
            return redirect('/delete-sims');
        }

        $data = $request->sims_paste;

        $exploded = explode("\r\n", $data);

        $removed_array = [];
        $not_removed_array = [];

        foreach ($exploded as $item) {

            if (SimUser::where('sim_number', $item)->delete()) {

                $removed_array[] = $item;

            } else {

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

    /**
     * Show the form for transferring sims
     */
    public function transfer()
    {
        $from_users = User::whereNotIn('role_id', [1, 2, 6])->orderBy('company')->get();
        $to_users = User::whereNotIn('role_id', [1, 2, 6])->orderBy('company')->get();

        return view('sim_users.transfer', compact('from_users', 'to_users'));
    }

    /**
     * Process SIM Transfer
     */
    public function transfer_sims(Request $request)
    {
        if (!$request->sims_paste) {
            session()->flash('danger', 'Please enter sims to transfer.');
            return redirect('/transfer-sims');
        }

        $data = $request->sims_paste;

        $exploded = explode("\r\n", $data);

        $found_array = [];
        $not_found_array = [];

        foreach ($exploded as $item) {
            $sim = SimUser::where('sim_number', $item)->first();
            if (!$sim) {
                $not_found_array[] = $item;
            } else {
                $found_array[] = $item;
                $sim->user_id = $request->user_id_to;
                $sim->save();
            }
        }

        if (count($found_array)) {
            session()->flash('sims_transferred', $found_array);
        }

        if (count($not_found_array)) {
            session()->flash('sims_not_found', $not_found_array);
        }

        return redirect('/transfer-sims');
    }

    /**
     * Process SIM Transfer
     */
    public function transfer_sims_all(Request $request)
    {
        if ($request->user_id_to == $request->user_id_from) {
            session()->flash('danger', 'Please select different users.');
            return redirect('/transfer-sims');
        }

        $sims = SimUser::where('user_id', $request->user_id_from)->get();

        foreach ($sims as $sim) {
            $sim->user_id = $request->user_id_to;
            $sim->save();
        }

        session()->flash('message', 'Sims Transferred');

        return redirect('/transfer-sims');

    }

    public function download_sims()
    {
        $user_id = \Auth::user()->id;
        UserSimsCSV::process_csv_download($user_id);
    }

}
