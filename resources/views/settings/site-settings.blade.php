@extends('layouts.layout')

@section('title')
Site Settings
@endsection

@section('content')

<div class="form-wrapper">

    <div class="form-wrapper-inner third">

        <h3>Default Residual Percent</h3>

    <form method="POST" action="/default_residual_percent">

        {{ csrf_field() }}
        
        <div class="form-wrap">

            <div class="field">
                <label class="label">Enter Percent</label>
                <div class="control">
                    <input class="input" type="number" name="default_percent" />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit" value="Publish">Update</button>
                </div>
            </div>

        </div> 
    
    </form>

</div>

    @include('layouts.errors')

</div>

@endsection

