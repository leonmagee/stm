@extends('layouts.layout')

@section('title')
Carriers
@endsection

@section('content')

    <div class="stm-grid-wrap carriers-wrap">
	    
	    @foreach( $carriers as $carrier )

	        {{-- <a href="/carriers/{{ $carrier->id }}" class="single-grid-item carrier-wrap"> --}}
	        <div class="single-grid-item carrier-wrap">

				<div class="flex-item icon-wrap">
					<i class="fas fa-mobile-alt"></i>
				</div>

				<div class="flex-item carrier-name">

	            	<div>
	            		<span>{{ $carrier->name }}</span>
	            	</div>

				</div>
	        
	        </div>

	    @endforeach

    </div>

@endsection



