@component('mail::message')

# Hello {{ $user->name }}

<div class="margin-bottom-35">
  <strong>Your account details have been updated. If the new information is not correct please contact us
    immediately.</strong>
</div>

## Information Changes

<table class="table custom small-font">
  <tr>
    <th></th>
    <th>Name</th>
    <th>Email</th>
    <th>Company</th>
    <th>Phone</th>
    <th>Address</th>
    <th>City</th>
    <th>State</th>
    <th>Zip</th>
  </tr>
  <tr>
    <th>Old</th>
    <th>{{ $old_user->name }}</th>
    <th>{{ $old_user->email }}</th>
    <th>{{ $old_user->company }}</th>
    <th>{{ $old_user->phone }}</th>
    <th>{{ $old_user->address }}</th>
    <th>{{ $old_user->city }}</th>
    <th>{{ $old_user->state }}</th>
    <th>{{ $old_user->zip }}</th>
  </tr>
  <tr>
    <th>New</th>
    <th>{{ $user->name }}</th>
    <th>{{ $user->email }}</th>
    <th>{{ $user->company }}</th>
    <th>{{ $user->phone }}</th>
    <th>{{ $user->address }}</th>
    <th>{{ $user->city }}</th>
    <th>{{ $user->state }}</th>
    <th>{{ $user->zip }}</th>
  </tr>
</table>

@include('emails.user-info',['user' => $user])

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
