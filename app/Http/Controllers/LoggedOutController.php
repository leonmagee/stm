<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmailNew;
use App\Mail\ContactEmailNewResponse;
use App\User;
use Cohensive\Embed\Facades\Embed;
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
     * About Us Page
     */
    public function about()
    {
        $url_1 = 'https://www.youtube.com/watch?v=k1kkJRcndIc&feature=emb_logo';
        $embed_1 = Embed::make($url_1)->parseUrl();
        $embed_1->setAttribute(['width' => 475]);
        $url_2 = 'https://www.youtube.com/watch?v=vWub9jwV-Lc&feature=emb_logo';
        $embed_2 = Embed::make($url_2)->parseUrl();
        $embed_2->setAttribute(['width' => 475]);
        $url_3 = 'https://www.youtube.com/watch?v=T8PMTYT_URA&feature=emb_logo';
        $embed_3 = Embed::make($url_3)->parseUrl();
        $embed_3->setAttribute(['width' => 475]);

        return view('about', compact('embed_1', 'embed_2', 'embed_3'));
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

        //dd($request);

        $this->validate($request, [
            'name' => 'required',
            'business' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'You mush check the reCAPTCHA box.',
        ]);

//         $this->validate($request, [
        //     'subject' => 'required',
        //     'message' => 'required',
        //     'cc_manual_email' => 'email|nullable',
        // ], [
        //     'cc_manual_email.email' => 'Must be a valid email address.',
        // ]);

        // 1. get all admin users
        $admin_users = User::getAdminManageerEmployeeUsers();

        // 2. loop through all admin users to send email
        foreach ($admin_users as $admin) {
            if (!$admin->contact_email_disable) {
                \Mail::to($admin)->send(new ContactEmailNew(
                    $admin,
                    $request->name,
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
            $request->name,
            'Thank You - GS Wireless'
        ));

        //session()->flash('message', 'Thank you ' . $user->name . '! We will get in touch as soon as possible.');
        session()->flash('message', 'Thank you! We will get in touch as soon as possible.');

        return redirect('contact-us');
    }

}
