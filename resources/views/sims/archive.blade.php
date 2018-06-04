@extends('layouts.layout')

@section('content')

	<h1 class="title">Archive Sims for {{ $name }}</h1>

    @foreach( $sims as $sim )

        <div>
            <a href="/sims/{{ $sim->id }}">{{ $sim->sim_number }}</a> - {{ $sim->value }} - {{ $sim->activation_date }} - {{ $sim->mobile_number }} - {{ $sim->report_type->carrier }} {{ $sim->report_type->name }}
        </div>

    @endforeach

@endsection

