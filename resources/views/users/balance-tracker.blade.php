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
  function afterLoadjQuery() {
  $('.modal-open').click(function() {
    let credit_id = $(this).attr('credit_id');
    let user_id = $(this).attr('user_id');
    let current_note = $(this).attr('current_note');
    $('#modal_credit_id').val(credit_id);
    $('#modal_user_id').val(user_id);
    $('#credit_modal_note').html(current_note);
    $('.modal#layout-modal').toggleClass('is-active');
    });
}


  $('#sims_table').DataTable({
"processing": true,
"serverSide": true,
"ajax": "{!! route('api.balance.index') !!}",
"order": [[ 0, "desc" ]],
"columns": [
{ "data": "id" },
{ "data": "user.company" },
{ "data": "admin_user.name", "defaultContent": "Balance Transfer" },
{ "data": "previous_balance" },
{ "data": "difference" },
{ "data": "new_balance" },
{ "data": "created_at_new" },
{ "data": "note", "width":"30%" },
//{ "data": "status_final", "className":"status_final" },
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
// "initComplete": function() {
//   afterLoadjQuery();
// }
});

$('#sims_table').on( 'draw.dt', function () {
  afterLoadjQuery();
} );

</script>

@endsection

@section('modal')

<h3 class="title">Finalize Transaction</h3>
<div class="modal-form-wrapper">
  <form method="POST" action="/credit-complete">
    @csrf
    <div class="form-wrap form-wrap-left-align">
      <input type="hidden" name="user_id" id="modal_user_id" />
      <input type="hidden" name="credit_id" id="modal_credit_id" />
      <div class="field">
        <label class="label">Note</label>
        <textarea class="textarea" name="note" id="credit_modal_note"></textarea>
      </div>
      <div class="field">
        <label class="label">Status</label>
        <div class="select">
          <select name="status">
            <option selected="selected" value="3">Completed</option>
            <option value="2">Pending</option>
          </select>
        </div>
      </div>
      <div class="modal-buttons">
        <button class="button is-primary call-loader" type="submit">Update Status</button>
        <a href="#" class="modal-close-button button is-danger">Cancel</a>
      </div>
    </div>
  </form>
</div>

@endsection
