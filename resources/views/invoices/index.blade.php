@extends('layouts.layout')

@section('content')
<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>All Invoices</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>Id</th>
          <th>Company</th>
          <th>Name</th>
          <th>Invoice Title</th>
          <th>Due Date</th>
          <th>Invoice Date</th>
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
"ajax": "{!! route('api.invoice.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "company" },
{ "data": "user_name" },
{ "data": "title" },
{ "data": "due_date_new" },
{ "data": "invoice_date" },
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a href='/invoices/" + oData.id + "'>View</a>");
}
}
]
});

</script>

@endsection
