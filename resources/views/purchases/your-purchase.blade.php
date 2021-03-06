@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Purchase Order</h3>

    <div class="sales-receipt">
      <div class="invoice-wrap">
        <div class="invoice-wrap__header">
          @include('layouts.stm-address')
          <div class="invoice-title">
            <span>Sales Receipt</span>
          </div>
        </div>

        <div class="invoice-wrap__details">
          <div class="address-block">
            <div class="top">Ship To:</div>
            <div>{{ $purchase->user->name }}</div>
            <div>{{ $purchase->user->company }}</div>
            <div>{{ $purchase->user->address }}</div>
            <div>{{ $purchase->user->city }}, {{ $purchase->user->state }} {{ $purchase->user->zip }}</div>
          </div>

          <div class="invoice-number-wrap">
            <div><span>Purchase Order #:</span>GSW-{{ $purchase->id }}</div>
            <div><span>Payment Type:</span>{{ $purchase->type }}</div>
            <div><span>Purchase Date:</span>{{ $purchase->created_at->format('m/d/Y') }}</div>
          </div>
        </div>

        <div class="invoice-wrap__middle">
          <table class="table custom small-font">
            <tr class="header-row">
              <th class="name-column">Product Name</th>
              <th>Color</th>
              @if($show_imei)
              <th class="imei-column">IMEI/Serial Number</th>
              @endif
              <th>Unit Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Discount</th>
              <th>Item Total</th>
            </tr>
            @foreach($purchase->products as $product)
            <tr class="item-{{ $product->id }}">
              <td class="name-column">{{ $product->name }}</td>
              <td class="item">{{ $product->variation }}</td>
              @if($show_imei)
              <td class="imei-column">
                @foreach($product->imeis as $imei)
                <div>{{ $imei->imei }}</div>
                @endforeach
              </td>
              @endif
              <td class="item">${{ number_format($product->unit_cost, 2) }}</td>
              <td class="item">{{ $product->quantity }}</td>
              <td class="item">{{ number_format($product->unit_cost * $product->quantity, 2) }}</td>
              <td class="item">{{ $product->discount ? $product->discount . '%' : '' }}</td>
              <td class="item">${{ number_format($product->final_cost, 2) }}</td>
            </tr>
            @endforeach
          </table>

        </div>{{-- invoice-wrap__middle --}}

        <div class="invoice-wrap__footer">
          <div class="invoice-wrap__footer--note">
            Tracking Numbers:
            @foreach($purchase->tracking_numbers as $tracking_number)
            <div>
              <strong>{{ $tracking_number->tracking_number }}</strong> -
              <strong>{{ $tracking_number->shipping_type }}</strong>
            </div>
            @endforeach
          </div>
          <div class="invoice-wrap__footer--totals">
            <div class="item">
              <div class="label">Subtotal</div>
              <div>${{ number_format($purchase->sub_total, 2) }}</div>
            </div>
            <div class="item discount">
              <div class="label">Service Charge</div>
              @if(strtoupper($purchase->type) == 'PAYPAL')
              <div>${{ number_format($purchase->sub_total * 2 / 100, 2) }}</div>
              @else
              <div>$0.00</div>
              @endif
            </div>
            @if($purchase->coupon_percent)
            <div class="item">
              <div class="label">Coupon Percent</div>
              <div>
                {{ \App\Helpers::percent_na($purchase->coupon_percent) }}
              </div>
            </div>
            <div class="item">
              <div class="label">Coupon</div>
              <div>
                {{ \App\Helpers::number_format_na($purchase->discount, '-') }}
              </div>
            </div>
            @endif
            @if($purchase->shipping)
            <div class="item discount">
              <div class="label">Shipping Charge</div>
              <div>
                {{ \App\Helpers::number_format_na($purchase->shipping) }}
              </div>
            </div>
            @endif
            @if($purchase->store_credit)
            <div class="item">
              <div class="label">Store Credit</div>
              <div>
                {{ \App\Helpers::number_format_na($purchase->store_credit, '-') }}
              </div>
            </div>
            @endif
            <div class="item final">
              <div class="label">Total</div>
              <div>${{ number_format($purchase->total, 2) }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

@endsection
