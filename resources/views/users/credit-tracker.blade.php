@extends('layouts.layout')

@section('title')
<div class="with-background">
  Credit Tracker
</div>
@endsection

@section('content')

<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Id</th>
      <th>Company</th>
      <th>User</th>
      <th>Credit</th>
      <th>Payment Type</th>
      <th>Account ID</th>
      <th>Date</th>
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
"ajax": "{!! route('api.credit.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "user.company" },
{ "data": "user.name" },
{ "data": "credit" },
{ "data": "type" },
{ "data": "account_id" },
{ "data": "created_at_new" },
//{ "data": "note", "width":"23%" }
]
});

</script>

@endsection
