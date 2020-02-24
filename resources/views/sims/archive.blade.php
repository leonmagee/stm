@extends('layouts.layout')

@section('title')
<div class="with-background">
  {{ $name }} Sims | {{ $current_site_date }}
</div>
@endsection

@section('content')

<table id="sims_table" class="stripe compact">

  <thead>
    <tr>
      <th>Sim Number</th>
      <th>Value</th>
      <th>Activation Date</th>
      <th>Mobile Number</th>
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
    "ajax": "{!! route('api.sims.archive', ['id' => $id]) !!}",
    "columns": [
        { "data": "sim_number" },
        { "data": "value" },
        { "data": "activation_date" },
        { "data": "mobile_number" },
    ]
});

</script>

@endsection
