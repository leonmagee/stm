@extends('layouts.layout')

@section('title')
One Sim User
@endsection

@section('content')

    {{ $sim->sim_number }} - {{ $sim->user->name }}

@endsection