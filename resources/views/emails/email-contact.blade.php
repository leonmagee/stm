@component('mail::message')

# Hello {{ $admin->name }}!

STM Contact form submitted by {{ $user->company }} - {{ $user->name }}

{{ $message }}

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
