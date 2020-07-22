@component('mail::message')

Hello {{ $user->name }}, thank you for your purchase!

Purchase Details:

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

<table class="table custom">
  <tr class="header-row">
    <th>Product Name</th>
    <th>Color</th>
    <th>Unit Cost</th>
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
