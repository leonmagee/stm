@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Create a Coupon</h3>

    <form method="POST" action="/add-coupon">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">


          <div class="field half">
            <label class="label" for="code">Coupon Code</label>
            <div class="control">
              <input type="text" class="input" name="code" id="code" value="{{ old('code') }}" />
            </div>
          </div>
          <div class="field half">
            <label class="label" for="percent">Coupon Percent</label>
            <div class="control">
              <input type="number" class="input" name="percent" id="percent" value="{{ old('percent') }}" />
            </div>
          </div>
        </div>
        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary" type="submit">Save Coupon</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
