@component('mail::message')

@if($hello)
{{ $hello }}
@else
@if($user->name)
# Hello {{ $user->name }}
@endif
@endif

{!! $message !!}

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
