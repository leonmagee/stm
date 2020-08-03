@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Purchase Order</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Purchase Order #</div>
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">Name</div>
          <div class="stm_inv__header--label">Purchase Date</div>
          <div class="stm_inv__header--label">Status</div>
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item purchase-id">GSW-{{ $purchase->id }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->company }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->name }}</div>
          <div class="stm_inv__header--item">{{ $purchase->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $purchase->status }}">
            {{ \App\Helpers::purchase_status($purchase->status) }}
          </div>
        </div>
      </div>


      <div class="stm_inv__items">
        <div class="stm_inv__flex">
          <div class="stm_inv__item--label stm_inv__flex--60">Product Name</div>
          <div class="stm_inv__item--label">Color</div>
          <div class="stm_inv__item--label">Unit Price</div>
          <div class="stm_inv__item--label">Quantity</div>
          <div class="stm_inv__item--label">Subtotal</div>
          <div class="stm_inv__item--label">Discount</div>
          <div class="stm_inv__item--label">Item Total</div>
        </div>

        @foreach($purchase->products as $product)
        <div class="stm_inv__flex stm_inv__flex-{{ $product->id }}">
          <div class="stm_inv__item--item stm_inv__flex--60">{{ $product->name }}</div>
          <div class="stm_inv__item--item">{{ $product->variation }}</div>
          <div class="stm_inv__item--item ">${{ number_format($product->unit_cost, 2) }}</div>
          <div class="stm_inv__item--item">{{ $product->quantity }}</div>
          <div class="stm_inv__item--item">${{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
          <div class="stm_inv__item--item">{{ $product->discount ? $product->discount . '%' : '' }}</div>
          <div class="stm_inv__item--item">${{ number_format($product->final_cost, 2) }}</div>
        </div>
        @endforeach
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Payment Type</div>
          <div class="stm_inv__header--label">Subtotal</div>
          <div class="stm_inv__header--label">Service Charge</div>
          <div class="stm_inv__header--label">Total</div>
        </div>
        <div class="stm_inv__flex">
          <?php $type = strtoupper($purchase->type); ?>
          <div class="stm_inv__header--item">{{ $type }}</div>
          <div class="stm_inv__header--item">${{ number_format($purchase->sub_total, 2) }}</div>
          <div class="stm_inv__header--item">
            @if($type == 'PAYPAL')
            ${{ number_format($purchase->sub_total * 2 / 100, 2) }}
            @else
            $0.00
            @endif
          </div>
          <div class="stm_inv__header--item">${{ number_format($purchase->total, 2) }}</div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label stm_inv__flex--30">Shipping Address</div>
          <div class="stm_inv__header--label">City</div>
          <div class="stm_inv__header--label">State</div>
          <div class="stm_inv__header--label">Zip</div>
          <div class="stm_inv__header--label">Tracking Number</div>
          <div class="stm_inv__header--label">Shipping Service</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item stm_inv__flex--30">{{ $purchase->user->address  }}
          </div>
          <div class="stm_inv__header--item">{{ $purchase->user->city }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->state }}</div>
          <div class="stm_inv__header--item">{{ $purchase->user->zip }}</div>
          <div class="stm_inv__header--item">{{ $purchase->tracking_number }}</div>
          <div class="stm_inv__header--item">{{ $purchase->shipping_type }}</div>
        </div>
      </div>

      @if((\Auth::user()->isAdmin()))
      <div class="stm_inv__flex--forms">
        <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-tracking">
          <form method="POST" action="/update-shipping-info">
            @csrf
            <div class="stm_inv__form--flex">
              <input type="hidden" name="purchase_id" value="{{ $purchase->id }}" />
              <div class="field description">
                <label class="label" for="description">Tracking Number</label>
                <div class="control">
                  <input class="input" type="text" id="tracking_number" name="tracking_number"
                    value="{{ $purchase->tracking_number }}" required />
                </div>
              </div>
              <div class="field flex-20">
                <label class="label" for="status">Shipping Type</label>
                <div class="select">
                  <select name="shipping_type" id="shipping_type">
                    <option value="USPS" @if($purchase->shipping_type == "USPS") selected @endif>USPS</option>
                    <option value="UPS" @if($purchase->shipping_type == "UPS") selected @endif>UPS</option>
                    <option value="FEDEX" @if($purchase->shipping_type == "FEDEX") selected @endif>FEDEX</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="field flex-margin margin-top-1">
              <div class="control">
                {{-- <button class="button is-primary call-loader" type="submit">Ship Purchase Order</button> --}}
                <a href="#" class="modal-open button is-primary">Ship Purchase Order</a>
              </div>
            </div>
            <div class="modal" id="layout-modal">

              <div class="modal-background"></div>

              <div class="modal-content">

                <div class="modal-box">

                  <h3 class="title">Are You Sure?</h3>
                  <div class="invoice-modal-flex">
                    <div class="field">
                      <label class="label" for="cc_user_1">BCC User</label>
                      <div class="control">
                        <div class="select">
                          <select name="cc_user_1" id="cc_user_1">
                            <option value="0">---</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <label class="label" for="cc_user_2">BCC Email Address</label>
                      <div class="control">
                        <input class="input" type="email" name="cc_user_2" id="cc_user_2" placeholder="Email Address" />
                      </div>
                    </div>
                  </div>
                  <button class="button is-danger call-loader" type="submit">Ship Purchase Order</button>
                  <a href="#" class="modal-close-button button is-primary">Cancel</a>
          </form>

        </div>

      </div>

      <button class="modal-close is-large" aria-label="close"></button>

    </div>

    </form>
  </div>
  <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-status">
    <form method="POST" action="/update-purchase-status">
      @csrf
      <div class="stm_inv__forms-no-flex">
        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}" />
        <div class="field">
          <label class="label" for="status">Status</label>
          <div class="select">
            <select name="status" id="status">
              <option value="2" @if($purchase->status == 2) selected @endif>Pending</option>
              <option value="3" @if($purchase->status == 3) selected @endif>Shipped</option>
              <option value="4" @if($purchase->status == 4) selected @endif>Cancelled</option>
            </select>
          </div>
        </div>
        <div class="field flex-margin margin-top-1">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Update</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endif


</div>
</div>

</div>

@endsection
