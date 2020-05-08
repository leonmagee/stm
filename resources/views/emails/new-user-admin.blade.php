@component('mail::message')

# Hello {{ $recipient->name }}

<strong>A new user has been added to STM.</strong>

<table class="table custom vertical">
  <tr>
    <th>Created By</th>
    <td>{{ $author->name }}</td>
  </tr>
  <tr>
    <th>{{ $user->role->name }}</th>
    <td>{{ $user->company }}</td>
  </tr>
  <tr>
    <th>Date Signed Up</th>
    <td>{{ $user->created_at->format('M d, Y, g:i a') }}</td>
  </tr>
</table>

@include('emails.user-info',['user' => $user])

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
