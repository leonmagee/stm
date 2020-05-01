<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceItem;
use App\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoices.index');
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
            //'message' => 'required',
        ]);
        $due_date = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d');
        $title = $request->title ? $request->title : 'Invoice';
        Invoice::create([
            'user_id' => $request->user_id,
            'due_date' => $due_date,
            'title' => $title,
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
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get();
        $total = 0;
        foreach ($items as $item) {
            $total += ($item->cost * $item->quantity);
        }
        return view('invoices.show', compact('invoice', 'items', 'total'));
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
        $title = $request->title ? $request->title : 'Invoice';
        $invoice->update([
            'user_id' => $request->user_id,
            'due_date' => $due_date,
            'title' => $title,
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
    public function finalize(Invoice $invoice)
    {
        dd($invoice);
        $users = User::getAgentsDealers();
        $invoice->due_date = \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y');
        return view('invoices.edit', compact('invoice', 'users'));
    }
}
