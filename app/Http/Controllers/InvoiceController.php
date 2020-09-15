<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Invoice;
use App\Mail\InvoiceEmail;
use App\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
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
        $user = \Auth::user();
        if (!($user->isAdmin() || $user->isMasterAgent())) {
            return redirect('/');
        }
        return view('invoices.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_user(User $user)
    {
        return view('invoices.index_user', compact('user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function your_invoices()
    {
        $user = \Auth::user();
        return view('invoices.index_user', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::getAgentsDealers();
        return view('invoices.create', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_user(User $user)
    {
        return view('invoices.create_user', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'due_date' => 'required',
        ], [
            'user_id.required' => 'The User field is required.',
            'due_date.required' => 'The Due Date field is required.',
        ]);
        $due_date = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d');
        Invoice::create([
            'user_id' => $request->user_id,
            'due_date' => $due_date,
            'status' => 1,
            'message' => $request->message,
            'note' => $request->note,
        ]);
        session()->flash('message', 'New Invoice Added');
        return redirect('invoices');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $total = 0;
        $discount = 0;
        $subtotal = 0;
        foreach ($invoice->items as $item) {
            if ($item->item == 3) {
                $total -= ($item->cost * $item->quantity);
                $discount += ($item->cost * $item->quantity);
            } else {
                $total += ($item->cost * $item->quantity);
                $subtotal += ($item->cost * $item->quantity);
            }
        }

        $logged_in = \Auth::user();
        if ($logged_in->isAdminManagerEmployee()) {

            $users = User::orderBy('company')->get();

            return view('invoices.show', compact('invoice', 'total', 'subtotal', 'discount', 'users'));

        } elseif ($site_id = $logged_in->isMasterAgent()) {
            $invoice_user = $invoice->user;
            $role_id = Helpers::get_role_id($site_id);
            if ($role_id != $invoice_user->role_id) {
                return redirect('/');
            }
            $users = [];
            return view('invoices.show', compact('invoice', 'total', 'subtotal', 'discount', 'users'));
        } else {
            if ($logged_in->id != $invoice->user_id) {
                return redirect('/');
            } else {
                return view('invoices.show-user', compact('invoice', 'total', 'subtotal', 'discount'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $users = User::getAgentsDealers();
        $invoice->due_date = \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y');
        return view('invoices.edit', compact('invoice', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'user_id' => 'required',
            'due_date' => 'required',
        ]);
        $due_date = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d');
        //$title = $request->title ? $request->title : 'Invoice';
        $invoice->update([
            'user_id' => $request->user_id,
            'due_date' => $due_date,
            'status' => $request->status,
            'message' => $request->message,
            'note' => $request->note,
        ]);
        session()->flash('message', 'Invoice Updated');
        return redirect('invoices/' . $invoice->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    /**
     * Update status to pending and email user
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function finalize(Invoice $invoice, Request $request)
    {
        $cc_user = User::find($request->cc_user_1);
        if ($cc_user) {
            $email_1 = $cc_user;
        } else {
            $email_1 = false;
        }
        $email_2 = $request->cc_user_2;

        // 1. send email
        $user = $invoice->user;
        $total = 0;
        $discount = 0;
        $subtotal = 0;
        foreach ($invoice->items as $item) {
            if ($item->item == 3) {
                $total -= ($item->cost * $item->quantity);
                $discount += ($item->cost * $item->quantity);
            } else {
                $total += ($item->cost * $item->quantity);
                $subtotal += ($item->cost * $item->quantity);
            }
        }

        \Mail::to($user)->send(new InvoiceEmail(
            $user,
            $invoice,
            $subtotal,
            $discount,
            $total,
            false,
            $user
        ));

        $admins = User::getAdminManageerUsers();
        foreach ($admins as $admin) {
            \Mail::to($admin)->send(new InvoiceEmail(
                $user,
                $invoice,
                $subtotal,
                $discount,
                $total,
                true,
                $admin
            ));
        }

        if ($email_1) {
            \Mail::to($email_1)->send(new InvoiceEmail(
                $user,
                $invoice,
                $subtotal,
                $discount,
                $total,
                false,
                $email_1
            ));
        }
        if ($email_2) {
            \Mail::to($email_2)->send(new InvoiceEmail(
                $user,
                $invoice,
                $subtotal,
                $discount,
                $total,
                false,
                false
            ));
        }

        // 2. update status (if set to new)
        if ($invoice->status == 1) {
            $invoice->status = 2;
        }
        $invoice->save();
        // 3. return redirect
        session()->flash('message', 'Email Sent & Status Updated.');
        return \Redirect::back();
    }

    /**
     * Update status to pending and email user
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function finalize_user(Invoice $invoice)
    {
        // 1. send email
        $user = $invoice->user;
        $total = 0;
        $discount = 0;
        $subtotal = 0;
        foreach ($invoice->items as $item) {
            if ($item->item == 3) {
                $total -= ($item->cost * $item->quantity);
                $discount += ($item->cost * $item->quantity);
            } else {
                $total += ($item->cost * $item->quantity);
                $subtotal += ($item->cost * $item->quantity);
            }
        }

        \Mail::to($user)->send(new InvoiceEmail(
            $user,
            $invoice,
            $subtotal,
            $discount,
            $total,
            true,
            $user
        ));

        // 2. return redirect
        session()->flash('message', 'Invoice Email Has Been Sent.');
        return \Redirect::back();
    }
}
