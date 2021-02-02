@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>STM Credit History</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>ID</th>
          <th>Old Balance</th>
          <th>Transaction</th>
          <th>New Balance</th>
          <th>Date</th>
          <th>Note</th>
          <th>Status</th>
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
"ajax": "{!! route('api.balance.user') !!}",
"order": [[ 0, "desc" ]],
"columns": [
  { "data": "id" },
{ "data": "previous_balance" },
{ "data": "difference" },
{ "data": "new_balance" },
{ "data": "created_at_new" },
{ "data": "note", "width":"45%" },
{ "data": "status", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
  if(oData.status == 2) {
    $(nTd).html("<span class='pending'>Pending</span>");
} else if(oData.status == 3) {
    $(nTd).html("<span class='completed'>Completed</span>");
} else {
    $(nTd).html("<span class='added'>Added</span>");
}
}
}

]
});

</script>

@endsection
