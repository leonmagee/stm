@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Purchase Orders</h3>

    <table id="sims_table" class="stripe compact" style="width: 100%">
      <thead>
        <tr>
          <th>Purchase Order #</th>
          <th>Company</th>
          <th>User</th>
          <th>Total</th>
          <th>Payment Type</th>
          <th>Purchase Date</th>
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
"ajax": "{!! route('api.purchases.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("GSW-" + oData.id);
}
},
{ "data": "user.company" },
{ "data": "user.name" },
{ "data": "total" },
{ "data": "type" },
{ "data": "date" },
{ "data": "status",
"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
if(oData.status == 1) {
$(nTd).html("<span class='new'>New</span>");
}
else if(oData.status == 2) {
$(nTd).html("<span class='pending'>Pending</span>");
} else if(oData.status == 3) {
$(nTd).html("<span class='completed'>Shipped</span>");
} else if(oData.status == 4) {
$(nTd).html("<span class='cancelled'>Cancelled</span>");
}
}
},
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='invoice-view' href='/purchases/" + oData.id + "'>View</a>");
}
}
]
});

</script>

@endsection
