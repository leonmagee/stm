@extends('layouts.layout')

@section('content')

<div class="form-wrapper">

    <div class="form-wrapper-inner">

        <h3>Date Settings</h3>

        <form method="POST" action="/current_date">

            {{ csrf_field() }}

            <div class="form-wrap">

                <div class="field">
                    <label class="label">Current Month</label>
                    <div class="select">
                        <select name="current_month">
                            @foreach( $months as $key => $month )
                            <option value="{{ ($key + 1) }}">{{ $month }}</option> 
                            @endforeach        
                        </select>
                    </div> 
                </div>

                <div class="field">
                    <label class="label">Current Year</label>
                    <div class="select">
                        <select name="current_year">
                            @foreach( $years as $year )
                            <option value="{{ $year }}">{{ $year }}</option> 
                            @endforeach        
                        </select>
                    </div> 
                </div>

                <div class="field update">
                    <div class="control">
                        <button class="button is-link" type="submit" value="Publish">Update</button>
                    </div>
                </div>

            </div> 

        </form>

    </div>

    <div class="form-wrapper-inner">

        <h3>Mode Settings</h3>

        <form method="POST" action="/mode">

            {{ csrf_field() }}

            <div class="form-wrap">

                <div class="field">
                    <label class="label">Current Mode</label>
                    <div class="select">
                        <select name="mode">
                            <option value="online">Online</option> 
                            <option value="locked">Locked</option> 
                        </select>
                    </div> 
                </div>

                <div class="field update">
                    <div class="control">
                        <button class="button is-link" type="submit" value="Publish">Update</button>
                    </div>
                </div>

            </div> 

        </form>

    </div>

    <div class="form-wrapper-inner">

        <h3>Site Settings</h3>

        <form method="POST" action="/site">

            {{ csrf_field() }}

            <div class="form-wrap">

                <div class="field">
                    <label class="label">Current Site</label>
                    <div class="select">
                        <select name="site">
                            @foreach( $sites as $site )
                                <option value="{{ $site->id }}">{{ $site->name }}</option> 
                            @endforeach  
                        </select>
                    </div> 
                </div>

                <div class="field update">
                    <div class="control">
                        <button class="button is-link" type="submit" value="Publish">Update</button>
                    </div>
                </div>

            </div> 

        </form>

    </div>

    @include('layouts.errors')

</div>

@endsection