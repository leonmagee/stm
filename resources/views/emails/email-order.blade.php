@component('mail::message')

# Hello {{ $admin->name }}!

<div class="date-wrap">
  {{ $date }}
</div>

<div class="note-wrap">
  A new Sims / POS order has been requested for <strong>{{ $user->company }}</strong>.
</div>

<table class="table custom">
  <tr>
    <th>Number</th>
    <th>Type</th>
  </tr>
  @foreach($sims as $carrier => $sims)
  <tr>
    <td>{{ $sims }}</td>
    <td>{{ $carrier }}</td>
  </tr>
  @endforeach
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
