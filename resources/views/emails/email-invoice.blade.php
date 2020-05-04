@component('mail::message')

Hello {{ $user->name }}, pleae remit the following invoice. Thank You!

<div class="invoice-wrap">

  <div class="invoice-wrap__header">
    <div class="address-block">
      <div>GS Wireless, Inc.</div>
      <div>750 B Street Suite 2840</div>
      <div>San Diego, CA 92101</div>
      <div>619-795-9200</div>
    </div>
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
        <th>Description</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Cost</th>
      </tr>
      @foreach($invoice->items as $item)
      <tr class="item-{{ $item->item }}">
        <td>{{ \App\Helpers::invoice_item($item->item) }}</td>
        <td>{{ $item->description }}</td>
        <td>${{ number_format($item->cost, 2) }}</td>
        <td>{{ $item->quantity }}</td>
        <td>@if($item->item ==
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
        <div>Subtotal</div>
        <div>${{ number_format($subtotal, 2) }}</div>
      </div>
      <div class="item discount">
        <div>Discount</div>
        <div>-${{ number_format($discount, 2) }}</div>
      </div>
      <div class="item final">
        <div>Balance Due</div>
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
{{-- <div>750 B Street Suite 2840</div>
<div>San Diego, CA 92101</div>
<div>619-795-9200</div>
<div><a href="http://mygswireless.com">http://mygswireless.com</a></div>
<div><a href="http://mygsaccessories.com">http://mygsaccessories.com</a></div> --}}

{{-- <div class="customer-info">
  <div>{{ $user->company . ' / ' . $user->name }}</div>
<div>{{ $user->address }}</div>
<div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
<div class="email">{{ $user->email }}</div>
<div>{{ $user->phone }}</div>
</div> --}}

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

{{-- Thanks,<br>
{{ config('app.name') }} --}}
@endcomponent
