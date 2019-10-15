<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Mail\EmailBlast;
use App\Site;
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
        $sites = Site::all();
        $users = User::orderBy('company')->get();
        $sites_exclude = Site::whereNotIn('id', [4])->get();
        return view('email_blast.index', compact('sites', 'sites_exclude', 'users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('email_blast.contact');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_send_email()
    {
        $users = User::orderBy('company')->get();
        return view('email_blast.send-email', compact('users'));
    }

    /**
     * Email users
     */
    public function email(Request $request)
    {

        if (!$request->just_one_user && !$request->email_site) {
            return back()->withErrors('Please choose All Users, One Site or One User.');
        }

        $file = $request->file('upload-file-email');
        $file2 = $request->file('upload-file-email-2');
        $file3 = $request->file('upload-file-email-3');

        if (intval($request->just_one_user)) {
            // email just one user
            $user = User::where('id', $request->just_one_user)->first();

            \Mail::to($user)->send(new EmailBlast(
                $user,
                $request->message,
                $request->subject,
                $file,
                $file2,
                $file3
            ));

            session()->flash('message', 'Email has been sent to ' . $user->company . ' - ' . $user->name);
        } else {
            // email multiple users

            if ($request->exclude_sites) {
                $exclude_array = $request->exclude_sites;
            } else {
                $exclude_array = [];
            }

            // if ($request->exclude_users) {
            //     $exclude_array = $request->exclude_users;
            // } else {
            //     $exclude_array = [];
            // }

            if ($request->email_site === 'all_users') {
                // email all users (but not canceld)
                $users = User::whereNotIn('role_id', [7])->get();

                foreach ($users as $user) {
                    if (!$user->email_blast_disable && !in_array($user->role_id, $exclude_array)) {
                        \Mail::to($user)->send(new EmailBlast(
                            $user,
                            $request->message,
                            $request->subject,
                            $file,
                            $file2,
                            $file3
                        ));
                    }
                }

            } else {
                // email all users from one site
                $users = User::whereIn('role_id', [$request->email_site])->get();

                foreach ($users as $user) {
                    if (!$user->email_blast_disable) {
                        //if (!$user->email_blast_disable && !in_array($user->id, $exclude_array)) {
                        \Mail::to($user)->send(new EmailBlast(
                            $user,
                            $request->message,
                            $request->subject,
                            $file,
                            $file2,
                            $file3
                        ));
                    }
                }

            }

            session()->flash('message', 'Email Blast has been sent!');

        }

        return redirect('email-blast');
    }

    /**
     * Email single user
     */
    public function send_email(Request $request)
    {
        $this->validate($request, [
            'just_one_user' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $file = $request->file('upload-file-email');
        $file2 = $request->file('upload-file-email-2');
        $file3 = $request->file('upload-file-email-3');

        $user = User::where('id', $request->just_one_user)->first();

        \Mail::to($user)->send(new EmailBlast(
            $user,
            $request->message,
            $request->subject,
            $file,
            $file2,
            $file3
        ));

        session()->flash('message', 'Email has been sent to ' . $user->company . ' - ' . $user->name);

        return redirect('send-email');
    }

    /**
     * Contact form submit
     */
    public function contact_submit(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        $user = \Auth::user();

        // 1. get all admin users
        $admin_users = User::getAdminManageerEmployeeUsers();

        // 2. loop through all admin users to send email
        foreach ($admin_users as $admin) {
            if (!$admin->contact_email_disable) {
                \Mail::to($admin)->send(new ContactEmail(
                    $user,
                    $admin,
                    $request->message,
                ));
            }
        }

        // 3. confirmation email
        \Mail::to($user)->send(new EmailBlast(
            $user,
            'Thank you for contacting Sim Track Manager. We will get in touch as soon as possible.',
            'STM Contact',
        ));

        session()->flash('message', 'Thank you ' . $user->name . '! We will get in touch as soon as possible.');

        return redirect('contact');
    }

}
