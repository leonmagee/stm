@extends('layouts.layout')

@section('content')

	<div class="report-totals-final-count">
		{{ $current_site_date }} Total Activations: <span>{{ number_format($total_count_final) }}</span>
	</div>

    <div class="stm-grid-wrap report-totals-wrap">
	    
	    @foreach( $report_type_totals_array as $report_type => $total )

	        <div class="single-grid-item">

				<div class="flex-item report-totals-item">

	            	<div>
	            		{{ $report_type }}: <span>{{ number_format($total) }}</span>
	            	</div>

				</div>
	        
	        </div>

	    @endforeach

    </div>

@endsection