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

//dd(phpinfo());

// just for testing
// use App\User;
// use App\Mail\EmailBlast;


Route::get('/', 'HomeController@index')->name('home');

/**
* Profile & Users Routes
*/
Route::get('users', 'UserController@index')->name('users');
Route::get('users/{user}', 'UserController@show');
Route::get('profile', 'UserController@profile');
Route::get('edit-user/{user}', 'UserController@edit');
Route::get('edit-profile/{user}', 'UserController@edit_profile');
Route::get('bonus-credit/{user}', 'UserCreditBonusController@edit');
Route::post('bonus-credit/{user}', 'UserCreditBonusController@update');
Route::get('change-password/{user}', 'UserController@edit_password');
Route::post('update-user/{id}','UserController@update');
Route::post('update-admin-manager/{id}','UserController@update_admin_manager');
Route::post('update-user-password/{id}','UserController@update_password');
Route::get('delete-user/{user}', 'UserController@destroy');
Route::get('user-plan-values/{user}', 'UserController@user_plan_residual');
Route::post('user-plan-values/{id}', 'UserPlanValuesController@store');
Route::post('user-residual-percent/{id}', 'UserResidualPercentController@store');
Route::post('delete-user-plan-value/{userPlanValues}', 'UserPlanValuesController@destroy');
Route::post('delete-user-residual-percent/{userResidualPercent}', 'UserResidualPercentController@destroy');

/**
* SIMs Routes
*/
//Route::get('sims', 'SimController@index'); // @todo return a 404 if you go to this route?
Route::get('sims/upload', 'SimController@upload_form');
Route::get('sims/create', 'SimController@addSim');
Route::get('sims/archive/{id}', 'SimController@archive');
Route::post('upload', 'SimController@upload');
Route::post('upload-single', 'SimController@upload_single');
Route::post('upload-single-paste', 'SimController@upload_single_paste');
Route::get('sims/{sim_number}', 'SimController@show');
Route::post('sims', 'SimController@store');

// API Routes
Route::get('/api/v1/sims', 'APIController@getSims')->name('api.sims.index');
Route::get('/api/v1/sims_archive/{id}', 'APIController@getSimsArchive')
->name('api.sims.archive');
Route::get('/api/v1/sim_users', 'APIController@getSimUsers')->name('api.sim_users.index');
Route::get('/api/v1/sim_user/{id}', 'APIController@getSimUser')->name('api.sim_users.index_user');

/**
* Settings Routes
*/
Route::get('settings', 'SettingsController@index');
Route::get('site-settings', 'SettingsController@index_site');
Route::post('date', 'SettingsController@update_date');
Route::post('mode', 'SettingsController@update_mode');
Route::post('site', 'SettingsController@update_site');
Route::post('default_spiff_payment', 'SettingsController@update_spiff');
Route::post('default_residual_percent', 'SettingsController@update_residual');

/**
* SIM Users Routes
*/
Route::get('user-sims', 'SimUserController@index');
Route::get('user-sims/{sim}', 'SimUserController@show');
Route::get('user-sims/user/{user}', 'SimUserController@index_user');
Route::get('assign-sims', 'SimUserController@create');
Route::post('assign-sims', 'SimUserController@store');
Route::get('find-sims', 'SimUserController@find');
Route::post('find_sims', 'SimUserController@find_sims');
Route::post('find_sims_phone', 'SimUserController@find_sims_phone');
Route::get('list-sims/{sims}', 'SimUserController@show_list');
Route::get('list-sims-phone/{sims}', 'SimUserController@show_list_phone');

// @todo I can lock out managers in a similar manner here... 
Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function()
{
    Route::get('delete-sims', 'SimUserController@delete');
});

Route::post('delete_sims', 'SimUserController@destroy');

/**
* Report Types Routes
*/
Route::get('report-types', 'ReportTypeController@index');
Route::get('report-types/{report_type}', 'ReportTypeController@show');
Route::get('add-report-type-spiff', 'ReportTypeController@create');
Route::get('add-report-type-residual', 'ReportTypeController@create_residual');
Route::post('new-report-type', 'ReportTypeController@store');
Route::post('new-report-type-residual', 'ReportTypeController@store_residual');
Route::get('delete-report-type/{report_type}', 'ReportTypeController@destroy');
Route::get('edit-report-type/{report_type}', 'ReportTypeController@edit');
Route::get('edit-report-type-residual/{report_type}', 'ReportTypeController@edit_residual');
Route::post('save-report-type/{report_type}', 'ReportTypeController@update');
Route::post('save-report-type-residual/{report_type}', 'ReportTypeController@update_residual');

Route::post('add-report-plan-value/{report_type}', 'ReportTypeController@add_plan_value');
Route::post('remove-report-plan-value/{report_type}', 'ReportTypeController@remove_plan_value');

/**
* Reports
*/
Route::get('reports', 'ReportsController@index');
Route::get('reports/{user}', 'ReportsController@show');
Route::get('report-totals', 'ReportsController@totals');
Route::get('recharge-data', 'ReportsController@recharge');
Route::post('get-csv-report/{id}', 'ReportsController@download_csv');
Route::post('get-csv-report-archive/{id}', 'ReportsController@download_csv_archive');
Route::post('save-archive', 'ReportsController@save_archive');

/**
* Archives
*/
Route::get('archives', 'ArchiveController@index');
Route::post('change-archive-date', 'ArchiveController@change_archive_date');

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
* Email Routes
*/
Route::get('email-blast', 'EmailBlastController@index');
Route::post('email-blast', 'EmailBlastController@email');

/**
* Test Routes
*/
// Route::get('test-email', function() {
// 	return view('mail-sent-test');
// });

// Route::post('send_test_email', function() {

// 	$user_leon = User::find(1);
// 	$user_kareem = User::find(2);

// 	$message = 'Here is a test email just to show you how the email formating is going to look for the new STM. Let me know what you think.';

// 	$mail_success = \Mail::to($user_leon)->send(new EmailBlast($user_leon, $message));
// 	//$mail_success2 = \Mail::to($user_kareem)->send(new EmailBlast($user_kareem, $message));

// 	session()->flash('message', 'Emails have been sent?');

// 	return redirect('/email-blast');


// });

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


