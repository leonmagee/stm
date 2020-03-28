<?php

namespace App\Http\Controllers;

use App\BalanceTracker;
use App\Helpers;
use App\Mail\EmailBalance;
use App\ReportType;
use App\Settings;
use App\Site;
use App\User;
use App\UserCreditBonus;
use App\UserPlanValues;
use App\UserResidualPercent;
use Illuminate\Http\Request;
use \DB;

class UserController extends Controller
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
        $settings = Settings::first();
        $site_id = $settings->get_site_id();
        $role_id = $settings->get_role_id();
        $site_name = Site::find($site_id)->name;
        $users = User::where('role_id', $role_id)->orderBy('company')->get();
        return view('users.index', compact('users', 'site_name'));
    }

    /**
     * Track user balance changes
     */
    public function balanceTracker()
    {
        //return view('login_tracker.index');
        return view('users.balance-tracker');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function your_dealers()
    {
        $logged_in_user = \Auth::user();
        if (!$id = $logged_in_user->master_agent_site) {
            return redirect('/');
        }
        $site = Site::find($id);
        $site_name = $site->name;
        $users = User::where('role_id', $site->role_id)->orderBy('company')->get();
        //return view('users.your_dealers', compact('users', 'site_name'));
        return view('users.all-users', compact('users', 'site_name'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_users()
    {
        $sites = Site::all();
        $settings = Settings::first();
        $site_id = $settings->get_site_id();
        $role_id = $settings->get_role_id();
        $site_name = Site::find($site_id)->name;
        // query all non-admin users
        // @todo fix this hardcoding...
        //$users = User::whereIn('role_id', array(3, 4, 5, 7))->orderBy('company')->get();
        $users = User::orderBy('company')->get();
        //$users = User::all();
        // dd($sites);
        // foreach ($users as $user) {
        //     var_dump($user->role_id);
        // }
        //dd($users->first());
        // $fake_site = new \stdClass();
        // $fake_site->name = "Closed";
        // $fake_site->role_id = 7;
        // $sites[] = $fake_site;
        // $sites_decoded = json_encode($sites);
        //dd($sites_decoded);
        return view('users.all-users')->with(
            [
                'users' => json_encode($users),
                'sites' => json_encode($sites),
                'current' => $role_id,
            ]
        );
        //$users = User::where('role_id', $role_id)->orderBy('company')->get();
        //return view('users.all-users', compact('users', 'site_name'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_managers()
    {
        $site_name = 'Admin & Manager';
        $managers_array = [1, 2, 6];
        $users = User::whereIn('role_id', $managers_array)->get();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function add_note(Request $request, User $user)
    // {
    //     $current_user = \Auth::user();
    //     $note = new \App\Note;
    //     $note->text = $request->note;
    //     $note->user_id = $user->id;
    //     $note->author = $current_user->name;
    //     $date = \Carbon\Carbon::now()->toDateTimeString();
    //     $note->save();

    //     $admin_users = User::getAdminManageerEmployeeUsers();
    //     foreach ($admin_users as $admin) {
    //         if (!$admin->notes_email_disable) {
    //             \Mail::to($admin)->send(new EmailNote(
    //                 $admin,
    //                 $note->text,
    //                 $note->author,
    //                 $date,
    //                 $user
    //             ));
    //         }
    //     }

    //     session()->flash('message', 'Note Added');
    //     return redirect('/users/' . $user->id);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function delete_note(User $user, $index)
    // {
    //     if ($user->notes) {
    //         $notes = json_decode($user->notes);
    //         unset($notes[$index]);
    //         $notes = array_values($notes); // re-index array
    //         if (!empty($notes)) {
    //             $user->notes = json_encode($notes);
    //         } else {
    //             $user->notes = null;
    //         }
    //         $user->save();
    //         session()->flash('danger', 'Note Deleted');
    //         return redirect('/users/' . $user->id);
    //         /**
    //          * Then I need to check if the array is empty?
    //          * @todo check array length and then set notes to null if empty?
    //          */
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //dd($user->id);
        $recharge_data_array = $this->recharge($user->id);
        $third_recharge_data_array = $this->third_recharge($user->id);
        //dd($data);
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date(),
        ])->first();

        if (isset($bonus_credit->bonus)) {
            $bonus = '$' . number_format($bonus_credit->bonus, 2);
        } else {
            $bonus = false;
        }
        if (isset($bonus_credit->credit)) {
            $credit = '$' . number_format($bonus_credit->credit, 2);
        } else {
            $credit = false;
        }

        $is_admin = Helpers::current_user_admin();

        $role = $user->role->id;

        //dd($user->role->name);

        if ($role === 1) {
            $role = 'Admin';
        } else {
            //$role = Site::find($role)->name;
            $role = $user->role->name;
        }

        //$notes = json_decode($user->notes);
        $notes = $user->notes;
        //dd($notes);
        return view('users.show', compact('user', 'notes', 'role', 'bonus', 'credit', 'is_admin', 'recharge_data_array', 'third_recharge_data_array'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_dealer(User $user)
    {
        //dd($user->id);
        $recharge_data_array = $this->recharge($user->id);
        $third_recharge_data_array = $this->third_recharge($user->id);
        //dd($data);
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date(),
        ])->first();

        if (isset($bonus_credit->bonus)) {
            $bonus = '$' . number_format($bonus_credit->bonus, 2);
        } else {
            $bonus = false;
        }
        if (isset($bonus_credit->credit)) {
            $credit = '$' . number_format($bonus_credit->credit, 2);
        } else {
            $credit = false;
        }

        $is_admin = Helpers::current_user_admin();

        $role = $user->role->id;

        //dd($user->role->name);

        if ($role === 1) {
            $role = 'Admin';
        } else {
            //$role = Site::find($role)->name;
            $role = $user->role->name;
        }

        //$notes = json_decode($user->notes);
        $notes = $user->notes;
        //dd($notes);
        return view('users.show_dealer', compact('user', 'notes', 'role', 'bonus', 'credit', 'is_admin', 'recharge_data_array', 'third_recharge_data_array'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $user = \Auth::user();
        $role = $user->role->name;
        if ($user->role->id > 2) {
            $bonus_credit = UserCreditBonus::where([
                'user_id' => $user->id,
                'date' => Helpers::current_date(),
            ])->first();

            if (isset($bonus_credit->bonus)) {
                $bonus = '$' . number_format($bonus_credit->bonus, 2);
            } else {
                $bonus = false;
            }
            if (isset($bonus_credit->credit)) {
                $credit = '$' . number_format($bonus_credit->credit, 2);
            } else {
                $credit = false;
            }

            return view('users.profile-user', compact('user', 'role', 'bonus', 'credit'));
        } else {
            return view('users.profile-admin-manager', compact('user', 'role'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $is_admin = Helpers::current_user_admin();
        $sites = Site::all();
        $master_agent_sites = Site::whereNotIn('id', [1, 2, 3, 4])->get();
        return view('users.edit', compact('user', 'sites', 'is_admin', 'master_agent_sites'));
    }

    public function edit_profile()
    {
        if ($user = \Auth::user()) {
            return view('users.edit_profile', compact('user'));

        } else {
            return redirect('/');
        }
    }

    public function edit_password(User $user)
    {
        return view('users.edit_password', compact('user'));
    }

    public function edit_profile_password()
    {
        return view('users.edit_profile_password');
    }

    /**
     * User Plan Values and Residual Percent overrides
     */
    public function user_plan_residual(User $user)
    {
        $report_types_spiff = ReportType::where('spiff', 1)->get();
        $report_types_residual = ReportType::where('spiff', 0)->get();
        $user_plan_items = UserPlanValues::where('user_id', $user->id)
            ->orderBy('report_type_id')->orderBy('plan_value')->get();
        $user_residual_items = UserResidualPercent::where('user_id', $user->id)
            ->orderBy('report_type_id')->get();

        return view('users.user-plan-values', compact(
            'user',
            'report_types_spiff',
            'report_types_residual',
            'user_plan_items',
            'user_residual_items'
        ));
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
        /**
         * @todo test this - refactor - big conidtional isn't necessary anymore...
         */
        if ($request->notes_email_disable) {
            $disable = 1;
        } else {
            $disable = 0;
        }

        if ($request->email_blast_disable) {
            $blast_disable = 1;
        } else {
            $blast_disable = 0;
        }

        if ($request->contact_email_disable) {
            $contact_disable = 1;
        } else {
            $contact_disable = 0;
        }

        if ($request->master_agent_site) {
            $master_agent_site = $request->master_agent_site;
        } else {
            $master_agent_site = null;
        }

        //dd($request);

        //validate the form
        if (Helpers::current_user_admin()) {

            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'company' => 'required',
                'phone' => 'required|digits:10',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                //'notes' => 'string|nullable',
                'role_id' => 'required',
                //'role_id' => 'required|gt:2', //prevent front end hack to create admin
            ]);

            // update user
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                //'notes' => $request->notes,
                'role_id' => $request->role_id,
                'notes_email_disable' => $disable,
                'email_blast_disable' => $blast_disable,
                'contact_email_disable' => $contact_disable,
                'master_agent_site' => $master_agent_site,
            ]);
        } else {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'company' => 'required',
                'phone' => 'required|digits:10',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required|nullable',
                //'notes' => 'string|nullable',
            ]);

            // update user
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'notes_email_disable' => $disable,
                'email_blast_disable' => $blast_disable,
                'contact_email_disable' => $contact_disable,
                //'notes' => $request->notes,
            ]);
        }

        session()->flash('message', 'User ' . $request->name . ' has been updated.');

        return redirect('users/' . $id);
    }

    public function update_admin_manager(Request $request)
    {
        if ($user = \Auth::user()) {

            if ($request->notes_email_disable) {
                $disable = 1;
            } else {
                $disable = 0;
            }

            if ($request->email_blast_disable) {
                $blast_disable = 1;
            } else {
                $blast_disable = 0;
            }

            if ($request->contact_email_disable) {
                $contact_disable = 1;
            } else {
                $contact_disable = 0;
            }

            $id = $user->id;

            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'company' => 'required',
                'phone' => 'required|digits:10',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
            ]);

            // update user
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'notes_email_disable' => $disable,
                'email_blast_disable' => $blast_disable,
                'contact_email_disable' => $contact_disable,
            ]);

            session()->flash('message', 'Your profile has been updated.');

            return redirect('/profile');

        } else {

            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $id)
    {
        // validate the form
        $this->validate(request(), [
            'password' => 'required|confirmed|min:8',
        ]);

        // update user
        $user = User::find($id)->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('message', 'Password updated.');

        return redirect('users/' . $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profile_password(Request $request)
    {
        if ($user = \Auth::user()) {

            $id = $user->id;
            // validate the form
            $this->validate(request(), [
                'password' => 'required|confirmed|min:8',
            ]);

            // update user
            $user = User::find($id)->update([
                'password' => bcrypt($request->password),
            ]);

            session()->flash('message', 'Password updated.');

            return redirect('profile');

        } else {

            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('message', 'User ' . $user->name . ' | ' . $user->company . ' has been deleted.');

        return redirect('users');
    }

    /**
     * Axios change user sites
     */
    public function changeUserSites(request $request)
    {
        $rold_id_int = intval($request->roleId);
        foreach ($request->selectedUsers as $id) {
            $id_intval = intval($id);
            User::find($id_intval)->update([
                'role_id' => $rold_id_int,
            ]);
        }
        return $request->selectedUsers;
    }

    /**
     * Axios change user balance
     */
    public function changeUserBalance(request $request)
    {
        $user_id = intval($request->selectedUserEdit['id']);
        $balance = floatval($request->newBalance);
        $difference = $request->difference;
        $note = $request->note;
        $user = User::find($user_id);
        $old_balance = $user->balance ? $user->balance : 0;
        $user->balance = $balance;
        $user->save();
        $logged_in = \Auth()->user();
        BalanceTracker::create([
            'admin_id' => $logged_in->id,
            'user_id' => $user_id,
            'previous_balance' => $old_balance,
            'difference' => $difference,
            'new_balance' => $balance,
            'note' => $note,
        ]);
        $date = \Carbon\Carbon::now()->format('F d, Y');
        if ($difference > 0) {
            $difference = '$' . number_format($difference, 2);
        } else {
            $difference = '-$' . number_format(abs($difference), 2);
        }
        /**
         * Email user then all admins without note email disabled
         */
        \Mail::to($user)->send(new EmailBalance(
            $user,
            $old_balance,
            $difference,
            $balance,
            $note,
            $date
        ));
        $admin_users = User::getAdminManageerEmployeeUsers();
        foreach ($admin_users as $admin) {
            if (!$admin->notes_email_disable) {
                \Mail::to($admin)->send(new EmailBalance(
                    $admin,
                    $old_balance,
                    $difference,
                    $balance,
                    $note,
                    $date
                ));

            }
        }

        return $user;
    }

    public function recharge($id)
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;

        $role_id = Helpers::current_role_id();
        // if (Helpers::is_normal_user()) {
        //     $logged_in_user = \Auth::user();
        //     $users = User::where('id', $logged_in_user->id)->get();
        // } else {
        //     $users = User::where('role_id', $role_id)->get();
        // }

        $users = User::where('id', $id)->get();
        //dd($users);

        $recharge_data_array = [];

        /**
         * I need to chagne this so it combines multiple report types, so I can
         * use both regular and instant...
         * @todo I need to add instant and second recharge HDN do this data
         */
        $config_array = [ // this can be changed for different report types
            'current' => 1, // Month
            'current_instant' => 4, // Emida / GS Posa
            'current_bundles' => 23, // Bundles
            'current_hdn' => 25, // Instant HDN
            // 'current_instant_hdn' => 19, // this isn't necessary
            'recharge' => 5, // H2O 2nd Recharge
            'recharge_instant' => 6, // H2O 2nd Rechage Instant
            'recharge_instant_hdn' => 19, // H2O 2nd Recharge HDN
            'recharge_bundles' => 24, // H2O 2nd Recharge HDN
        ];

        $report_type_current = ReportType::find($config_array['current']);
        $report_type_current_instant = ReportType::find($config_array['current_instant']);
        $report_type_current_bundles = ReportType::find($config_array['current_bundles']);
        $report_type_current_hdn = ReportType::find($config_array['current_hdn']);
        $report_type_recharge = ReportType::find($config_array['recharge']);
        $report_type_recharge_instant = ReportType::find($config_array['recharge_instant']);
        $report_type_recharge_hdn = ReportType::find($config_array['recharge_instant_hdn']);
        $report_type_recharge_bundles = ReportType::find($config_array['recharge_bundles']);

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_months_ago = $date_array[$array_index - 2];
        $three_months_ago = $date_array[$array_index - 3];

        $recarge_search_array = [
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_i_id' => $report_type_current_instant->id,
                    'rt_bnd_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $one_month_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_i_id' => $report_type_recharge_instant->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'rt_bnd_id' => $report_type_recharge_bundles->id,
                    'date' => $current_date,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_i_id' => $report_type_current_instant->id,
                    'rt_bnd_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $two_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_i_id' => $report_type_recharge_instant->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'rt_bnd_id' => $report_type_recharge_bundles->id,
                    'date' => $one_month_ago,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_i_id' => $report_type_current_instant->id,
                    'rt_bnd_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $three_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_i_id' => $report_type_recharge_instant->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'rt_bnd_id' => $report_type_recharge_bundles->id,
                    'date' => $two_months_ago,
                ],
            ],
        ];

        foreach ($users as $user) {

            $data = [];

            foreach ($recarge_search_array as $item) {

                $matching_sims_count_activation = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[0]['rt_id'], $item[0]['rt_i_id'], $item[0]['rt_bnd_id'], $item[0]['rt_hdn_id']])
                // ->where('sims.report_type_id', $item[0]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[0]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[0]['date'])
                    ->count();

                $matching_sims_count_recharge = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[1]['rt_id'], $item[1]['rt_i_id'], $item[1]['rt_hdn_id'], $item[1]['rt_bnd_id']])
                // ->where('sims.report_type_id', $item[1]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[1]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[1]['date'])
                    ->count();

                if ($matching_sims_count_activation && $matching_sims_count_recharge) {
                    $recharge_percent = number_format((($matching_sims_count_recharge / $matching_sims_count_activation) * 100), 2);
                } else {
                    $recharge_percent = '0.00';
                }

                if ($recharge_percent >= 70) {
                    $percent_class = 'best';
                } elseif ($recharge_percent >= 60) {
                    $percent_class = 'good';
                } elseif ($recharge_percent >= 50) {
                    $percent_class = 'ok';
                } else {
                    $percent_class = 'bad';
                }

                $data[] = [
                    'act_name' => Helpers::get_date_name($item[0]['date']) . ' Activation',
                    'act_count' => $matching_sims_count_activation,
                    'rec_name' => Helpers::get_date_name($item[1]['date']) . '<span> 2nd</span> Recharge',
                    'rec_count' => $matching_sims_count_recharge,
                    'percent' => $recharge_percent,
                    'class' => $percent_class,
                ];
            }

            $recharge_data_array[] = [
                'name' => $user->name,
                'company' => $user->company,
                'data' => $data,
            ];

        }

        $recharge = '2nd';

        return $recharge_data_array;

    }

    public function third_recharge($id)
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;

        $role_id = Helpers::current_role_id();

        $users = User::where('id', $id)->get();

        $recharge_data_array = [];

        /**
         * I need to chagne this so it combines multiple report types, so I can
         * use both regular and instant...
         */
        $config_array = [ // this can be changed for different report types
            'current' => 5, // H2O 2nd Recharge
            'current_instant' => 6, // H2O 2nd Rechage Instant
            'current_bundles' => 24, // H2O 2nd Rechage Bundles
            'current_hdn' => 19, // H2O 2nd Recharge HDN
            'recharge' => 8, // H2O 3rd Recharge
            'recharge_emida' => 33, // H2O 2nd Recharge HDN
            'recharge_hdn' => 20, // H2O 2nd Recharge HDN
            //'recharge_instant' => 6 // H2O 2nd Rechage Instant
        ];

        $report_type_current = ReportType::find($config_array['current']);
        $report_type_current_instant = ReportType::find($config_array['current_instant']);
        $report_type_current_bundles = ReportType::find($config_array['current_bundles']);
        $report_type_current_hdn = ReportType::find($config_array['current_hdn']);
        $report_type_recharge = ReportType::find($config_array['recharge']);
        $report_type_recharge_emida = ReportType::find($config_array['recharge_emida']);
        $report_type_recharge_hdn = ReportType::find($config_array['recharge_hdn']);
        //$report_type_recharge_instant = ReportType::find($config_array['recharge_instant']);

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_months_ago = $date_array[$array_index - 2];
        $three_months_ago = $date_array[$array_index - 3];

        $recarge_search_array = [
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_i_id' => $report_type_current_instant->id,
                    'rt_bdl_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $one_month_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_emd_id' => $report_type_recharge_emida->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $current_date,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_i_id' => $report_type_current_instant->id,
                    'rt_bdl_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $two_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_emd_id' => $report_type_recharge_emida->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $one_month_ago,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_i_id' => $report_type_current_instant->id,
                    'rt_bdl_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $three_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_emd_id' => $report_type_recharge_emida->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $two_months_ago,
                ],
            ],
        ];

        foreach ($users as $user) {

            $data = [];

            foreach ($recarge_search_array as $item) {

                $matching_sims_count_activation = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[0]['rt_id'], $item[0]['rt_i_id'], $item[0]['rt_hdn_id'], $item[0]['rt_bdl_id']])
                // ->where('sims.report_type_id', $item[0]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[0]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[0]['date'])
                    ->count();

                $matching_sims_count_recharge = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[1]['rt_id'], $item[1]['rt_hdn_id'], $item[1]['rt_emd_id']])
                // ->where('sims.report_type_id', $item[1]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[1]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[1]['date'])
                    ->count();

                if ($matching_sims_count_activation && $matching_sims_count_recharge) {
                    $recharge_percent = number_format((($matching_sims_count_recharge / $matching_sims_count_activation) * 100), 2);
                } else {
                    $recharge_percent = '0.00';
                }

                if ($recharge_percent >= 70) {
                    $percent_class = 'best';
                } elseif ($recharge_percent >= 60) {
                    $percent_class = 'good';
                } elseif ($recharge_percent >= 50) {
                    $percent_class = 'ok';
                } else {
                    $percent_class = 'bad';
                }

                $second_recharge_name = Helpers::get_date_name($item[0]['date']) . ' <span>2nd</span> Recharge';
                $third_recahrge_name = Helpers::get_date_name($item[1]['date']) . ' <span>3rd</span> Recharge';

                $data[] = [
                    'act_name' => $second_recharge_name,
                    'act_count' => $matching_sims_count_activation,
                    'rec_name' => $third_recahrge_name,
                    'rec_count' => $matching_sims_count_recharge,
                    'percent' => $recharge_percent,
                    'class' => $percent_class,
                ];
            }

            $recharge_data_array[] = [
                'name' => $user->name,
                'company' => $user->company,
                'data' => $data,
            ];

        }

        $recharge = '3rd';

        return $recharge_data_array;

    }

    public function search(Request $request)
    {
        return redirect('/search-user?user=' . $request->user_search);
    }

    public function search_page(Request $request)
    {
        $search = $request->user;
        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('company', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->get();

        return view('users.search-results', compact('users', 'search'));
    }

}
