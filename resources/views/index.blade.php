@extends('layouts.layout')

@section('content')

<div class="homepage-wrap">

	<h1 class="title">Reports</h1>

	<div class="chart-wrap">
		
		<canvas id="graph">

		</canvas>

	</div>

</div>

@endsection

@section('page-script')
<script>
var data = {
	labels: ['April 2018', 'May 2018', 'June 2018'],
	datasets: [
		{
			label: 'H2O Wireless Month',
			data: [30, 122, 80],
			backgroundColor: 'rgba(0,210,255,0.3)',
			borderColor: 'rgba(0,210,255,1)',
			//borderWidth: 5,
		},
		{
			label: 'H2O Wireless Minute',
			data: [20, 35, 110],
			backgroundColor: 'rgba(0,255,0,0.3)',
			borderColor: 'rgba(0,255,0,1)',
		},
		{
			label: 'H2O Wireless 2nd Recharge',
			data: [33, 11, 80],
			backgroundColor: 'rgba(233,0,200,0.3)',
			borderColor: 'rgba(233,0,200,1)',
		}
	]
}

var context = document.querySelector('#graph').getContext('2d');

var options = {
	//showLines: false,
	//borderColor: 'red',
};

//new Chart(context).Line(data, {});

var myLineChart = new Chart(context, {
    //type: 'bar',
    type: 'line',
    data: data,
    options: options
});	
</script>
@endsection