@extends('layouts.layout')

@section('title')
Order Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner half">

    <h3>Choose Details of SIM Order</h3>

    <form action="/order-sims" method="POST" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        @foreach($carriers as $carrier)
        <div class="field">
          <label class="label">Number of {{ $carrier->name }} Sims</label>
          <input name="sims-{{ $carrier->id }}" type="number" class="input" placeholder="0" />
        </div>
        @endforeach

        <div class="field submit">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Order Sims</button>
          </div>
        </div>

      </div>

    </form>

  </div>

  @include('layouts.errors')

</div>

@endsection
