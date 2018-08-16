@extends('layouts.layout')

@section('title')
Just One SIM
@endsection

@section('content')

	
	<a>Delete SIM</a> | <a>Edit SIM</a>

    <hr />

        <div>
        	<label>Sim Number - Value - Activation Date - Mobile Number - Carrier</label><br />
            {{ $sim->sim_number }} - {{ $sim->value }} - {{ $sim->activation_date }} - {{ $sim->mobile_number }} - {{ $sim->report_type->carrier->name }} {{ $sim->report_type->name }}
        </div>

        <div>
			Belongs to {{ $sim_user->user->name }} | {{ $sim_user->user->company }}

        </div>

@endsection

