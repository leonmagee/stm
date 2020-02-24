@extends('layouts.layout')

@section('title')
<div class="with-background">
  @if(\Auth()->user()->isAdmin() || \Auth()->user()->isManager() || \Auth()->user()->isEmployee())
  All Agents / Dealers
  @else
  Your Dealers
  @endif
</div>
@endsection

@section('content')
@if(\Auth()->user()->isAdmin())
<div id="allUsers" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
@elseif(\Auth()->user()->isManager() || \Auth()->user()->isEmployee())
<div id="allUsersNotAdmin" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
@else
<div id="allUsersAgents" users='{{ $users }}'></div>
@endif
<script src="js/app.js"></script>
@endsection
