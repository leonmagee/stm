@extends('layouts.layout')

@section('title')
<div class="with-background">
  Logins for {{ $user->company . ' - ' . $user->name }}
</div>
@endsection

@section('content')
@include('mixins.user-back', ['user' => $user])
@if($data)
<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Id</th>
      <th>Company</th>
      <th>User</th>
      <th>Login Time</th>
      <th>Logout Time</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
@else
<div>No login data for this user.</div>
@endif

@endsection

@section('page-script')

<script>
  $('#sims_table').DataTable({
"processing": true,
"serverSide": true,
"ajax": "{!! route('api.logins.show', ['id' => $user->id]) !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "user.company" },
{ "data": "user.name" },
{ "data": "login" },
{ "data": "logout" }
]
});

</script>

@endsection
