@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI Check</h3>


    <form method="POST" action="/imei">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
            <label class="label">Blacklisted & Carriers IMEI Check</label>
            <div class="control">
              <input name="imei" class="input" type="text" placeholder="Enter IMEI Number..." autocomplete="off" />
            </div>
          </div>
        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Submit</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
