@extends('layouts.layout')

@section('title')
Orders
@endsection

@section('content')

    <div class="stm-grid-wrap notes-wrap">

	    @foreach( $orders as $order )

	        <div class="single-grid-item note-wrap">

            <div class="flex-item notes-icon-wrap">
              <i class="fas fa-truck"></i>
            </div>

            <div class="flex-item note-text">
              @if(isset($order->user))
              <div>
                <span><a href="/users/{{ $order->user_id }}">{{ $order->user->company }} - {{ $order->user->name }}</a></span>
              </div>
              @endif
              <div>
                <span>Number Sims Ordered: {{ number_format($order->sims) }} {{ $order->carrier->name }}</span>
              </div>

            </div>
            <div class="flex-item note-end">
              <div>
                <span>{{ $order->created_at->format('m/d/Y') }}</span>
              </div>
            </div>

	        </div>

	    @endforeach

    </div>

@endsection
