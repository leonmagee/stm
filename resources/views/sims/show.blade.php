@extends('layouts.layout')

@section('content')

    <h1 class="title">Just One SIM</h1>
	
	<a>Delete SIM</a> | <a>Edit SIM</a>

    <hr />

        <div>
        	<label>Sim Number - Value - Activation Date - Mobile Number - Carrier</label><br />
            {{ $sim->sim_number }} - {{ $sim->value }} - {{ $sim->activation_date }} - {{ $sim->mobile_number }} - {{ $sim->report_type->carrier->name }} {{ $sim->report_type->name }}
        </div>

@endsection

