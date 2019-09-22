<?php

namespace App\Http\Controllers;

use App\Mail\EmailBlast;
use App\User;
use Illuminate\Http\Request;

class EmailBlastController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('email_blast.index');
    }

    /**
     * Email all users
     */
    public function email(Request $request)
    {

        $users = User::all();

        foreach ($users as $user) {
            if ($user->role_id !== 7) {
                \Mail::to($user)->send(new EmailBlast($user, $request->message));
            }
        }

        session()->flash('message', 'Email Blast has been sent!');

        return redirect('email-blast');
    }

}
