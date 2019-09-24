@component('mail::message')

# Hello {{ $user->name }}!

A new sims order has been requested:<br /><br />
<strong>{{ $sims . ' ' . $carrier }} Sims</strong><br /><br />
Agent/Dealer: <strong>{{ $user->company }} - {{ $user->name }}</strong><br /><br />
Date: <strong>{{ $date }}</strong>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
