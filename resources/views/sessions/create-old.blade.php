@extends('layouts.layout-simple')

@section('content')

<div class="form-wrapper">

  <div class="homepage-third">

    <div class="form-wrapper-inner homepage-form-wrap-inner">

      <h3>Log In</h3>

      <form method="POST" action="/login">
        @csrf
        <div class="form-wrap">
          <div class="field">
            <label class="label" for="email">Email</label>
            <div class="control">
              <input class="input" type="email" id="email" name="email" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="password">Password</label>
            <div class="control">
              <input class="input" type="password" id="password" name="password" />
            </div>
          </div>

          <div class="field">
            <div class="control">
              <button class="button is-primary" type="submit">Log In</button>
            </div>
          </div>

          <a href="/password/reset">Reset Password</a>

          <div class="field">

            @include('layouts.errors')

          </div>

        </div>

      </form>

    </div>
    <a class="homepage-link h2o" href="https://www.h2odirectnow.com" target="_blank">
      <span>Login to H2O Direct</span>
      <img src="https://res.cloudinary.com/dabvi4jmx/image/upload/v1580272755/stm/logo-h2o.png" />
    </a>
    <a class="homepage-link lyca" href="http://www.gswmax.com" target="_blank">
      <span>Login to Lyca Direct</span>
      <img src="https://res.cloudinary.com/dabvi4jmx/image/upload/v1580272755/stm/logo-lyca.png" />
    </a>
    <a class="homepage-link eco" href="https://portal.ecomobile.com" target="_blank">
      <span>Login to Eco Direct</span>
      <img src="https://res.cloudinary.com/dabvi4jmx/image/upload/v1580357592/stm/logo-eco3.png" />
    </a>
  </div>

  <div class="form-wrapper-inner image-1 banner-image-wrap">
    <a href="https://mygsaccessories.com" target="_blank">
      <img src="{{ $banner_2 }}" />
    </a>
  </div>

  <div class="form-wrapper-inner image-2 banner-image-wrap">
    <a href="https://mygswireless.com" target="_blank">
      <img src="{{ $banner_1 }}" />
    </a>
  </div>

</div>

@endsection
