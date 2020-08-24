@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="total-sales">
  <div class="total-sales__header">Total Sales: ${{ number_format($total_sales, 2) }}</div>
  <div class="total-sales__body">
    @foreach($monthly_data as $item)
    {{-- +"total": 2662.5299987793
      +"data": 20
      +"new_date": "07-2020"
      +"year": 2020
      +"month": 7 --}}
    <div class="total-sales__item">
      <div>Month: {{ $item->month}}</div>
      <div>Year: {{ $item->year }}</div>
      <div>Total: ${{ number_format($item->total, 2) }}</div>
    </div>
    @endforeach
  </div>
</div>

@endsection
