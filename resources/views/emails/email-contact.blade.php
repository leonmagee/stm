@component('mail::message')

# Hello {{ $admin->name }}!

STM Contact form submission.

<div class="note-wrap">
  <strong>Message:</strong>
  {{ $message }}
</div>

@include('emails.user-info',['user' => $user])

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
