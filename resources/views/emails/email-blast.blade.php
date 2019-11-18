@component('mail::message')

@if($user->name)
# Hello {{ $user->name }}!
@endif

{{ $message }}

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
