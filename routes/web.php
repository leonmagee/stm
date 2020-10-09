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
// just a test edit

//Route::get('/', 'HomeController@index')->name('home');
//Route::get('/', 'HomeController@commission')->name('home');
Route::get('/', 'ProductController@index')->name('home');
Route::get('about', 'LoggedOutController@about')->name('about');
Route::get('plans', 'HomeController@commission');
//Route::get('commission', 'HomeController@commission')->name('commission');
Route::get('/charts', 'HomeController@index')->name('charts');

//Route::get('products', 'ProductController@index');
Route::post('rma-new', 'RmaController@store');
Route::get('your-rmas', 'RmaController@your_rmas');
Route::get('your-purchases', 'PurchaseController@your_purchases');
Route::get('purchase-order/{purchase}', 'PurchaseController@your_purchase');
Route::post('process-paypal', 'PurchaseController@store');
Route::get('products/{product}', 'ProductController@show');
Route::post('update-user-rating', 'ProductRatingController@store');
Route::get('cart', 'CartProductController@index');
Route::post('add-to-cart', 'CartProductController@store');
Route::post('add-to-cart-axios', 'CartProductController@store_axios');
Route::post('toggle-favorite', 'ProductFavoriteController@store');
Route::post('update-cart-item/{item}', 'CartProductController@update');
Route::get('delete-cart-item/{item}', 'CartProductController@destroy');
Route::post('review-create-update', 'ProductReviewController@update');
Route::get('purchase-complete', 'PurchaseController@purchase_complete');
Route::post('pay-with-balance', 'PurchaseController@pay_with_balance');
Route::post('transfer-balance', 'UserController@transfer_balance');
Route::get('sales', 'PurchaseController@sales');
Route::get('dealer-purchases', 'PurchaseController@index_dealer');
Route::get('dealer-purchases/{purchase}', 'PurchaseController@show_dealer');
//Route::get('dealer-rmas', 'RmaController@dealer_rmas');
Route::get('rmas', 'RmaController@index');
Route::get('rmas/{rma}', 'RmaController@show');

Route::get('imei', 'HomeController@imei');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    //Route::get('sales-agents', 'PurchaseController@sales_agents');
    //Route::get('sales-agents/{agent}', 'PurchaseController@sales');
    Route::get('purchases/{purchase}', 'PurchaseController@show');
    Route::get('products-list', 'ProductController@list');
    Route::get('products-sort', 'ProductController@sort');
    Route::get('purchases', 'PurchaseController@index');
    //Route::get('purchase-email-test', 'PurchaseController@store_test');
    Route::post('update-shipping-info', 'PurchaseController@update_shipping');
    Route::post('add-tracking-number', 'TrackingNumberController@store');
    Route::post('delete-tracking-number/{trackingNumber}', 'TrackingNumberController@destroy');
    Route::post('update-purchase-status', 'PurchaseController@update_status');
    Route::post('update-rma-status/{rma}', 'RmaController@update_status');
    //Route::post('update-rma-note/{rma}', 'RmaController@update_note');
    Route::post('update-rma-status-approve/{rma}', 'RmaController@rma_approve');
    Route::post('update-rma-status-reject/{rma}', 'RmaController@rma_reject');
    Route::post('add-imei-number', 'ImeiController@store');
    Route::post('delete-imei/{imei}', 'ImeiController@destroy');
    //Route::get('products-carousel', 'ProductController@index_carousel');
    Route::get('product-new', 'ProductController@create');
    Route::post('product-new', 'ProductController@store');
    Route::get('products/edit/{product}', 'ProductController@edit');
    Route::post('products/edit/{product}', 'ProductController@update');
    Route::get('products/delete/{product}', 'ProductController@destroy');
    Route::get('products/duplicate/{product}', 'ProductController@duplicate');
    Route::post('product-update-order', 'ProductController@update_order');
});

/**
 * Plans (commission)
 */
Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('plan/edit/{plan}', 'PlansController@edit');
    Route::post('update-plan/{plan}', 'PlansController@update');
    Route::get('plan/create', 'PlansController@create');
    Route::post('plan/create', 'PlansController@store');
    Route::get('plan/destroy/{plan}', 'PlansController@destroy');
});

/**
 * Profile & Users Routes
 */
Route::get('profile', 'UserController@profile');
Route::get('edit-profile', 'UserController@edit_profile');
Route::get('change-profile-password', 'UserController@edit_profile_password');
Route::post('update-user/{id}', 'UserController@update');
Route::post('update-user-profile-password', 'UserController@update_profile_password');
/**
 * @todo change the name of this, it can update any profile
 */
