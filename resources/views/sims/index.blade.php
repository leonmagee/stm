@extends('layouts.layout')

@section('content')

<h1 class="title">All Sims | {{ CURRENT_SITE_DATE }}</h1>

<table id="sims_table" class="stripe compact">
	<thead>
		<tr>
			<th>Sim Number</th>
			<th>Value</th>
			<th>Activation Date</th>
			<th>Mobile Number</th>
			<th>Report Type</th>
		</tr>
	</thead>
	<tbody>
		@foreach( $sims as $sim )
		<tr>
			<td><a href="/sims/{{ $sim->id }}">{{ $sim->sim_number }}</a></td>
			<td>{{ $sim->value }}</td>
			<td>{{ $sim->activation_date }}</td>
			<td>{{ $sim->mobile_number }}</td>
			<td>{{ $sim->report_type->carrier->name }} {{ $sim->report_type->name }}</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection