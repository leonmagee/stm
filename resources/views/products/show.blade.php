@extends('layouts.layout')

@section('content')

<div class="product-single">
  <div class="product-single__image">
    @if($product->img_url)
    <div class="product-single__image--stack">
      <img src="{{ $product->img_url_small }}" />
      <img src="{{ $product->img_url_small }}" />
      <img src="{{ $product->img_url_small }}" />
      <img src="{{ $product->img_url_small }}" />
    </div>
    <div class="product__image product__image--url"><img src="{{ $product->img_url }}" /></div>
    @else
    <div class="product__image product__image--default"><i class="far fa-image"></i></div>
    @endif
  </div>
  <div class="product-single__right product-details">
    <div class="product-details__title">{{ $product->name }}</div>
    @if($product->discount)
    <div class="product-details__cost-discount">
      <div class="product-details__cost">${{ $product->cost }}<span
          class="product-details__cost--orig">${{ $product->orig_price }}</span></div>
      <div class="product-details__discount"><i class="fas fa-tag"></i>{{ $product->discount }}% Off</div>
    </div>
    @else
    <div class="product-details__cost">${{ $product->cost }}</div>
    @endif
    <div class="product-details__description">
      {{ $product->description }}
    </div>
    <div class="product-details__flex-wrap">
      <div class="product-details__attributes">
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

    <div class="product-details__buttons">
      <button class="add-to-cart"><i class="fas fa-cart-plus"></i>Add To Cart</button>
    </div>

    <a href="/products/edit/{{ $product->id }}">Edit</a>
  </div>
</div>
@endsection
