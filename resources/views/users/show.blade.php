@extends('layouts.layout')

@section('content')

    <h1 class='title'>User</h1>

        <div>{{ $user->name }}</div>
        <div>{{ $user->company}}</div>
        <div>{{ $user->phone }}</div>
        <div>{{ $user->address }}</div>
        <div>{{ $user->city }}</div>
        <div>{{ $user->state }}</div>
        <div>{{ $user->zip }}</div>

@endsection

