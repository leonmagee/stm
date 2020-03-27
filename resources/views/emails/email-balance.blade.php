@component('mail::message')

# Hello {{ $user->name }}!

Your STM Balance has been udpated:<br /><br />
Previous Balance: <strong>{{ $previous }}</strong><br /><br />
Transaction Amount: <strong>{{ $difference }}</strong><br /><br />
Current Balance: <strong>{{ $current }}</strong><br /><br />
<strong>{{ $note }}</strong><br /><br />
Date: <strong>{{ $date }}</strong>



<strong>{{ $user->name }}</strong><br />
<strong>{{ $user->address }}</strong><br />
<strong>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</strong><br />
<span style="color: #1b9aaa">{{ $user->email }}</span><br />
<strong>{{ $user->phone }}</strong><br /><br />


@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
