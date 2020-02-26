@extends('layouts.layout')

@section('title')
@if(\Auth()->user()->isAdmin() || \Auth()->user()->isManager() || \Auth()->user()->isEmployee())
<div class="with-background">
  All Agents / Dealers
</div>
{{-- @else
Your Dealers --}}
@endif
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
