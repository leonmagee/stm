@extends('layouts.layout')

@section('content')

@include('mixins.misc-back', ['url' => '/imeis', 'label' => 'IMEI Check History'])

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>IMEI # {{ $imei->imei }}</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">User</div>
          <div class="stm_inv__header--label">IMEI Number</div>
          <div class="stm_inv__header--label">Model</div>
          <div class="stm_inv__header--label">Model Name</div>
          <div class="stm_inv__header--label">Manufacturer</div>
          <div class="stm_inv__header--label">Search Date</div>
          <div class="stm_inv__header--label">Price</div>
          <div class="stm_inv__header--label">Blacklist</div>
        </div>
        <div class="stm_inv__flex stm_inv__header--smaller-font">
          <div class="stm_inv__header--item">{{ $imei->user->company }}</div>
          <div class="stm_inv__header--item">{{ $imei->imei }}</div>
          <div class="stm_inv__header--item">{{ $imei->model }}</div>
          <div class="stm_inv__header--item">{{ $imei->model_name }}</div>
          <div class="stm_inv__header--item">{{ $imei->manufacturer }}</div>
          <div class="stm_inv__header--item stm_inv__header--item-no-wrap">
            {{ $imei->created_at->format('M d, Y g:ia') }}</div>
          @if(\Auth::user()->isAdminManager())
          <div class="stm_inv__header--item">${{ number_format($imei->price, 2) }}</div>
          @else
          <div class="stm_inv__header--item">$0.00</div>
          @endif
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $imei->blacklist }}">{{ $imei->blacklist }}
          </div>
        </div>
      </div>

      @if($imei->all_data)
      <div class="stm_inv__header imei-center-max-wrap margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">All Data</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">
            <div class="imei-all-data-wrap">
              {!! $imei->all_data !!}
            </div>
          </div>
        </div>
      </div>
      @endif
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
