@extends('layouts.layout-simple')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Contact Us</h3>

    <form method="POST" action="/contact-us">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="form-wrap-flex">

          <div class="field fourth">
            <div class="control">
              <label class="label">Full Name<span class="required">*</span></label>
              <input class="input" type="text" name="name" value="{{ old('name') }}" />
            </div>
          </div>

          <div class="field fourth">
            <div class="control">
              <label class="label">Business Name<span class="required">*</span></label>
              <input class="input" type="text" name="business" value="{{ old('business') }}" />
            </div>
          </div>

          <div class="field fourth">
            <div class="control">
              <label class="label">Email Address<span class="required">*</span></label>
              <input class="input" type="email" name="email" value="{{ old('email') }}" />
            </div>
          </div>

          <div class="field fourth">
            <div class="control">
              <label class="label">Phone Number<span class="required">*</span></label>
              <input class="input" type="text" name="phone" value="{{ old('phone') }}" />
            </div>
          </div>

          <div class="field full padding-bottom">
            <label class="label">Comment<span class="required">*</span></label>
            <div class="control">
              <textarea class="textarea" name="message">{{ old('message') }}</textarea>
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
