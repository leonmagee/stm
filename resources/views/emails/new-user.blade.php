@component('mail::message')
# Introduction

The body of your message.

- one
- two
- three

@component('mail::button', ['url' => 'https://simtrackmanager.com'])
Go to Sim Track Manager
@endcomponent

@component('mail::panel')
Panel area new?
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
