@component('mail::message')

# Hello {{ $user->name }}

You are now signed up to Sim Track Manager!

## Your Login Info

Username: {{ $user->email }}

Password: {{ $password }}

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
