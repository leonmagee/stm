@extends('layouts.layout')

@section('title')
Report Types
@endsection

@section('content')

{{--     @foreach( $report_types as $report_type )

        <div>
            <a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a>
            - Added: {{ $report_type->created_at->toFormattedDateString() }}

        </div>

    @endforeach --}}

    <div class="report-types-wrap">
	    
	    @foreach( $report_types as $report_type )

	        <a href="/report_types/{{ $report_type->id }}" class="report-type-wrap">

				<div class="flex-item icon-wrap">
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

