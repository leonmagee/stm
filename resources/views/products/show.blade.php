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
  <a href="/products/edit/{{ $product->id }}">Edit</a>
</div>

<script src="js/app.js"></script>
@endsection
