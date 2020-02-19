@extends('layouts.layout')

@section('title')
Report Types
@endsection

@section('content')

<div class="stm-grid-wrap report-types-wrap">

  @foreach( $report_types as $report_type )

  <a href="/report-types/{{ $report_type->id }}" class="single-grid-item report-type-wrap">

    <div class="flex-item icon-wrap carrier-{{ $report_type->carrier_id }}">
      <i class="fas fa-chart-pie"></i>
    </div>

    <div class="flex-item report-type-name">
      <div>
        <span>{{ $report_type->carrier->name }} {{ $report_type->name }}</span>
      </div>
      <div class="spiff-residual">
        @if( $report_type->spiff )
        <span>Spiff / Activation</span>
        @else
        <span>Residual</span>
        @endif
      </div>
    </div>

  </a>

  @endforeach

</div>

@endsection
