@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">IMEI Number</div>
          <div class="stm_inv__header--label">User</div>
          <div class="stm_inv__header--label">Model</div>
          <div class="stm_inv__header--label">Model Name</div>
          <div class="stm_inv__header--label">Search Date</div>
          <div class="stm_inv__header--label">Blacklist</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $imei->imei }}</div>
          <div class="stm_inv__header--item">{{ $imei->user->company }}</div>
          <div class="stm_inv__header--item">{{ $imei->model }}</div>
          <div class="stm_inv__header--item">{{ $imei->model_name }}</div>
          <div class="stm_inv__header--item">{{ $imei->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item">{{ $imei->blacklist }}</div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Manufacturer</div>
          <div class="stm_inv__header--label">Carrier</div>
          <div class="stm_inv__header--label">Price</div>
          <div class="stm_inv__header--label">Warranty</div>
          <div class="stm_inv__header--label">Warranty</div>
          <div class="stm_inv__header--label">Warranty</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $imei->manufacturer }}</div>
          <div class="stm_inv__header--item">{{ $imei->carrier }}</div>
          <div class="stm_inv__header--item">${{ number_format($imei->price, 2) }}</div>
          <div class="stm_inv__header--item">{{ $imei->model_name }}</div>
          <div class="stm_inv__header--item">{{ $imei->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item">{{ $imei->blacklist }}</div>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection

{{-- @section('modal')

<h3 class="title">Are You Sure?</h3>

<form action="/invoice/finalize/{{ $invoice->id }}" method="POST" class="stm_imv__finalize">
@csrf
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
    <label class="label" for="cc_user_2">BCC Another User</label>
    <div class="control">
      <input class="input" type="email" name="cc_user_2" id="cc_user_2" placeholder="Email Address" />
    </div>
  </div>
</div>
<button class="button is-danger call-loader" type="submit">Email Invoice</button>
<a href="#" class="modal-close-button button is-primary">Cancel</a>
</form>


@endsection --}}
