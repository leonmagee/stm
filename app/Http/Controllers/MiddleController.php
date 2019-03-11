<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Settings;
use App\Helpers;
use App\Site;

class MiddleController extends Controller
{

    public function __construct()
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id(); // not really a query? gets id from session?
        $site_name = Site::find($site_id)->name;




        $this->middleware('auth');
        dd('testing');
        var_dump('this is working?');
    }
}