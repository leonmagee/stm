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
use App\Site;

/**
* Companies Route / main index???
* @todo not sure if I should make this dynamic or not... 
* @todo - this could really just depend on who's logged in - if a Company Admin is logged in, then 
* they will see data tied to their company, and there will be an admin page listing different sites...
* so the number 1 landing page will be the login form - this will take a user to an admin page with different sites to navigate - and hopefully I can do away with the different icon ctas... 
**/



Route::get('/', function () {
	// get logged in user company ID...
	// regurn all fo the sites for that logged in users company
	$user_company_id = 1;
	$sites = Site::where('company_id', '=', $user_company_id)->get();

    return view('index', compact('sites'));
})->name('home');

/**
* I might want to disable this for now... I'm not sure how to handle the multisite functionality
* I can just do this with cookies but that seems like a bad way to do it???
*/
// Route::get('{site}', function() {
// 	$array = array(1,2,3);
// 	return $array;
// });



/**
* SIMs Routes
*/
Route::get('sims', 'SimController@index');
Route::get('sims/upload', 'SimController@upload_form');
Route::get('sims/create', 'SimController@addSim');
Route::post('upload', 'SimController@upload');
Route::get('sims/{sim}', 'SimController@show');
Route::post('sims', 'SimController@store');

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


