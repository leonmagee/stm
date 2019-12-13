<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jdavidbakr\MailTracker\Model\SentEmail;

class EmailTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SentEmail $email)
    {
        $email->delete();
        session()->flash('danger', 'Email Deleted');
        return redirect('/email-tracker');
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
}
