@extends('layouts.layout')

@section('content')

<div class="products">
  @foreach($products as $product)
  <div class="products__item">{{ $product->name }}</div>
  @endforeach
</div>

<div id="products" products='{{ $products }}'></div>

<script src="js/app.js"></script>
@endsection
