@extends('layouts.layout')

{{-- @section('title')
<div class="with-background">
  All Sims assigned to {{ $user_title }}
</div>
@endsection --}}

@section('content')


<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Sim Number</th>
      <th>Carrier</th>
      <th>Company</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

@if(!\Auth::user()->isAdminManagerEmployee())
<div class="csv-button-wrap">
  <form method="POST" action="/download-sims">
    @csrf
    <button class="button is-primary">Download SIMS CSV</button>
  </form>
</div>
@endif

@endsection

@section('page-script')

<script>
  $('#sims_table').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": "{{ route('api.sim_users.index') }}",
    "columns": [
        { data: "sim_number", name: "sim_users.sim_number" },
        { data: "carrier_name", name: "carriers.name" },
        { data: "company", name: "users.company" },
        { data: "user_name", name: "users.name" }
    ]
});

</script>

@endsection
