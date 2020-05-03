@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Invoice</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Invoice Number</div>
          {{-- <div class="stm_inv__header--label">Invoice Title</div> --}}
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">Agent / Dealer</div>
          <div class="stm_inv__header--label">Invoice Date</div>
          <div class="stm_inv__header--label">Due Date</div>
          <div class="stm_inv__header--label">Discount</div>
          <div class="stm_inv__header--label">Status</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">#{{ $invoice->id }}</div>
          {{-- <div class="stm_inv__header--item">{{ $invoice->title }}
        </div> --}}
        <div class="stm_inv__header--item">{{ $invoice->user->company }}</div>
        <div class="stm_inv__header--item">{{ $invoice->user->name }}</div>
        <div class="stm_inv__header--item">{{ $invoice->created_at->format('M d, Y') }}</div>
        <div class="stm_inv__header--item">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
        <div class="stm_inv__header--item">${{ number_format($invoice->discount, 2) }}</div>
        <div class="stm_inv__header--item">{{ \App\Helpers::status($invoice->status) }}</div>
      </div>
    </div>

    <div class="stm_inv__header margin-top-2">
      <div class="stm_inv__flex">
        <div class="stm_inv__header--label">Message</div>
        <div class="stm_inv__header--label">Note</div>
      </div>
      <div class="stm_inv__flex">
        <div class="stm_inv__header--item">{{ $invoice->message }}</div>
        <div class="stm_inv__header--item">{{ $invoice->note }}</div>
      </div>
    </div>

    <div class="stm_inv__items">
      <div class="stm_inv__flex">
        <div class="stm_inv__item--label">Quantity</div>
        <div class="stm_inv__item--label">Cost</div>
        <div class="stm_inv__item--label stm_inv__flex--60">Description</div>
        <div class="stm_inv__item--label stm_inv__flex--delete"></div>
      </div>
      @foreach($invoice->items as $item)
      <div class="stm_inv__flex">
        <div class="stm_inv__item--item">{{ $item->quantity }}</div>
        <div class="stm_inv__item--item">${{ number_format($item->cost, 2) }}</div>
        <div class="stm_inv__item--item stm_inv__flex--60">{{ $item->description }}</div>
        <div class="stm_inv__item--item stm_inv__flex--delete">
          <a href="/invoice-item/delete/{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
          </a>
        </div>
      </div>
      @endforeach
    </div>

    <div class="stm_inv__header margin-top-2">
      <div class="stm_inv__flex">
        <div class="stm_inv__header--label">Total</div>
        <div class="stm_inv__header--label">Discount</div>
        <div class="stm_inv__header--label">Amount Due</div>
      </div>
      <div class="stm_inv__flex">
        <div class="stm_inv__header--item">${{ number_format($total, 2) }}</div>
        <div class="stm_inv__header--item">-${{ number_format($invoice->discount, 2) }}</div>
        <div class="stm_inv__header--item">${{ number_format(($total - $invoice->discount), 2) }}</div>
      </div>
    </div>

    {{-- <div class="stm_inv__total">
        Total: <span>${{ number_format($total, 2) }}</span>
  </div> --}}

  <div class="stm_inv__form">
    <form method="POST" action="/new-invoice-item">

      @csrf

      <div class="stm_inv__form--flex">

        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />

        <div class="field">
          <label class="label" for="quantity">Quantity</label>
          <div class="control">
            <input class="input" type="number" min="0" id="quantity" name="quantity" />
          </div>
        </div>

        <div class="field">
          <label class="label" for="cost">Cost</label>
          <div class="control">
            <input class="input" type="number" min="0" id="cost" name="cost" step="any" />
          </div>
        </div>

        <div class="field">
          <label class="label" for="description">Description</label>
          <div class="control">
            <input class="input" type="text" id="description" name="description" />
          </div>
        </div>

      </div>
      <div class="field flex-margin">
        <div class="control">
          <button class="button is-primary" type="submit">Add Line Item</button>
        </div>
      </div>
  </div>
  </form>
  <form action="/invoice/finalize/{{ $invoice->id }}" method="POST" class="stm_imv__finalize">
    @csrf
    <button class="button is-danger call-loader" type="submit">Finalize Invoice</button>
    <a class="button is-primary" href="/invoices/edit/{{ $invoice->id }}">Edit</a>
  </form>
</div>


</div>

</div>

@endsection
