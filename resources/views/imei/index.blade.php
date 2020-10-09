@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI Lookup</h3>


    <form method="POST" action="/imei">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
            <label class="label">Lookup your IMEI Number</label>
            <div class="control">
              <input class="input" type="text" placeholder="Enter Number..." />
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
