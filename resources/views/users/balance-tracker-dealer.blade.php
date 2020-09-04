@extends('layouts.layout')

{{-- @section('title')
<div class="with-background">
  Credit History
</div>
@endsection --}}

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Credit History</h3>

    <table id="sims_table" class="stripe compact">
      <thead>
        <tr>
          <th>Id</th>
          <th>Company</th>
          <th>Admin</th>
          <th>Previous</th>
          <th>Transaction</th>
          <th>Current</th>
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
    "ajax": "{!! route('api.balance.index-dealer') !!}",
    "order": [[ 0, "desc" ]],
    "columns": [
    { "data": "id" },
    { "data": "company" },
    { "data": "name", "defaultContent": "Cash Out" },
    { "data": "previous_balance" },
    { "data": "difference" },
    { "data": "new_balance" },
    { "data": "created_at_new" },
    { "data": "note", "width":"30%" },
    { "data": "status",
        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
          if(oData.status == 2) {
            @if(Auth::user()->isAdmin())
            $(nTd).html("<a class='credit-link pending modal-open' current_note='"+oData.note+"' credit_id='"+oData.id+"' user_id='"+oData.user_id+"'>Pending</a>");
            @else
            $(nTd).html("<span class='pending'>Pending</span>");
            @endif
          } else if(oData.status == 3) {
            @if(Auth::user()->isAdmin())
            $(nTd).html("<a class='credit-link completed modal-open' current_note='"+oData.note+"' credit_id='"+oData.id+"' user_id='"+oData.user_id+"'>Completed</a>");
            @else
            $(nTd).html("<span class='completed'>Completed</span>");
            @endif
          } else {
            $(nTd).html("<span class='added'>Added</span>");
          }
        }
      }
    ]
});

</script>

@endsection
