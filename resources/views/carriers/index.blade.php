@extends('layouts.layout')

@section('content')

    <h1 class='title'>Carriers</h1>
    
    @foreach( $carriers as $carrier )

        <div>
            <a href="/carriers/{{ $carrier->id }}">{{ $carrier->name }}</a>
        </div>

    @endforeach

@endsection

