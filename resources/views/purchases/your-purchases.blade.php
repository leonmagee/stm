@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Your Purchases</h3>

    <div class="stm-flex">

      @if(count($purchases))
      @foreach($purchases as $purchase)
      <div class="stm-flex-wrap">
        <div class="stm-flex-row">
          <div class="stm-flex-row__item header">Purchase Order #</div>
          <div class="stm-flex-row__item header">Purchase Date</div>
          <div class="stm-flex-row__item header">Status</div>
        </div>
        <div class="stm-flex-row">
          <div class="stm-flex-row__item bold primary">GSW-{{ $purchase->id }}</div>
          <div class="stm-flex-row__item">{{ $purchase->created_at->format('M d, Y') }}</div>
          <div class="stm-flex-row__item status-{{ $purchase->status }}">
            {{ \App\Helpers::purchase_status($purchase->status) }}
          </div>
        </div>

        <div class="stm-flex-row separator">
          <div class="stm-flex-row__item header flex-30">Product Name</div>
          <div class="stm-flex-row__item header">Color</div>
          <div class="stm-flex-row__item header flex-15">IMEIs</div>
          <div class="stm-flex-row__item header">Price</div>
          <div class="stm-flex-row__item header">Quantity</div>
          <div class="stm-flex-row__item header">Subtotal</div>
          <div class="stm-flex-row__item header">Discount</div>
          <div class="stm-flex-row__item header">Total</div>
          <div class="stm-flex-row__item header flex-15">RMA (60 day limit)</div>
        </div>
        @foreach($purchase->products as $product)
        <div class="stm-flex-row">
          <div class="stm-flex-row__item flex-30">{{ $product->name }}</div>
          <div class="stm-flex-row__item">{{ $product->variation }}</div>
          <div class="stm-flex-row__item flex-15">
            @foreach($product->imeis as $imei)
            <div>{{ $imei->imei }}</div>
            @endforeach
          </div>
          <div class="stm-flex-row__item">${{ number_format($product->unit_cost, 2) }}</div>
          <div class="stm-flex-row__item">{{ $product->quantity }}</div>
          <div class="stm-flex-row__item">${{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
          <div class="stm-flex-row__item red">
            {{ $product->discount ? $product->discount . '%' : '' }}</div>
          <div class="stm-flex-row__item">${{ number_format($product->final_cost, 2) }}</div>
          <div class="stm-flex-row__item bold flex-15">
            @if($purchase->created_at->diff(\Carbon\Carbon::now())->days < 60) <a href="#" class="modal-delete-open"
              item_id={{ $product->id }}>SUBMIT RMA</a>
              @else
              N/A
              @endif
          </div>
        </div>

        <div class="modal" id="delete-item-modal-{{ $product->id }}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <form method="POST" action="rma-new">
              @csrf
              <div class="modal-box">
                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}" />
                <input type="hidden" name="purchase_product_id" value="{{ $product->id }}" />
                <h4 class="title">Submit RMA Request</h4>
                <div class="stm-flex">
                  <div class="stm-flex-row">
                    <div class="stm-flex-row__item header flex-50">Product Name</div>
                    <div class="stm-flex-row__item header">Color</div>
                    <div class="stm-flex-row__item header">Quantity</div>
                  </div>
                  <div class="stm-flex-row">
                    <div class="stm-flex-row__item flex-50">{{ $product->name }}</div>
                    <div class="stm-flex-row__item">{{ $product->variation }}</div>
                    <div class="stm-flex-row__item">{{ $product->quantity }}</div>
                  </div>
                  <div class="field margin-top-2">
                    <label class="label">Quantity to Return</label>
                    <input name="quantity" class="input" min="0" max="{{ $product->quantity }}" type="number"
                      placeholder="quantity" value=1 required>
                  </div>
                  <div class="field">
                    <label class="label">Reason for Return</label>
                    <textarea name="explanation" class="textarea" required></textarea>
                  </div>
                </div>
                <button type="submit" class="button is-danger call-loader">Submit RMA</button>
                <a class="modal-delete-close-button button is-primary" item_id={{ $product->id }}>Cancel</a>
              </div>
            </form>
          </div>
          <button class="modal-delete-close is-large" aria-label="close" item_id={{ $product->id }}></button>
        </div>
        @endforeach

        <div class="stm-flex-row separator">
          <div class="stm-flex-row__item header">Payment Type</div>
          <div class="stm-flex-row__item header">Subtotal</div>
          <div class="stm-flex-row__item header">Service Charge</div>
          <div class="stm-flex-row__item header">Total</div>
        </div>
        <div class="stm-flex-row">
          <div class="stm-flex-row__item">{{ strtoupper($purchase->type) }}</div>
          <div class="stm-flex-row__item">${{ number_format($purchase->sub_total, 2) }}</div>
          <div class="stm-flex-row__item red">
            @if(strtoupper($purchase->type) == 'PAYPAL')
            ${{ number_format($purchase->sub_total * 2 / 100, 2) }}
            @else
            $0.00
            @endif
          </div>
          <div class="stm-flex-row__item bold">${{ number_format($purchase->total, 2) }}</div>
        </div>
      </div>
      @endforeach
      @else
      <div class="no-rmas-purchases">No purchases have been completed yet.</div>
      @endif
    </div>
  </div>
</div>

@endsection
