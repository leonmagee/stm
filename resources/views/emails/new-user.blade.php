@component('mail::message')
# Introduction

You are now signed up to Sim Track Manager!

@component('mail::button', ['url' => 'https://stmmax.com'])
Go to Sim Track Manager
@endcomponent

{{ config('app.name') }}
@endcomponent
