@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Notes</h3>

    <table id="sims_table" class="stripe compact" style="width: 100%">
      <thead>
        <tr>
          <th>Id</th>
          <th>Company</th>
          <th>Note</th>
          <th>Author</th>
          <th>Date</th>
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
"ajax": "{!! route('api.notes.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "user_name", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
$(nTd).html("<a class='nowrap padding-right-10' href='/users/" + oData.user.id + "'>" + oData.user_name + "</a>");
}
},
{ "data": "text" },
{ "data": "author" },
{ "data": "date" }
]
});

</script>

@endsection
