@extends('layouts.layout')

@section('content')

<div class="homepage-wrap">

	<h1>HOMEPAGE</h1>

	<div class="chart-wrap">
		
		<canvas id="graph">

		</canvas>

	</div>

</div>

@endsection

@section('page-script')
<script>
var data = {
	labels: ['January', 'February', 'March'],
	datasets: [
		{
			data: [30, 122, 80],
			backgroundColor: 'rgba(0,210,255,0.3)',
			borderColor: 'rgba(0,210,255,1)',
			//borderWidth: 5,
		},
		{
			data: [20, 35, 110],
			backgroundColor: 'rgba(0,255,0,0.3)',
			borderColor: 'rgba(0,255,0,1)',
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