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
            <span class="primary">{{ $item['sim_number'] }}</span>
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



