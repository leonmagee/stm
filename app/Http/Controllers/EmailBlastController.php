<?php

namespace App\Http\Controllers;

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
        //dd($users[0]);
        return view('email_blast.index', compact('sites', 'users'));
    }

    /**
     * Email users
     */
    public function email(Request $request)
    {

        $file = $request->file('upload-file-email');
        $file2 = $request->file('upload-file-email-2');
        $file3 = $request->file('upload-file-email-3');
        //dd($file);
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
            if ($request->email_site === 'all_users') {
                // email all users (but not canceld)
                $users = User::whereNotIn('role_id', [7])->get();
            } else {
                // email all users from one site
                $users = User::whereIn('role_id', [$request->email_site])->get();
            }

            foreach ($users as $user) {
                if (!$user->email_blast_disable) {
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

            session()->flash('message', 'Email Blast has been sent!');

        }

        return redirect('email-blast');
    }

}
