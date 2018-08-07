@extends('layouts.layout')

@section('content')

<div class="homepage-wrap">

	<h1 class="title">Data</h1>

	<div class="chart-wrap">
		
		<canvas id="graph">

		</canvas>

		<div class="legend"></div>

	</div>

</div>

@endsection

@section('page-script')
<script>
	var date_array = [];
	@foreach( $date_array as $date )
		date_array.push('{{$date}}');
	@endforeach
	//console.log('array', date_array);

	var report_types_array = [];


	var fill_color_array = [
	'rgba(27, 154, 170, 0.3)',
	'rgba(6, 229, 170, 0.3)',
	'rgba(239, 71, 111, 0.3)',
	'rgba(255, 196, 61, 0.3)',
	'rgba(227, 99, 151, 0.3)'
	];

		var stroke_color_array = [
	'rgba(27, 154, 170, 1)',
	'rgba(6, 229, 170, 1)',
	'rgba(239, 71, 111, 1)',
	'rgba(255, 196, 61, 1)',
	'rgba(227, 99, 151, 1)'
	];

	@foreach($report_types as $key => $report_type)
		var report_object = {
				label: '{{$report_type->carrier->name}} {{$report_type->name}}',
				data: [30,122,80],
				backgroundColor: fill_color_array[{{$key}}],
				borderColor: stroke_color_array[{{$key}}],
		};
		report_types_array.push(report_object);
	@endforeach

var data = {
	//labels: ['April 2018', 'May 2018', 'June 2018'],
	labels: date_array,
	datasets: report_types_array
	// [
	// 	{
	// 		label: 'H2O Wireless Month',
	// 		data: [30, 122, 80],
	// 		//backgroundColor: 'rgba(0,210,255,0.3)',
	// 		backgroundColor: 'rgba(0,210,255,0.3)',
	// 		borderColor: 'rgba(0,210,255,1)',
	// 		//borderWidth: 5,
	// 	},
	// 	{
	// 		label: 'H2O Wireless Minute',
	// 		data: [20, 35, 110],
	// 		backgroundColor: 'rgba(0,255,0,0.3)',
	// 		borderColor: 'rgba(0,255,0,1)',
	// 	},
	// 	{
	// 		label: 'H2O Wireless 2nd Recharge',
	// 		data: [33, 11, 80],
	// 		backgroundColor: 'rgba(233,0,200,0.3)',
	// 		borderColor: 'rgba(233,0,200,1)',
	// 	}
	// ]
}

var context = document.querySelector('#graph').getContext('2d');

var options = {
	//showLines: false,
	//borderColor: 'red',
};

//new Chart(context).Line(data, {});

const chartReport = new Chart(context, {
    //type: 'bar',
    type: 'line',
    data: data,
    options: options
});

console.log(chartReport.generateLegend());
</script>
@endsection