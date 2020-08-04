<?php

namespace App\Http\Controllers;

use App\Mail\RmaEmail;
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

        \Mail::to($user)->send(new RmaEmail(
            $user,
            $purchase,
            $header_text,
            'RMA Processing: # RMA-GSW-' . $rma->id,
            true,
            $rma
        ));

        // 6. Email admins (admins and managers)
        $admins = User::getAdminManageerUsers();
        foreach ($admins as $admin) {
            if (!$admin->notes_email_disable) {
                $header_text = "<strong>Hello " . $admin->name . "!</strong><br />A new RMA has been submitted by " . $user->company . " - " . $user->name . ". RMA #: <strong>RMA-GSW-" . $rma->id . "</strong>";

                \Mail::to($admin)->send(new RmaEmail(
                    $user,
                    $purchase,
                    $header_text,
                    'New RMA Received',
                    false,
                    $rma
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request, Rma $rma)
    {
        $rma->status = $request->status;
        $rma->save();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function rma_approve(Request $request, Rma $rma)
    {
        $rma->status = 3;
        $rma->save();
        $user = $rma->user;
        $header_text = "<strong>Hello " . $user->name . "</strong><br />" . $request->rma_message;
        $purchase = Purchase::find($rma->product->purchase_id);

        \Mail::to($user)->send(new RmaEmail(
            $user,
            $purchase,
            $header_text,
            'RMA # RMA-GSW-' . $rma->id . ' Approved',
            true,
            $rma
        ));

        session()->flash('message', 'RMA Approved.');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rma  $rma
     * @return \Illuminate\Http\Response
     */
    public function rma_reject(Request $request, Rma $rma)
    {
        //dd('reject', $request, $rma);
        $rma->status = 4;
        $rma->save();
        $user = $rma->user;
        $header_text = "<strong>Hello " . $user->name . "</strong><br />" . $request->rma_message;
        $purchase = Purchase::find($rma->product->purchase_id);

        \Mail::to($user)->send(new RmaEmail(
            $user,
            $purchase,
            $header_text,
            'RMA # RMA-GSW-' . $rma->id . ' Rejected',
            true,
            $rma
        ));

        session()->flash('message', 'RMA Rejected.');
        return redirect()->back();
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
