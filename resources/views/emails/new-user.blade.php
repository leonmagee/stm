@component('mail::message')

# Hello {{ $user->name }}

You are now signed up to Sim Track Manager!

## Your Login Info

<table class="table custom">
  <tr>
    <th>Username</th>
    <th>Password</th>
  </tr>
  <tr>
    <td>{{ $user->email }}</td>
    <td>{{ $password }}</td>
  </tr>
</table>

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
