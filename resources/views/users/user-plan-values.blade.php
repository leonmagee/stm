@extends('layouts.layout')

@section('title')
{{ $user->name }} / User Plan Values
@endsection

@section('content')

@include('layouts.errors')

<!-- add value overrides for spiffs -->


<div class="user-plan-section">

    <h4>Spiff Value Overrides</h4>

    <form method="POST" class="add-user-data-form" action="/user-plan-values/{{ $user->id }}">

        {{ csrf_field() }}

        <div class="field report_type">
            <label class="label" for="report_type">Report Type</label>
            <div class="select">
                <select name="report_type" id="report_type">
                    @foreach ($report_types_spiff as $report_type)
                    <option 
                    value="{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}
                    </option>   
                    @endforeach
                </select>

            </div>
        </div>

        <div class="field">
            <label class="label" for="plan">Plan Value</label>
           <input type="number" class="input" name="plan" id="plan" placeholder="$0.00"> 
        </div>

        <div class="field">
            <label class="label" for="report_type">Payment Amount</label>
           <input type="number" class="input" name="payment" id="payment" placeholder="$0.00"> 
        </div>

        <div class="field update">
            <button class="button is-link" type="submit">Update</button>
        </div>
        
    </form>

    <div class="user-plan-items">
        
        @foreach($user_plan_items as $item)

        <div class="user-plan-item">

            <div class="data">
                <label>Report Type</label>
                <div>{{ $item->report_type->carrier->name }} {{ $item->report_type->name }}</div>
            </div>

            <div class="data">
                <label>Plan Value</label>
                <div>{{ $item->plan_value }}</div>
            </div>

            <div class="data">
                <label>Payment Amount</label>
                <div>{{ $item->payment_amount }}</div>
            </div>

            <div class="data">
                <a class="button is-danger" type="submit">Delete</a>
            </div>

        </div>


        @endforeach

    </div>


</div>














@endsection

