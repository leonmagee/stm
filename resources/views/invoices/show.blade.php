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
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">User</div>
          <div class="stm_inv__header--label">Invoice Date</div>
          <div class="stm_inv__header--label">Due Date</div>
          <div class="stm_inv__header--label">Status</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">#{{ $invoice->id }}</div>
          <div class="stm_inv__header--item">{{ $invoice->user->company }}</div>
          <div class="stm_inv__header--item">{{ $invoice->user->name }}</div>
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
          @if(($invoice->status < 3) && (\Auth::user()->isAdmin())) <div
              class="stm_inv__item--label stm_inv__flex--delete">
            </div>
            @endif
        </div>
        @foreach($invoice->items as $item)
        <div class="stm_inv__flex stm_inv__flex-{{ $item->item }}">
          <div class="stm_inv__item--item">{{ \App\Helpers::invoice_item($item->item) }}</div>
          <div class="stm_inv__item--item stm_inv__flex--60">{{ $item->description }}</div>
          <div class="stm_inv__item--item">{{ $item->quantity }}</div>
          <div class="stm_inv__item--item">${{ number_format($item->cost, 2) }}</div>
          <div class="stm_inv__item--item">@if($item->item ==
            3)-@endif${{ number_format(($item->cost * $item->quantity), 2) }}</div>
          @if(($invoice->status < 3) && (\Auth::user()->isAdmin())) <div
              class="stm_inv__item--item stm_inv__flex--delete">
              <a class="modal-delete-open" item_id={{ $item->id }}>
                <i class="fas fa-trash-alt"></i>
              </a>
            </div>

            <div class="modal" id="delete-item-modal-{{ $item->id }}">

              <div class="modal-background"></div>

              <div class="modal-content">

                <div class="modal-box">

                  <h4 class="title">Are You Sure?</h4>

                  <a href="/invoice-item/delete/{{ $item->id }}" class="button is-danger">Delete Item</a>
                  <a class="modal-delete-close-button button is-primary" item_id={{ $item->id }}>Cancel</a>
                </div>

              </div>

              <button class="modal-delete-close is-large" aria-label="close" item_id={{ $item->id }}></button>

            </div>
            @endif
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
          <div class="stm_inv__header--label">Note</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $invoice->message }}</div>
          <div class="stm_inv__header--item">{{ $invoice->note }}</div>
        </div>
      </div>
      @if(($invoice->status < 3) && (\Auth::user()->isAdmin())) <div class="stm_inv__form">
          <form method="POST" action="/new-invoice-item">
            @csrf
            <div class="stm_inv__form--flex">
              <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />
              <div class="field">
                <label class="label" for="item">Item</label>
                <div class="select">
                  <select name="item" id="item">
                    <option value="1">Product</option>
                    <option value="2">Service</option>
                    <option value="3">Discount</option>
                  </select>
                </div>
              </div>
              <div class="field description">
                <label class="label" for="description">Description</label>
                <div class="control">
                  <input class="input" type="text" id="description" name="description" />
                </div>
              </div>
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
            </div>
            <div class="field flex-margin">
              <div class="control">
                <button class="button is-primary" type="submit">Add Line Item</button>
              </div>
            </div>
          </form>
        </div>
        @endif

        @if(\Auth::user()->isAdmin())
        <div class="stm_imv__finalize">
          @if($invoice->status < 3) <a href="#" class="modal-open button is-danger">Send Invoice</a>
            <a class="button is-primary" href="/invoices/edit/{{ $invoice->id }}">Finalize Invoice</a>
            @else
            <a disabled class="button is-danger">Send Invoice</a>
            <a disabled class="button is-primary">Finalize Invoice</a>
            @endif
        </div>
        @endif

    </div>
  </div>

</div>

@endsection

@section('modal')

<h3 class="title">Are You Sure?</h3>

<form action="/invoice/finalize/{{ $invoice->id }}" method="POST" class="stm_imv__finalize">
  @csrf
  <div class="invoice-modal-flex">
    <div class="field">
      <label class="label" for="cc_user_1">BCC User</label>
      <div class="control">
        <div class="select">
          <select name="cc_user_1" id="cc_user_1">
            <option value="0">---</option>
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="field">
      <label class="label" for="cc_user_2">BCC Another User</label>
      <div class="control">
        <input class="input" type="email" name="cc_user_2" id="cc_user_2" placeholder="Email Address" />
      </div>
    </div>
  </div>
  <button class="button is-danger call-loader" type="submit">Send Invoice</button>
  <a href="#" class="modal-close-button button is-primary">Cancel</a>
</form>


@endsection
