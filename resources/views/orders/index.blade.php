@extends('layouts.layout')

@section('title')
Orders
@endsection

@section('content')

<div class="stm-grid-wrap notes-wrap">

  @if(!$orders->count())
  <div>No current orders.</div>
  @endif
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
    <div class="flex-item notes-icon-wrap border-left">
      <i class="fas fa-times-circle delete-icon modal-delete-open" order_id={{ $order->id }}></i>
    </div>

  </div>

  <div class="modal" id="delete-order-modal-{{ $order->id }}">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        <h3 class="title">Are You Sure?</h3>

        <a href="/delete-order/{{ $order->id }}" class="button is-danger">Delete Order</a>
        <a class="modal-delete-close-button button is-primary" order_id={{ $order->id }}>Cancel</a>
      </div>

    </div>

    <button class="modal-delete-close is-large" aria-label="close" order_id={{ $order->id }}></button>

  </div>

  @endforeach

</div>

@endsection
