@extends('layouts.layout')

@section('content')

    <h1 class='title'>Report Types</h1>
    @foreach( $report_types as $report_type )

        <div>
            <a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier }} {{ $report_type->name }}</a>
            @if( $report_type->spiff )
				<span class="spiff-resid">Spiff</span>
            @else
				<span class="spiff-resid">Residual</span>
            @endif
            - Added: {{ $report_type->created_at->toFormattedDateString() }}

        </div>

    @endforeach

@endsection

