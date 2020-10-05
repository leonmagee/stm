@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Sort Products</h3>

    <div class="list-group" id="sortable-list">
      @foreach($products as $product)
      <div class="list-group-item">{{ $product->name }}</div>
      @endforeach
    </div>
  </div>
</div>

@endsection

@section('page-script')

<script>

</script>

@endsection
