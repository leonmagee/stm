@extends('layouts.layout')

{{-- @section('title')
Order Sims / POS
@endsection --}}

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Choose Details of SIM / POS Order</h3>

    <form id="order_sims_form" action="/order-sims" method="POST" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="columns is-multiline">

          @foreach($carriers as $carrier)
          <div class="column is-half-desktop">
            <div class="field">
              <label class="label">Number of {{ $carrier->name }} Sims</label>
              <input name="sims-{{ $carrier->id }}" type="number" class="input" placeholder="0" min="0" />
            </div>
          </div>
          @endforeach

          @foreach($carriers as $carrier)
          <div class="column is-half-desktop">
            <div class="field">
              <label class="label">Number of {{ $carrier->name }} Brochures</label>
              <input name="brochures-{{ $carrier->id }}" type="number" class="input" placeholder="0" min="0" />
            </div>
          </div>
          @endforeach

        </div>

        <div class="info-red">* Please order sims responsibly based on your trending average monthly activations.</div>

        <div class="field submit">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Order Sims</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
