<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseEmail;
use App\Purchase;
use App\Rma;
use App\User;
use Illuminate\Http\Request;

class RmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rmas.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function your_rmas()
    {
        $user_id = \Auth::user()->id;
        $rmas = Rma::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view('rmas.your-rmas', compact('rmas'));
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
        $user = \Auth::user();
        $rma = Rma::create(
            [
                'user_id' => $user->id,
                'purchase_product_id' => $request->purchase_product_id,
                'quantity' => $request->quantity,
                'explanation' => $request->explanation,
                'status' => 2,
            ]
        );

        $purchase = Purchase::find($request->purchase_id);

        $header_text = "<strong>Hello " . $user->name . "!</strong><br />We have received your RMA submission. Your RMA # is <strong>RMA-GSW" . $rma->id . "</strong>. You will receive another email when we update the status of your RMA.";

        \Mail::to($user)->send(new PurchaseEmail(
            $user,
            $purchase,
            $header_text,
            'RMA Processing: # RMA-GSW-' . $rma->id,
            true
        ));

        // 6. Email admins (admins and managers)
        $admins = User::getAdminManageerUsers();
        foreach ($admins as $admin) {
            if (!$admin->notes_email_disable) {
                $header_text = "<strong>Hello " . $admin->name . "!</strong><br />A new RMA has been submitted by " . $user->company . " - " . $user->name . ". RMA #: <strong>RMA-GSW-" . $rma->id . "</strong>";

                \Mail::to($admin)->send(new PurchaseEmail(
                    $user,
                    $purchase,
                    $header_text,
                    'New RMA Received',
                    false
                ));
            }
        }

        session()->flash('message', 'An RMA request has been submitted. You will receive an email with more details. <a href="/your-rmas">View RMA</a>.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function show(Rma $rma)
    {
        //$users = User::orderBy('company')->get();
        return view('rmas.show', compact('rma'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function edit(Rma $rma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rma $rma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rma $rma)
    {
        //
    }
}
