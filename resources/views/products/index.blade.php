@extends('layouts.layout')

@section('content')

<div id="products" products='{{ $products }}' categories='{{ $categories }}'></div>

@endsection
