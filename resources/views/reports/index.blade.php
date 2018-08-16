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
					<tr>
						<td>H2O Wireless Month</td>
						<td>57</td>
						<td>$1,222.00</td>
					</tr>
					<tr>
						<td>H2O Wireless Residual</td>
						<td>522</td>
						<td>$82.00</td>
					</tr>
					<tr>
						<td>H2O Wireless Minute</td>
						<td>9</td>
						<td>$15.00</td>
					</tr>
				</tbody>

			</table>

		</div>


	</div>

	@endforeach

</div>


@endsection