Route::post('update-admin-manager', 'UserController@update_admin_manager');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('admins-managers', 'UserController@admin_managers');
    Route::get('edit-user/{user}', 'UserController@edit');
    Route::get('change-password/{user}', 'UserController@edit_password');
    Route::post('update-user-password/{id}', 'UserController@update_password');
    Route::post('update-user-sites', 'UserController@changeUserSites');
    Route::post('update-user-balance', 'UserController@changeUserBalance');
    Route::get('delete-note/{note}', 'NoteController@destroy');
    Route::get('delete-rma-note/{rmaNote}', 'RmaNoteController@destroy');
    Route::get('delete-email/{email}', 'EmailTrackerController@destroy');
    Route::get('delete-email-user/{email}/{user}', 'EmailTrackerController@destroy_on_user');
    Route::get('delete-emails/{string}', 'EmailTrackerController@destroy_page');
    Route::get('delete-order/{order}', 'OrderController@destroy');
    Route::get('resend-email/{email}', 'EmailTrackerController@resend');
    Route::get('transaction-change-credit/{user}', 'UserController@transactionTrackerAddCredit');
    Route::post('edit-transaction/{user}', 'UserController@changeUserBalance');
    Route::post('credit-complete', 'UserController@creditComplete');
});

/**
 * @todo restrict access here?
 */
Route::get('transaction-tracker', 'UserController@transactionTracker');
Route::get('transaction-tracker-dealer', 'UserController@transactionTrackerDealer');
Route::get('transaction-tracker/{user}', 'UserController@transactionTrackerShow');
//Route::get('credit-tracker', 'UserController@creditTracker');
//Route::get('credit-tracker/{user}', 'UserController@creditTrackerShow');
Route::get('order-sims', 'OrderController@create');
Route::post('order-sims', 'OrderController@store');
Route::get('redeem-credit', 'UserController@redeemCredit');
Route::post('redeem-credit', 'UserController@redeemCreditSubmit');
Route::get('login-tracker', 'UserLoginLogoutController@index');
Route::post('search-user', 'UserController@search');
Route::get('search-user', 'UserController@search_page');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
    Route::get('login-tracker/{user}', 'UserLoginLogoutController@show');
    //Route::get('notes', 'NoteController@index');
    Route::get('notes', 'NoteController@index_new');
    Route::get('orders', 'OrderController@index');
    Route::get('users/{user}', 'UserController@show');
    Route::post('add-note/{user}', 'NoteController@store');
    Route::post('add-rma-note/{rma}', 'RmaNoteController@store');
    Route::get('users', 'UserController@index')->name('users');
    Route::get('all-users', 'UserController@all_users')->name('all-users');
});

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('users-admins/{user}', 'UserController@show_admin');
});

// *** LOCK OUT non 'master' users
Route::get('your-dealers', 'UserController@your_dealers');
Route::get('dealer/{user}', 'UserController@show_dealer');
Route::get('dealer-report-totals', 'ReportsController@totals_dealers');
// END LOCK OUT ***

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('bonus-credit/{user}', 'UserCreditBonusController@edit');
    Route::post('bonus-credit/{user}', 'UserCreditBonusController@update');
    Route::get('delete-user/{user}', 'UserController@destroy');
    Route::get('user-plan-values/{user}', 'UserController@user_plan_residual');
    Route::post('user-plan-values/{id}', 'UserPlanValuesController@store');
    Route::post('user-residual-percent/{id}', 'UserResidualPercentController@store');
    Route::post('delete-user-plan-value/{userPlanValues}', 'UserPlanValuesController@destroy');
    Route::post('delete-user-residual-percent/{userResidualPercent}', 'UserResidualPercentController@destroy');
});
/**
 * SIMs Routes
 */
Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersEmployees'], function () {
    Route::get('sims/upload-all', 'SimController@upload_form_all');
    Route::get('sims/upload', 'SimController@upload_form');
    Route::get('sims/upload/{user}', 'SimController@upload_single_form');
    Route::post('upload', 'SimController@upload');
    Route::post('upload-single', 'SimController@upload_single');
    Route::post('upload-single-paste', 'SimController@upload_single_paste');
});
//Route::get('sims/create', 'SimController@addSim');

//Route::get('sims/{sim_number}', 'SimController@show');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
    Route::post('sims', 'SimController@store');
    Route::get('sims/archive/{id}', 'SimController@archive');
});

