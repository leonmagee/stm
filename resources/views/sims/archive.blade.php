@extends('layouts.layout')

{{-- @section('title')
<div class="with-background">
  {{ $name }} Sims | {{ $current_site_date }}
</div>
@endsection --}}

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>{{ $name }} Sims | {{ $current_site_date }}</h3>

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
  </div>
</div>

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
