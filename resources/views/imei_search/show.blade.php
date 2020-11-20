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
          <div class="stm_inv__header--label">Search Date</div>
          <div class="stm_inv__header--label">Blacklist</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $imei->user->company }}</div>
          <div class="stm_inv__header--item">{{ $imei->imei }}</div>
          <div class="stm_inv__header--item">{{ $imei->model }}</div>
          <div class="stm_inv__header--item">{{ $imei->model_name }}</div>
          <div class="stm_inv__header--item">{{ $imei->created_at->format('M d, Y g:ia') }}</div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $imei->blacklist }}">{{ $imei->blacklist }}
          </div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Manufacturer</div>
          <div class="stm_inv__header--label">Carrier</div>
          @if($imei->warranty_status)
          <div class="stm_inv__header--label">Warranty Status</div>
          @endif
          @if($imei->warranty_start)
          <div class="stm_inv__header--label">Warranty Start</div>
          @endif
          @if($imei->warranty_end)
          <div class="stm_inv__header--label">Warranty End</div>
          @endif
          @if($imei->apple_care)
          <div class="stm_inv__header--label">Apple Care</div>
          @endif
          @if($imei->activated)
          <div class="stm_inv__header--label">Activated</div>
          @endif
          @if($imei->repairs_service)
          <div class="stm_inv__header--label">Repairs & Services</div>
          @endif
          @if($imei->refurbished)
          <div class="stm_inv__header--label">Refurbished</div>
          @endif
          <div class="stm_inv__header--label">Search Price</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $imei->manufacturer }}</div>
          <div class="stm_inv__header--item">{{ $imei->carrier }}</div>
          @if($imei->warranty_status)
          <div class="stm_inv__header--item">{{ $imei->warranty_status }}</div>
          @endif
          @if($imei->warranty_start)
          <div class="stm_inv__header--item">{{ $imei->warranty_start }}</div>
          @endif
          @if($imei->warranty_end)
          <div class="stm_inv__header--item">{{ $imei->warranty_end }}</div>
          @endif
          @if($imei->apple_care)
          <div class="stm_inv__header--item">{{ $imei->apple_care }}</div>
          @endif
          @if($imei->activated)
          <div class="stm_inv__header--item">{{ $imei->activated }}</div>
          @endif
          @if($imei->repairs_service)
          <div class="stm_inv__header--item">{{ $imei->repairs_service }}</div>
          @endif
          @if($imei->refurbished)
          <div class="stm_inv__header--item">{{ $imei->refurbished }}</div>
          @endif
          @if(\Auth::user()->isAdminManager())
          <div class="stm_inv__header--item">${{ number_format($imei->price, 2) }}</div>
          @else
          <div class="stm_inv__header--item">$0.00</div>
          @endif
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
