<?php

namespace App\Http\Controllers;

use App\ContactToken;
use App\Helpers;
use App\Mail\ContactEmailNew;
use App\Mail\ContactEmailNewResponse;
use App\Mail\ContactEmailStart;
use App\User;
use Cohensive\Embed\Facades\Embed;
use Illuminate\Http\Request;

class LoggedOutController extends Controller
{

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
    public function contact(Request $request)
    {
        if ($access_token = $request->token) {
            $token_check = ContactToken::where('token', $access_token)->first();
            if ($token_check) {
                $token_date = $token_check->created_at->addHour();
                $expired = \Carbon\Carbon::now()->gt($token_date);
                if ($expired) {
                    $token_check->delete();
                    session()->flash('danger', 'Token has expired. Please submit your email again.');
                    return view('logged_out.contact-start');
                }
                return view('logged_out.contact', compact('access_token'));
            } else {
                session()->flash('danger', 'Token not valid. Please submit your email again.');
                return view('logged_out.contact-start');
            }
        } else {
            return view('logged_out.contact-start');
        }
    }

    /**
     * Contact form submit
     */
    public function contact_start_submit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'You mush check the reCAPTCHA box.',
        ]);

        $token = bin2hex(random_bytes(64));

        $save_token = ContactToken::create([
            'token' => $token,
        ]);

        // 3. confirmation email
        \Mail::to($request->email)->send(new ContactEmailStart(
            'Contact Us - GS Wireless',
            $save_token->token
        ));

        session()->flash('message', 'Thank you! Please check your email for the contact link.');

        return redirect('contact-us');

    }

    /**
     * Contact form submit
     */
    public function contact_submit(Request $request)
    {
        $token_check = ContactToken::where('token', $request->access_token)->first();
        if ($token_check) {
            $token_date = $token_check->created_at->addHour();
            $expired = \Carbon\Carbon::now()->gt($token_date);
            if ($expired) {
                $token_check->delete();
                session()->flash('danger', 'Token has expired. Please submit your email again.');
                return redirect('/contact-us');
            }
        } else {
            session()->flash('danger', 'Token not valid. Please submit your email again.');
            return redirect('/contact-us');
        }

        $this->validate($request, [
            'name' => 'required',
            'business' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required|max:300',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'You mush check the reCAPTCHA box.',
            'message.max' => 'The Comment is limited to 300 characters.',
        ]);

        $email_block_array = [
            '.ru',
            'petviktors',
            'shestakovromanrsai',
            'JO6746',
            'MORDA0260',
        ];
        foreach ($email_block_array as $block) {
            if (strpos($request->email, $block) !== false) {
                session()->flash('message', 'Thank you! We will get in touch as soon as possible.');
                return redirect('contact-us');
            }
        }
        $message_block_array = [
            'http',
            '.com',
            'www',
            'dotcom',
            'dot com',
            'Thank you!!1',
        ];
        foreach ($message_block_array as $block) {
            if (strpos($request->message, $block) !== false) {
                session()->flash('message', 'Thank you! We will get in touch as soon as possible.');
                return redirect('contact-us');
            }
        }

        if (Helpers::isRussian($request->message)) {
            session()->flash('message', 'Thank you! We will get in touch as soon as possible.');
            return redirect('contact-us');
        }
        $message = strip_tags($request->message, '<br />');

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
                    $message
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
