@extends('layouts.layout')

@section('content')
<div class="form-wrapper">
    <form method="POST" action="/sims">
        {{ csrf_field() }}

        
        <div class="grid-x grid-padding-x">

            <div class="cell small-8">
                <label>Sim Number</label>
                <input type="text" name="sim_number" />
            </div>

            <div class="cell small-4">
                <label>Sim Value</label>
                <input type="text" name="value" />
            </div>

            <div class="cell small-4">
                <label>Activation Date</label>
                <input type="text" name="activation_date" />
            </div> 

            <div class="cell small-4">
                <label>Mobile Number</label>
                <input type="text" name="mobile_number" />
            </div> 

            <div class="cell small-4">
                <label>Carrier</label>
                <input type="text" name="carrier" />
            </div> 

        </div> 

        <button class="button" type="submit" value="Publish">Publish</button>
    </form>

    @include('layouts.errors')
</div>
@endsection

