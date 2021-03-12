@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>RMAs</h3>

    <table id="sims_table" class="stripe compact" style="width: 100%">
      <thead>
        <tr>
          <th>RMA #</th>
          <th>Company</th>
          <th>User</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>RMA Date</th>
          <th>Status</th>
          <th></th>
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
responsive: true,
"ajax": "{!! route('api.rmas.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("RMA-GSW-" + oData.id);
}
},
{ "data": "company" },
{ "data": "user_name" },
{ "data": "product_name" },
{ "data": "quantity" },
{ "data": "date" },
{ "data": "status",
"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
if(oData.status == 1) {
$(nTd).html("<span class='new'>Completed</span>");
}
else if(oData.status == 2) {
$(nTd).html("<span class='pending'>Pending</span>");
} else if(oData.status == 3) {
$(nTd).html("<span class='completed'>Approved</span>");
} else if(oData.status == 4) {
$(nTd).html("<span class='cancelled'>Rejected</span>");
}
}
},
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='invoice-view' href='/rmas/" + oData.id + "'>View</a>");
}
}
]
});

</script>

@endsection
