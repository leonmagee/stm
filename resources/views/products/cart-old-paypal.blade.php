@extends('layouts.layout-no-wrap')

@section('content')

<div class="cart-wrapper">
  <div class="cart-wrapper-left cart-wrapper-inner">
    <h3>Shopping Cart <i class="fas fa-cart-plus"></i></h3>

    <div class="stm-cart">

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
      <div id="paypal-button-container" amount="777" name="Hector"></div>
      @endif
      <a class="button continue-shopping" href="/products">Continue Shopping</a>
    </div>
  </div>
</div>

@endsection

@section('page-script')
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}">
</script>

@if(count($items))
<script>
  paypal.Buttons({
  style: {
    // layout: 'vertical',
    // color: 'blue',
    // shape: 'pill',
    // label: 'paypal'
    },
  createOrder: function(data, actions) {
    console.log('my data', data);
  // This function sets up the details of the transaction, including the amount and line item details.
  /**
  * @todo Add line items here...
  **/
 //purchase_units[].amount.breakdown.item_total
  return actions.order.create({
  purchase_units: [{
  description: 'here is a description...',
  amount: {
  currency_code: "USD",
  value: "{{ $total }}",
  breakdown: {
    item_total: {
      currency_code: "USD",
      value: "{{ $total }}",
    }
  }
  },
  //paypal_instruction: 'sldfjldfjdf',
  items: [
    @foreach($items as $item)
    {
    name: "{{ $item->product->name }} | {{ $item->variation }}",
    unit_amount: {
      currency_code: "USD",
      value: "{{ $item->product->discount_cost() }}",
    },
    quantity: "{{ $item->quantity }}"
    },
    @endforeach
    ]
  }
],
// purchase_units  > amount > breakdown > item_total
// purchase_units: [
// {
// // "reference_id": "PUHF",
// // "description": "Sporting Goods",
// // "custom_id": "CUST-HighFashions",
// // "soft_descriptor": "HighFashions",
// amount: {
// currency_code: "USD",
// value: 180,
// breakdown: {
// item_total: {
// currency_code: "USD",
// value: 180
// },
// // "shipping": {
// // "currency_code": "USD",
// // "value": "30.00"
// // },
// // "handling": {
// // "currency_code": "USD",
// // "value": "10.00"
// // },
// // "tax_total": {
// // "currency_code": "USD",
// // "value": "20.00"
// // },
// // "shipping_discount": {
// // "currency_code": "USD",
// // "value": "10"
// // }
// }
// },
// "items": [
// {
// name: "T-Shirt",
// description: "Green XL",
// //sku: "sku01",
// unit_amount: {
// currency_code: "USD",
// value: 90
// },
// // "tax": {
// // "currency_code": "USD",
// // "value": "10.00"
// // },
// quantity: 1,
// category: "PHYSICAL_GOODS"
// },
// {
// name: "Shoes",
// description: "Running, Size 10.5",
// //sku: "sku02",
// unit_amount: {
// currency_code: "USD",
// value: 45
// },
// // "tax": {
// // "currency_code": "USD",
// // "value": "5.00"
// // },
// quantity: 2,
// category: "PHYSICAL_GOODS"
// }
// ],
// // "shipping": {
// // "method": "United States Postal Service",
// // "address": {
// // "name": {
// // "full_name":"John",
// // "surname":"Doe"
// // },
// // "address_line_1": "123 Townsend St",
// // "address_line_2": "Floor 6",
// // "admin_area_2": "San Francisco",
// // "admin_area_1": "CA",
// // "postal_code": "94107",
// // "country_code": "US"
// // }
// // }
// }
// ]
  });
  },
  onApprove: function(data, actions) {
    // This function captures the funds from the transaction.

    return actions.order.capture().then(function(details) {
    // This function shows a transaction success message to your buyer.
        // axios.post('/api/process-paypal/1').then(function(res) {
        //   console.log('capture in cart', res);
        //   return res.id;
        // });

        axios.post('/process-paypal', {
          total: "{{ $total }}",
        }).then(function(res) {
          console.log('capture in cart', res);
          return res.id;
        });

      //alert('Transaction completed by ' + details.payer.name.given_name);
      console.log(details);
    });
  }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>
@endif
@endsection
