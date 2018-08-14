@extends('layouts.layout')

@section('title')
User
@endsection

@section('content')

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

        <div class="item credit flex-wrap">
            <i class="far fa-credit-card"></i>
            <span>Monthly Credit: <span class="credit-val">{{ $credit }}</span></span>
        </div>

        <did class="item address-wrap flex-wrap">
            <i class="fas fa-map-marked-alt"></i>
            <div class="address-wrap-inner">
    	        <div class="address">{{ $user->address }}</div>
    	        <div class="city_state_zip">
    	        	{{ $user->city }} {{ $user->state }}, {{ $user->zip }}
    	        </div>
            </div>
        </did>

	</div>

	<div class="button-bar">
    	<a href="/edit-user/{{ $user->id }}" class="button is-primary">Edit User</a>
        <a href="/change-password/{{ $user->id }}" class="button is-primary">Change Password</a>
    	<a href="/delete-user/{{ $user->id }}" class="button is-danger">Delete User</a>
	</div>

@endsection