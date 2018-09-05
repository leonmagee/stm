@extends('layouts.layout')

@section('title')
Single Report Type
@endsection

@section('content')

@include('layouts.errors')

<div class="single-report-type-wrap">

    <div class="item name">{{ $reportType->carrier->name }} {{ $reportType->name}}</div>

    <div class="item spiff-residual">
       @if($reportType->spiff)
       Spiff / Activation
       @else
       Residual
       @endif 
   </div>

   <div class="site-wrap-flex-outer">

    @foreach($site_values_array as $item)
    <div class="site-wrap-flex">
        <div class="item role flex-wrap">
            <i class="fas fa-sitemap"></i> 
            <span class="site-name">{{ $item['name'] }}</span>
            <span class="value">{!! $item['value'] !!}</span>
        </div>


        @if($reportType->spiff)
        <div class="plan-values-table-wrap">
            <div class="plan-values">

                <div class="plan-values-table flex-table">
                    <div class="header-row">
                     <div class="header-item">
                         Plan Value
                     </div> 
                     <div class="header-item">
                         Payment Value
                     </div>
                     <div class="header-item last"></div>
                 </div>

                 @foreach($item['plans'] as $plan)

                        <form method="POST" action="/remove-report-plan-value/{{ $reportType->id }}">

                 <div class="body-row">

                    <div class="body-item">${{ $plan->plan_value }}</div>

                    <div class="body-item">${{ $plan->payment_amount }}</div>

                    <div class="body-item last">

                            {{ csrf_field() }}
                            <input type="hidden" name="report_plan_id" value="{{ $plan->id }}" />
                            <button class="minus-link" type="submit">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                    </div>

                </div>

                                        </form>


                @endforeach

                <form method="POST" action="/add-report-plan-value/{{ $reportType->id }}">

                    <div class="body-row has-inputs">

                        {{ csrf_field() }}
                        <div class="body-item input-wrap"><input type="number" name="plan_value" /></div>
                        <div class="body-item input-wrap"><input type="number" name="payment_amount" /></div>
                        <input type="hidden" name="plan_value_id" value={{ $item['id'] }} />
                        <div class="body-item last">
                            <button class="add-link" type="submit">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>
    @endif
</div>
@endforeach
</div>
</div>

<div class="button-bar-wrap">
    <div class="button-bar">
        @if($reportType->spiff)
        <a href="/edit-report-type/{{ $reportType->id }}" id="edit-report-type" class="button is-primary">Edit Report Type</a>
        @else
        <a href="/edit-report-type-residual/{{ $reportType->id }}" id="edit-report-type" class="button is-primary">Edit Report Type</a>
        @endif
        <a href="#" class="modal-open button is-danger">Delete Report Type</a>
    </div>
</div>

@section('modal')

<h3 class="title">Are You Sure?</h3> 

<a href="/delete-report-type/{{ $reportType->id }}" id="delete-report-type" class="button is-danger">Delete Report Type {{ $reportType->carrier->name }} {{ $reportType->name }}</a>
<a href="#" class="modal-close-button button is-primary">Cancel</a>

@endsection



@endsection

