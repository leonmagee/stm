@extends('layouts.layout')

@section('title')
<?php if(!isset($is_single)) {$is_single = false; }?>
@if(!$is_single && count($report_data_array) > 0)
<div class="user-report-totals-final-count">
  <div class="item">
    Total Payment: ${{ number_format($total_payment_all_users, 2) }}
  </div>
  @foreach($total_payments_residual as $item)
  <div class="item">
    {{ $item['name'] }} total: {{ $item['total'] }}
  </div>
  @endforeach
</div>
@endif
@endsection


@section('content')
@if($is_single && isset($user))
@include('mixins.user-back', ['user' => $user])
@endif

<div class="reports-wrap reports-wrap-grid">
  @foreach( $report_data_array as $item )

  <div class="report-wrap">

    @if(!Auth::user()->isAdminManagerEmployee())
    <div class="date-title-line">
      <i class="fas fa-calendar"></i>
      <span class="date">{{ $current_site_date }}</span>
    </div>
    @endif
    <div class="title-line">
      <i class="fas fa-user-tie"></i>
      <span class="company">{{ $item->user_company }}</span>
      <span>|</span>
      <span class="name">{{ $item->user_name }}</span>
    </div>

    <div class="report-details">

      <table class="table">
        <thead>
          <tr>
            <th>Report Type</th>
            <th># Sims</th>
            <th>Payment</th>
          </tr>
        </thead>
        <tbody>
          @foreach($item->report_data as $report_data_single)
          <tr>
            <td>{{ $report_data_single->name }}</td>
            <td>{{ $report_data_single->number }}</td>
            <td>{{ $report_data_single->payment }}</td>
          </tr>
          @endforeach
          <tr>
            <td>Monthly Bonus</td>
            <td class="plus_minus">+</td>
            <td class="bonus bold">${{ number_format($item->bonus, 2) }}</td>
          </tr>
          <tr>
            <td>Oustanding Balance</td>
            <td class="plus_minus minus">-</td>
            <td class="credit bold">${{ number_format($item->credit, 2) }}</td>
          </tr>
          <tr>
            <td>Total Assigned Sims</td>
            <td></td>
            <td class="bold blue">{{ number_format($item->count) }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Totals</th>
            <th>{{ $item->total_count }}</th>
            <th>${{ number_format($item->total_payment, 2) }}</th>
          </tr>
        </tfoot>
      </table>

      <form method="POST" action="/get-csv-report/{{ $item->user_id }}">
        {{ csrf_field() }}
        <input type="submit" href="#" class="button is-primary" value="CSV Report" />
      </form>

    </div>


  </div>

  @endforeach

</div>
@if($is_admin && !$is_single)
<div class="save-archive-button-wrap">
  <form method="POST" action="save-archive">
    {{ csrf_field() }}
    <a class="button is-primary modal-open">Save Current Archive</a>
  </form>
</div>
@endif

@endsection

@section('modal')

<h3 class="title">Are You Sure?</h3>

<form method="POST" action="save-archive">
  {{ csrf_field() }}
  <button type="submit" class="button is-danger call-loader">Save Current Archive</button>
</form>

<a href="#" class="modal-close-button button is-primary">Cancel</a>

@endsection
