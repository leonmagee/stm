@component('mail::message')

# Hello {{ $admin->name }}!

<div class="date-wrap">
  {{ $date }}
</div>

<div class="note-wrap">
  Sims Order Placed: <strong>{{ $user->company }}</strong>.
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

@include('emails.user-info',['user' => $user])

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
