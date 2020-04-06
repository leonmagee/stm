@component('mail::message')

# Hello {{ $admin->name }}!

STM Contact Form Submission.

<div class="note-wrap">
  {{ $message }}
</div>

<table class="table custom">
  <tr>
    <th>Business Name</th>
    <th>Email Address</th>
    <th>Phone Number</th>
    <th>Date</th>
  </tr>
  <tr>
    <td>{{ $business }}</td>
    <td>{{ $email }}</td>
    <td>{{ $phone }}</td>
    <td>{{ $date }}</td>
  </tr>
</table>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
