@extends('layouts.layout')

@section('title')
Report Types
@endsection

@section('content')

    @foreach( $report_types as $report_type )

        <div>
            <a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a>
            - Added: {{ $report_type->created_at->toFormattedDateString() }}

        </div>

    @endforeach

@endsection

