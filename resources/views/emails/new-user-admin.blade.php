@component('mail::message')

# Hello {{ $recipient->name }}

A new user has been added to STM.

<table class="table custom">
  <tr>
    <th>Created By</th>
    <th>Agent / Dealer</th>
    <th>Date Signed Up</th>
  </tr>
  <tr>
    <td>{{ $author->name }}</td>
    <td>{{ $user->company }}</td>
    <td>{{ $user->created_at->format('M d, Y') }}</td>
  </tr>
</table>

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
