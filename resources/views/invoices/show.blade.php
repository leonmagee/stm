@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Invoice</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__header--flex">
          <div class="stm_inv__header--label">Invoice Title</div>
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">Agent / Dealer</div>
          <div class="stm_inv__header--label">Due Date</div>
        </div>
        <div class="stm_inv__header--flex">
          <div class="stm_inv__header--item">{{ $invoice->title }}</div>
          <div class="stm_inv__header--item">{{ $invoice->user->company }}</div>
          <div class="stm_inv__header--item">{{ $invoice->user->name }}</div>
          <div class="stm_inv__header--item">{{ $invoice->due_date }}</div>
        </div>
      </div>

      <div class="stm_inv__items">
        @foreach($items as $item)
        <div class="stm_inv__items--item">
          {{ $item->description }}
        </div>
        @endforeach
      </div>

      <div class="stm_inv__form">
        <form method="POST" action="/new-invoice-item">

          @csrf

          <div class="stm_inv__form--flex">

            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />

            <div class="field">
              <label class="label" for="quantity">Quantity</label>
              <div class="control">
                <input class="input" type="number" min="0" id="quantity" name="quantity" />
              </div>
            </div>

            <div class="field">
              <label class="label" for="cost">Cost</label>
              <div class="control">
                <input class="input" type="number" min="0" id="cost" name="cost" />
              </div>
            </div>

            <div class="field">
              <label class="label" for="description">Description</label>
              <div class="control">
                <input class="input" type="text" id="description" name="description" />
              </div>
            </div>

          </div>
          <div class="field flex-margin">
            <div class="control">
              <button class="button is-primary" type="submit">Add Line Item</button>
            </div>
          </div>

      </div>
      </form>

    </div>


  </div>

</div>

@endsection
