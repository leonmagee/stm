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

      <div class="field">
        <label class="label">Number of Sims</label>
        <input name="sims" type="number" class="input" placeholder="0" />
      </div>

      <div class="field">
        <label class="label">Carrier</label>
        <div class="select">
          <select name="carrier_id">
            @foreach($carriers as $carrier)
            <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

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
