@extends('layouts.layout-no-wrap')

@section('content')

<div class="cart-wrapper">
  <div class="cart-wrapper-left cart-wrapper-inner">
    <h3 class="cart-h3">Shopping Cart <i class="fas fa-cart-plus"></i></h3>
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
            <div class="stm-cart__item--name">
              <a href="/products/{{ $item->product->id }}">{{ $item->product->name }}</a>
              <a class="save-for-later" href="/save-for-later/{{ $item->product->id }}/{{ $item->id }}">(Move to Wish
                List)</a>
            </div>
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
        <div class="stm-cart__item--total"></div>
        <div class="stm-cart__item--delete"></div>
      </div>

      <div class="apply-coupon">
        @if(!$coupon)
        <form method="POST" action="/apply-coupon">
          @csrf
          <div class="apply-coupon-form">
            <input type="text" class="input" name="coupon_code" placeholder="Coupon Code..." />
            <button type="submit" class="button is-primary">Apply Coupon</button>
          </div>
        </form>
        @endif
        @if($coupon)
        <form method="POST" action="/delete-cart-coupon/{{ $cart_coupon->id }}">
          @csrf
          <div class="apply-coupon-form">
            <span class="current-coupon">
              Coupon Applied: {{ $coupon->code }} - {{ $coupon->percent }}% Off
            </span>
            <button type="submit" class="button is-danger">Remove Coupon</button>
          </div>
        </form>
        @endif
      </div>

      <div class="cart-wrapper__notification">
        <div class="free-shipping-alert">
          {{-- <div class="icon-wrap"><i class="fas fa-shipping-fast"></i></div> --}}
          <div class="image-wrap"><img src="{{ asset('img/free-shipping-small.png') }}" /></div>
          <div class="text-wrap">
            <div class="line-1">Free shipping on all orders above ${{ $shipping_max}}.</div>
            <div class="line-2">A <span>${{ $shipping_default }}</span> shipping charge will be applied for all orders
              under
              ${{ $shipping_max }}.
            </div>
            <div class="line-3">
              Returning or exchanging undamaged or undefective phones are subject to 20% restocking fee.
            </div>
          </div>
        </div>
      </div>
      @else
      <div class="stm-cart-empty">
        Your cart is empty.
      </div>
      @endif
    </div>

    {{-- Wish List Section --}}
    <div class="saved-favorites">
      <h3 class="wish-list cart-h3">Wish List <i class="far fa-list-alt"></i></h3>
      @if($fav_products->isEmpty())
      <div class="saved-favorites__no-items">
        You have no products in your Wish List.
      </div>
      @endif
      @foreach($fav_products as $item)
      @include('products.fav-saved', ['item' => $item, 'link' => 'Remove', 'link_path' => 'remove-favorite'])
      @endforeach
    </div>
    {{-- @endif --}}
  </div>
  <div class="cart-wrapper-right cart-wrapper-inner">
    <h3 class="cart-h3">Checkout <i class="far fa-credit-card"></i></h3>
    <div class="stm-cart-footer">
      @if(count($items))
      <div class="stm-total-wrap">
        @if($shipping_charge || $coupon || $store_credit)
        <div class="item"><span class="">Subtotal:</span><span class="">${{ number_format($subtotal, 2) }}</span>
        </div>
        @endif
        @if($shipping_charge)
        <div class="item"><span class="">Shipping:</span><span
            class="red">${{ number_format($shipping_charge, 2) }}</span>
        </div>
        @endif
        @if($coupon_discount)
        <div class="item"><span class="">Coupon:</span><span
            class="green">-${{ number_format($coupon_discount, 2) }}</span>
        </div>
        @endif
        @if($store_credit)
        <div class="item"><span class="">Store Credit:</span><span
            class="green">-${{ number_format($store_credit, 2) }}</span>
        </div>
        @endif
        <div class="item total"><span class="">Total Due:</span><span class="">${{ number_format($total, 2) }}</span>
        </div>
      </div>
      @if($covered_by_credit)
      <a class="button custom-button stm-credit modal-open-2">
        <img src="{{ URL::asset('img/stm_logo_short.png') }}" />
        <span class="small">
          Pay With Store Credit
        </span>
      </a>
      @else
      <a class="button custom-button stm-credit modal-open">
        <img src="{{ URL::asset('img/stm_logo_short.png') }}" />
        <span>
          Pay With Balance
        </span>
      </a>
      <div id="paypal-button-container"></div>
      <a class="button custom-button behalf">
        <img src="{{ URL::asset('img/behalf.svg') }}" />
        <span>
          Pay With Behalf
        </span>
      </a>
      @endif
      @endif
      <a class="button custom-button continue-shopping" href="/">Continue Shopping</a>
    </div>
  </div>
