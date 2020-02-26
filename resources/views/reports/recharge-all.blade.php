@extends('layouts.layout')

@section('title')
<div class="with-background">
  Recharge Data for {{ $current_site_date }}
</div>
@endsection

@section('content')
<h4 class="recharge-subheader">2nd Recharge</h4>

<div class="reports-wrap">

  @foreach( $recharge_data_array as $item )

  <div class="report-wrap">

    <div class="title-line">
      <i class="fas fa-user-tie"></i>
      <span class="company">{{ $item['company'] }}</span>
      <span>|</span>
      <span class="name">{{ $item['name'] }}</span>
    </div>

    <div class="recharge-details">

      @foreach($item['data'] as $data)

      <div class="recharge-item">
        <div class="item">
          <label>{!! $data['act_name'] !!}</label>
          <div class="count">{{ $data['act_count'] }}</div>
        </div>
        <div class="item">
          <label>{!! $data['rec_name'] !!}</label>
          <div class="count">{{ $data['rec_count'] }}</div>
        </div>
        <div class="item percent {{ $data['class'] }}">
          <span>{{ $data['percent'] }}%</span>
        </div>

      </div>

      @endforeach

    </div>

  </div>

  @endforeach

</div>

<h4 class="recharge-subheader">3rd Recharge</h4>

<div class="reports-wrap">

  @foreach( $recharge_data_array_third as $item )

  <div class="report-wrap">

    <div class="title-line">
      <i class="fas fa-user-tie"></i>
      <span class="company">{{ $item['company'] }}</span>
      <span>|</span>
      <span class="name">{{ $item['name'] }}</span>
    </div>

    <div class="recharge-details">

      @foreach($item['data'] as $data)

      <div class="recharge-item">
        <div class="item">
          <label>{!! $data['act_name'] !!}</label>
          <div class="count">{{ $data['act_count'] }}</div>
        </div>
        <div class="item">
          <label>{!! $data['rec_name'] !!}</label>
          <div class="count">{{ $data['rec_count'] }}</div>
        </div>
        <div class="item percent {{ $data['class'] }}">
          <span>{{ $data['percent'] }}%</span>
        </div>

      </div>

      @endforeach

    </div>

  </div>

  @endforeach

</div>


@endsection
