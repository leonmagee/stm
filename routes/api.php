<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Works with Amazon SNS/SES to record email bounces
Route::post('/email-bounced', function ($data) {
    $data_json = json_encode($data);
    \Log::notice($data_json);
    return 'this rest endpoint is working?';
    //return 'email bounce testing';
});

Route::get('/api-testing', function () {
    return 'api success with get?';
});
