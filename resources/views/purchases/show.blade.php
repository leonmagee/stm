@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Purchase | {{ $purchase->created_at->format('m/d/Y') }}</h3>

    <div>
      <label class="label">Company</label>
      <span>{{ $purchase->user->company }}</span>
    </div>
    <br />
    <div>
      <label class="label">User</label>
      <span>{{ $purchase->user->name }}</span>
    </div>
    <br />
    <div>
      <label class="label">Total</label>
      <span>${{ number_format($purchase->total, 2) }}</span>
    </div>
    <br />
    @foreach($purchase->products as $product)
    <div>
      <label class="label">Product</label>
      <span>{{ $product->product_id }} - {{ $product->name }}</span>
    </div>
    <br />
    @endforeach

  </div>
</div>

@endsection
