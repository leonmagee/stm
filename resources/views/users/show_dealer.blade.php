@extends('layouts.layout')

@section('content')
@include('layouts.errors')
<div class="users-flex-wrap">
  <div class="users-left-content">
    <div class="single-user-wrap">

      <div class="item company">{{ $user->company}}</div>

      <div class="item name flex-wrap">
        <i class="fas fa-user"></i>
        <span>{{ $user->name }}</span>
      </div>

      <div class="item role flex-wrap">
        <i class="fas fa-sitemap"></i>
        <span>{{ $role }}</span>
      </div>

      <div class="item email flex-wrap">
        <i class="far fa-envelope"></i>
        <span>{{ $user->email }}</span>
      </div>

      <div class="item phone flex-wrap">
        <i class="fas fa-phone"></i>
        <span>{{ $user->phone }}</span>
      </div>

      @if($bonus)
      <div class="item credit-bonus flex-wrap">
        <i class="fas fa-user-plus"></i>
        <span>Monthly Bonus: <span class="bonus-val">{{ $bonus }}</span></span>
      </div>
      @endif

      @if($credit)
      <div class="item credit-bonus flex-wrap">
        <i class="fas fa-user-minus"></i>
        <span>Outstanding Balance: <span class="credit-val">{{ $credit }}</span></span>
      </div>
      @endif

      @if($user->address || $user->city || $user->state || $user->zip)
      <did class="item address-wrap flex-wrap">
        <i class="fas fa-map-marker-alt"></i>
        <div class="address-wrap-inner">
          <div class="address">{{ $user->address }}</div>
          <div class="city_state_zip">
            {{ $user->city }} {{ $user->state }}, {{ $user->zip }}
          </div>
        </div>
      </did>
      @endif

    </div>






    @if(!$user->isAdminManagerEmployee())

    <div class="reports-wrap">

      @foreach( $recharge_data_array as $item )

      <div class="report-wrap">
        <h3 class='recharge-title'>2nd Recharge</h3>

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

    <div class="reports-wrap">

      @foreach( $third_recharge_data_array as $item )

      <div class="report-wrap">
        <h3 class='recharge-title'>3rd Recharge</h3>

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
    @endif

  </div>

</div>

@endsection
