@extends('layouts.layout-simple')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Contact Us</h3>

    <form method="POST" action="/contact-us-start">

      <div class="form-wrap">

        @csrf
        <div class="padding-1">To contact us please share your email address. You will receive and email and from there
          you can follow a
          link to the contact page.</div>


        <div class="form-wrap-flex">

          <div class="field">
            <div class="control">
              <label class="label">Email Address<span class="required">*</span></label>
              <input class="input" type="email" name="email" value="{{ old('email') }}" />
            </div>
          </div>

          <div class="field recaptcha-start">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_KEY') }}"></div>
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

@include('sessions.login-modal')

@endsection

{{-- @section('page-script')
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
</script>
@endsection --}}
