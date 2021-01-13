@component('mail::message')

# Hello!

<div class="note-wrap">
  Please contact us by following this link: <a href="https://stmmax.com/contact-us?token={{ $token }}">Contact Us</a>
</div>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
