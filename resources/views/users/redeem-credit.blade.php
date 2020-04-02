@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner half">

    <h3>Redeem All Credit</h3>

    <div class="redeem-credit-wrap"></div>

    <div class="form-wrap redeem-credit">

      <div class="balance">
        Your Current Credit: <span>${{ number_format($user->balance, 2) }}</span>
      </div>
      <label class="label">Choose Payout Method</label>
      <div class="credit-redeem-choices">
        <div class="item paypal" name="paypal">
          <img src="{{ URL::asset('img/paypal.jpg') }}" />
        </div>
        <div class="item zelle" name="zelle">
          <img src="{{ URL::asset('img/zelle.jpg') }}" />
        </div>
        <div class="item venmo" name="venmo">
          <img src="{{ URL::asset('img/venmo.jpg') }}" />
        </div>
        <div class="item cash-app" name="cash-app">
          <img src="{{ URL::asset('img/cash-app.jpg') }}" />
        </div>
        <div class="item h2o" name="h2o-direct-portal">
          <img src="{{ URL::asset('img/h2o.jpg') }}" />
        </div>
        <div class="item lyca" name="lyca-direct-portal">
          <img src="{{ URL::asset('img/lyca.jpg') }}" />
        </div>
        <div class="item gs-posa" name="gs-posa-portal">
          <img src="{{ URL::asset('img/gs-posa.jpg') }}" />
        </div>
      </div>

      <input type="hidden" id="hidden-user-balance" value="{{ $user->balance }}" />
      <div class="field">
        <label class="label" for="account">Account ID, Email Address, or Phone Number</label>
        <div class="control">
          <input class="input" type="text" id="account_entry" name="account_entry" />
        </div>
      </div>


      <div class="field">
        <div class="control">
          <a href="#" class="redeem-credit-modal button is-primary">Submit</a>
        </div>
      </div>

    </div>


  </div>

</div>

@endsection

@section('modal')

<form method="POST" id="redeem-credit" action="/redeem-credit">

  <div class="form-wrap redeem-credit">

    {{ csrf_field() }}

    <input type="hidden" id="type" name="type" />
    <input type="hidden" id="account" name="account" />
    <input type="hidden" id="user_id" name="user_id" value={{ $user->id }} />
    <div class="modal-account-details">
      <div class="item credit-to-redeem">Credit to Redeem: <span>${{ number_format($user->balance, 2) }}</span></div>
      <div class="item modal-payment-type">Payment Type Selected: <span></span></div>
      <div class="item modal-account-id">Account Identifier: <span></span></div>
      <div class="warning-info">
        <h2>Important</h2>
        <p>Please make sure you input the correct information before submitting your request. We are not responsible if
          any information was input incorrectly.</p>
      </div>
    </div>
    <div class="field">
      <div class="control">
        <button class="button is-primary call-loader" type="submit">Finalize Transaction</button>
        <a class="button is-danger modal-close-button">Cancel</a>
      </div>
    </div>

  </div>

</form>

@endsection
