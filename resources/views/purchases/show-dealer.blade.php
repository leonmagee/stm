@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Purchase Order</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Purchase Order #</div>
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">Name</div>
          <div class="stm_inv__header--label">Purchase Date</div>
          <div class="stm_inv__header--label">Status</div>
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item purchase-id"><a
              href="/purchase-order/{{ $purchase->id }}">GSW-{{ $purchase->id }}</a></div>
          <div class="stm_inv__header--item">{{ $purchase->user->company }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->name }}</div>
          <div class="stm_inv__header--item">{{ $purchase->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $purchase->status }}">
            {{ \App\Helpers::purchase_status($purchase->status) }}
          </div>
        </div>
      </div>

      <div class="stm_inv__items">
        <div class="stm_inv__flex">
          <div class="stm_inv__item--label stm_inv__flex--60">Product Name</div>
          <div class="stm_inv__item--label stm_inv__flex--28">IMEI / Serial Number</div>
          <div class="stm_inv__item--label">Color</div>
          <div class="stm_inv__item--label">Price</div>
          <div class="stm_inv__item--label">Quantity</div>
          <div class="stm_inv__item--label">Subtotal</div>
          <div class="stm_inv__item--label">Discount</div>
          <div class="stm_inv__item--label">Total</div>
        </div>

        @foreach($purchase->products as $product)
        <div class="stm_inv__flex stm_inv__flex-{{ $product->id }}">
          <div class="stm_inv__item--item stm_inv__flex--60">{{ $product->name }}</div>
          <div class="stm_inv__item--item stm_inv__flex--28">
            @foreach($product->imeis as $imei)
            <div class="imei-row">
              {{ $imei->imei }}
            </div>
            @endforeach
          </div>
          <div class="stm_inv__item--item">{{ $product->variation }}</div>
          <div class="stm_inv__item--item ">${{ number_format($product->unit_cost, 2) }}</div>
          <div class="stm_inv__item--item">{{ $product->quantity }}</div>
          <div class="stm_inv__item--item">${{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
          <div class="stm_inv__item--item">{{ $product->discount ? $product->discount . '%' : '' }}</div>
          <div class="stm_inv__item--item">${{ number_format($product->final_cost, 2) }}</div>
        </div>
        @endforeach
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Payment Type</div>
          <div class="stm_inv__header--label">Subtotal</div>
          <div class="stm_inv__header--label">Service Charge</div>
          <div class="stm_inv__header--label">Shipping Charge</div>
          <div class="stm_inv__header--label">Total</div>
          <div class="stm_inv__header--label stm_inv__flex--4"></div>
        </div>
        <div class="stm_inv__flex">
          <?php $type = strtoupper($purchase->type); ?>
          <div class="stm_inv__header--item">{{ $type }}</div>
          <div class="stm_inv__header--item">${{ number_format($purchase->sub_total, 2) }}</div>
          <div class="stm_inv__header--item">
            @if($type == 'PAYPAL')
            ${{ number_format($purchase->sub_total * 2 / 100, 2) }}
            @else
            $0.00
            @endif
          </div>
          <div class="stm_inv__header--item">${{ number_format($purchase->shipping, 2) }}</div>
          <div class="stm_inv__header--item">${{ number_format($purchase->total, 2) }}</div>
          <div class="stm_inv__header--item stm_inv__flex--4 strong blue"><a
              href="/purchase-order/{{ $purchase->id }}"><i class="fas fa-eye"></i></a></div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label stm_inv__flex--30">Shipping Address</div>
          <div class="stm_inv__header--label">City</div>
          <div class="stm_inv__header--label">State</div>
          <div class="stm_inv__header--label">Zip</div>
          <div class="stm_inv__header--label stm_inv__flex--25">Tracking Numbers</div>
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item stm_inv__flex--30">{{ $purchase->user->address  }}
          </div>
          <div class="stm_inv__header--item">{{ $purchase->user->city }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->state }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->zip }}</div>
          <div class="stm_inv__header--item stm_inv__flex--25">
            @foreach($purchase->tracking_numbers as $tracking_number)
            <div class="imei-row">
              {{ $tracking_number->tracking_number . ' - ' . $tracking_number->shipping_type }}
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
