@component('mail::message')

{!! $header_text !!}

<div class="invoice-wrap">
  <div class="invoice-wrap__header">
    <div class="address-block">
      <div>GS Wireless, Inc.</div>
      <div>100 Park Plaza, #3301</div>
      <div>San Diego, CA 92101</div>
      <div>gs-wireless@att.net</div>
      <div>619-795-9200</div>
    </div>
    <div class="invoice-title">
      <span>Sales Receipt</span>
    </div>
  </div>

  <div class="invoice-wrap__details">
    <div class="address-block">
      <div class="top">Ship To:</div>
      <div>{{ $user->name }}</div>
      <div>{{ $user->company }}</div>
      <div>{{ $user->address }}</div>
      <div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
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
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Discount</th>
        <th>Item Total</th>
      </tr>
      @foreach($purchase->products as $product)
      <tr class="item-{{ $product->id }}">
        <td class="name-column">{{ $product->name }}</td>
        <td class="item">{{ $product->variation }}</td>
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
      {{-- note --}}
    </div>
    <div class="invoice-wrap__footer--totals">
      @if($purchase->type == 'paypal')
      <div class="item">
        <div class="label">Subtotal</div>
        <div>${{ number_format($purchase->sub_total, 2) }}</div>
      </div>
      <div class="item discount">
        <div class="label">Service Charge</div>
        <div>${{ number_format($purchase->sub_total * 2 / 100, 2) }}</div>
      </div>
      @endif
      <div class="item final">
        <div class="label">Total</div>
        <div>${{ number_format($purchase->total, 2) }}</div>
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
