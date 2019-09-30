@extends('layouts.layout')

@section('title')
All Agents / Dealers
@endsection

@section('content')
@if(\Auth()->user()->isAdmin())
<div id="allUsers" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
@else
<div id="allUsersNotAdmin" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
@endif
<script src="js/app.js"></script>
@endsection
