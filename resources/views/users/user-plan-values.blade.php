@extends('layouts.layout')

{{-- @section('title')
{{ $user->name }} / User Plan Values
@endsection --}}

@section('content')

@include('mixins.user-back', ['user' => $user])

@include('layouts.errors')

<div class="user-plan-section">

  <h4>Spiff Value Overrides</h4>

  <form method="POST" class="add-user-data-form flex-section" action="/user-plan-values/{{ $user->id }}">

    {{ csrf_field() }}

    <div class="field one report_type">

      <label class="label" for="report_type">Report Type</label>

      <div class="select">

        <select name="report_type" id="report_type">
          @foreach ($report_types_spiff as $report_type)
          <option value="{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}
          </option>
          @endforeach
        </select>

      </div>

    </div>

    <div class="field two">
      <label class="label" for="plan">Plan Value</label>
      <input type="number" class="input" name="plan" id="plan" placeholder="$0.00">
    </div>

    <div class="field three">
      <label class="label" for="payment">Payment Amount</label>
      <input type="number" step="0.01" class="input" name="payment" id="payment" placeholder="$0.00">
    </div>

    <div class="field four update">
      <input class="button is-primary" type="submit" value="Update" />
    </div>

  </form>

  <div class="user-plan-items">

    @foreach($user_plan_items as $item)

    <div class="user-plan-item flex-section">

      <div class="data one">
        <label>Report Type</label>
        <div>{{ $item->report_type->carrier->name }} {{ $item->report_type->name }}</div>
      </div>

      <div class="data two">
        <label>Plan Value</label>
        <div>${{ $item->plan_value }}</div>
      </div>

      <div class="data three">
        <label>Payment Amount</label>
        <div>${{ number_format($item->payment_amount, 2) }}</div>
      </div>

      <div class="data four">
        <form method="POST" action="/delete-user-plan-value/{{ $item->id }}">
          {{ csrf_field() }}
          <input class="button is-danger" type="submit" value="Delete" />
        </form>
      </div>

    </div>


    @endforeach

  </div>


</div>

<div class="user-plan-section">

  <h4>Residual Percent Overrides</h4>

  <form method="POST" class="add-user-data-form flex-section" action="/user-residual-percent/{{ $user->id }}">

    {{ csrf_field() }}

    <div class="field one report_type">
      <label class="label" for="report_type_residual">Report Type</label>
      <div class="select">
        <select name="report_type_residual" id="report_type_residual">
          @foreach ($report_types_residual as $report_type)
          <option value="{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}
          </option>
          @endforeach
        </select>

      </div>
    </div>

    <div class="field two">
      <label class="label" for="percent">Payment Percent</label>
      <input type="number" step="0.01" class="input" name="percent" id="percent" placeholder="0%">
    </div>

    <div class="field four update">
      <input class="button is-primary" type="submit" value="Update" />
    </div>

  </form>

  <div class="user-plan-items">

    @foreach($user_residual_items as $item)

    <div class="user-plan-item flex-section">

      <div class="data one">
        <label>Report Type</label>
        <div>{{ $item->report_type->carrier->name }} {{ $item->report_type->name }}</div>
      </div>

      <div class="data two">
        <label>Payment Percent</label>
        <div>{{ $item->residual_percent }}%</div>
      </div>

      <div class="data four">
        <form method="POST" action="/delete-user-residual-percent/{{ $item->id }}">
          {{ csrf_field() }}
          <input class="button is-danger" type="submit" value="Delete" />
        </form>
      </div>

    </div>


    @endforeach

  </div>


</div>

@endsection
