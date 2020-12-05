@extends('layouts.layout')

@section('content')

@include('mixins.misc-back', ['url' => '/imeis', 'label' => 'IMEI Check History'])

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI # {{ $imei->imei }}</h3>

    <div class="stm-flex">
      <div class="stm-flex-wrap">
        <div class="stm-flex-row">
          <div class="stm-flex-row__item header bg-blue">User</div>
          <div class="stm-flex-row__item header bg-blue">IMEI Number</div>
          <div class="stm-flex-row__item header bg-blue">Model</div>
          <div class="stm-flex-row__item header bg-blue">Model Name</div>
          <div class="stm-flex-row__item header bg-blue">Manufacturer</div>
          <div class="stm-flex-row__item header bg-blue">Search Date</div>
          <div class="stm-flex-row__item header bg-blue">Price</div>
          <div class="stm-flex-row__item header bg-blue">Blacklist</div>
        </div>
        <div class="stm-flex-row font-small font-bold">
          <div class="stm-flex-row__item">{{ $imei->user->company }}</div>
          <div class="stm-flex-row__item">{{ $imei->imei }}</div>
          <div class="stm-flex-row__item">{{ $imei->model }}</div>
          <div class="stm-flex-row__item">{{ $imei->model_name }}</div>
          <div class="stm-flex-row__item">{{ $imei->manufacturer }}</div>
          <div class="stm-flex-row__item nowrap">
            {{ $imei->created_at->format('M d, Y g:ia') }}</div>
          @if(\Auth::user()->isAdminManager())
          <div class="stm-flex-row__item">${{ number_format($imei->price, 2) }}</div>
          @else
          <div class="stm-flex-row__item">$0.00</div>
          @endif
          <div class="stm-flex-row__item status-{{ \App\Helpers::blacklist_status($imei->blacklist) }}">
            {{ $imei->blacklist }}
          </div>
        </div>

        @if($imei->all_data)
        <div class="imei-center-max-wrap">
          <div class="stm-flex-row margin-top-1-5">
            <div class="stm-flex-row__item header bg-blue font-center">Complete Data Report</div>
          </div>
          <div class="stm-flex-row">
            <div class="stm-flex-row__item">
              <div class="imei-all-data-wrap">
                {!! $imei->all_data !!}
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
