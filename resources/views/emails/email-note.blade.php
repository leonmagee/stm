@component('mail::message')

# Hello {{ $user->name }}!

A new note has been added:<br /><br />
<strong>{{ $note }}</strong><br /><br />
Agent/Dealer: <strong>{{ $agent->company }} - {{ $agent->name }}</strong><br /><br />
Author: <strong>{{ $author }}</strong><br /><br />
Date: <strong>{{ $date }}</strong>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
