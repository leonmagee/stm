<?php

namespace App\Http\Controllers;

use App\Mail\EmailNote;
use App\Note;
use App\User;
use Illuminate\Http\Request;
use jdavidbakr\MailTracker\Model\SentEmail;

class NoteController extends Controller
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
        $notes = Note::orderBy('created_at', 'DESC')->get();
        return view('notes.index', compact('notes'));
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
    public function store(Request $request, User $user)
    {

        $this->validate(request(), [
            'note' => 'required|max:200',
        ]);

        $current_user = \Auth::user();
        $note = new \App\Note;
        $note->text = $request->note;
        $note->user_id = $user->id;
        $note->author = $current_user->name;
        $date = \Carbon\Carbon::now()->toDateTimeString();
        $note->save();

        $admin_users = User::getAdminManageerEmployeeUsers();
        foreach ($admin_users as $admin) {
            if (!$admin->notes_email_disable) {
                \Mail::to($admin)->send(new EmailNote(
                    $admin,
                    $note->text,
                    $note->author,
                    $date,
                    $user
                )
                    // [],
                    // function ($message) {
                    //     $message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));
                    // }
                );
            }
        }

// \Mail::send('email.test', [], function ($message) {
        //     // ... other settings here
        //     $message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));
        // });

        session()->flash('message', 'Note Added');
        return redirect('/users/' . $user->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $user = $note->user->id;
        $note->delete();
        session()->flash('danger', 'Note Deleted');
        return redirect('/users/' . $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy_email(SentEmail $email)
    {
        $email->delete();
        session()->flash('danger', 'Email Deleted');
        return redirect('/email-tracker');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy_emails($string)
    {

        $array = json_decode(base64_decode($string));
        foreach ($array as $item) {
            $email = SentEmail::find($item);
            $email->delete();
        }
        session()->flash('danger', 'Emails Deleted');
        return redirect('/email-tracker');
    }
}
