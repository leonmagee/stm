@component('mail::message')

# Hello {{ $user->name }}

<strong>Congratulations! Your account was created on STM. Now you can start ordering your FREE sim cards and
  POS.</strong>

## Your Login Info

<table class="table custom vertical">
  <tr>
    <th>Username</th>
    <td>{{ $user->email }}</td>
  </tr>
  <tr>
    <th>Password</th>
    <td>{{ $password }}</td>
  </tr>
  <tr>
    <th>Date Signed Up</th>
    <td>{{ $user->created_at->format('M d, Y, g:i a') }}</td>
  </tr>
</table>

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
