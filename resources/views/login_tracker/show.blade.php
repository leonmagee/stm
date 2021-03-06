@extends('layouts.layout')

{{-- @section('title')
<div class="with-background">
  Logins for {{ $user->company . ' - ' . $user->name }}
</div>
@endsection --}}

@section('content')
@include('mixins.user-back', ['user' => $user])

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Logins for {{ $user->company . ' - ' . $user->name }}</h3>
    @if($data)
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
    @else
    <div class="add-padding">No login data for this user.</div>
    @endif

  </div>
</div>

@endsection

@section('page-script')

<script>
  $('#sims_table').DataTable({
"processing": true,
"serverSide": true,
responsive: true,
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
