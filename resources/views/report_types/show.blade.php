@extends('layouts.layout')

@section('content')

	<h1 class="title">Single Report Type</h1>

    <div>
        {{ $reportType->carrier }} {{ $reportType->name }}
        @if( $reportType->spiff )
			<span class="spiff-resid">Spiff</span>
        @else
			<span class="spiff-resid">Residual</span>
        @endif
    </div>

@endsection

