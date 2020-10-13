@extends('layouts.layout-no-wrap')

@section('content')

<div class="cart-wrapper">
  <div class="cart-wrapper-left cart-wrapper-inner">
    <h3>Shopping Cart <i class="fas fa-cart-plus"></i></h3>
    <div class="stm-cart">
      <div class="stm-cart__alerts">
        @include('layouts.alert')
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
      <?php $item->cart_variations(); ?>
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
            @if(count(($item->cart_variations())))
            <div class="select">
              <select name="variation" class="variation-select">
                @foreach($item->cart_variations() as $variation)
                <option @if($item->variation == $variation) selected @endif
                  value="{{ $variation }}">{{ $variation }}</option>
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
        {{-- <div class="stm-cart__item--total"><span>${{ $total }}</span>
      </div> --}}
      <div class="stm-cart__item--total"></div>
      <div class="stm-cart__item--delete"></div>
    </div>
    {{-- <div class="apply-coupon">
      <form action="">
        @csrf
        <input type="text" class="input" placeholder="Coupon Code..." />
        <button class="button is-primary">Apply Coupon</button>
      </form>
    </div> --}}
    <div class="cart-wrapper__notification">
      <div class="notification larger-text center is-danger">
        {{-- <button class="delete"></button> --}}
        Free shipping on all orders above ${{ $shipping_max}}. A ${{ $shipping_default }} shipping charge will be
        applied
        for all orders
        under
        ${{ $shipping_max }}.</div>
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
    @if($shipping_charge)
    <a class="button custom-button stm-total flex-vertical">
      <div><span class="text">Subtotal:</span><span class="total">${{ number_format($subtotal, 2) }}</span></div>
      <div><span class="text">Shipping:</span><span class="total">${{ number_format($shipping_charge, 2) }}</span></div>
      <div><span class="text">Total Due:</span><span class="total">${{ number_format($total, 2) }}</span></div>
    </a>
    @else
    <a class="button custom-button stm-total"><span class="text">Total Due:</span><span
        class="total">${{ number_format($total, 2) }}</span></a>
    @endif
    <a class="button custom-button stm-credit modal-open">
      <img src="{{ URL::asset('img/stm_logo_short.png') }}" />
      <span>
        Pay With Balance
      </span>
    </a>
    <div id="paypal-button-container"></div>
    @endif
    <a class="button custom-button continue-shopping" href="/">Continue Shopping</a>
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
      console.log('one', paypal, data, actions);
      //$('.stm-absolute-wrap#loader-wrap').css({ display: 'flex' });
      return actions.order.create({
        application_context: {
          shipping_preference: 'NO_SHIPPING'
        },
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
            {
              name: "Shipping Charge",
              unit_amount: {
              currency_code: "USD",
              value: parseFloat("{{ $shipping_charge }}"),
              },
              quantity: "1"
            },
          ]
        }
      ],
      // redirect_urls: {
      //   return_url: '/purchase-complete',
      //   cancel_url: '/purchase-complete',
      // },
    });
  },
  onApprove: function(data, actions) {
    $('.stm-absolute-wrap#loader-wrap').css({ display: 'flex' });
    console.log('two', data, actions, 'payer?', data.payer, data.payerID, data.orderID, data.payerAddress, data.payments, data.transactions);
    return actions.order.capture().then(function(details) {
        axios.post('/process-paypal', {
          sub_total: "{{ $subtotal }}",
          total: "{{ $paypal_total }}",
          type: 'paypal',
          //testers: true,
        }).then(function(res) {
          //console.log('res', res);
          //console.log('McDetails?', details, details.payer, details.payer.address);
          // redirect to purchase complete page
          window.location.href = "/purchase-complete";
          //return res.id;
        });
    });
  }
  }).render('#paypal-button-container');
</script>
@endif
@endsection

@section('modal')
<h3 class="title">Pay with balance</h3>
<form method="POST" action="pay-with-balance">
  @csrf
  <div class="pay-with-balance-modal">
    Total Charge: <span>${{ number_format($total, 2) }}</span><br />
    Your Current Balance: <span>${{ number_format($balance, 2) }}</span><br />
  </div>
  @if(!$sufficient) <div class="pay-with-balance-warning">
    Your balance is currently too low to make this purchase.
  </div>
  @else
  <button type="submit" class="button is-danger call-loader">Pay Now with Balance</button>
  @endif
  <a href="#" class="modal-close-button button is-primary">Cancel</a>
</form>
@endsection
