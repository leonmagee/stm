@extends('layouts.layout')

@section('content')

<div class="report-totals-final-count">
  Total Activations: <span>{{ number_format($total_count_final) }}</span>
  &nbsp;&nbsp;&nbsp;Total Residuals: <span>{{ number_format($total_count_final_res) }}</span>
</div>

<div class="stm-grid-wrap report-totals-wrap">

  {{-- @foreach( $report_type_totals_array as $report_type => $total ) --}}
  @foreach( $report_type_totals_array as $item )

  <div class="single-grid-item">

    <div class="flex-item icon-wrap carrier-{{ $item['carrier'] }}">
      <i class="fas fa-chart-pie"></i>
    </div>

    <div class="flex-item report-totals-item">

      {{ $item['name'] }}: <span>{{ number_format($item['count']) }}</span>

    </div>

  </div>

  @endforeach

</div>

@endsection
