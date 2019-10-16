@component('mail::message')

# Hello {{ $admin->name }}!

STM Contact form submission.

<strong style="font-size: 1.3em">{{ $user->company }}</strong><br />
<strong>{{ $user->name }}</strong><br />
<strong>{{ $user->address }}</strong><br />
<strong>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</strong><br />
<span style="color: #1b9aaa">{{ $user->email }}</span><br />
<strong>{{ $user->phone }}</strong><br /><br />

<strong>Message:</strong>
{{ $message }}

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
