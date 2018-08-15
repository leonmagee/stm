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
        @if($reportType->spiff)
    	<a href="/edit-report-type/{{ $reportType->id }}" id="edit-report-type" class="button is-primary">Edit Report Type</a>
        @else
        <a href="/edit-report-type-residual/{{ $reportType->id }}" id="edit-report-type" class="button is-primary">Edit Report Type</a>
        @endif
    	<a href="#" class="modal-open button is-danger">Delete Report Type</a>
	</div>

    @section('modal')

    <h3 class="title">Are You Sure?</h3> 

    <a href="/delete-report-type/{{ $reportType->id }}" id="delete-report-type" class="button is-danger">Delete Report Type {{ $reportType->carrier->name }} {{ $reportType->name }}</a>
    <a href="#" class="modal-close-button button is-primary">Cancel</a>

    @endsection



@endsection

