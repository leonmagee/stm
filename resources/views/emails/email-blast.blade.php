@component('mail::message')

# Hello {{ $user->name }}!

{{ $message }}

@component('mail::button', ['url' => 'https://simtrackmanager.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent