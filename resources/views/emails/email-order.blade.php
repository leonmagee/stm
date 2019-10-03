@component('mail::message')

# Hello {{ $admin->name }}!

A new sims order has been requested:<br /><br />
@foreach($sims as $carrier => $sims)
<strong>{{ $sims . ' ' . $carrier }} Sims</strong><br />
@endforeach
<br />
<strong style="font-size: 1.3em">{{ $user->company }}</strong><br />
<strong>{{ $user->name }}</strong><br />
<strong>{{ $user->address }}</strong><br />
<strong>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</strong><br />
<span style="color: #1b9aaa">{{ $user->email }}</span><br />
<strong>{{ $user->phone }}</strong><br /><br />

Date: <strong>{{ $date }}</strong>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
