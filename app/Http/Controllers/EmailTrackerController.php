<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use jdavidbakr\MailTracker\Model\SentEmail;
use Mail;

class EmailTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_one_user(User $user)
    {
        $emails = SentEmail::where('email_address', $user->email)->orderBy('created_at', 'desc')->get();
        return view('vendor.emailTrakingViews.index-one-user', compact('emails', 'user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function your_emails(User $user)
    {
        $user = \Auth::user();
        $emails = SentEmail::where('email_address', $user->email)->orderBy('created_at', 'desc')->get();
        return view('vendor.emailTrakingViews.your-emails', compact('emails', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  jdavidbakr\MailTracker\Model\SentEmail;
     * @return \Illuminate\Http\Response
     */
    public function destroy(SentEmail $email)
    {
        $email->delete();
        session()->flash('danger', 'Email Deleted');
        return redirect('/email-tracker');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  jdavidbakr\MailTracker\Model\SentEmail;
     * @return \Illuminate\Http\Response
     */
    public function destroy_on_user(SentEmail $email, $user)
    {
        $email->delete();
        session()->flash('danger', 'Email Deleted');
        return redirect('/email-tracker/' . $user);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy_page($string)
    {
        $array = json_decode(base64_decode($string));
        foreach ($array as $item) {
            $email = SentEmail::find($item);
            $email->delete();
        }
        session()->flash('danger', 'Emails Deleted');
        return redirect('/email-tracker');
    }

    /**
     * Resend the email to the same email address
     *
     * @param  jdavidbakr\MailTracker\Model\SentEmail;
     * @return \Illuminate\Http\Response
     */
    public function resend(SentEmail $email)
    {
        $email_address = $email->email_address;
        $subject = $email->subject;
        $content = $email->content;
        $recipient = $email->company ? $email->company : $email_address;

        Mail::send([], [], function ($message) use ($email_address, $subject, $content) {
            $message->to($email_address)
                ->subject($subject)
                ->setBody($content, 'text/html');
        });

        // $message = 'this is a message...';
        // $user = User::where('email', $email_address)->first();
        // Mail::to($user)->send(new EmailBlast(
        //     $user,
        //     $message,
        //     $subject
        // ));

        session()->flash('message', 'Email has been resent to ' . $recipient);
        return redirect('/email-tracker');
    }
}
