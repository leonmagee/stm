@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Contact Us</h3>


    <form method="POST" action="/contact">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
            <h4>Please submit this form or call us at <strong>619-795-9200</strong>
            </h4>
            <br />

            <label class="label">Your Message</label>
            <div class="control">
              <textarea class="textarea" name="message"></textarea>
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
