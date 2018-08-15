@extends('layouts.layout')

@section('title')
{{ $site_name }} Site Settings
@endsection

@section('content')

<div class="form-wrapper">

    <div class="form-wrapper-inner half">

        <h3>Default Spiff Payment</h3>

        <form method="POST" action="/default_spiff_payment">

            {{ csrf_field() }}

            <div class="form-wrap">

                <div class="field">
                    <label class="label">Enter Amount</label>
                    <div class="control">
                        <input value="{{ $spiff }}" class="input" type="number" name="default_spiff" />
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

    <div class="form-wrapper-inner half">

        <h3>Default Residual Percent</h3>

        <form method="POST" action="/default_residual_percent">

            {{ csrf_field() }}

            <div class="form-wrap">

                <div class="field">
                    <label class="label">Enter Percent</label>
                    <div class="control">
                        <input value="{{ $residual }}" class="input" type="number" name="default_percent" />
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

