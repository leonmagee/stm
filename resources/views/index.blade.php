@extends('layouts.layout')

@section('content')

<div class="chart-wrap-outer">

	<h1 class="title">SIM Activations Per Month</h1>

	<div class="chart-toggle">
		<a class="button is-primary" id="toggle">Toggle Chart</a>
	</div>

	<div class="homepage-wrap">

		<div class="chart-wrap">
			<canvas id="graph"></canvas>
		</div>

	</div>

</div>

<div class="mobile-only">
	<h1 class="title">Welcome to Sim Track Manager!</h1>
</div>

@endsection

@section('page-script')
<script>

	var report_types_array = [];

	var fill_color_array = [
	'rgba(27, 154, 170, 0.3)',
	'rgba(6, 229, 170, 0.3)',
	'rgba(239, 71, 111, 0.3)',
	'rgba(255, 196, 61, 0.3)',
	'rgba(81, 229, 255, 0.3)',
	'rgba(27, 154, 170, 0.3)',
	'rgba(6, 229, 170, 0.3)',
	'rgba(239, 71, 111, 0.3)',
	'rgba(255, 196, 61, 0.3)',
	'rgba(81, 229, 255, 0.3)',
	'rgba(27, 154, 170, 0.3)',
	'rgba(6, 229, 170, 0.3)',
	'rgba(239, 71, 111, 0.3)',
	'rgba(255, 196, 61, 0.3)',
	'rgba(81, 229, 255, 0.3)',
	'rgba(27, 154, 170, 0.3)',
	'rgba(6, 229, 170, 0.3)',
	'rgba(239, 71, 111, 0.3)',
	'rgba(255, 196, 61, 0.3)',
	'rgba(81, 229, 255, 0.3)',
	];

	var stroke_color_array = [
	'rgba(27, 154, 170, 1)',
	'rgba(6, 229, 170, 1)',
	'rgba(239, 71, 111, 1)',
	'rgba(255, 196, 61, 1)',
	'rgba(81, 229, 255, 1)',
	'rgba(27, 154, 170, 1)',
	'rgba(6, 229, 170, 1)',
	'rgba(239, 71, 111, 1)',
	'rgba(255, 196, 61, 1)',
	'rgba(81, 229, 255, 1)',
	'rgba(27, 154, 170, 1)',
	'rgba(6, 229, 170, 1)',
	'rgba(239, 71, 111, 1)',
	'rgba(255, 196, 61, 1)',
	'rgba(81, 229, 255, 1)',
	'rgba(27, 154, 170, 1)',
	'rgba(6, 229, 170, 1)',
	'rgba(239, 71, 111, 1)',
	'rgba(255, 196, 61, 1)',
	'rgba(81, 229, 255, 1)',
	];

	@foreach($data_array as $key => $data)
	var report_object = {
		label: "{{$data['title'] }}",
		data: [
		{{ $data['counts'][0] }},
		{{ $data['counts'][1] }},
		{{ $data['counts'][2] }},
		{{ $data['counts'][2] }}
		],
		backgroundColor: fill_color_array[{{$key}}],
		borderColor: stroke_color_array[{{$key}}],
	};
	report_types_array.push(report_object);
	@endforeach

	var date_name_array = [];
	@foreach($date_name_array as $date)
	date_name_array.push('{{ $date }}');
	@endforeach

	var data = {
	//labels: ['April 2018', 'May 2018', 'June 2018'],
	labels: date_name_array, 
	//labels: date_array,
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
	scales: {
		yAxes: [{
			ticks: {
				beginAtZero:true
			}
		}]
	},
	legend: {
		display: true,
		position: 'right',
		onClick: function(e, legendItem) {
			var index = legendItem.datasetIndex;
			var ci = this.chart;
			var alreadyHidden = (ci.getDatasetMeta(index).hidden === null) ? false : ci.getDatasetMeta(index).hidden;

			ci.data.datasets.forEach(function(e, i) {
				var meta = ci.getDatasetMeta(i);

				if (i !== index) {
					if (!alreadyHidden) {
						meta.hidden = meta.hidden === null ? !meta.hidden : null;
					} else if (meta.hidden === null) {
						meta.hidden = true;
					}
				} else if (i === index) {
					meta.hidden = null;
				}
			});

			ci.update();
		}
	}
};

//new Chart(context).Line(data, {});

var chartType = 'bar';

function init() {
	chartReport = new Chart(context, {
		type: chartType,
	    //type: 'line',
	    data: data,
	    //scaleStartValue : 0,
	    options: options
	});
}


init();

// function init() {
//   // Chart declaration:
//   myBarChart = new Chart(ctx, {
//     type: chartType,
//     data: data,
//     options: options
//   });
// }

function toggleChart() {
  //destroy chart:
  chartReport.destroy();
  //change chart type: 
  this.chartType = (this.chartType == 'bar') ? 'line' : 'bar';
  //restart chart:
  init();
}

$('.chart-toggle #toggle').click(function() {
	toggleChart();
});


//console.log(chartReport.generateLegend());
</script>
@endsection