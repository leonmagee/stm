@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Notes</h3>

    <table id="sims_table" class="stripe compact">
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
"ajax": "{!! route('api.notes.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "user_name" },
{ "data": "text" },
{ "data": "author" },
{ "data": "date" }
]
});

</script>

@endsection
