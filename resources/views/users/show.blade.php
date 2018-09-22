@extends('layouts.layout')

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

        @if($bonus)
        <div class="item credit-bonus flex-wrap">
            <i class="fas fa-user-plus"></i>
            <span>Monthly Bonus: <span class="bonus-val">{{ $bonus }}</span></span>
        </div>
        @endif

        @if($credit)
        <div class="item credit-bonus flex-wrap">
            <i class="fas fa-user-minus"></i>
            <span>Monthly Credit: <span class="credit-val">{{ $credit }}</span></span>
        </div>
        @endif
    
        @if($user->address)
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

    <div class="button-bar-wrap">
    	<div class="button-bar">
        	<a href="/edit-user/{{ $user->id }}" class="button is-primary">Edit User</a>
            <a href="/change-password/{{ $user->id }}" class="button is-primary">Change Password</a>
            <a href="/user-sims/user/{{ $user->id }}" class="button is-primary">View Sims</a>
    	</div>

        <div class="button-bar">
            <a href="/bonus-credit/{{ $user->id }}" class="button is-primary">Bonus / Credit</a>
            <a href="/user-plan-values/{{ $user->id }}" class="button is-primary">Payment Override</a>
            <a href="#" class="modal-open button is-danger">Delete User</a>
        </div>
    </div>


    @section('modal')

    <h3 class="title">Are You Sure?</h3> 

    <a href="/delete-user/{{ $user->id }}" class="button is-danger">Delete User {{ $user->name }} | {{ $user->company }}</a>
    <a href="#" class="modal-close-button button is-primary">Cancel</a>
        
    @endsection

@endsection