@component('mail::message')

@if($admin)
# Hello {{ $admin->name }}!

<div class="note-wrap">
  Credit Change for: {{ $user->company }}
</div>
<div class="note-wrap">
  {{ $note }}
</div>

@else
# Hello {{ $user->name }}!

<div class="note-wrap">
  {{ $note }}
</div>
@endif


<table class="table custom">
  <tr>
    <th>Previous Balance</th>
    <th>Transaction Amount</th>
    <th>Current Balance</th>
    <th>Date</th>
  </tr>
  <tr>
    <td>${{ number_format($previous, 2) }}</td>
    <td>{{ $difference }}</td>
    <td>${{ number_format($current, 2) }}</td>
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
