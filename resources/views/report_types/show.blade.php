@extends('layouts.layout')

@section('title')
Single Report Type
@endsection

@section('content')

    <div class="single-report-type-wrap">

        <div class="item name">{{ $reportType->carrier->name }} {{ $reportType->name}}</div>

		@foreach($sites as $site)
        <div class="item role flex-wrap">
            <i class="fas fa-sitemap"></i> {{ $site->name }}
        </div>
        @endforeach


	</div>

	<div class="button-bar">
    	<a href="/edit-user" class="button is-primary">Edit Report Type</a>
    	<a href="/delete-user" class="button is-danger">Delete Report Type</a>
	</div>

@endsection

