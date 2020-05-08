<?php

namespace App\Http\Controllers;

use App\Mail\NewUser;
use App\Mail\NewUserAdmin;
use App\Settings;
use App\Site;
use App\User;
use Illuminate\Http\Request;

//
class RegistrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {

        $sites = Site::all();

        $sites_array = [
            [
                'name' => 'Admin',
                'role' => 1,
                'site' => null,
            ],
            [
                'name' => 'Manager',
                'role' => 2,
                'site' => null,
            ],
            [
                'name' => 'Employee',
                'role' => 6,
                'site' => null,
            ],
        ];

        foreach ($sites as $site) {
            $sites_array[] = [
                'name' => $site->name,
                'role' => $site->role_id,
                'site' => $site->id,
            ];
        }

        //dd($sites_array);

        $settings = Settings::first();

        $current_site_id = $settings->get_site_id();

        return view('registration.create', compact('sites_array', 'current_site_id'));
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'xxxxx',
        ];
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'company' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'role_id' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
        ]);

        \Mail::to($user)->send(new NewUser($user, $request->password));

        $admins = User::getAdminManageerEmployeeUsers();
        $author = \Auth::user();
        foreach ($admins as $admin) {
            \Mail::to($admin)->send(new NewUserAdmin($user, $author, $admin));
        }

        return $user->id;
    }
}
