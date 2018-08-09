@extends('layouts.layout')

@section('title')
Carrier
@endsection

@section('content')

    <div>
        {{ $carrier->name }}
    </div>

@endsection

