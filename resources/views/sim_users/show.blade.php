@extends('layouts.layout')

@section('title')
Sim Number
@endsection

@section('content')

	<div class="sim-wrap">
		
    	<h3>{{ $sim->sim_number }}</h3>

    	<div class="details">
    		{{ $sim->user->name }} <sep>/</sep> {{ $sim->carrier->name }}
    	</div>

    	<a class="button is-danger">Delete SIM</a>


	</div>


@endsection