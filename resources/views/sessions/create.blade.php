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

@include('sessions.login-modal')

@endsection
