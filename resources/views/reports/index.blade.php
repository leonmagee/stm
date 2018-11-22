@extends('layouts.layout')

@section('title')
{{ $site_name }} Reports for {{ $current_site_date }} / Total Payment: <span>${{ number_format($total_payment_all_users, 2) }}</span>
@endsection

@section('content')

@if($is_admin)
<div class="save-archive-button-wrap">
	<form method="POST" action="save-archive">
		{{ csrf_field() }}
		<button type="submit" class="button is-primary call-loader">Save Current Archive</button>
	</form>
</div>
@endif

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
					<tr>
						<td>Monthly Bonus</td>
						<td class="plus_minus">+</td>
						<td class="bonus bold">${{ number_format($item->bonus, 2) }}</td>
					</tr>
					<tr>
						<td>Oustanding Balance</td>
						<td class="plus_minus minus">-</td>
						<td class="credit bold">${{ number_format($item->credit, 2) }}</td>
					</tr>
					<tr>
						<td>Total Assigned Sims</td>
						<td></td>
						<td class="bold">{{ number_format($item->count) }}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th>Totals</th>
						<th>{{ $item->total_count }}</th>
						<th>${{ number_format($item->total_payment, 2) }}</th>
					</tr>
				</tfoot>
			</table>

			<form method="POST" action="/get-csv-report/{{ $item->user_id }}">
				{{ csrf_field() }}
				<input type="submit" href="#" class="button is-primary" value="CSV Report" />
			</form>

		</div>


	</div>

	@endforeach

</div>


@endsection

