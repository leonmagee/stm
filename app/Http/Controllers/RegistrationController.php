<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Settings;

use App\User;

use App\Site;

use App\Mail\NewUser;

class RegistrationController extends Controller
{

	public function __construct() {

		$this->middleware('auth');
	}

	public function create() {

		$sites = Site::all();

		$settings = Settings::first();
		$current_site_id = $settings->site_id;

		return view('registration.create', compact('sites', 'current_site_id'));
	}

	public function store(Request $request) {

    	// validate the form
		$this->validate(request(), [
			'name' => 'required',
			'email_address' => 'required|email',
			'company' => 'required',
			'phone' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required',
			'role' => 'required',
			'password' => 'required|confirmed'
		]);

		//$role_array = ['null','agent','dealer','sigstore'];

    	// create and save new user
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email_address,
			'company' => $request->company,
			'phone' => $request->phone,
			'address' => $request->address,
			'city' => $request->city,
			'state' => $request->state,
			'zip' => $request->zip,
			'role' => $request->role,
			'password' => bcrypt($request->user_password)
		]);

		/**
		* Update this email to include branding and reflect that a user account was created.
		* Mandate strong password... 
		*/
		\Mail::to($user)->send(new NewUser($user));

    	// log in new user
		//auth()->login($user);

		return redirect('users/' . $user->id);
	}
}
