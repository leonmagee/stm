@component('mail::message')

# Hello {{ $user->name }}

<div class="margin-bottom-35">
  <strong>Congratulations! Your account has been created successfully. Now you can enjoy the full benefits of STM.
    Welcome to GS
    Wireless.</strong>
</div>

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

@include('emails.user-info',['user' => $user])

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
