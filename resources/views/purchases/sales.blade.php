@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    @if($agent_user)
    <h3>{{ $agent_user->company }} Sales</h3>
    @else
    <h3>Sales</h3>
    @endif

    <div class="stm-flex">
      <div class="total-sales">
        <div class="total-sales__label">Total Sales</div>
        <div class="total-sales__value">${{ number_format($total_sales, 2) }}</div>
      </div>


      <div class="sales-menu">
        <form method="GET" class="sales-menu__form">
          @csrf
          <div class="sales-menu__form--inner">
            <div class="field input-field">
              <label for="starting_date" class="label">Starting Date</label>
              <input class="input" type="text" id="starting_date" name="starting_date" autocomplete="off"
                value="{{ $start_input }}" />
            </div>
            <div class="field input-field">
              <label for="ending_date" class="label">Ending Date</label>
              <input class="input" type="text" id="ending_date" name="ending_date" autocomplete="off"
                value="{{ $end_input }}" />
            </div>
            <div class="field input-field-users">
              <label for="user_id" class="label">Agent/Dealer</label>
              <div class="select">
                <select name="user_id">
                  <option value="0">N/A</option>
                  @foreach($agents as $agent)
                  <option @if('agent-' . $agent->id == $user_id) selected @endif value="agent-{{ $agent->id }}">AGENT:
                    {{ $agent->company }}
                  </option>
                  @endforeach
                  @foreach($users as $dealer)
                  <option @if($dealer->id == $user_id) selected @endif value="{{ $dealer->id }}">{{ $dealer->company }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="field">
              <button type="submit" class="button is-primary call-loader">Update</button>
            </div>
            <div class="field">
              <a href="/sales" class="button call-loader">Reset</a>
            </div>
          </div>
        </form>
      </div>


      <div class="stm-flex-wrap">
        <div class="stm-flex-row">
          <div class="stm-flex-row__item header flex-12">Date</div>
          <div class="stm-flex-row__item header">Total</div>
        </div>
        @foreach($monthly_data as $item)
        <div class="stm-flex-row">
          <?php
              $date_obj = \DateTime::createFromFormat('!m', $item->month);
              $month_name = $date_obj->format('F'); // March
      ?>
          <div class="stm-flex-row__item flex-12">{{ $month_name }} {{ $item->year }}</div>
          <div class="stm-flex-row__item">${{ number_format($item->total, 2) }}</div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
</div>


@endsection