// API Routes
//Route::get('/api/v1/sims', 'APIController@getSims')->name('api.sims.index');
Route::get('/api/v1/sims_archive/{id}', 'APIController@getSimsArchive')->name('api.sims.archive');
Route::get('/api/v1/sim_users', 'APIController@getSimUsers')->name('api.sim_users.index');
Route::get('/api/v1/sim_user/{id}', 'APIController@getSimUser')->name('api.sim_users.index_user');
Route::get('/api/v1/logins', 'APIController@getLogins')->name('api.logins.index');
Route::get('/api/v1/products', 'APIController@getProducts')->name('api.products.index');
Route::get('/api/v1/purchases', 'APIController@getPurchases')->name('api.purchases.index');
Route::get('/api/v1/purchases-dealer', 'APIController@getPurchasesDealer')->name('api.purchases.index-dealer');
Route::get('/api/v1/rmas', 'APIController@getRmas')->name('api.rmas.index');
Route::get('/api/v1/notes', 'APIController@getNotes')->name('api.notes.index');
Route::get('/api/v1/balance', 'APIController@getBalanceChanges')->name('api.balance.index');
Route::get('/api/v1/balance-dealer', 'APIController@getBalanceChangesDealer')->name('api.balance.index-dealer');
Route::get('/api/v1/balance-show/{user}', 'APIController@getBalanceChangesShow')->name('api.balance.show');
Route::get('/api/v1/balance-user', 'APIController@getBalanceChangesUser')->name('api.balance.user');
Route::get('/api/v1/logins-show/{id}', 'APIController@getLogin')->name('api.logins.show');
Route::get('/api/v1/invoices', 'APIController@getInvoices')->name('api.invoice.index');
Route::get('/api/v1/invoices/{id}', 'APIController@getInvoicesUser')->name('api.invoice.index_user');

//Route::get('/api/v1/credit', 'APIController@getCreditRequests')->name('api.credit.index');
//Route::get('/api/v1/credit-show/{user}', 'APIController@getCreditRequestsShow')->name('api.credit.show');
//Route::get('/api/v1/credit-user', 'APIController@getCreditRequestsUser')->name('api.credit.user');

//https: //stmmax.com/email-bounced

/**
 * Settings Routes
 */

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
    Route::get('settings', 'SettingsController@index');
    Route::get('site-settings', 'SettingsController@index_site');
    Route::post('date', 'SettingsController@update_date');
    Route::post('mode', 'SettingsController@update_mode');
    Route::post('site', 'SettingsController@update_site');
    Route::post('default_spiff_payment', 'SettingsController@update_spiff');
    Route::post('default_residual_percent', 'SettingsController@update_residual');
});

/**
 * SIM Users Routes
 */
Route::get('user-sims', 'SimUserController@index');
Route::get('user-sims/{sim}', 'SimUserController@show');
//Route::get('assign-sims', 'SimUserController@create');
//Route::post('assign-sims', 'SimUserController@store');
Route::get('find-sims', 'SimUserController@find');
Route::get('look-up-sims', 'SimUserController@find'); // duplicate of above for menu purposes
Route::post('find_sims', 'SimUserController@find_sims');
Route::post('find_sims_phone', 'SimUserController@find_sims_phone');
Route::get('list-sims/{sims}', 'SimUserController@show_list');
Route::get('list-sims-phone/{sims}', 'SimUserController@show_list_phone');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
    Route::get('user-sims/user/{user}', 'SimUserController@index_user');
});

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('delete-sims', 'SimUserController@delete');
    Route::post('delete_sims', 'SimUserController@destroy');
    Route::get('transfer-sims', 'SimUserController@transfer');
    Route::post('transfer_sims', 'SimUserController@transfer_sims');
    Route::post('transfer_sims_all', 'SimUserController@transfer_sims_all');
});

Route::post('download-sims', 'SimUserController@download_sims');

/**
 * Report Types Routes
 */

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
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
});

/**
 * Reports
 */
Route::get('reports', 'ReportsController@index');
Route::get('dealer-reports', 'ReportsController@dealer_reports');
Route::get('dealer-2nd-recharge', 'ReportsController@dealer_2nd_recharge');
Route::get('dealer-3rd-recharge', 'ReportsController@dealer_3rd_recharge');
Route::get('recharge-data', 'ReportsController@recharge');
Route::get('3rd-recharge-data', 'ReportsController@third_recharge');
Route::get('all-recharge-data', 'ReportsController@all_recharge');
Route::post('get-csv-report/{id}', 'ReportsController@download_csv');
Route::post('get-csv-report-archive/{id}', 'ReportsController@download_csv_archive');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
    Route::get('reports/{user}', 'ReportsController@show');
    Route::post('save-archive', 'ReportsController@save_archive');
    Route::get('report-totals', 'ReportsController@totals');
});

