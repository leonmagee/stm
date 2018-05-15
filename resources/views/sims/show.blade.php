@extends('layouts.layout')

@section('content')

    <p>Just One SIM</p>

        <div>
            {{ $sim->sim_number }} - {{ $sim->value }} - {{ $sim->activation_date }} - {{ $sim->mobile_number }}
        </div>

@endsection

