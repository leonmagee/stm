@extends('layouts.layout')

{{-- @section('title')
{{ $user->name }}
@endsection --}}

@section('content')

@include('mixins.user-back', ['user' => $user])

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner third">

    <h3>{{ $date }} - Bonus / Credit</h3>

    <form method="POST" action="/bonus-credit/{{ $user->id }}">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="field">
          <label class="label" for="bonus">Monthly Bonus</label>
          <div class="control">
            <input class="input" value="{{ $bonus }}" type="number" id="bonus" name="bonus" placeholder="$0.00" />
          </div>
        </div>

        <div class="field">
          <label class="label" for="credit">Outstanding Balance</label>
          <div class="control">
            <input class="input" value="{{ $credit }}" type="number" id="credit" name="credit" placeholder="$0.00" />
          </div>
        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary" type="submit">Update</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
