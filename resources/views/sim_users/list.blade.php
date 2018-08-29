@extends('layouts.layout')

@section('title')
Sim Results
@endsection

@section('content')

<div class="sims-list">
    
<ul>
    @foreach( $list_array as $item )

    <li>
        <div class="section-1">
            <span class="primary"><a href="/user-sims/{{ $item['id'] }}">{{ $item['sim_number'] }}</a></span>
            <sep>/</sep>
            <span>{{ $item['carrier'] }}</span>
            <sep>/</sep>
            <span>{{ $item['user'] }}</span>
        </div>
    </li>

    @endforeach
</ul>

</div>



@endsection



