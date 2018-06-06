@extends('layouts.layout')

@section('content')

    <h1 class='title'>Report Types</h1>
    @foreach( $report_types as $report_type )

        <div>
            <a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a>
            - Added: {{ $report_type->created_at->toFormattedDateString() }}

        </div>

    @endforeach

@endsection

