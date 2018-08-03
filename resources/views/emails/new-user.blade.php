@component('mail::message')
# Introduction

The body of your message.

- one
- two
- three

@component('mail::button', ['url' => 'https://levon.io'])
Go to Levon
@endcomponent

@component('mail::panel')
Panel area new?
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
