@component('mail::message')

Hello {{ $user->name }}, thank you for your purchase!

<div class="invoice-wrap">

  <div class="invoice-wrap__header">
    @include('layouts.stm-address')
    <div class="invoice-title">
      <span>Purchase Order</span>
    </div>
  </div>

  <div class="invoice-wrap__details">
    <div class="address-block">
      <div class="top">Purchase By:</div>
      <div>{{ $user->name }}</div>
      <div>{{ $user->company }}</div>
      <div>{{ $user->address }}</div>
      <div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
    </div>
    <div class="invoice-number-wrap">
      <div><span>Purchase Order #</span>{{ $invoice->id }}</div>
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
        <div class="label">Total Discount</div>
        <div>-${{ number_format($discount, 2) }}</div>
      </div>
      <div class="item final">
        <div class="label">Balance Due</div>
        <div>${{ number_format(($total), 2) }}</div>
      </div>
    </div>
  </div>
</div>

<div class="bottom-thanks">
  <div>Thank you for your business.</div>
  <div>Sincerely,</div>
  <div class="margin-top">GS Wireless, Inc.</div>
</div>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

@endcomponent








<div class="purchase-email">
  <div class="purchase-email__table margin-bottom-15">
    <table class="table custom">
      <tr class="header-row">
        <th>Product Name</th>
        <th>Color</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Discount</th>
        <th>Item Total</th>
      </tr>
      @foreach($purchase->products as $product)
      <tr class="item">
        <td class="">{{ $product->name }}</td>
        <td class="">{{ $product->variation }}</td>
        <td class="">${{ number_format($product->unit_cost, 2) }}</td>
        <td class="">{{ $product->quantity }}</td>
        <td class="">{{ number_format($product->unit_cost * $product->quantity, 2) }}</td>
        <td class="">{{ $product->discount ? $product->discount . '%' : '' }}</td>
        <td class="">${{ number_format($product->final_cost, 2) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
  <div class="purchase-email__table margin-bottom-15">
    <table class="table custom">
      <tr class="header-row">
        <th>Purchase Order #</th>
        {{-- <th>Company</th>
    <th>Name</th> --}}
        @if($purchase->type == 'paypal')
        <th>Subtotal</th>
        <th>Service Charge</th>
        @endif
        <th>Total</th>
        <th>Payment Type</th>
        <th>Purchase Date</th>
      </tr>
      <tr class="item">
        <td class="">GSW-{{ $purchase->id }}</td>
        {{-- <td class="">{{ $purchase->user->company }}</td>
        <td class="">{{ $purchase->user->name }}</td> --}}
        @if($purchase->type == 'paypal')
        <td class="">${{ number_format($purchase->sub_total, 2) }}</td>
        <td class="">${{ number_format($purchase->sub_total * 2 / 100, 2) }}</td>
        @endif
        <td class="">${{ number_format($purchase->total, 2) }}</td>
        <td class="">{{ $purchase->type }}</td>
        <td class="">{{ $purchase->created_at->format('m/d/Y') }}</td>
      </tr>
    </table>
  </div>
</div>

<div class="bottom-thanks">
  <div>Thank you for your business.</div>
  <div>Sincerely,</div>
  <div class="margin-top">GS Wireless, Inc.</div>
</div>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

{{-- Thanks,<br>
{{ config('app.name') }} --}}
@endcomponent
