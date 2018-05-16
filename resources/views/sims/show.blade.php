@extends('layouts.layout')

@section('content')

    <p>Just One Awesome SIM!</p>

        <div>
        	<label>Sim Number - Value - Activation Date - Mobile Number - Carrier</label><br />
            {{ $sim->sim_number }} - {{ $sim->value }} - {{ $sim->activation_date }} - {{ $sim->mobile_number }} - {{ $sim->report_type->carrier }} {{ $sim->report_type->name }}
        </div>

@endsection

