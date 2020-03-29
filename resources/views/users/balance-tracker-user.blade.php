@extends('layouts.layout')

@section('title')
<div class="with-background">
  Balance History
</div>
@endsection

@section('content')

<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Old Balance</th>
      <th>Difference</th>
      <th>New Balance</th>
      <th>Date</th>
      <th>Note</th>
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
"ajax": "{!! route('api.balance.user') !!}",
"order": [[ 3, "desc" ]],
"columns": [
{ "data": "previous_balance" },
{ "data": "difference" },
{ "data": "new_balance" },
{ "data": "created_at" },
{ "data": "note", "width":"23%" }
]
});

</script>

@endsection
