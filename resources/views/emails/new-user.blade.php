@component('mail::message')
# Introduction

# Hello {{ $user->name }}!

You are now signed up to Sim Track Manager!

Here is your login info:

Username / Email: {{ $user->email }}

Password: {{ $user->password }}

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
