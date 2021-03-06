@extends('layouts.layout')

@section('title')
{{ $name }} Sims | {{ $current_site_date }}
@endsection

@section('content')

    <table id="sims_table" class="stripe compact" style="width: 100%">

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
