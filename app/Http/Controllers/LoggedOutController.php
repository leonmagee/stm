<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmailNewResponse;
use App\User;
use Illuminate\Http\Request;

class LoggedOutController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('logged_out.contact');
    }

    /**
     * Contact form submit
     */
    public function contact_submit(Request $request)
    {

        $this->validate($request, [
            'business' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        // 1. get all admin users
        $admin_users = User::getAdminManageerEmployeeUsers();

        // 2. loop through all admin users to send email
        foreach ($admin_users as $admin) {
            if (!$admin->contact_email_disable) {
                \Mail::to($admin)->send(new ContactEmailNew(
                    $admin,
                    $request->business,
                    $request->email,
                    $request->phone,
                    $request->message
                ));
            }
        }

        // 3. confirmation email
        \Mail::to($request->email)->send(new ContactEmailNewResponse(
            'Thank you for contacting us. One of our professional staff will get in touch with you as soon as possible.',
            'Thank You - GS Wireless'
        ));

        //session()->flash('message', 'Thank you ' . $user->name . '! We will get in touch as soon as possible.');
        session()->flash('message', 'Thank you! We will get in touch as soon as possible.');

        return redirect('contact-us');
    }

}
