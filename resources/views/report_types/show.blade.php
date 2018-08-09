@extends('layouts.layout')

@section('title')
Single Report Type
@endsection

@section('content')

    <div>
        {{ $reportType->carrier->name }} {{ $reportType->name }}
    </div>

@endsection

