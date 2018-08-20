@extends('layouts.layout')

@section('title')
{{ $site_name }} Reports for {{ $current_site_date }}
@endsection

@section('content')

<div class="reports-wrap">
	@foreach( $report_data_array as $item )

	<div class="report-wrap">

		<div class="title-line">
			<i class="fas fa-user-tie"></i>
			<span class="company">{{ $item->user_company }}</span>
			<span>|</span>
			<span class="name">{{ $item->user_name }}</span>
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
					@foreach($item->report_data as $report_data_single)
					<tr>
						<td>{{ $report_data_single->name }}</td>
						<td>{{ $report_data_single->number }}</td>
						<td>{{ $report_data_single->payment }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th>Totals</th>
						<th>{{ $item->total_count }}</th>
						<th>${{ number_format($item->total_payment, 2) }}</th>
					</tr>
				</tfoot>
			</table>

		</div>


	</div>

	@endforeach

</div>


@endsection

