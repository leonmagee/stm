@extends('layouts.layout')

@section('title')
Login Tracker
@endsection

@section('content')

<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Company</th>
      <th>User</th>
      <th>Login Time</th>
      <th>Logout Time</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

@endsection

@section('page-script')

<script>
  $('#sims_table').DataTable({
"processing": true,
"serverSide": true,
"ajax": "{!! route('api.logins.index') !!}",
"columns": [
{ "data": "user.company" },
{ "data": "user.name" },
{ "data": "login" },
{ "data": "logout" }
]
});

</script>

@endsection
