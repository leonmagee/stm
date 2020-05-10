@extends('layouts.layout')

@section('content')
<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Invoices for {{ $user->company }} - {{ $user->name }}</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>Invoice #</th>
          <th>Invoice Date</th>
          <th>Due Date</th>
          <th>Amount Due</th>
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
"ajax": "{!! route('api.invoice.index_user', ['id' => $user->id]) !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "invoice_date" },
{ "data": "due_date_new" },
{ "data": "total",
"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<span class='total-due'>" + oData.total + "</span>");
}
},
{ "data": "status",
"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
if(oData.status == 1) {
$(nTd).html("<span class='new'>New</span>");
}
else if(oData.status == 2) {
$(nTd).html("<span class='pending'>Pending</span>");
} else if(oData.status == 3) {
$(nTd).html("<span class='completed'>Paid</span>");
} else if(oData.status == 4) {
$(nTd).html("<span class='cancelled'>Cancelled</span>");
}
}
},
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='invoice-view' href='/invoices/" + oData.id + "'>View</a>");
}
}
]
});

</script>

@endsection
