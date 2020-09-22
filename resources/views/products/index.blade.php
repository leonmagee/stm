@extends('layouts.layout-no-wrap')

@section('content')

<div id="products" class="products-react" products='{{ $products }}' categories='{{ $categories }}'
  sub_cat_match='{{ $sub_cat_match }}' sub_cats_array='{{ $sub_cats_array }}' chosen_cat='{{ $chosen_cat }}'></div>

@include('layouts.scroll-up')

@endsection
