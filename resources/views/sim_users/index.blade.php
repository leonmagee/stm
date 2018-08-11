@extends('layouts.layout')

@section('title')
Sims For Logged In User
@endsection

@section('content')


<table id="sims_table" class="stripe compact">
    <thead>
        <tr>
            <th>Sim Number</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $sims as $sim )
        <tr>
            <td><a href="/sims/{{ $sim->id }}">{{ $sim->sim_number }}</a></td>
            <td><a href="/users/{{ $sim->user->id }}">{{ $sim->user->name }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>










    @foreach( $sims_user as $sim )

        <div>
            <a href="/sim_users/{{ $sim->id }}">{{ $sim->sim_number }}</a> - {{ $sim->user->name }}
        </div>

    @endforeach

<hr />

<h4 class="subtitle">Sim Users All</h4>

    @foreach( $sims as $sim )

        <div>
            <a href="/sim_users/{{ $sim->id }}">{{ $sim->sim_number }}</a> - {{ $sim->user->name }}
        </div>

    @endforeach

@endsection

