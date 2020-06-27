@extends('layouts.layout-no-wrap')

@section('content')

<div id="products-carousel" class="products-react" products='{{ $products }}'></div>

@endsection
