@extends('layouts.layout')

@section('content')
@if(\Auth()->user()->isAdmin())
<div id="allUsers" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
@elseif(\Auth()->user()->isManager() || \Auth()->user()->isEmployee())
<div id="allUsersNotAdmin" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
@else
<div id="allUsersAgents" users='{{ $users }}'></div>
@endif
@endsection
