@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Login Tracker</h3>

    <table id="sims_table" class="stripe compact" style="width: 100%">
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
responsive: true,
"ajax": "{!! route('api.logins.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "company" },
{ "data": "name" },
{ "data": "login" },
{ "data": "logout" }
]
});

</script>

@endsection
