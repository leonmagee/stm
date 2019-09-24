@component('mail::message')

# Hello {{ $user->name }}!

A new sims order has been requested:<br /><br />
<strong>{{ $sims . ' ' . $carrier }} Sims</strong><br /><br />
<strong style="font-size: 1.3em">{{ $user->company }}</strong><br />
<strong>{{ $user->name }}</strong><br />
<strong>{{ $user->address }}</strong><br />
<strong>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</strong><br /><br />
Date: <strong>{{ $date }}</strong>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
