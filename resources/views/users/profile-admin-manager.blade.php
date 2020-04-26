@extends('layouts.layout')

@section('content')

<div class="single-user-wrap">

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
        {{ $user->city }}, {{ $user->state }} {{ $user->zip }}
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

</div>

<div class="button-bar-wrap">
  <div class="button-bar">
    <a href="/edit-profile" class="button is-primary">Edit Profile</a>
    <a href="/change-profile-password" class="button is-primary">Change Password</a>
  </div>
</div>

@endsection
