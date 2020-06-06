@extends('layouts.layout')

@section('content')

<div class="product-single">
  <div class="product-single__images">
    @if($product->img_url)
    <div class="product-single__images--url"><img src="{{ $product->img_url }}" /></div>
    <div class="product-single__images--row">
      <div class="product-single__images--item">
        <img src="{{ $product->img_url_small }}" />
      </div>
      <div class="product-single__images--item">
        <img src="{{ $product->img_url_small }}" />
      </div>
      <div class="product-single__images--item">
        <img src="{{ $product->img_url_small }}" />
      </div>
      <div class="product-single__images--item">
        <img src="{{ $product->img_url_small }}" />
      </div>
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
          class="product-details__cost--orig">${{ $product->orig_price }}</span></div>
      <div class="product-details__discount"><i class="fas fa-tag"></i>{{ $product->discount }}% Off</div>
    </div>
    @else
    <div class="product-details__cost">${{ $product->cost }}</div>
    @endif
    <div class="product-details__description">
      {!! $product->description !!}
    </div>

    <div class="product-details__tabs tabs is-toggle" id="product-tabs">
      <ul>
        <li class="is-active" tab="tab-1"><a>Product Details</a></li>
        <li tab="tab-2"><a>Product Info</a></li>
        <li tab="tab-3"><a>More Details</a></li>
      </ul>
    </div>

    <div class="product-details__tabs-content tabs-content">

      <div class="tab-item active" id="tab-1">
        <div class="product-details__details">
          {!! $product->details !!}
        </div>
      </div>

      <div class="tab-item" id="tab-2">
        <div class="product-details__info">
          <div class="product-details__flex-wrap">
            <div class="product-details__attributes">
              <label class="label">Attributes</label>
              @foreach($product->attributes as $attribute)
              <div class="product-details__attribute"><i class="fas fa-circle"></i>{{ $attribute->text }}</div>
              @endforeach
            </div>
            <div class="product-details__categories">
              <label class="label">Categories</label>
              @foreach($product->categories as $category)
              <div class="product-details__category"><i class="fas fa-check"></i>{{ $category->category->name }}</div>
              @foreach($product->sub_categories as $sub_category)
              @if($category->category->id == $sub_category->sub_category->category_id)
              <div class="product-details__category"><i class="fas fa-check"></i>{{ $sub_category->sub_category->name }}
              </div>
              @endif
              @endforeach
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="tab-item" id="tab-3">
        <div class="product-details__more">
          {!! $product->more_details !!}
        </div>
      </div>
    </div>


    <div class="product-details__buttons">
      <button class="add-to-cart"><i class="fas fa-cart-plus"></i>Add To Cart</button>
    </div>

    <a href="/products/edit/{{ $product->id }}">Edit</a>
  </div>
</div>
@endsection
