@extends('layouts.layout')

@section('title')
Single Report Type
@endsection

@section('content')

    <div class="single-report-type-wrap">

        <div class="item name">{{ $reportType->carrier->name }} {{ $reportType->name}}</div>

        <div class="item spiff-residual">
           @if($reportType->spiff)
            Spiff / Activation
           @else
            Residual
           @endif 


        </div>

		@foreach($site_values_array as $name => $value)
        <div class="item role flex-wrap">
            <i class="fas fa-sitemap"></i> 
            <span class="site-name">{{ $name }}</span>
            <span class="value">{{ $value }}</span>
        </div>
        @endforeach


	</div>

	<div class="button-bar">
    	<a href="/edit-report-type/{{ $reportType->id }}" class="button is-primary">Edit Report Type</a>
    	<a href="/delete-report-type/{{ $reportType->id }}" class="button is-danger">Delete Report Type</a>
	</div>

@endsection

