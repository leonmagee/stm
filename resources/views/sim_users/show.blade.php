@extends('layouts.layout')

@section('content')

    <h1 class="title">One Sim User</h1>

    {{ $sim->sim_number }} - {{ $sim->user->name }}

@endsection

