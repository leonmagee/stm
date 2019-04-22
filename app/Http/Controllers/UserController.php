<?php

namespace App\Http\Controllers;

use App\User;
use App\Site;
use App\Settings;
use App\UserCreditBonus;
use App\Helpers;
use App\ReportType;
use App\UserPlanValues;
use App\UserResidualPercent;
use Illuminate\Http\Request;

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
        $users = User::whereIn('role_id', array(3,4,5))->orderBy('company')->get();
        //$users = User::all();
        return view('users.all-users')->with(
          [
            'users' => json_encode($users),
            'sites' => json_encode($sites),
            'current' => $role_id
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
        $managers_array = [1,2,6];
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date()
        ])->first();

        if ( isset($bonus_credit->bonus) ) {
            $bonus = '$' . number_format($bonus_credit->bonus, 2);
        } else {
            $bonus = false;
        }
        if ( isset($bonus_credit->credit) ) {
            $credit = '$' . number_format($bonus_credit->credit, 2);
        } else {
            $credit = false;
        }

        $is_admin = Helpers::current_user_admin();

        $role = $user->role->id;

        //dd($user->role->name);

        if ( $role === 1 ) {
            $role = 'Admin';
        } else {
            //$role = Site::find($role)->name;
            $role = $user->role->name;
        }
        return view('users.show', compact('user', 'role', 'bonus', 'credit', 'is_admin'));
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

        if ($user->role->id > 2)
        {
            $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date()
            ])->first();

            if ( isset($bonus_credit->bonus) ) {
                $bonus = '$' . number_format($bonus_credit->bonus, 2);
            } else {
                $bonus = false;
            }
            if ( isset($bonus_credit->credit) ) {
                $credit = '$' . number_format($bonus_credit->credit, 2);
            } else {
                $credit = false;
            }

            return view('users.profile-user', compact('user', 'role', 'bonus', 'credit'));
        }
        else
        {
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
        return view('users.edit', compact('user', 'sites', 'is_admin'));
    }

    public function edit_profile()
    {
        if($user = \Auth::user()) {
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
    public function user_plan_residual(User $user) {
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
        //validate the form
        if(Helpers::current_user_admin())
        {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'company' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
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
                'role_id' => $request->role_id,
            ]);
        }
        else
        {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'company' => 'required',
                'phone' => 'required',
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
            ]);
        }


        session()->flash('message', 'User ' . $request->name . ' has been updated.');

        return redirect('users/' . $id);
    }

    public function update_admin_manager(Request $request)
    {

        if($user = \Auth::user()) {

            $id = $user->id;

            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'company' => 'required',
                'phone' => 'required',
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
            'password' => 'required|confirmed|min:8'
        ]);

        // update user
        $user = User::find($id)->update([
            'password' => bcrypt($request->password)
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
        if($user = \Auth::user())
        {

            $id = $user->id;
            // validate the form
            $this->validate(request(), [
                'password' => 'required|confirmed|min:8'
            ]);

            // update user
            $user = User::find($id)->update([
                'password' => bcrypt($request->password)
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

    public function changeUserSites(request $request) {

      // $this->validate(request(), [
      // 	'data' => 'required',
      // ]);

      //   dd($request->data);
      //   var_dump($request);

      //$data = json_decode($request->selectedUsers);

      $rold_id_int = intval($request->roleId);
      foreach( $request->selectedUsers as $id ) {
        $id_intval = intval($id);
            User::find($id_intval)->update([
                'role_id' => $rold_id_int
            ]);
      }
      // how to validate this worked?
      return $request->selectedUsers;
    }
}
