@component('mail::message')

{{-- # Hello {{ $admin->name }}! --}}
# Hello!

<div class="note-wrap">
  {{ $text }}
</div>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
