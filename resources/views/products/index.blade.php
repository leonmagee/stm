@extends('layouts.layout')

@section('content')

<div id="products" products='{{ $products }}' categories='{{ $categories }}' sub_cat_match='{{ $sub_cat_match }}'
  sub_cats_array='{{ $sub_cats_array }}'></div>

@endsection
