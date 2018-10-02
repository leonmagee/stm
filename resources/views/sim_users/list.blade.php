@extends('layouts.layout')

@section('title')
Sim Results
@endsection

@section('content')

<div class="sims-list">
    
<ul>
    @foreach( $list_array as $item )

    <li>
        <div class="sim-user-details">

            <span class="primary">
                <a href="/user-sims/{{ $item['id'] }}">{{ $item['sim_number'] }}</a>
            </span>
            <sep>/</sep>
            <span>{{ $item['carrier'] }}</span>
            <sep>/</sep>
            <span class="user">{{ $item['user'] }}</span>

        </div>

        @if($item['spiff'])

            <div class="sim-details">
                Spiff Details
                <div>Value: ${{ $item['value'] }}</div>
            </div>

        @endif
       
        @if($item['residual'])

            <div class="sim-details">
                Residual Details
            </div>

        @endif



    </li>

    @endforeach
</ul>

</div>



@endsection



