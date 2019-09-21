<?php

namespace App\Http\Controllers;

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
