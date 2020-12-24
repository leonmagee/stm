@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Promotions</h3>

    <div class="coupons">
      @foreach($promotions as $promotion)
      <div class="coupon">
        <div class="coupon__item coupon__tag"><i class="fas fa-bullhorn"></i></div>
        <div class="coupon__item coupon__code">{{ $promotion->text }}</div>
        <div class="coupon__item coupon__activate">
          @if(!$promotion->active)
          <form method="POST" action="/start-promotion-non-coupon/{{ $promotion->id }}">
            @csrf
            <button class="start call-loader" type="submit">Start Promotion</button>
          </form>
          @else
          <form method="POST" action="/end-promotion-non-coupon/{{ $promotion->id }}">
            @csrf
            <button class="end call-loader" type="submit">End Promotion</button>
          </form>
          @endif
        </div>
        <div class="coupon__item coupon__icon coupon__delete modal-delete-open" item_id={{ $promotion->id }}><i
            class="fa fa-trash"></i></div>
      </div>

      <div class="modal" id="delete-item-modal-{{ $promotion->id }}">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h4 class="title modal-title">Are You Sure?</h4>

            <a href="/delete-coupon/{{ $promotion->id }}" class="button is-danger">Delete Promotion</a>
            <a class="modal-delete-close-button button is-primary" item_id={{ $promotion->id }}>Cancel</a>
          </div>

        </div>

        <button class="modal-delete-close is-large" aria-label="close" item_id={{ $promotion->id }}></button>

      </div>

      @endforeach
      <form method="POST" action="/add-promotion" class="margin-top-2">
        @csrf
        <div class="coupon">
          <div class="coupon__item coupon__tag"><i class="fas fa-bullhorn"></i></div>
          <div class="coupon__item coupon__code coupon__input">
            <input type="text" name="text" id="text" placeholder="Promotion Text..." autocomplete="off" required />
          </div>
          <div class="coupon__item coupon__icon coupon__add"><button type="submit"><i class="fa fa-plus"></i></button>
          </div>
      </form>
    </div>
  </div>

</div>

</div>

@endsection
