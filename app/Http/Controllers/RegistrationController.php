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
			'role' => 'required',
			'password' => 'required|confirmed'
		]);

    	// create and save new user
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'company' => $request->company,
			'role' => $request->role,
			'password' => bcrypt($request->password)
		]);

		\Mail::to($user)->send(new NewUser($user));

    	// log in new user
		auth()->login($user);

		return redirect()->home();
	}
}