/**
 * Archives
 */
Route::get('archives', 'ArchiveController@index');
Route::post('change-archive-date', 'ArchiveController@change_archive_date');

// Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
//     Route::post('change-archive-date', 'ArchiveController@change_archive_date');
// });

/**
 * Carriers Routes
 */
// Route::get('carriers', 'CarrierController@index');
// Route::get('carriers/{carrier}', 'CarrierController@show');

/**
 * Auth Routes
 */
//Route::get('register', 'AuthController@register');

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('register', 'RegistrationController@create');
    Route::post('register', 'RegistrationController@store');
});

//Route::get('login', 'AuthController@login');
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store');
Route::get('logout', 'SessionsController@destroy');
// Route::get('reset-password', function() {
//     return view('auth.passwords.reset');
// });

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/**
 * Email Routes
 */
Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('email-blast', 'EmailBlastController@index');
});

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
    Route::post('email-blast', 'EmailBlastController@email');
    Route::get('email-user/{user}', 'EmailBlastController@email_user');
    Route::get('send-email', 'EmailBlastController@index_send_email');
    Route::post('send-email', 'EmailBlastController@send_email');
    Route::get('email-tracker/{user}', 'EmailTrackerController@index_one_user');
});

Route::get('email-tracker-dealer', 'EmailTrackerController@getIndex_dealers');

Route::get('your-emails', 'EmailTrackerController@your_emails');

Route::get('contact', 'EmailBlastController@contact');
Route::post('contact', 'EmailBlastController@contact_submit');
Route::get('contact-us', 'LoggedOutController@contact');
Route::post('contact-us', 'LoggedOutController@contact_submit');

/**
 * Invoice Routes
 */
Route::get('invoices', 'InvoiceController@index');
// Route::group(['middleware' => 'App\Http\Middleware\LockOutUsers'], function () {
//     Route::get('invoices', 'InvoiceController@index');
// });
Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('invoices/user/{user}', 'InvoiceController@index_user');
    Route::get('new-invoice', 'InvoiceController@create');
    Route::get('new-invoice/{user}', 'InvoiceController@create_user');
    Route::post('new-invoice', 'InvoiceController@store');
    Route::post('new-invoice-item', 'InvoiceItemController@store');
    Route::get('invoices/edit/{invoice}', 'InvoiceController@edit');
    Route::post('update-invoice/{invoice}', 'InvoiceController@update');
    Route::get('invoice-item/delete/{item}', 'InvoiceItemController@destroy');
    Route::post('invoice/finalize/{invoice}', 'InvoiceController@finalize');
});

Route::get('invoices/{invoice}', 'InvoiceController@show');
Route::get('your-invoices', 'InvoiceController@your_invoices');
Route::post('invoice/finalize_user/{invoice}', 'InvoiceController@finalize_user');

/**
 * Closed Route
 */
Route::get('closed', function () {
    return view('closed');
})->name('closed');

/**
 * Test Routes
 */
// Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
//     Route::get('laravel-tester', function () {
//         \Log::emergency('emergency');
//         \Log::alert('alert');
//         \Log::critical('critical');
//         \Log::error('error');
//         \Log::warning('warning');
//         \Log::notice('notice');
//         \Log::info('info');
//         \Log::debug('debug');

//         return 'just a test';
//     })->name('laravel-tester');
// });

Route::group(['middleware' => 'App\Http\Middleware\LockOutUsersManagers'], function () {
    Route::get('phpinfo', function () {
        phpinfo();
    });
});
/**
 * To make changes...
 * sudo service php7.2-fpm restart
 *
 */

// Route::post('send_test_email', function() {

//     $user_leon = User::find(1);
//     //$user_kareem = User::find(2);

//     $message = 'Here is a test email just to show you how the email formating is going to look for the new STM. Let me know what you think. xxx';

//     $mail_success = \Mail::to($user_leon)->send(new EmailBlast($user_leon, $message));
//     //$mail_success2 = \Mail::to($user_kareem)->send(new EmailBlast($user_kareem, $message));

//     session()->flash('message', 'Emails have been sent?');

//     return redirect('/email-blast');

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
//     Auth::logout();
//     return redirect('/home');
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
