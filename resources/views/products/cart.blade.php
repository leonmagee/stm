@extends('layouts.layout-no-wrap')

@section('content')

<div class="cart-wrapper">
  <div class="cart-wrapper-left cart-wrapper-inner">
    <h3>Shopping Cart <i class="fas fa-cart-plus"></i></h3>

    <div class="stm-cart">
      <div class="notification is-success" id="payment-complete-notification">

        <button class="delete"></button>

        Your purchase is complete. You will receive an email with purchase details.

      </div>

      @if(count($items))

      <div class="stm-cart__item stm-cart__item--header">
        <div class="stm-cart__item--product">Product</div>
        <div class="stm-cart__item--variation">Variation</div>
        <div class="stm-cart__item--quantity">Quantity</div>
        <div class="stm-cart__item--available">Available</div>
        <div class="stm-cart__item--subtotal">Subtotal</div>
        <div class="stm-cart__item--discount">Discount</div>
        <div class="stm-cart__item--total">Total</div>
        <div class="stm-cart__item--delete"></div>
      </div>
      @foreach($items as $item)
      <form class="stm-cart__form" method="POST" action="update-cart-item/{{ $item->id }}">
        @csrf
        <div class="stm-cart__item stm-cart__item--body">
          <div class="stm-cart__item--product">
            <a class="stm-cart__item--product---thumbnail" href="/products/{{ $item->product->id }}">
              <img src="{{ $item->product->get_cloudinary_thumbnail(200, 200) }}" />
            </a>
            <a href="/products/{{ $item->product->id }}">{{ $item->product->name }}</a>
          </div>
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
            <input class="input quantity-input" min="0" type="number" name="quantity" value={{ $item->quantity }} />
          </div>
          <div class="stm-cart__item--available">{{ $item->color_quantity($item->product->id, $item->variation) }}</div>
          <div class="stm-cart__item--subtotal">${{ number_format($item->product->cost * $item->quantity, 2) }}</div>
          <div class="stm-cart__item--discount">{{ $item->product->discount ? $item->product->discount . '%' : ''  }}
          </div>
          <?php $after_discount = ($item->product->discount_cost() * $item->quantity); ?>
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
        <div class="stm-cart__item--available"></div>
        <div class="stm-cart__item--subtotal"></div>
        <div class="stm-cart__item--discount"></div>
        <div class="stm-cart__item--total"><span>${{ $total }}</span></div>
        <div class="stm-cart__item--delete"></div>
      </div>
      @else
      <div class="stm-cart-empty">
        Your cart is empty.
      </div>
      @endif

    </div>

  </div>

  <div class="cart-wrapper-right cart-wrapper-inner">
    <h3>Checkout <i class="far fa-credit-card"></i></h3>
    <div class="stm-cart-footer">
      @if(count($items))
      <div id="paypal-button-container"></div>
      <a class="button custom-button stm-credit" href="/stm-credit">Pay with STM Credit</a>
      @endif
      <a class="button custom-button continue-shopping" href="/products">Continue Shopping</a>
    </div>
  </div>
</div>

@endsection

@section('page-script')
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>

@if(count($items))
<script>
  paypal.Buttons({
    style: {
      //layout: 'horizontal',
      // color: 'blue',
      // shape: 'pill',
      label: 'buynow',
      //tagline: false, // only applies to horizontal layout
    },
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
        amount: {
          currency_code: "USD",
          value: parseFloat("{{ $paypal_total }}"),
          breakdown: {
            item_total: {
              currency_code: "USD",
              value: parseFloat("{{ $paypal_total }}"),
            }
          }
        },
        items: [
            @foreach($items as $item)
            {
            name: "{{ $item->product->name }} | {{ $item->variation }}",
            unit_amount: {
              currency_code: "USD",
              value: parseFloat("{{ $item->product->discount_cost() }}"),
            },
            quantity: "{{ $item->quantity }}"
            },
            @endforeach
            {
              name: "Service Charge (2%)",
              unit_amount: {
                currency_code: "USD",
                value: parseFloat("{{ $service_charge }}"),
              },
              quantity: "1"
            },
          ]
        }
      ],
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
        axios.post('/process-paypal', {
          total: "{{ $paypal_total }}",
        }).then(function(res) {
          $('#payment-complete-notification').show();
          //console.log('capture in cart', res);
          //return res.id;
          // dispaly success message
        });
    });
  }
  }).render('#paypal-button-container');
</script>
@endif
@endsection
