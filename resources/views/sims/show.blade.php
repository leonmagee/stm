@extends('layouts.layout')

@section('content')

    <h2 class="title">Just One Awesome SIM!</h2>
    <p>Not sure if i need to have a single view for a sim number - maybe I could in order to add some controls - i.e. ability to edit the sim number and/or delete a sim? It would probably be better to have these controls function in a more general manner - you can paste in a number of sims to remove them all at once - like the code runner functionality</p>

    <hr />

        <div>
        	<label>Sim Number - Value - Activation Date - Mobile Number - Carrier</label><br />
            {{ $sim->sim_number }} - {{ $sim->value }} - {{ $sim->activation_date }} - {{ $sim->mobile_number }} - {{ $sim->report_type->carrier->name }} {{ $sim->report_type->name }}
        </div>

@endsection

