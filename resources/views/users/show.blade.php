@extends('layouts.layout')

@section('content')

    <h1 class='title'>User</h1>

    	<div class="single-user-wrap">

	        <div class="company">{{ $user->company}}</div>
	        <div class="name">{{ $user->name }}</div>
	        <div class="role">{{ $role }}</div>
	        <div class="phone">{{ $user->phone }}</div>
	        <div class="credit">Monthly Credit: <span>{{ $credit }}</span></div>
	        <did class="address-wrap">
		        <div class="address">{{ $user->address }}</div>
		        <div class="city_state_zip">
		        	{{ $user->city }} {{ $user->state }}, {{ $user->zip }}
		        </div>
	        </did>

    	</div>

    	<div class="button-bar">
	    	<a href="/edit-user" class="button is-primary">Edit User</a>
	    	<a href="/delete-user" class="button is-danger">Delete User</a>
    	</div>

@endsection