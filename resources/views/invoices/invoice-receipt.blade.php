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
            <span>Invoice</span>
          </div>
        </div>

        <div class="invoice-wrap__details">
          <div class="address-block">
            <div class="top">Bill To:</div>
            <div>{{ $user->name }}</div>
            <div>{{ $user->company }}</div>
            <div>{{ $user->address }}</div>
            <div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
          </div>
          <div class="invoice-number-wrap">
            <div><span>Invoice #</span>{{ $invoice->id }}</div>
            <div><span>Invoice Date:</span>{{ $invoice->created_at->format('M d, Y') }}</div>
            <div><span>Due Date:</span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
          </div>
        </div>
        <div class="invoice-wrap__middle">
          <table class="table custom">
            <tr class="header-row">
              <th>Item</th>
              <th class="desc-column">Description</th>
              <th>Unit Price</th>
              <th>Quantity</th>
              <th>Cost</th>
            </tr>
            @foreach($invoice->items as $item)
            <tr class="item-{{ $item->item }}">
              <td class="item">{{ \App\Helpers::invoice_item($item->item) }}</td>
              <td class="desc-column">{{ $item->description }}</td>
              <td class="cost">${{ number_format($item->cost, 2) }}</td>
              <td>{{ $item->quantity }}</td>
              <td class="total">@if($item->item ==
                3)-@endif${{ number_format(($item->cost * $item->quantity), 2) }}</td>
            </tr>
            @endforeach
          </table>

        </div>{{-- invoice-wrap__middle --}}

        <div class="invoice-wrap__footer">
          <div class="invoice-wrap__footer--note">
            {{ $invoice->message }}
          </div>
          <div class="invoice-wrap__footer--totals">
            <div class="item">
              <div class="label">Subtotal</div>
              <div>${{ number_format($subtotal, 2) }}</div>
            </div>
            <div class="item discount">
              <div class="label">Total Payment</div>
              <div>-${{ number_format($discount, 2) }}</div>
            </div>
            <div class="item final">
              <div class="label">Balance Due</div>
              <div>${{ number_format(($total), 2) }}</div>
            </div>
          </div>
        </div>
      </div>






    </div>

  </div>

</div>

@endsection
