@extends('layouts.layout')

@section('title')
Carriers
@endsection

@section('content')

    <div class="report-types-wrap">
	    
	    @foreach( $carriers as $carrier )

	        <a href="/carriers/{{ $carrier->id }}" class="report-type-wrap">

				<div class="flex-item icon-wrap">
					<i class="fas fa-mobile-alt"></i>
				</div>

				<div class="flex-item report-type-name">

	            	<div>
	            		<span>{{ $carrier->name }}</span>
	            	</div>

				</div>
	        
	        </a>

	    @endforeach

    </div>

@endsection



