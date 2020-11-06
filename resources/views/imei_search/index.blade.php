@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI Records</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>Id</th>
          <th>IMEI</th>
          {{-- <th>User</th> --}}
          <th>Model</th>
          <th>Model Name</th>
          <th>Manufacturer</th>
          <th>Carrier</th>
          <th>Blacklist</th>
          <th>Price</th>
          <th>Balance</th>
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
"ajax": "{!! route('api.imei_search.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "imei" },
//{ "data": "company" },
{ "data": "model" },
{ "data": "model_name" },
{ "data": "manufacturer" },
{ "data": "carrier" },
{ "data": "blacklist" },
{ "data": "price" },
{ "data": "balance" },
]
});

</script>

@endsection
