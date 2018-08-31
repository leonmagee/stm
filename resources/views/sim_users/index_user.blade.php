@extends('layouts.layout')

@section('title')
Sims For {{ $user->company }} - {{ $user->name }}
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
    <tbody>
    </tbody>
</table>

@endsection

@section('page-script')

<script>

$('#sims_table').DataTable({ // .DataTable vs .dataTable???
    "processing": true,
    "serverSide": true,
    "ajax": "{!! route('api.sim_users.index_user', ['id' => $user->id]) !!}",
    "columns": [
        { "data": "sim_number" },
        { "data": "name" },
        { "data": "company" },
    ]
});

</script>

@endsection

