<?php

namespace App\Http\Controllers;

use App\Sim;
use Illuminate\Http\Request;

class AuthorizedController extends Controller
{
    /**
    * Only Logged In Users can see this
    **/
    public function __construct()
    {
        $this->middleware('auth');
    }

}