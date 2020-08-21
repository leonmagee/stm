@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="total-sales-wrap">
  Total Sales: ${{ number_format($total_sales, 2) }}
</div>

@endsection
