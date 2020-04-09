@extends('layouts.layout')

@section('content')

<div class="commission-wrap">

  <div class="tabs is-toggle" id="commission-tabs">
    <ul>
      <li class="is-active" tab="tab-1"><a><i class="fas fa-wifi"></i>H2O Wireless</a></li>
      <li tab="tab-2"><a><i class="fas fa-wifi"></i>Lyca Mobile</a></li>
    </ul>
  </div>

  <div class="tabs-content">
    <div class="tab-item active" id="tab-1">

      @foreach($h2o_plans as $plan)
      <div class="com-bar">
        <div class="com-bar__item com-bar__item--h2o com-bar__img com-bar__item--padding">
          <img class="h2o" src="{{ URL::asset('img/h2o-wireless.png') }}" />
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item com-text__item--value">
              <span>$</span>{{ $plan['value'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--padding">
          <ul class="com-ul">
            @foreach( $plan['text'] as $text)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $text }}</li>
            @endforeach
          </ul>
        </div>
        <div class="com-bar__item com-bar__item--spiff">
          <div class="com-spiff">
            <div class="com-spiff__item">1st Spiff ${{ $plan['spiff'][0] }}</div>
            <div class="com-spiff__item">2nd Spiff ${{ $plan['spiff'][1] }}</div>
            <div class="com-spiff__item">3rd Spiff ${{ $plan['spiff'][2] }}</div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              RTR Margin
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan['rtr']['percent'] }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan['rtr']['description'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              Life Residual
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan['life']['percent'] }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan['life']['description'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--total">
          <div class="com-text com-text--border">
            <div class="com-text__item com-text__item--white">
              Total Commission
            </div>
            <div class="com-text__item com-text__item--percent com-text__item--white">
              <span>$</span>{{ $plan['total'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text">
            <div class="com-text__item">
              Port In Spiff
            </div>
            <div class="com-text__item com-text__item--percent">
              <span>$</span>{{ $plan['port-in']['value'] }}
            </div>
            <div class="com-text__item com-text__item--extra">
              {{ $plan['port-in']['description'] }}
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>
    <div class="tab-item" id="tab-2">

      @foreach($lyca_plans as $plan)
      <div class="com-bar">
        <div class="com-bar__item com-bar__item--lyca com-bar__img com-bar__item--padding">
          <img class="lyca" src="{{ URL::asset('img/lyca-mobile.png') }}" />
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item com-text__item--value">
              <span>$</span>{{ $plan['value'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--padding">
          <ul class="com-ul">
            @foreach( $plan['text'] as $text)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $text }}</li>
            @endforeach
          </ul>
        </div>
        <div class="com-bar__item com-bar__item--spiff">
          <div class="com-spiff">
            <div class="com-spiff__item">1st Spiff ${{ $plan['spiff'][0] }}</div>
            <div class="com-spiff__item">2nd Spiff ${{ $plan['spiff'][1] }}</div>
            <div class="com-spiff__item">3rd Spiff ${{ $plan['spiff'][2] }}</div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              RTR Margin
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan['rtr']['percent'] }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan['rtr']['description'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              Life Residual
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan['life']['percent'] }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan['life']['description'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--total">
          <div class="com-text com-text--border">
            <div class="com-text__item com-text__item--white">
              Total Commission
            </div>
            <div class="com-text__item com-text__item--percent com-text__item--white">
              <span>$</span>{{ $plan['total'] }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text">
            <div class="com-text__item">
              Port In Spiff
            </div>
            <div class="com-text__item com-text__item--percent">
              <span>$</span>{{ $plan['port-in']['value'] }}
            </div>
            <div class="com-text__item com-text__item--extra">
              {{ $plan['port-in']['description'] }}
            </div>
          </div>
        </div>
      </div>
      @endforeach


    </div>
  </div>

</div>

@endsection
