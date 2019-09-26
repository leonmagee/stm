@component('mail::message')

# Hello {{ $user->name }}!

A new note has been added:<br /><br />
<strong>{{ $note }}</strong><br /><br />
<strong style="font-size: 1.3em">{{ $agent->company }}</strong><br />
<strong>{{ $agent->name }}</strong><br />
<strong>{{ $agent->address }}</strong><br />
<strong>{{ $agent->city }}, {{ $agent->state }} {{ $agent->zip }}</strong><br /><br />

Author: <strong>{{ $author }}</strong><br /><br />
Date: <strong>{{ $date }}</strong>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
