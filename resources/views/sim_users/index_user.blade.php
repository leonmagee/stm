@extends('layouts.layout')

{{-- @section('title')
Sims For {{ $user->company }} - {{ $user->name }}
@endsection --}}

@section('content')

@include('mixins.user-back', ['user' => $user])

<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Sim Number</th>
      <th>Carrier</th>
      <th>Company</th>
      <th>Name</th>
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
    "ajax": "{!! route('api.sim_users.index_user', ['id' => $user->id]) !!}",
    "columns": [
        { data: "sim_number", name: "sim_users.sim_number" },
        { data: "carrier_name", name: "carriers.name" },
        { data: "company", name: "users.company" },
        { data: "user_name", name: "users.name" }
    ]
});

</script>

@endsection
