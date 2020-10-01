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
      <a href="/{{ $search_route }}/{{ $user->id }}">{{ $user->company }}</a>
    </div>
    <div class="divider"></div>
    <div class="detail">
      {{ $user->name }}
    </div>
    <div class="divider hide-mobile"></div>
    <div class="detail hide-mobile">
      {{ $user->email }}
    </div>
    <div class="divider hide-mobile"></div>
    <div class="detail hide-mobile">
      {{ $user->phone }}
    </div>
    <div class="divider hide-mobile"></div>
    <div class="detail hide-mobile">
      @if($admin)
      <a class="balance" href="transaction-change-credit/{{ $user->id }}">${{ number_format($user->balance, 2) }}</a>
      @else
      ${{ number_format($user->balance, 2) }}
      @endif
    </div>




  </div>
  @endforeach

</div>

@endsection
