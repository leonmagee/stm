@extends('layouts.layout')

@section('title')
Sim Search Results
@endsection

@section('content')

<div class="sims-list">
    
<ul>
    @foreach( $list_array as $item )

    <li>

        @if($item['user_data'])

        <div class="detail-wrap">

            <div class="detail-header">User Sim Record</div>

            <div class="detail-item">
                <label>Sim Number</label>
                <div>{{ $item['user_data']['sim_number'] }}</div>
            </div>

            <div class="detail-item">
                <label>Carrier</label>
                <div>{{ $item['user_data']['carrier'] }}</div>
            </div>

            <div class="detail-item">
                <label>Company</label>
                <div>{{ $item['user_data']['company'] }}</div>
            </div>

            <div class="detail-item">
                <label>User</label>
                <div>{{ $item['user_data']['user'] }}</div>
            </div>

        </div>

        @endif

        @if($item['monthly_data'])

            <div class="detail-wrap">

                <div class="detail-header">Monthly Sim Record</div>

                <div class="detail-item">
                    <label>Sim Number</label>
                    <div>{{ $item['monthly_data']['sim_number'] }}</div>
                </div>

                <div class="detail-item">
                    <label>Report Type</label>
                    <div>{{ $item['monthly_data']['report_type'] }}</div>
                </div>
                
                <div class="detail-item">
                    <label>Plan Value</label>
                    <div>${{ $item['monthly_data']['value'] }}</div>
                </div>

                <div class="detail-item">
                    <label>Activation Date</label>
                    <div>{{ $item['monthly_data']['date'] }}</div>
                </div>

                <div class="detail-item">
                    <label>Mobile Number</label>
                    <div>{{ $item['monthly_data']['mobile'] }}</div>
                </div>

                <div class="detail-item">
                    <label>Upload Date</label>
                    <div>{{ $item['monthly_data']['upload_date'] }}</div>
                </div>

            </div>

        @endif

    </li>

    @endforeach
</ul>

</div>



@endsection



