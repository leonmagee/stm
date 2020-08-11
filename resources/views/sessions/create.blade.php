@extends('layouts.layout-simple-no-wrap')

@section('content')

<div class="stm-slider">

  <div class="stm-slider__inner">
    @foreach($slides as $i => $slide)
    <div @if($i==0)class="image-div active" @else class="image-div" @endif
      style="background-image: url({{ $slide->url }})" index_id="{{ $i }}" id="slide-{{ $i }}">
    </div>
    @endforeach
  </div>
  <div class="stm-slider__arrows">
    <a id="prevNav"><i class="fas fa-arrow-circle-left"></i></a>
    <a id="nextNav"><i class="fas fa-arrow-circle-right"></i></a>
  </div>
  <div class="stm-slider__nav">
    <div class="stm-slider__nav--inner">
      @foreach($slides as $i => $slide)
      <div @if($i==0)class="slide-dot active" @else class="slide-dot" @endif index_id="{{ $i }}" id="dot-{{ $i }}">
        <a><i class="fas fa-circle"></i></a>
      </div>
      @endforeach
    </div>
  </div>
</div>

<div class="modal" id="layout-modal">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <img src="{{ URL::asset('img/gs-wireless.png') }}" />

      <form method="POST" action="/login">
        @csrf
        <div class="form-wrap">
          <div class="field">
            <label class="label" for="email">Email</label>
            <div class="control">
              <input class="input" type="email" id="email" name="email" required />
            </div>
          </div>

          <div class="field">
            <label class="label" for="password">Password</label>
            <div class="control">
              <input class="input" type="password" id="password" name="password" required />
            </div>
          </div>

          <div class="field margin-top-1-5">
            <div class="control">
              <button class="button is-primary call-loader" type="submit">Log In</button>
              <a href="#" class="modal-close-button button is-danger">Cancel</a>
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
