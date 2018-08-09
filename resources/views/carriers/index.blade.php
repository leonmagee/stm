@extends('layouts.layout')

@section('title')
Carriers
@endsection

@section('content')
    
    @foreach( $carriers as $carrier )

        <div>
            <a href="/carriers/{{ $carrier->id }}">{{ $carrier->name }}</a>
        </div>

    @endforeach

@endsection

