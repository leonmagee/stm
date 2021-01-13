@extends('layouts.layout-simple')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Contact Us</h3>

    <form method="POST" action="/contact-us-start">

      <div class="form-wrap">

        @csrf
        <div class="contact-start-message">To contact us please share your email address. You will receive an email with
          a link to contact us form (please check
          your spam). Contact us link will expired in 60 minutes.</div>

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
