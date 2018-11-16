@component('mail::message')

# Hello {{ $user->name }}!

You are now signed up to Sim Track Manager!

Here is your login info:

Username / Email: {{ $user->email }}

Password: {{ $password }}

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
