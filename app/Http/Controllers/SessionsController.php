<?php

namespace App\Http\Controllers;

use App\Slide;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }

    public function create()
    {
        //$banner_1 = "https://res.cloudinary.com/dabvi4jmx/image/upload/v1560143448/stm/h2o-wireless-banner.png";
        //$banner_1 = "https://res.cloudinary.com/dabvi4jmx/image/upload/v1551818964/stm/port-in-spiff-20.jpg";
        //$banner_2 = "https://res.cloudinary.com/dabvi4jmx/image/upload/v1560214428/stm/gsa-link.png";
        //$banner_2 = "https://res.cloudinary.com/dabvi4jmx/image/upload/v1551818965/stm/port-in-spiff-40.jpg";
        //return view('sessions.create', compact('banner_1', 'banner_2'));

        // get slides
        $slides = Slide::all();
        return view('sessions.create', compact('slides'));
    }

    public function store()
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
                'message' => 'Login Failed',
            ]);
        }

        return redirect()->home();
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->home();
    }
}
