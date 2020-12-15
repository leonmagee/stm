@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>All Products</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Status</th>
          <th>Our Price</th>
          <th>Dealer Price</th>
          <th>Discount</th>
          <th>Total</th>
          <th>Quantity</th>
          <th></th>
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
"ajax": "{!! route('api.products.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "name" },
{ "data": "archived",
"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
if(oData.archived == 0) {
$(nTd).html("<span class='completed'>Live</span>");
}
else if(oData.archived == 1) {
$(nTd).html("<span class='pending'>Archived</span>");
}
}
},
{ "data": "our_cost_val" },
{ "data": "cost_val" },
{ "data": "discount_val" },
{ "data": "total" },
{ "data": "quantity" },
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='invoice-view' href='/products/edit/" + oData.id + "'>Edit</a>");
}
},
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='invoice-view' href='/products/" + oData.id + "'>View</a>");
}
}
]
});

</script>

@endsection
