@extends('layouts.layout')

@section('content')

<div class="product-single">
  <div class="product-single__images">
    @if($product->img_url_1)
    <div class="product-single__images--url">
      @for($i = 1; $i
      <= $num_images; ++$i) <div class="product-single__images--url-item product-single__images--url-item_{{ $i }}">
        <img class="{{ ($i == 1) ? 'active' : 'hidden' }} img_url_{{ $i }}" class="active"
          src="{{ $product->{'img_url_' . $i } }}" />
    </div>
    @endfor
  </div>
  <div class="product-single__images--row">
    @for($i = 1; $i <= $num_images; ++$i) @if($product->{"img_url_small_" . $i })
      <div class="product-single__images--item product-single__images--item_{{ $i }}" image_id="{{ $i }}">
        <img src="{{ $product->{"img_url_small_" . $i } }}" />
      </div>
      @endif
      @endfor
  </div>
  @else
  <div class="product-single__images--default"><i class="far fa-image"></i></div>
  @endif
</div>
<div class="product-single__right product-details">
  <div class="product-details__title">{{ $product->name }}</div>
  @if($product->discount)
  <div class="product-details__flex-space-wrap">
    <div class="product-details__cost">${{ $product->cost }}<span
        class="product-details__cost--orig"><span>${{ $product->orig_price }}</span></div>
    <div class="product-details__discount">
      <div class="product-details__discount--inner"><i class="fas fa-tag"></i>{{ $product->discount }}% Off
      </div>
    </div>
    <div class="product-details__cart">
      <div class="product-details__quantity">
        <i class="fas fa-minus-circle"></i>1<i class="fas fa-plus-circle"></i>
      </div>
      <button class="add-to-cart"><i class="fas fa-cart-plus"></i>Add To Cart</button>
    </div>
  </div>
  @else
  <div class="product-details__flex-space-wrap">
    <div class="product-details__cost">${{ $product->cost }}</div>
  </div>
  @endif
  <div class="product-details__description">
    {!! $product->description !!}
  </div>

  <div class="product-details__tabs tabs is-toggle" id="product-tabs">
    <ul>
      <li class="is-active" tab="tab-1"><a>Product Details</a></li>
      <li tab="tab-2"><a>More Details</a></li>
      <li tab="tab-3"><a>Product Images</a></li>
    </ul>
  </div>

  <div class="product-details__tabs-content tabs-content">

    <div class="tab-item active background" id="tab-1">
      <div class="product-details__details">
        {!! $product->details !!}
      </div>
    </div>

    <div class="tab-item background" id="tab-2">
      <div class="product-details__details">
        {!! $product->more_details !!}
      </div>
    </div>

    <div class="tab-item" id="tab-3">
      <div class="product-details__images">
        @for($i = 1; $i<= $num_tab_images; ++$i) <div class="product-details__images--item">
          <img src="{{ $product->{'tab_img_url_' . $i } }}" />
      </div>
      @endfor
    </div>
  </div>


</div>

<div class="product-details__edit">
  <a href="/products/edit/{{ $product->id }}">Edit</a>
</div>
</div>
</div>
@endsection
