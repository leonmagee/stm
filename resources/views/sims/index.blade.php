@extends('layouts.layout')

@section('title')
All Sims | {{ $current_site_date }}
@endsection

@section('content')

<table id="sims_table" class="stripe compact" style="width: 100%">
	<thead>
		<tr>
			<th>Sim Number</th>
			<th>Value</th>
			<th>Activation Date</th>
			<th>Mobile Number</th>
			<th>Report Type</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

@endsection

@section('page-script')

<script>

$('#sims_table').DataTable({
    "processing": true,
    "serverSide": true,
    responsive: true,
    "ajax": "{{ route('api.sims.index') }}",
    "columns": [
        { "data": "sim_number" },
        { "data": "value" },
        { "data": "activation_date" },
        { "data": "mobile_number" },
        { "data": "report_type" }
    ]
});

</script>

@endsection
