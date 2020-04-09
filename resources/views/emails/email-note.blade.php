@component('mail::message')

# Hello {{ $user->name }}!

<div>
  A new note has been added:
</div>
<div class="note-wrap">
  {{ $note }}
</div>

<table class="table custom">
  <tr>
    <th>Author</th>
    <th>Agent / Dealer</th>
    <th>Date</th>
  </tr>
  <tr>
    <td>{{ $author }}</td>
    <td>{{ $agent->company }}</td>
    <td>{{ $date }}</td>
  </tr>
</table>

<div class="customer-info">
  <div>{{ $agent->company . ' / ' . $agent->name }}</div>
  <div>{{ $agent->address }}</div>
  <div>{{ $agent->city }}, {{ $agent->state }} {{ $agent->zip }}</div>
  <div class="email">{{ $agent->email }}</div>
  <div>{{ $agent->phone }}</div>
</div>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
