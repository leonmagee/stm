@extends('layouts.layout-simple-no-wrap')

@section('content')

<div class="stm-slider">

  <div class="stm-slider__item">
    <img src="https://res.cloudinary.com/www-stmmax-com/image/upload/v1597094350/Slider/1_p7mff3.png" />
  </div>

</div>

<div class="modal" id="layout-modal">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <img src="{{ URL::asset('img/gs-wireless.png') }}" />

      <h3 class="title">Log In</h3>

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

  </div>

  <button class="modal-close is-large" aria-label="close"></button>

</div>

@endsection
