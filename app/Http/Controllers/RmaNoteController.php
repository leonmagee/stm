<?php

namespace App\Http\Controllers;

use App\Rma;
use App\RmaNote;
use Illuminate\Http\Request;

class RmaNoteController extends Controller
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
    public function store(Request $request, Rma $rma)
    {
        $this->validate(request(), [
            'note' => 'required|max:200',
        ]);

        $current_user = \Auth::user();
        $note = new \App\RmaNote;
        $note->text = $request->note;
        $note->rma_id = $rma->id;
        $note->author = $current_user->name;
        $date = \Carbon\Carbon::now()->format('F j, Y - g:i a');
        $note->save();

        session()->flash('message', 'Note Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RmaNote  $rmaNote
     * @return \Illuminate\Http\Response
     */
    public function show(RmaNote $rmaNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmaNote  $rmaNote
     * @return \Illuminate\Http\Response
     */
    public function edit(RmaNote $rmaNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmaNote  $rmaNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RmaNote $rmaNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmaNote  $rmaNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(RmaNote $rmaNote)
    {
        $rmaNote->delete();
        session()->flash('danger', 'Note Deleted');
        return redirect()->back();
    }
}
