@component('mail::message')

# Hello {{ $admin->name }}!

Contact Form Submission.

<table class="table custom">
  <tr>
    <th>Name</th>
    <th>Business</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Date</th>
  </tr>
  <tr>
    <td>{{ $name }}</td>
    <td>{{ $business }}</td>
    <td>{{ $email }}</td>
    <td>{{ $phone }}</td>
    <td>{{ $date }}</td>
  </tr>
</table>

<div class="note-wrap">
  {{ $message }}
</div>

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
