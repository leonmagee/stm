@extends('layouts.layout')

@section('content')

<h4 class="subtitle">Sims For Logged In User</h4>

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

