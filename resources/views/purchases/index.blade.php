@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>All Purchases</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>Id</th>
          <th>Company</th>
          <th>User</th>
          <th>Total</th>
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
"ajax": "{!! route('api.purchases.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "user.company" },
{ "data": "user.name" },
{ "data": "total" },
// { "data": "archived",
// "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
// if(oData.archived == 0) {
// $(nTd).html("<span class='completed'>Live</span>");
// }
// else if(oData.archived == 1) {
// $(nTd).html("<span class='pending'>Archived</span>");
// }
// }
// },
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='invoice-view' href='/purchases/edit/" + oData.id + "'>Edit</a>");
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
