@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Your RMAs</h3>

    <div class="stm-flex">

      @if(count($rmas))
      @foreach($rmas as $rma)
      <div class="stm-flex-wrap">

        <div class="stm-flex-row">
          <div class="stm-flex-row__item header">RMA #</div>
          <div class="stm-flex-row__item header">Request Date</div>
          <div class="stm-flex-row__item header">Status</div>
        </div>

        <div class="stm-flex-row">
          <div class="stm-flex-row__item red bold">RMA-GSW-{{ $rma->id }}</div>
          <div class="stm-flex-row__item">{{ $rma->created_at->format('M d, Y') }}</div>
          <div class="stm-flex-row__item status-{{ $rma->status }}">
            {{ \App\Helpers::rma_status($rma->status) }}
          </div>
        </div>

        <div class="stm-flex-row separator">
          <div class="stm-flex-row__item header">Reason for Return</div>
        </div>

        <div class="stm-flex-row">
          <div class="stm-flex-row__item">{{ $rma->explanation }}</div>
        </div>

        <div class="stm-flex-row separator">
          <div class="stm-flex-row__item header flex-35">Product Name</div>
          <div class="stm-flex-row__item header">Color</div>
          <div class="stm-flex-row__item header flex-15">IMEIs</div>
          <div class="stm-flex-row__item header">Price</div>
          <div class="stm-flex-row__item header">Quantity</div>
          <div class="stm-flex-row__item header">Subtotal</div>
          <div class="stm-flex-row__item header">Discount</div>
          <div class="stm-flex-row__item header">Total</div>
        </div>

        <div class="stm-flex-row">
          <div class="stm-flex-row__item flex-35">{{ $rma->product->name }}</div>
          <div class="stm-flex-row__item">{{ $rma->product->variation }}</div>
          <div class="stm-flex-row__item flex-15">
            @foreach($rma->product->imeis as $imei)
            <div>{{ $imei->imei }}</div>
            @endforeach
          </div>
          <div class="stm-flex-row__item">${{ number_format($rma->product->unit_cost, 2) }}</div>
          <div class="stm-flex-row__item">{{ $rma->quantity }}</div>
          <div class="stm-flex-row__item">${{ number_format($rma->product->unit_cost * $rma->product->quantity, 2) }}
          </div>
          <div class="stm-flex-row__item red">
            {{ $rma->product->discount ? $rma->product->discount . '%' : '' }}</div>
          <div class="stm-flex-row__item">${{ number_format($rma->product->final_cost, 2) }}</div>
        </div>

      </div>

      @endforeach
      @else
      <div class="no-rmas-purchases">No RMAs have been submitted yet.</div>
      @endif
    </div>
  </div>
</div>

@endsection
