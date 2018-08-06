@extends('layouts.layout')

@section('content')

<h1 class="title">Site Settings</h1>

<div class="form-wrapper">

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

