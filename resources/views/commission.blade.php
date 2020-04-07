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



      <div class="com-bar">
        <div class="com-bar__item com-bar__item--yellow com-bar__img com-bar__item--padding">
          <img src="{{ URL::asset('img/h2o-wireless.png') }}" />
        </div>
        <div class="com-bar__item com-bar__item--padding">
          <ul class="com-ul">
            <li class="com-ul__li"><i class="fas fa-circle"></i>Unlimited Talk & Text Nationwide</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>1GS of 4G LTE Data (unlimited at up to 128 kbps speed
              thereafter)</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>Unlimited International Talk to 50+ Countries</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>$10 International Talk Credit</li>
          </ul>
        </div>
        <div class="com-bar__item">
          <div class="com-spiff">
            <div class="com-spiff__item">1st Spiff $10</div>
            <div class="com-spiff__item">2nd Spiff $20</div>
            <div class="com-spiff__item">3rd Spiff $30</div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              RTR Margin
            </div>
            <div class="com-text__item com-text__item--percent">
              6%
            </div>
            <div class="com-text__item com-text__item--bottom">
              Top Up
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              Life Residual
            </div>
            <div class="com-text__item com-text__item--percent">
              3%
            </div>
            <div class="com-text__item com-text__item--bottom">
              2 year
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text">
            <div class="com-text__item">
              Total Commission
            </div>
            <div class="com-text__item com-text__item--cash">
              $18
            </div>
          </div>
        </div>
      </div>

      <div class="com-bar">
        <div class="com-bar__item com-bar__item--yellow com-bar__img com-bar__item--padding">
          <img src="{{ URL::asset('img/h2o-wireless.png') }}" />
        </div>
        <div class="com-bar__item com-bar__item--padding">
          <ul class="com-ul">
            <li class="com-ul__li"><i class="fas fa-circle"></i>Unlimited Talk & Text Nationwide</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>1GS of 4G LTE Data (unlimited at up to 128 kbps speed
              thereafter)</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>Unlimited International Talk to 50+ Countries</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>$10 International Talk Credit</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>Unlimited Talk & Text Nationwide</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>1GS of 4G LTE Data (unlimited at up to 128 kbps speed
              thereafter)</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>Unlimited International Talk to 50+ Countries</li>
            <li class="com-ul__li"><i class="fas fa-circle"></i>$10 International Talk Credit</li>
          </ul>
        </div>
        <div class="com-bar__item">
          <div class="com-spiff">
            <div class="com-spiff__item">1st Spiff $10</div>
            <div class="com-spiff__item">2nd Spiff $20</div>
            <div class="com-spiff__item">3rd Spiff $30</div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              RTR Margin
            </div>
            <div class="com-text__item com-text__item--percent">
              6%
            </div>
            <div class="com-text__item com-text__item--bottom">
              Top Up
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text com-text--border">
            <div class="com-text__item">
              Life Residual
            </div>
            <div class="com-text__item com-text__item--percent">
              3%
            </div>
            <div class="com-text__item com-text__item--bottom">
              2 year
            </div>
          </div>
        </div>
        <div class="com-bar__item">
          <div class="com-text">
            <div class="com-text__item">
              Total Commission
            </div>
            <div class="com-text__item com-text__item--cash">
              $18
            </div>
          </div>
        </div>
      </div>





    </div>
    <div class="tab-item" id="tab-2">
      Tab 2 content
    </div>
  </div>

</div>

@endsection
