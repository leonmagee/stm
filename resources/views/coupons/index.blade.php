@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Discount Coupons</h3>

    <div class="coupons">
      @foreach($coupons as $coupon)
      <div class="coupon">
        <div class="coupon__item coupon__tag"><i class="fas fa-tag"></i></div>
        <div class="coupon__item coupon__code">{{ $coupon->code }}</div>
        <div class="coupon__item coupon__percent">{{ $coupon->percent }}% Off</div>
        <div class="coupon__item coupon__expires">Expires: {{ $coupon->expiration ? $coupon->expiration : 'N/A' }}</div>
        @if($coupon->expiration)
        <div class="coupon__item coupon__activate">
          @if(!$coupon->active)
          <form method="POST" action="/start-promotion/{{ $coupon->id }}">
            @csrf
            <button class="start call-loader" type="submit">Start Promotion</button>
          </form>
          @else
          <form method="POST" action="/end-promotion/{{ $coupon->id }}">
            @csrf
            <button class="end call-loader" type="submit">End Promotion</button>
          </form>
          @endif
        </div>
        @endif
        <div class="coupon__item coupon__icon coupon__delete modal-delete-open" item_id={{ $coupon->id }}><i
            class="fa fa-trash"></i></div>
      </div>

      <div class="modal" id="delete-item-modal-{{ $coupon->id }}">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h4 class="title modal-title">Are You Sure?</h4>

            <a href="/delete-coupon/{{ $coupon->id }}" class="button is-danger">Delete Coupon</a>
            <a class="modal-delete-close-button button is-primary" item_id={{ $coupon->id }}>Cancel</a>
          </div>

        </div>

        <button class="modal-delete-close is-large" aria-label="close" item_id={{ $coupon->id }}></button>

      </div>

      @endforeach
      <form method="POST" action="/add-coupon" class="margin-top-2">
        @csrf
        <div class="coupon">
          <div class="coupon__item coupon__tag"><i class="fas fa-tag"></i></div>
          <div class="coupon__item coupon__code coupon__input">
            <input type="text" name="code" id="code" placeholder="Coupon Code..." autocomplete="off" required />
          </div>
          <div class="coupon__item coupon__percent coupon__input">
            <input type="number" name="percent" id="percent" placeholder="Percent Off..." autocomplete="off" required />
          </div>
          <div class="coupon__item coupon__expires coupon__input">
            <input type="text" name="expiration" id="expiration_date" placeholder="Expires..." autocomplete="off" />
          </div>
          <div class="coupon__item coupon__icon coupon__add"><button type="submit"><i class="fa fa-plus"></i></button>
          </div>
      </form>
    </div>
  </div>

</div>

</div>

@endsection
