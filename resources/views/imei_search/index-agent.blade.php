@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI Check History</h3>

    <table id="sims_table" class="stripe compact" style="width: 100%">
      <thead>
        <tr>
          <th>Id</th>
          <th>User</th>
          <th>IMEI</th>
          <th>Model</th>
          <th>Manufacturer</th>
          {{-- <th>Carrier</th> --}}
          <th>Price</th>
          <th>Blacklist</th>
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
"ajax": "{!! route('api.imei_search.index-agent') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "company" },
{ "data": "imei" },
{ "data": "model" },
{ "data": "manufacturer" },
// { "data": "carrier" },
{ "data": "price" },
{ "data": "blacklist",
"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
if(oData.blacklist == 'BLACKLISTED') {
  $(nTd).html("<span class='pending'>BLACKLISTED</span>");
} else if(oData.blacklist == 'CLEAN') {
  $(nTd).html("<span class='completed'>CLEAN</span>");
}
}
},
{ "data": "id", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='imei-view' href='/imeis/" + oData.id + "'>VIEW MORE</a>");
}
}
]
});

</script>

@endsection
