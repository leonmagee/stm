@extends('layouts.layout')

@section('content')

<div class="form-wrapper">
  <div class="form-wrapper-inner">
    <h3>Shopping Cart <i class="fas fa-cart-plus"></i></h3>

    <div class="stm-cart">

      @if(count($items))

      <div class="stm-cart__item stm-cart__item--header">
        <div class="stm-cart__item--product">Product</div>
        <div class="stm-cart__item--variation">Variation</div>
        <div class="stm-cart__item--quantity">Quantity</div>
        <div class="stm-cart__item--subtotal">Subtotal</div>
        <div class="stm-cart__item--discount">Discount</div>
        <div class="stm-cart__item--total">Total</div>
        <div class="stm-cart__item--delete"></div>
      </div>
      <?php $total = 0 ?>
      @foreach($items as $item)
      <form class="stm-cart__form" method="POST" action="update-cart-item/{{ $item->id }}">
        @csrf
        <div class="stm-cart__item stm-cart__item--body">
          <div class="stm-cart__item--product">{{ $item->product->name }}</div>
          <div class="stm-cart__item--variation">
            @if(count(($item->product->variations)))
            <div class="select">
              <select name="variation" class="variation-select">
                @foreach($item->product->variations as $variation)
                <option @if($item->variation == $variation->text) selected @endif
                  value={{ $variation->text }}>{{ $variation->text }}</option>
                @endforeach
              </select>
            </div>
            @endif
          </div>
          <div class="stm-cart__item--quantity">
            <input class="input quantity-input" type="number" name="quantity" value={{ $item->quantity }} />
          </div>
          <div class="stm-cart__item--subtotal">${{ number_format($item->product->cost * $item->quantity, 2) }}</div>
          <div class="stm-cart__item--discount">{{ $item->product->discount }}%</div>
          <?php $after_discount = ($item->product->cost * ((100 - $item->product->discount)/100) * $item->quantity); $total += $after_discount; ?>
          <div class="stm-cart__item--total">
            ${{ number_format($after_discount, 2) }}
          </div>
          <div class="stm-cart__item--delete"><a class="modal-delete-open" item_id={{ $item->id }}><i
                class="fas fa-minus-circle"></i></a></div>
        </div>
      </form>


      <div class="modal" id="delete-item-modal-{{ $item->id }}">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h4 class="title">Are You Sure?</h4>

            <a href="/delete-cart-item/{{ $item->id }}" class="button is-danger">Delete Item</a>
            <a class="modal-delete-close-button button is-primary" item_id={{ $item->id }}>Cancel</a>
          </div>

        </div>

        <button class="modal-delete-close is-large" aria-label="close" item_id={{ $item->id }}></button>

      </div>

      @endforeach
      <div class="stm-cart__item stm-cart__item--footer">
        <div class="stm-cart__item--product"></div>
        <div class="stm-cart__item--variation"></div>
        <div class="stm-cart__item--quantity"></div>
        <div class="stm-cart__item--subtotal"></div>
        <div class="stm-cart__item--discount"></div>
        <div class="stm-cart__item--total">${{ number_format($total, 2) }}</div>
        <div class="stm-cart__item--delete"></div>
      </div>
      @else
      <div class="stm-cart-empty">
        Your cart is empty.
      </div>
      @endif

    </div>

    <div class="stm-cart-footer">
      @if(count($items))
      <a class="button is-green checkout call-laoder" href="/checkout">Complete Purchase</a>
      @endif
      <a class="button is-primary checkout call-laoder margin-left" href="/products">Continue Shopping</a>
    </div>

  </div>
</div>

@endsection
