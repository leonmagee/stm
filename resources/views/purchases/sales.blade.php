@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Sales</h3>

    <div class="stm-flex">
      <div class="total-sales">
        <div class="total-sales__label">Total Sales</div>
        <div class="total-sales__value">${{ number_format($total_sales, 2) }}</div>
      </div>
      <div class="stm-flex-wrap">
        <div class="stm-flex-row">
          <div class="stm-flex-row__item header flex-12">Date</div>
          <div class="stm-flex-row__item header">Total</div>
        </div>
        @foreach($monthly_data as $item)
        <div class="stm-flex-row">
          <?php
              $date_obj = \DateTime::createFromFormat('!m', $item->month);
              $month_name = $date_obj->format('F'); // March
      ?>
          <div class="stm-flex-row__item flex-12">{{ $month_name }} {{ $item->year }}</div>
          <div class="stm-flex-row__item">${{ number_format($item->total, 2) }}</div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
</div>


@endsection
