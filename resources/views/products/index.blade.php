@extends('layouts.layout')

@section('content')

<div class="products">
  @foreach($products as $product)
  <div class="product">
    <div class="product__image"><i class="far fa-image"></i></div>
    <div class="product__title">{{ $product->name }}</div>
    <div class="product__cost">${{ number_format($product->cost, 2) }}</div>


  </div>
  @endforeach
</div>

<div id="products" products='{{ $products }}'></div>

<script src="js/app.js"></script>
@endsection
