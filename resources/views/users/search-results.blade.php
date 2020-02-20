@extends('layouts.layout')

@section('title')
Search Results for <span>{{ $search }}</span>
@endsection

@section('content')

<div class="allUsersList">

  @foreach($users as $user)
  <div class="allUsersItem">
    <div class="divider"></div>
    <div class="detail">
      <a href="/users/{{ $user->id }}">{{ $user->company }}</a>
    </div>
    <div class="divider"></div>
    <div class="detail">
      {{ $user->name }}
    </div>
    <div class="divider"></div>
    <div class="detail">
      {{ $user->email }}
    </div>
    <div class="divider"></div>
    <div class="detail">
      {{ $user->phone }}
    </div>
  </div>
  @endforeach

</div>

@endsection
