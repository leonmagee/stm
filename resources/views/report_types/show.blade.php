@extends('layouts.layout')

@section('content')

	<h1 class="title">Single Report Type</h1>

    <div>
        {{ $reportType->carrier->name }} {{ $reportType->name }}
    </div>

@endsection

