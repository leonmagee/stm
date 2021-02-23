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
        $slides = Slide::where('url', '!=', '')->orderBy('order', 'ASC')->get();
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
