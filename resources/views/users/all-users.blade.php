@extends('layouts.layout')

@section('title')
All Users
@endsection

@section('content')
    <div id="allUsers" users='{{ $users }}' sites='{{ $sites }}' current='{{ $current }}'></div>
    <script src="js/app.js"></script>
@endsection

