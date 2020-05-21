@extends('layouts.layout')

@section('content')

<div class="product">
  @if($product->img_url)
  <div class="product__image product__image--url"><img src="{{ $product->img_url }}" /></div>
  @else
  <div class="product__image product__image--default"><i class="far fa-image"></i></div>
  @endif
  <div class="product__title">{{ $product->name }}</div>
  <div class="product__cost">${{ number_format($product->cost, 2) }}</div>
  <div class="product__attributes">
    <label class="label">Attributes</label>
    @foreach($product->attributes as $attribute)
    <div class="product__attributes--item"><i class="far fa-dot-circle"></i>{{ $attribute->text }}</div>
    @endforeach
  </div>
  <div class="product__categories">
    <label class="label">Categories</label>
    @foreach($product->categories as $category)
    <div class="product__categories--item"><i class="fas fa-check"></i>{{ $category->category->name }}</div>
    <div class="product__sub_categories">
      @foreach($product->sub_categories as $sub_category)
      @if($category->category->id == $sub_category->sub_category->category_id)
      <div class="product__sub_categories--item">{{ $sub_category->sub_category->name }}
      </div>
      @endif
      @endforeach
    </div>
    @endforeach
  </div>

  <div class="product__footer">
    <a href="/products/edit/{{ $product->id }}">Edit</a>
  </div>
</div>
@endsection
