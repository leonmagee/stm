@extends('layouts.layout')

@section('title')
Sims For Logged In User or all for admin
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
        @foreach( $sims as $sim )
        <tr>
            <td><a href="/sims/{{ $sim->sim_number }}">{{ $sim->sim_number }}</a></td>
            <td>{{ $sim->carrier->name }}</td>
            <td><a href="/users/{{ $sim->user->id }}">{{ $sim->user->name }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

