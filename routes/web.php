<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use App\Billing\Stripe;
use App\Settings;
use App\Site;
use App\ReportType;
use App\Sim;

/**
* Companies Route / main index???
* @todo not sure if I should make this dynamic or not... 
* @todo - this could really just depend on who's logged in - if a Company Admin is logged in, then 
* they will see data tied to their company, and there will be an admin page listing different sites...
* so the number 1 landing page will be the login form - this will take a user to an admin page with different sites to navigate - and hopefully I can do away with the different icon ctas... 


* so maybe I can manage the current 'site' just with Session details, rather than with different routes - so basically you choose which site you're part of 'Agents' / 'Dealers' / 'Signature Store' - and this is displayed in the header in bold... and you can change this in an admin panel in accordance with 'company'? I might want to have a 'super' admin that only I see, and then Kareem will see an admin page for GS Wireless - so that way when I login I can have what amounts to multisite functionality, but he will just see everything under the umbrella of GS Wireless... 
**/



Route::get('/', function () {
	// get logged in user company ID...
	// regurn all fo the sites for that logged in users company
	//$config_tester = config('mail.driver');
	//dd($config_tester);
	// session_start();
	// $session = $_SESSION;
	//dd($session);
	// $array = array('one', 'two', 'three');
	// dd($array);
	//$user_company_id = 1;
	//$sites = Site::where('company_id', '=', $user_company_id)->get();


        $current_date = Settings::first()->current_date;

        

        $data_array = [
        	[
        		'title' => 'H2O Wireless Month',
        		'counts' => [
        			'200',
        			'133',
        			'144'
        		]
        	],
        	[
        		'title' => 'H2O Wireless Minute',
        		'counts' => [
        			'170',
        			'153',
        			'114'
        		]
        	],
        	[
        		'title' => 'H2O Wireless 2nd Recharge',
        		'counts' => [
        			'100',
        			'133',
        			'174'
        		]
        	],
        ];

        $data_array = [];

        $array_item = [];

		$date_array = ['4_2018','5_2018','6_2018'];

		//$report_types_array = [1,3,4];
		$report_types_array = ReportType::where('spiff',1)->get();

		foreach( $report_types_array as $report_type ) {

			    //$report_type = ReportType::find($report_type->id);

        		$name = $report_type->name;

        		$carrier = $report_type->carrier->name;

        		$array_item['title'] = $carrier . " " . $name;

        		foreach( $date_array as $date ) {

	        		$sims = Sim::where([
	        			'upload_date' => $date, 
	        			'report_type_id' => $report_type->id
	        		])->latest()->get();

		        	$number = count($sims);

		        	$array_item['counts'][] = $number;
        		}

	        	$data_array[] = $array_item;
	        	$array_item = [];

		}

		//var_dump($data_array);



        // foreach( $date_array as $date ) {

        // 	foreach( $report_types_array as $id ) {

        // 		$report_type = ReportType::find($id);

        // 		$name = $report_type->name;

        // 		$carrier = $report_type->carrier->name;

        // 		$sims = Sim::where(['upload_date' => $date, 'report_type_id' => $id])->latest()->get();

	       //  	$number = count($sims);

	       //  	echo "report type: " . $carrier . " " . $name . "<br /> date: " . $date . "<br /> count: " . $number . "<br /><br /><br />";

	       //  	$data_array[] = [
	       //  		'title' => '',
	       //  		'',
	       //  	];
        // 	}


        // }

        //dd('test');








	// graph data
	//$date_array = ['April 2018', 'May 2018', 'June 2018'];
	//$report_types = ReportType::where('spiff',1)->get();

    return view('index', compact('data_array'));
})->name('home');

/**
* I might want to disable this for now... I'm not sure how to handle the multisite functionality
* I can just do this with cookies but that seems like a bad way to do it???
*/
// Route::get('{site}', function() {
// 	$array = array(1,2,3);
// 	return $array;
// });

Route::get('profile', function() {

	return view('profile');
});



/**
* SIMs Routes
*/
Route::get('sims', 'SimController@index');
Route::get('sims/upload', 'SimController@upload_form');
Route::get('sims/create', 'SimController@addSim');
Route::get('sims/archive/{id}', 'SimController@archive');
Route::post('upload', 'SimController@upload');
Route::get('sims/{sim}', 'SimController@show');
Route::post('sims', 'SimController@store');

/**
* Settings Routes
*/
Route::get('settings', 'SettingsController@index');
Route::get('site_settings', 'SettingsController@index_site');
Route::post('date', 'SettingsController@update_date');
Route::post('mode', 'SettingsController@update_mode');
Route::post('site', 'SettingsController@update_site');

/**
* SIM Users Routes
*/
Route::get('sim_users', 'SimUserController@index');
Route::get('sim_users/{sim}', 'SimUserController@show');
Route::get('assign-sims', 'SimUserController@create');
Route::post('assign-sims', 'SimUserController@store');

/**
* Report Types Routes
*/
Route::get('report_types', 'ReportTypeController@index');
Route::get('report_types/{report_type}', 'ReportTypeController@show');

/**
* Carriers Routes
*/
Route::get('carriers', 'CarrierController@index');
Route::get('carriers/{carrier}', 'CarrierController@show');

/**
* Auth Routes
*/
//Route::get('register', 'AuthController@register');
Route::get('register', 'RegistrationController@create');
Route::post('register', 'RegistrationController@store');
//Route::get('login', 'AuthController@login');
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store');
Route::get('logout', 'SessionsController@destroy');







/**
* Enables User Registration
* @todo this is done custom in laracast tutorials
*/
//Auth::routes();

/**
* Named Route - naming this route home allows you to reference it other places. 
**/




// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/logmeout', function() {
// 	Auth::logout();
// 	return redirect('/home');
// });

/**
* Service Containers
* bind vs. singleton
* should not go in this file?
**/

// App::singleton('App\Billing\Stripe', function() {
//     return new \App\Billing\Stripe(config('services.stripe.secret'));
//     // config / services.php / services > stripe > secret
// });

// App::bind('App\Billing\Stripe', function() {
//     return new \App\Billing\Stripe(config('services.stripe.secret'));
//     // config / services.php / services > stripe > secret
// });

//App::instance('App\Billing\Stripe', $stripe);

// $stripe = App::make('App\Billing\Stripe');
// $stripe2 = App::make('App\Billing\Stripe');
// dd($stripe2);

//resolve();


