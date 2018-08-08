@extends('layouts.layout')

@section('content')

    <h1 class='title'>Users</h1>

    <div class="users-wrap">
	    
	    @foreach( $users as $user )

	        <div class="user-wrap">
	            <a href="/profile/{{ $user->id }}">{{ $user->name }}</a>
	        </div>

	    @endforeach

    </div>
    

@endsection