</div>

@endsection

@if(!$covered_by_credit)
@section('page-script')
@if(count($items))
<script src="https://sdk.demo.behalf.com/sdk/v4/behalf_payment_sdk.js" async></script>
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>
<script>
  let breakdown_obj = {
    item_total: {
      currency_code: "USD",
      value: parseFloat("{{ $paypal_total_item }}"),
    }
  };
  if("{{ $paypal_discount }}") {
    breakdown_obj.discount = {
      currency_code: "USD",
      value: parseFloat("{{ $paypal_discount }}"),
    }
  };

  paypal.Buttons({
    style: {
      label: 'buynow',
    },
    createOrder: function(data, actions) {
      return actions.order.create({
        application_context: {
          shipping_preference: 'NO_SHIPPING'
        },
        purchase_units: [{
        amount: {
          currency_code: "USD",
          value: parseFloat("{{ $paypal_total }}"),
          breakdown: breakdown_obj
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
            // {
            //   name: "Store Credit",
            //   unit_amount: {
            //   currency_code: "USD",
            //   value: parseFloat("{{ $store_credit }}"),
            //   },
            //   quantity: "1"
            //   },
          ]
        }
      ],
    });
  },
  onApprove: function(data, actions) {
    $('.stm-absolute-wrap#loader-wrap').css({ display: 'flex' });
    // console.log('two', data, actions, 'payer?', data.payer, data.payerID, data.orderID, data.payerAddress, data.payments, data.transactions);
    return actions.order.capture().then(function(details) {
        axios.post('/process-paypal', {
          sub_total: "{{ $subtotal }}",
          discount: "{{ $coupon_discount }}",
          store_credit: "{{ $store_credit }}",
          total: "{{ $paypal_total }}",
          type: 'paypal',
          //testers: true,
        }).then(function(res) {
          // redirect to purchase complete page
          window.location.href = "/purchase-complete";
          //return res.id;
        });
    });
  }
  }).render('#paypal-button-container');
</script>
<script>
  var config = {
  "clientToken" : "<clientToken>",
    "showPromo" : true,
    "callToAction" : {
    "workflow" : "noredirect",
    "text" : "In order to enjoy these terms, pay with Behalf on your upcoming order."
    }
    };

    BehalfPayment.init(config);
</script>
@endif
@endsection
@endif

@section('modal')
<h3 class="title">Pay with balance</h3>
<form method="POST" action="pay-with-balance">
  @csrf
  <input type="hidden" value="{{ $coupon_discount }}" name="discount" />
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

@section('modal-2')
<h3 class="title">Pay with Store Credit</h3>
<form method="POST" action="pay-with-store-credit">
  @csrf
  <input type="hidden" value="{{ $coupon_discount }}" name="discount" />
  <div class="pay-with-balance-modal">
    Total Credit to Use: <span>${{ number_format($store_credit, 2) }}</span><br />
  </div>
  @if(!$sufficient) <div class="pay-with-balance-warning">
    Your balance is currently too low to make this purchase.
  </div>
  @else
  <button type="submit" class="button is-danger call-loader">Pay Now with Store Credit</button>
  @endif
  <a href="#" class="modal-close-button button is-primary">Cancel</a>
</form>
@endsection
