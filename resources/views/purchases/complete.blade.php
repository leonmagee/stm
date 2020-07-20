@extends('layouts.layout')

@section('content')
<h3 class="title">Your purchase is complete!</h3>
<div class="purchase-complete">
  <div class="purchase-complete__body">
    You will receive an email with details.
  </div>
  <div class="purchase-complete__footer">
    <a href="products" class="button is-primary">Continue Shopping</a>
  </div>
</div>
@endsection
