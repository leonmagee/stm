@extends('layouts.layout')

@section('title')
Settings
@endsection

@section('content')

<div class="form-wrapper">

    <div class="form-wrapper-inner half">

        <h3>Site Settings</h3>

        <form method="POST" action="/site">

            {{ csrf_field() }}

            <div class="form-wrap">

                <div class="field">
                    <label class="label">Current Site</label>
                    <div class="select">
                        <select name="site">
                            @foreach( $sites as $site )
                                <option value="{{ $site->id }}"
                                    @if ($site->id == $current_site)
                                        selected="selected"
                                    @endif
                                    >{{ $site->name }}</option> 
                            @endforeach  
                        </select>
                    </div> 
                </div>

                <div class="field submit">
                    <div class="control">
                        <button class="button is-primary call-loader" type="submit">Update</button>
                    </div>
                </div>

            </div> 

        </form>

    </div>

    @include('layouts.errors')

</div>

@endsection