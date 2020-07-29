@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Your Purchases</h3>

    <div class="stm-flex">

      @foreach($purchases as $purchase)
      <div class="stm-flex-wrap">
        <div class="stm-flex-row">
          <div class="stm-flex-row__item stm-flex-row__item--header">
            Purchase Order #
          </div>
          <div class="stm-flex-row__item stm-flex-row__item--header">
            Purchase Date
          </div>
          <div class="stm-flex-row__item stm-flex-row__item--header">
            Status
          </div>
        </div>
        <div class="stm-flex-row">
          <div class="stm-flex-row__item stm-flex-row__item--po">
            GSW-{{ $purchase->id }}
          </div>
          <div class="stm-flex-row__item">
            {{ $purchase->created_at->format('M d, Y') }}
          </div>
          <div class="stm-flex-row__item stm-flex-row__item--status-{{ $purchase->status }}">
            {{ \App\Helpers::purchase_status($purchase->status) }}
          </div>
        </div>

        <div class="stm-flex-row__item stm-flex-padding-border">
          <div class="stm-flex-row">
            <div class="stm-flex-row__item stm-flex-row__item--header stm-flex-row__item--35">
              Product Name
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              Color
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              Unit Cost
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              Quantity
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              Subtotal
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              Discount
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              Total
            </div>
            <div class="stm-flex-row__item stm-flex-row__item--header">
              RMA
            </div>
          </div>
          @foreach($purchase->products as $product)
          <div class="stm-flex-row">
            <div class="stm-flex-row__item stm-flex-row__item--35">{{ $product->name }}</div>
            <div class="stm-flex-row__item">{{ $product->variation }}</div>
            <div class="stm-flex-row__item">${{ number_format($product->unit_cost, 2) }}</div>
            <div class="stm-flex-row__item">{{ $product->quantity }}</div>
            <div class="stm-flex-row__item">${{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
            <div class="stm-flex-row__item stm-flex-row__item--red">
              {{ $product->discount ? $product->discount . '%' : '' }}</div>
            <div class="stm-flex-row__item">${{ number_format($product->final_cost, 2) }}</div>
            <div class="stm-flex-row__item">
              <a href="#" class="modal-delete-open-pending" item_id={{ $product->id }}>Submit RMA</a>
            </div>
          </div>


          <div class="modal" id="delete-item-modal-{{ $product->id }}">

            <div class="modal-background"></div>

            <div class="modal-content">

              <div class="modal-box">

                <h3 class="title">Are You Sure?</h3>

                <a href="/delete-note/{{ $product->id }}" class="button is-danger">Process RMA</a>
                <a class="modal-delete-close-button button is-primary" item_id={{ $product->id }}>Cancel</a>
              </div>

            </div>

            <button class="modal-delete-close is-large" aria-label="close" item_id={{ $product->id }}></button>

          </div>

          @endforeach
        </div>

        <div class="stm-flex-row">
          <div class="stm-flex-row__item stm-flex-row__item--header">Payment Type</div>
          <div class="stm-flex-row__item stm-flex-row__item--header">Subtotal</div>
          <div class="stm-flex-row__item stm-flex-row__item--header">Service Charge</div>
          <div class="stm-flex-row__item stm-flex-row__item--header">Total</div>
        </div>
        <div class="stm-flex-row">
          <div class="stm-flex-row__item">{{ strtoupper($purchase->type) }}</div>
          <div class="stm-flex-row__item">${{ number_format($purchase->sub_total, 2) }}</div>
          <div class="stm-flex-row__item stm-flex-row__item--red">
            ${{ number_format($purchase->sub_total * 2 / 100, 2) }}</div>
          <div class="stm-flex-row__item stm-flex-row__item--bold">${{ number_format($purchase->total, 2) }}</div>
        </div>






      </div>
      @endforeach
    </div>

  </div>
</div>

@endsection
