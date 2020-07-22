@component('mail::message')

Hello {{ $user->name }}, thank you for your purchase!




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
      <span>Purchase</span>
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
      <tr class="item">
        <td class="item">sdfl</td>
        <td class="desc-column">sdf</td>
        <td class="cost">sdfs</td>
        <td class="misc">sdf</td>
        <td class="total">dlfjd</td>
      </tr>
    </table>

  </div>{{-- invoice-wrap__middle --}}

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
