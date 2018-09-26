@extends('layouts.layout')

@section('title')
{{ $site_name }} Recharge Data for {{ $current_site_date }}
@endsection

@section('content')

<div class="reports-wrap">
	@foreach( $recharge_data_array as $item )

	<div class="report-wrap">

		<div class="title-line">
			<i class="fas fa-user-tie"></i>
			<span class="company">{{ $item['company'] }}</span>
			<span>|</span>
			<span class="name">{{ $item['name'] }}</span>
		</div>

		<div class="recharge-details">



			



		</div>


	</div>

	@endforeach

</div>


@endsection

