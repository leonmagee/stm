@extends('layouts.layout')

@section('title')
{{ $site_name }} Users
@endsection

@section('content')

    <div class="users-wrap">
	    
	    @foreach( $users as $user )

	        <a href="/users/{{ $user->id }}" class="user-wrap">

				<div class="flex-item icon-wrap">
					<i class="fas fa-user"></i>
				</div>

				<div class="flex-item company-wrap">
	            	<span>{{ $user->company }}</span>
				</div>

				<div class="flex-item name-phone-wrap">
	            	<div class="name">{{ $user->name }}</div>
	            	<div class="phone">{{ $user->phone }}</div>
				</div>
				
	        </a>

	    @endforeach

    </div>
    

@endsection

