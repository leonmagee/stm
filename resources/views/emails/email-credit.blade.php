@component('mail::message')

@if($admin)
# Hello {{ $admin->name }}!

<div class="note-wrap">
  {{ $user->company }} has requested a credit cash out transfer to:
</div>
@else
# Hello {{ $user->name }}!

<div class="note-wrap">
  Thank you, your credit transfer request will be processed soon.
</div>
@endif

<table class="table custom">
  <tr>
    <th>Transfer Type</th>
    <th>Account ID</th>
    <th>Credit Amount</th>
    <th>Date</th>
  </tr>
  <tr>
    <td>{{ $type }}</td>
    <td>{{ $account_id }}</td>
    <td>${{ number_format($credit, 2) }}</td>
    <td>{{ $date }}</td>
  </tr>
</table>

<div class="customer-info">
  <div>{{ $user->company . ' / ' . $user->name }}</div>
  <div>{{ $user->address }}</div>
  <div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
  <div class="email">{{ $user->email }}</div>
  <div>{{ $user->phone }}</div>
</div>


@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
