@extends('layouts.layout')

@section('content')

<div class="title-form-wrap">

	<h1 class="title">Archive {{ $site_name }} Reports</h1>

	<form id="change-archive-date-form" method="POST" action="change-archive-date">
		{{ csrf_field() }}
		<div class="field select-field-wrap">
			<div class="select">
				<select id="archive-date-select" name="archive_date">
					@foreach($date_select_array as $date => $date_name)
					<option 
					@if($current_date === $date)
					selected="selected"
					@endif
					value="{{ $date }}">{{ $date_name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</form>

</div>

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

			<form method="POST" action="/get-csv-report-archive/{{ $item->user_id }}">
				{{ csrf_field() }}
				<input type="submit" href="#" class="button is-primary" value="CSV Report" />
			</form>

		</div>


	</div>

	@endforeach

</div>


@endsection

@section('page-script')
<script>
console.log('page script working?');

$('#archive-date-select').change(function() {

	// call loader
	$('.stm-absolute-wrap#loader-wrap').css({'display':'flex'});
	$('#change-archive-date-form').submit();

	//let item_value = $(this).val();
	//console.log('change happened?' + item_value);
});

</script>
@endsection

