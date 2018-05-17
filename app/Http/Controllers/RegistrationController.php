<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class RegistrationController extends Controller
{
    public function create() {

    	return view('registration.create');
    }

    public function store() {

    	// validate the form
    	$this->validate(request(), [
    		'name' => 'required',
    		'email' => 'required|email',
    		'password' => 'required'
    		]
    	);

    	// create and save new user
    	$user = User::create(request(['name','email','password']));

    	// log in new user
    	auth()->login($user);



    	//return redirect()->home();
    	return redirect('/');
    }
}
