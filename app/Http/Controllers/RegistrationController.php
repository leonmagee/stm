<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use App\User;
use App\Site;
use App\Role;
use App\Mail\NewUser;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function create() {


		// hash: $2y$10$6GVb0gNVVDJJxjH/2Jfn/evnZEYkUu6EcF7bwKakku.9oCTPhrTrW
		// salt: base64:w5l9fkCGJzgczyUctdGg+c/Bz05iCMnSt79eeW5kOgo=

		//$password = 'aaa';

		//$password = 'Trustno34!';


		//$bcrypt = bcrypt($password);

		//dd($bcrypt);

		// $password = '11111111';
		// //$hash = '$2y$10$1rx5jvTKOsJoaozOTQm.muVixLWHvb6ly9O7pRKUcnyvpWyXYU2J2'; // works = Trustno34!
		// //$hash = '$2y$10$6GVb0gNVVDJJxjH/2Jfn/evnZEYkUu6EcF7bwKakku.9oCTPhrTrW'; // 11111111
		// $hash = '$2y$10$MnWMLTft3lVA7zaLhEBj1edk31KHmcL7TJirFi1CbNs.VTGYcijaS'; // 11111111

		// //$hash = "$2y$10$4G2JgBlF5qzdcsTom7E24uIDuL2GDNkS1hT9eTNEw9G03dV9tNXQe"; // newly computed

		// $verification = password_verify($password, $hash);

		// dd($verification);

		$sites = Site::all();

		$sites_array = [
			[
				'name' => 'Admin',
				'role' => 1,
				'site' => null
			],
			[
				'name' => 'Manager',
				'role' => 2,
				'site' => null
			],
		];


		foreach($sites as $site) {
			$sites_array[] = [
				'name' => $site->name,
				'role' => $site->role_id,
				'site' => $site->id
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

	public function store(Request $request) {

    	/**
    	* validate the form
    	* @todo should address info be required?
    	*/

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'company' => 'required',
			'phone' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required',
			//'role_id' => 'required|gt:2',
			'role_id' => 'required',
			'password' => 'required|confirmed|min:8'
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
			'role_id' => $request->role_id,
			'password' => bcrypt($request->password)
			//'password' => Hash::make($request->user_password)
			//'password' => $request->user_password
		]);

		/**
		* @todo I need to make an entry here in user roles...
		*/


		/**
		* Update this email to include branding and reflect that a user account was created.
		* Mandate strong password... 
		* @todo this will currently not work on the server - prob because of mail driver in .env?
		*/
		\Mail::to($user)->send(new NewUser($user, $request->password));

    	// log in new user
		//auth()->login($user);
		return $user->id;

		// this doesn't happen as ajax is being used?
		//return redirect('users/' . $user->id);
	}
}
