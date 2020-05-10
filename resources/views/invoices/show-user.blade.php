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
          <div class="stm_inv__header--label">Invoice Date</div>
          <div class="stm_inv__header--label">Due Date</div>
          <div class="stm_inv__header--label">Status</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">#{{ $invoice->id }}</div>
          <div class="stm_inv__header--item">{{ $invoice->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $invoice->status }}">
            {{ \App\Helpers::status($invoice->status) }}
          </div>
        </div>
      </div>
      <div class="stm_inv__items">
        <div class="stm_inv__flex">
          <div class="stm_inv__item--label">Item</div>
          <div class="stm_inv__item--label stm_inv__flex--60">Description</div>
          <div class="stm_inv__item--label">Quantity</div>
          <div class="stm_inv__item--label">Cost</div>
          <div class="stm_inv__item--label">Total</div>
        </div>
        @foreach($invoice->items as $item)
        <div class="stm_inv__flex stm_inv__flex-{{ $item->item }}">
          <div class="stm_inv__item--item">{{ \App\Helpers::invoice_item($item->item) }}</div>
          <div class="stm_inv__item--item stm_inv__flex--60">{{ $item->description }}</div>
          <div class="stm_inv__item--item">{{ $item->quantity }}</div>
          <div class="stm_inv__item--item">${{ number_format($item->cost, 2) }}</div>
          <div class="stm_inv__item--item">@if($item->item ==
            3)-@endif${{ number_format(($item->cost * $item->quantity), 2) }}</div>
        </div>
        @endforeach
      </div>
      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Total</div>
          <div class="stm_inv__header--label">Total Discount</div>
          <div class="stm_inv__header--label">Amount Due</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">${{ number_format($subtotal, 2) }}</div>
          <div class="stm_inv__header--item stm_inv__header--item-red">-${{ number_format($discount, 2) }}</div>
          <div class="stm_inv__header--item">${{ number_format(($total), 2) }}</div>
        </div>
      </div>
      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Message</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $invoice->message }}</div>
        </div>
      </div>
      <div class="stm_imv__finalize">
        <a href="#" class="modal-open button is-danger">Send Invoice Email</a>
      </div>
    </div>
  </div>

</div>

@endsection

@section('modal')

<h3 class="title">Are You Sure?</h3>

<form action="/invoice/finalize_user/{{ $invoice->id }}" method="POST" class="stm_imv__finalize">
  @csrf
  <button class="button is-danger call-loader" type="submit">Send Invoice</button>
  <a href="#" class="modal-close-button button is-primary">Cancel</a>
</form>


@endsection
