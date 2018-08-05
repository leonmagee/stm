@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

    <form method="POST" action="/current_date">

        {{ csrf_field() }}
        
        <div class="form-wrap">

            <div class="field">
                <label class="label">Current Month</label>
                <div class="select">
                    <select name="current_month">
                        @foreach( $months as $key => $month )
                        <option value="{{ ($key + 1) }}">{{ $month }}</option> 
                        @endforeach        
                    </select>
                </div> 
            </div>

            <div class="field">
                <label class="label">Current Year</label>
                <div class="select">
                    <select name="current_year">
                        @foreach( $years as $year )
                        <option value="{{ $year }}">{{ $year }}</option> 
                        @endforeach        
                    </select>
                </div> 
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit" value="Publish">Update</button>
                </div>
            </div>

        </div> 
    
    </form>

    <form method="POST" action="/default_residual_percent">

        {{ csrf_field() }}
        
        <div class="form-wrap">

            <div class="field">
                <label class="label">Default Residual Percent</label>
                <div class="control">
                    <input class="input" type="text" name="sim_number" />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit" value="Publish">Update</button>
                </div>
            </div>

        </div> 
    
    </form>

    @include('layouts.errors')

</div>

@endsection

