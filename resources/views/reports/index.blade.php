@extends('layouts.layout')

@section('title')
{{ $site_name }} Reports for {{ $current_site_date }}
@endsection

@section('content')

<div class="reports-wrap">

	@foreach( $users as $user )

	<div class="report-wrap">

		<div class="title-line">
			<i class="fas fa-user-tie"></i>
			<span class="company">{{ $user->company }}</span>
			<span>|</span>
			<span class="name">{{ $user->name }}</span>
		</div>

		<div class="report-details">

			<table class="table">
				<thead>
					<tr>
						<th>Report Type</th>
						<th># Sims</th>
						<th>Payment</th>
					</tr>
				</thead>
				<tbody>
					@foreach($report_data_array as $report_data)
					<tr>
						<td>{{ $report_data->name }}</td>
						<td>{{ $report_data->number }}</td>
						<td>{{ $report_data->payment }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th>Totals</th>
						<th>189</th>
						<th>$1,999.00</th>
					</tr>
				</tfoot>
			</table>

		</div>


	</div>

	@endforeach

</div>


@endsection

