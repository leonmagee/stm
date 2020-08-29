@component('mail::message')

{!! $header_text !!}

@if(count($rma->notes))
<div class="margin-bottom-25">
  @foreach($rma->notes as $note)
  <div class="note">{{ $note->text }}</div>
  @endforeach
</div>
@endif

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
      <span>RMA</span>
    </div>
  </div>

  <div class="invoice-wrap__details">
    <div class="address-block">
      <div class="top">Customer Address:</div>
      <div>{{ $user->name }}</div>
      <div>{{ $user->company }}</div>
      <div>{{ $user->address }}</div>
      <div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
    </div>

    <div class="invoice-number-wrap">
      <div><span>RMA #:</span>RMA-GSW-{{ $rma->id }}</div>
      <div><span>Purchase Order #:</span>GSW-{{ $purchase->id }}</div>
      <div><span>Payment Type:</span>{{ $purchase->type }}</div>
      <div><span>Purchase Date:</span>{{ $purchase->created_at->format('m/d/Y') }}</div>
    </div>
  </div>

  <div class="invoice-wrap__middle">
    <?php $return_total = '$' . number_format((($rma->product->unit_cost * $rma->quantity) * ((100 - $rma->product->discount) / 100)), 2); ?>
    <table class="table custom small-font">
      <tr class="header-row">
        <th class="name-column">Product Name</th>
        <th>Color</th>
        @if($imeis)
        <th class="imei-column">IMEI/Serial Number</th>
        @endif
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Discount</th>
        <th>Item Total</th>
      </tr>
      <tr>
        <td class="name-column">{{ $rma->product->name }}</td>
        <td class="item">{{ $rma->product->variation }}</td>
        @if($imeis)
        <td class="imei-column">
          @foreach($imeis as $imei)
          <div>{{ $imei }}</div>
          @endforeach
        </td>
        @endif
        <td class="item">${{ number_format($rma->product->unit_cost, 2) }}</td>
        <td class="item">{{ $rma->quantity }}</td>
        <td class="item">{{ number_format($rma->product->unit_cost * $rma->quantity, 2) }}</td>
        <td class="item">{{ $rma->product->discount ? $rma->product->discount . '%' : '' }}</td>
        <td class="item">{{ $return_total }}</td>
      </tr>
    </table>

  </div>{{-- invoice-wrap__middle --}}

  <div class="invoice-wrap__footer">
    <div class="invoice-wrap__footer--rma">
      <h4>Reason for Return</h4>
      <div>{{ $rma->explanation }}</div>
    </div>
    <div class="invoice-wrap__footer--totals">
      <div class="item">
        <div class="label">Subtotal</div>
        <div>{{ $return_total }}</div>
      </div>
      <div class="item">
        <div class="label">Service Charge</div>
        <div>N/A</div>
      </div>
      <div class="item final">
        <div class="label">Total</div>
        <div>{{ $return_total }}</div>
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
