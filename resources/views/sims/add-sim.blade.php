@extends('layouts.layout')

@section('title')
Add One Sim
@endsection

@section('content')

<div class="form-wrapper">

<div class="form-wrapper-inner third">

    <h3>Test</h3>

    <form method="POST" action="/sims">

        {{ csrf_field() }}
        
        <div class="form-wrap">

            <div class="field">
                <label class="label">Sim Number</label>
                <div class="control">
                    <input class="input" type="text" name="sim_number" />
                </div>
            </div>

            <div class="field">
                <label class="label">Sim Value</label>
                <div class="control">
                    <input class="input" type="text" name="value" />
                </div>
            </div>

            <div class="field">
                <label class="label">Activation Date</label>
                <div class="control">
                    <input class="input" type="text" name="activation_date" />
                </div> 
            </div>

            <div class="field">
                <label class="label">Mobile Number</label>
                <div class="control">
                    <input class="input" type="text" name="mobile_number" />
                </div> 
            </div>

            <div class="field">
                <label class="label">Report Type</label>
                <div class="select">
                    <select name="report_type_id">
                        @foreach( $report_types as $report_type )
                        <option value="{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</option> 
                        @endforeach        
                    </select>
                </div> 
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit" value="Publish">Publish</button>
                </div>
            </div>

        </div> 
        </div> 
    
    </form>

    @include('layouts.errors')

</div>

@endsection

