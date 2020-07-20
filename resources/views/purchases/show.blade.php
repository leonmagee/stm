@extends('layouts.layout')

@section('content')

<div class="form-wrapper">
  <div class="form-wrapper-inner">
    <h3>Purchase Order</h3>
    <div class="purchase">
      <div class="purchase__row purchase__row--header">
        <div class="purchase_item">Purchase ID</div>
        <div class="purchase_item">Company</div>
        <div class="purchase_item">Name</div>
        <div class="purchase_item">Total</div>
        <div class="purchase_item">Date</div>
      </div>
      <div class="purchase__row purchase__row--body">
        <div class="purchase_item">{{ $purchase->id }}</div>
        <div class="purchase_item">{{ $purchase->user->company }}</div>
        <div class="purchase_item">{{ $purchase->user->name }}</div>
        <div class="purchase_item">${{ number_format($purchase->total, 2) }}</div>
        <div class="purchase_item">{{ $purchase->created_at->format('m/d/Y') }}</div>
      </div>
    </div>
    <div class="purchase">
      <div class="purchase__row purchase__row--header">
        <div class="purchase_item">Product ID</div>
        <div class="purchase_item purchase_item--product_name">Product Name</div>
        <div class="purchase_item">Color</div>
        <div class="purchase_item">Unit Cost</div>
        <div class="purchase_item">Quantity</div>
        <div class="purchase_item">Subtotal</div>
        <div class="purchase_item">Discount</div>
        <div class="purchase_item">Item Total</div>
      </div>
      @foreach($purchase->products as $product)
      <div class="purchase__row purchase__row--body">
        <div class="purchase_item">{{ $product->product_id }}</div>
        <div class="purchase_item purchase_item--product_name"><a
            href="/products/{{ $product->product_id }}">{{ $product->name }}</a></div>
        <div class=" purchase_item">{{ $product->variation }}</div>
        <div class="purchase_item">${{ number_format($product->unit_cost, 2) }}</div>
        <div class="purchase_item">{{ $product->quantity }}</div>
        <div class="purchase_item">{{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
        <div class="purchase_item">{{ $product->discount ? $product->discount . '%' : '' }}</div>
        <div class="purchase_item">${{ number_format($product->final_cost, 2) }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
