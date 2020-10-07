@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Sort Products</h3>

    <div class="cats-wrap">
      @foreach($categories as $cat)
      @if($active == $cat->id)
      <a class="button is-info">{{ $cat->name }}</a>
      @else
      <a class="button is-default" href="products-sort?cat={{ $cat->id }}">{{ $cat->name }}</a>
      @endif
      @endforeach
    </div>

    <div class="list-group" id="sortable-list">
      @foreach($products as $product)
      <div class="list-group-item {{ $product->is_active }}" id="{{ $product->id }}" order="{{ $product->order }}">
        {{ $product->name }}</div>
      @endforeach
    </div>
  </div>
</div>

@endsection

@section('page-script')

<script>

</script>

@endsection
