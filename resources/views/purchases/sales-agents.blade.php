@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Agent Sales</h3>

    <div class="agent-sales">

      @foreach($agents as $agent)
      <div class="agent-sales__item"><a
          href="/sales-agents/{{ $agent->id }}">{{ $agent->company . ' - ' . $agent->name }}</a></div>
      @endforeach
    </div>

  </div>
</div>


@endsection
