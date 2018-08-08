<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Mail\NewUser;

class RegistrationController extends Controller
{

	public function __construct() {

		$this->middleware('guest');
	}

	public function create() {

		return view('registration.create');
	}

	public function store(Request $request) {

    	// validate the form
		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email',
			'company' => 'required',
			'phone' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required',
			'password' => 'required|confirmed'
		]);

    	// create and save new user
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'company' => $request->company,
			'phone' => $request->phone,
			'address' => $request->address,
			'city' => $request->city,
			'state' => $request->state,
			'zip' => $request->zip,
			'role' => 'new_user', // admin only dropdown to choose site // admin can edit also
			'password' => bcrypt($request->password)
		]);

		\Mail::to($user)->send(new NewUser($user));

    	// log in new user
		auth()->login($user);

		return redirect()->home();
	}
}
