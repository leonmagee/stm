@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>RMA</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">RMA #</div>
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">Name</div>
          <div class="stm_inv__header--label">Product</div>
          <div class="stm_inv__header--label">Color</div>
          <div class="stm_inv__header--label">Quantity</div>
          <div class="stm_inv__header--label">RMA Date</div>
          <div class="stm_inv__header--label">Purchase Order</div>
          <div class="stm_inv__header--label">Status</div>
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">RMA-GSW-{{ $rma->id }}</div>
          <div class="stm_inv__header--item">{{ $rma->user->company }}</div>
          <div class="stm_inv__header--item">{{ $rma->user->name }}</div>
          <div class="stm_inv__header--item">{{ $rma->product->name }}</div>
          <div class="stm_inv__header--item">{{ $rma->product->variation }}</div>
          <div class="stm_inv__header--item">{{ $rma->quantity }}</div>
          <div class="stm_inv__header--item">{{ $rma->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item"><a href="/purchases/{{ $rma->product->purchase_id }}">View</a></div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $rma->status }}">
            {{ \App\Helpers::rma_status($rma->status) }}
          </div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Reason for Return</div>
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $rma->explanation }}</div>
        </div>
      </div>


      {{-- <div class="stm_inv__items">
        <div class="stm_inv__flex">
          <div class="stm_inv__item--label stm_inv__flex--60">Product Name</div>
          <div class="stm_inv__item--label">Color</div>
          <div class="stm_inv__item--label">Unit Cost</div>
          <div class="stm_inv__item--label">Quantity</div>
          <div class="stm_inv__item--label">Subtotal</div>
          <div class="stm_inv__item--label">Discount</div>
          <div class="stm_inv__item--label">Item Total</div>
        </div>

        @foreach($rma->products as $product)
        <div class="stm_inv__flex stm_inv__flex-{{ $product->id }}">
      <div class="stm_inv__item--item stm_inv__flex--60">{{ $product->name }}</div>
      <div class="stm_inv__item--item">{{ $product->variation }}</div>
      <div class="stm_inv__item--item ">${{ number_format($product->unit_cost, 2) }}</div>
      <div class="stm_inv__item--item">{{ $product->quantity }}</div>
      <div class="stm_inv__item--item">${{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
      <div class="stm_inv__item--item">{{ $product->discount ? $product->discount . '%' : '' }}</div>
      <div class="stm_inv__item--item">${{ number_format($product->final_cost, 2) }}</div>
    </div>
    @endforeach
  </div> --}}

  {{-- <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Payment Type</div>
          <div class="stm_inv__header--label">Subtotal</div>
          <div class="stm_inv__header--label">Service Charge</div>
          <div class="stm_inv__header--label">Total</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ strtoupper($rma->type) }}
</div>
<div class="stm_inv__header--item">${{ number_format($rma->sub_total, 2) }}</div>
<div class="stm_inv__header--item stm_inv__header--item-red">
  ${{ number_format($rma->sub_total * 2 / 100, 2) }}</div>
<div class="stm_inv__header--item">${{ number_format($rma->total, 2) }}</div>
</div>
</div> --}}

{{-- <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label stm_inv__flex--30">Shipping Address</div>
          <div class="stm_inv__header--label">City</div>
          <div class="stm_inv__header--label">State</div>
          <div class="stm_inv__header--label">Zip</div>
          <div class="stm_inv__header--label">Tracking Number</div>
          <div class="stm_inv__header--label">Shipping Service</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item stm_inv__flex--30">{{ $rma->user->address  }}
</div>
<div class="stm_inv__header--item">{{ $rma->user->city }}</div>
<div class="stm_inv__header--item">{{ $rma->user->state }}</div>
<div class="stm_inv__header--item">{{ $rma->user->zip }}</div>
<div class="stm_inv__header--item">{{ $rma->tracking_number }}</div>
<div class="stm_inv__header--item">{{ $rma->shipping_type }}</div>
</div>
</div> --}}

<div class="stm_inv__flex--forms">

  <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-status">
    <form method="POST" action="/update-rma-status/{{ $rma->id }}">
      @csrf
      <div class="stm_inv__forms-no-flex">
        <input type="hidden" name="purchase_id" value="{{ $rma->id }}" />
        <div class="field">
          <label class="label" for="status">Approve or Reject RMA</label>
          <div class="select">
            <select name="status" id="status">
              <option value="2" @if($rma->status == 2) selected @endif>Pending</option>
              <option value="3" @if($rma->status == 3) selected @endif>Approved</option>
              <option value="4" @if($rma->status == 4) selected @endif>Rejected</option>
            </select>
          </div>
        </div>
        <div class="field flex-margin margin-top-1">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Update</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-status">
    <form method="POST" action="/update-rma-status/{{ $rma->id }}">
      @csrf
      <div class="stm_inv__forms-no-flex">
        <input type="hidden" name="purchase_id" value="{{ $rma->id }}" />
        <div class="field">
          <label class="label" for="status">Update Status</label>
          <div class="select">
            <select name="status" id="status">
              <option value="2" @if($rma->status == 2) selected @endif>Pending</option>
              <option value="3" @if($rma->status == 3) selected @endif>Approved</option>
              <option value="4" @if($rma->status == 4) selected @endif>Rejected</option>
            </select>
          </div>
        </div>
        <div class="field flex-margin margin-top-1">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Update</button>
          </div>
        </div>
      </div>
    </form>
  </div>


</div>


</div>
</div>

</div>

@endsection
