@extends('layouts.layout')

@section('title')
All Sims assigned to Users
@endsection

@section('content')


<table id="sims_table" class="stripe compact">
    <thead>
        <tr>
            <th>Sim Number</th>
            <th>Carrier</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

@endsection

@section('page-script')

<script>

$('#sims_table').DataTable({ // .DataTable vs .dataTable???
    "processing": true,
    "serverSide": true,
    "ajax": "{{ route('api.sim_users.index') }}",
    "columns": [
        { "data": "sim_number" },
        // { "data": "carrier_id" },
        // { "data": "user_id" },
        { "data": "name" },
        { "data": "company" },
    ]
});

</script>

@endsection

