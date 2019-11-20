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

        $this->validate($request, [
            'cc_manual_email' => 'email|nullable',
        ], [
            'cc_manual_email.email' => 'Must be a valid email address.',
        ]);

        if (!$request->just_one_user && !$request->email_site) {
            return back()->withErrors('Please choose All Users, One Site or One User.');
        }

        $file = $request->file('upload-file-email');
        $file2 = $request->file('upload-file-email-2');
        $file3 = $request->file('upload-file-email-3');

        if (intval($request->just_one_user)) {
            // email just one user
            $user = User::where('id', $request->just_one_user)->first();
            $hello = '# Hello ' . $user->name . '!';
            $hello_cc = '# Copy of email sent to ' . $user->name . ' - ' . $user->company;

            \Mail::to($user)->send(new EmailBlast(
                $user,
                $request->message,
                $request->subject,
                $file,
                $file2,
                $file3,
                null,
                $hello
            ));

            $email_to_string = $user->company . ' - ' . $user->name;

            if (intval($request->cc_just_one_user)) {
                // cc one user
                $user_cc = User::where('id', $request->cc_just_one_user)->first();

                $email_to_string .= ' / ' . $user_cc->company . ' - ' . $user_cc->name;

                \Mail::to($user_cc)->send(new EmailBlast(
                    $user_cc,
                    $request->message,
                    $request->subject,
                    $file,
                    $file2,
                    $file3,
                    null,
                    $hello_cc
                ));
            }

            if ($request->cc_manual_email) {

                $user_manual = new User;
                $user_manual->name = false;
                $user_manual->email = $request->cc_manual_email;

                $email_to_string .= ' / ' . $user_manual->email;

                \Mail::to($user_manual)->send(new EmailBlast(
                    $user_manual,
                    $request->message,
                    $request->subject,
                    $file,
                    $file2,
                    $file3,
                    null,
                    $hello_cc
                ));
            }

            session()->flash('message', 'Email has been sent to ' . $email_to_string);
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
            'cc_manual_email' => 'email|nullable',
            'subject' => 'required',
            'message' => 'required',
        ], [
            'just_one_user.required' => 'The user field is required.',
            'cc_manual_email.email' => 'Must be a valid email address.',
        ]);

        if (intval($request->just_one_user)) {

            $file = $request->file('upload-file-email');
            $file2 = $request->file('upload-file-email-2');
            $file3 = $request->file('upload-file-email-3');

            // email just one user
            $user = User::where('id', $request->just_one_user)->first();
            $hello = '# Hello ' . $user->name . '!';
            $hello_cc = '# Copy of email sent to ' . $user->name . ' - ' . $user->company;

            \Mail::to($user)->send(new EmailBlast(
                $user,
                $request->message,
                $request->subject,
                $file,
                $file2,
                $file3,
                null,
                $hello
            ));

            $email_to_string = $user->company . ' - ' . $user->name;

            if (intval($request->cc_just_one_user)) {
                // cc one user
                $user_cc = User::where('id', $request->cc_just_one_user)->first();

                $email_to_string .= ' / ' . $user_cc->company . ' - ' . $user_cc->name;

                \Mail::to($user_cc)->send(new EmailBlast(
                    $user_cc,
                    $request->message,
                    $request->subject,
                    $file,
                    $file2,
                    $file3,
                    null,
                    $hello_cc
                ));
            }

            if ($request->cc_manual_email) {

                $user_manual = new User;
                $user_manual->name = false;
                $user_manual->email = $request->cc_manual_email;

                $email_to_string .= ' / ' . $user_manual->email;

                \Mail::to($user_manual)->send(new EmailBlast(
                    $user_manual,
                    $request->message,
                    $request->subject,
                    $file,
                    $file2,
                    $file3,
                    null,
                    $hello_cc
                ));
            }
        } else {
            return redirect()->back()->with('danger', 'The user field is required.');

        }

        session()->flash('message', 'Email has been sent to ' . $email_to_string);

        //session()->flash('message', 'Email has been sent to ' . $user->company . ' - ' . $user->name);

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
                    $request->message
                ));
            }
        }

        // 3. confirmation email
        \Mail::to($user)->send(new EmailBlast(
            $user,
            'Thank you for contacting us. One of our professional staff will get in touch with you as soon as possible.',
            'STM Contact'
        ));

        session()->flash('message', 'Thank you ' . $user->name . '! We will get in touch as soon as possible.');

        return redirect('contact');
    }

}
