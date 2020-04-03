@extends('layouts.layout')


@section('title')
<div class="with-background">
  Credit History
</div>
@endsection


@section('content')

@include('mixins.user-back', ['user' => $user])

<table id="sims_table" class="stripe compact">
  <thead>
    <tr>
      <th>Id</th>
      <th>Company</th>
      <th>User</th>
      <th>Admin</th>
      <th>Old Balance</th>
      <th>Transaction</th>
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
    "ajax": "{!! route('api.balance.show', ['id' => $user->id]) !!}",
    "order": [[ 0, "desc" ]],
    "columns": [
      { "data": "id" },
      { "data": "user.company" },
      { "data": "user.name" },
      { "data": "admin_user.name", "defaultContent": "Cash Out" },
      { "data": "previous_balance" },
      { "data": "difference" },
      { "data": "new_balance" },
      { "data": "created_at_new" },
      { "data": "note", "width":"23%" }
    ]
});

</script>

@endsection
