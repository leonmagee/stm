@extends('layouts.layout')

@section('content')

<div class="single-user-wrap three-quarters">

  <div class="item company">{{ $user->company}}</div>

  <div class="item role flex-wrap">
    <i class="fas fa-sitemap"></i>
    <span>{{ $role }}</span>
  </div>

  <div class="item name flex-wrap">
    <i class="fas fa-user"></i>
    <span>{{ $user->name }}</span>
  </div>

  @if($user->address || $user->city || $user->state || $user->zip)
  <div class="item address-wrap flex-wrap">
    <i class="fas fa-map-marker-alt"></i>
    <div class="address-wrap-inner">
      <div class="address">{{ $user->address }}</div>
      <div class="city_state_zip">
        {{ $user->city }} {{ $user->state }}, {{ $user->zip }}
      </div>
    </div>
  </div>
  @endif

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

  <div class="item credit-bonus flex-wrap">
    <i class="fas fa-dollar-sign"></i>
    <span>Available Credit: <span class="bonus-val">${{ number_format($user->balance, 2) }}</span></span>
  </div>

</div>

<div class="button-bar-wrap">
  <div class="button-bar profile-only">
    <a href="/edit-profile" class="button is-primary">Edit Info</a>
    <a href="/change-profile-password" class="button is-primary">Change Password</a>
    <a href="/user-sims" class="button is-primary">View Sims</a>
    <a href="/reports" class="button is-primary">View Report</a>
    <a href="/redeem-credit" class="button is-primary">Redeem Credit</a>
  </div>
</div>

@endsection
