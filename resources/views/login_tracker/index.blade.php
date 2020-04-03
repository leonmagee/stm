@extends('layouts.layout')

{{-- @section('title')
<div class="with-background">
  Login Tracker
</div>
@endsection --}}

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Login Tracker</h3>

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
  </div>
</div>

@endsection

@section('page-script')

<script>
  $('#sims_table').DataTable({
"processing": true,
"serverSide": true,
"ajax": "{!! route('api.logins.index') !!}",
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
