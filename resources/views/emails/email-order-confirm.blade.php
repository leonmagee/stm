@component('mail::message')

# Hello {{ $user->name }}!

Your Sims / POS order has been processed:<br /><br />
@foreach($sims as $carrier => $sims)
<strong>{{ $sims . ' ' . $carrier }}</strong><br />
@endforeach
<br />
Thank You!
<br /><br />
Date: <strong>{{ $date }}</strong>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
