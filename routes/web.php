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

Route::get('/', function () {
    return view('index');
});


// Route::get('sims', function() {
// 	return view('sims.sims');
// });

/**
* SIMs Routes
**/
Route::get('sims', 'SimController@index');
Route::get('sims/upload', 'SimController@upload_form');
Route::get('sims/create', 'SimController@addSim');
Route::post('upload', 'SimController@upload');
Route::get('sims/{sim}', 'SimController@show');
Route::post('sims', 'SimController@store');

/**
* SIM Users Routes
**/
Route::get('sim_users', 'SimUserController@index');
Route::get('sim_users/{sim}', 'SimUserController@show');
Route::get('assign-sims', 'SimUserController@create');
Route::post('assign-sims', 'SimUserController@store');

/**
* Report Types Routes
**/
Route::get('report_types', 'ReportTypeController@index');
Route::get('report_types/{report_type}', 'ReportTypeController@show');


/**
* Enables User Registration
* @todo this is done custom in laracast tutorials
*/
Auth::routes();

/**
* Named Route - naming this route home allows you to reference it other places. 
**/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logmeout', function() {
	Auth::logout();
	return redirect('/home');
});


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


