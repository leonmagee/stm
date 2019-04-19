@extends('layouts.layout')

@section('title')
All Users
@endsection

@section('content')
    <div id="allUsers" users='{{ $users }}'></div>
    <script src="js/app.js"></script>
@endsection

