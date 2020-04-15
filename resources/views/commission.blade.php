@extends('layouts.layout')

@section('content')

<div class="commission-wrap">

  <div class="commission-header">
    <div class="tabs is-toggle" id="commission-tabs">
      <ul>
        <li class="is-active" tab="tab-1"><a><i class="fas fa-wifi"></i>H2O Wireless</a></li>
        <li tab="tab-2"><a><i class="fas fa-wifi"></i>Lyca Mobile</a></li>
      </ul>
    </div>

    <div class="commission-header__link">
      @if(Auth::user()->isAdmin())
      <a href="/plan/create" class="button"><i class="fas fa-plus-circle"></i>Add New Plan</a>
      @endif
      <a href="/charts" class="button"><i class="fi flaticon-analytics"></i>Charts</a>
    </div>
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
              <span>$</span>{{ $plan->value }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--padding">
          <ul class="com-ul">
            @if($plan->feature_1)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_1 }}</li>
            @endif
            @if($plan->feature_2)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_2 }}</li>
            @endif
            @if($plan->feature_3)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_3 }}</li>
            @endif
            @if($plan->feature_4)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_4 }}</li>
            @endif
            @if($plan->feature_5)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_5 }}</li>
            @endif
            @if($plan->feature_6)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_6 }}</li>
            @endif
          </ul>
        </div>
        <div class="com-bar__item com-bar__item--spiff">
          <div class="com-spiff">
            <div class="com-spiff__item">1st Spiff ${{ $plan->spiff_1 }}</div>
            <div class="com-spiff__item">2nd Spiff ${{ $plan->spiff_2 }}</div>
            <div class="com-spiff__item">3rd Spiff ${{ $plan->spiff_3 }}</div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              RTR Margin
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan->rtr }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan->rtr_d }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              Life Residual
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan->life }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan->life_d }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--total">
          <div class="com-text com-text--border">
            <div class="com-text__item com-text__item--white">
              Total Commission
            </div>
            <div class="com-text__item com-text__item--percent com-text__item--white">
              <span>$</span>{{ ($plan->spiff_1 + $plan->spiff_2 + $plan->spiff_3) }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text">
            <div class="com-text__item">
              Port In Spiff
            </div>
            <div class="com-text__item com-text__item--percent">
              <span>$</span>{{ $plan->port ? $plan->port : 0 }}
            </div>
            <div class="com-text__item com-text__item--extra">
              Extra
            </div>
          </div>
        </div>
        @if(Auth::user()->isAdmin())
        <div class="com-bar__item">
          <div class="admin-slide">
            <a href="/plan/edit/{{ $plan->id }}"><i class="fas fa-pen"></i></a>
            {{-- <a href="/plan/edit/{{ $plan->id }}"><i class="fas fa-trash"></i></a> --}}
          </div>
        </div>
        @endif
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
              <span>$</span>{{ $plan->value }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--padding">
          <ul class="com-ul">
            @if($plan->feature_1)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_1 }}</li>
            @endif
            @if($plan->feature_2)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_2 }}</li>
            @endif
            @if($plan->feature_3)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_3 }}</li>
            @endif
            @if($plan->feature_4)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_4 }}</li>
            @endif
            @if($plan->feature_5)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_5 }}</li>
            @endif
            @if($plan->feature_6)
            <li class="com-ul__li"><i class="fas fa-circle"></i>{{ $plan->feature_6 }}</li>
            @endif
          </ul>
        </div>
        <div class="com-bar__item com-bar__item--spiff">
          <div class="com-spiff">
            <div class="com-spiff__item">1st Spiff ${{ $plan->spiff_1 }}</div>
            <div class="com-spiff__item">2nd Spiff ${{ $plan->spiff_2 }}</div>
            <div class="com-spiff__item">3rd Spiff ${{ $plan->spiff_3 }}</div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              RTR Margin
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan->rtr }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan->rtr_d }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              Life Residual
            </div>
            <div class="com-text__item com-text__item--percent">
              {{ $plan->life }}<span>%</span>
            </div>
            <div class="com-text__item com-text__item--bottom">
              {{ $plan->life_d }}
            </div>
          </div>
        </div>
        <div class="com-bar__item com-bar__item--total">
          <div class="com-text com-text--border">
            <div class="com-text__item com-text__item--white">
              Total Commission
            </div>
            <div class="com-text__item com-text__item--percent com-text__item--white">
              <span>$</span>{{ ($plan->spiff_1 + $plan->spiff_2 + $plan->spiff_3) }}
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text">
            <div class="com-text__item">
              Port In Spiff
            </div>
            <div class="com-text__item com-text__item--percent">
              <span>$</span>{{ $plan->port ? $plan->port : 0 }}
            </div>
            <div class="com-text__item com-text__item--extra">
              Extra
            </div>
          </div>
        </div>
        @if(Auth::user()->isAdmin())
        <div class="com-bar__item">
          <div class="admin-slide">
            <a href="/plan/edit/{{ $plan->id }}"><i class="fas fa-pen"></i></a>
          </div>
        </div>
        @endif
      </div>
      @endforeach
    </div>
  </div>

</div>

@endsection
