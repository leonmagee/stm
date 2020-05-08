@component('mail::message')

# Hello {{ $user->name }}!

<div class="bottom-padding">
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

@include('emails.user-info',['user' => $user])

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
