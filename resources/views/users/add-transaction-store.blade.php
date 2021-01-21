@extends('layouts.layout')

@section('content')

@include('mixins.user-back', ['user' => $user])

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner third">

    <h3>Add / Subtract Store Credit</h3>

    <form method="POST" action="/edit-transaction-store/{{ $user->id }}">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="field">
          <label class="label">Current Balace: <span
              class="label-green">${{ number_format($user->store_credit, 2) }}</span></label>
        </div>

        <div class="field">
          <label class="label" for="bonus">Add Credit</label>
          <div class="control">
            <input type="number" min="0" class="input" type="number" id="add-credit" name="add_credit"
              placeholder="$0.00" step=".01" />
          </div>
        </div>

        <div class=" field">
          <label class="label" for="credit">Subtract Credit</label>
          <div class="control">
            <input type="number" min="0" class="input" type="number" id="subtract-credit" name="subtract_credit"
              placeholder="$0.00" step=".01" />
          </div>
        </div>

        <div class="field">
          <label class="label" for="credit">Add Note</label>
          <div class="control">
            <textarea class="textarea" name="note"></textarea>
          </div>
        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Update</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
