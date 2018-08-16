@extends('layouts.layout')

@section('title')
Assign SIMs
@endsection

@section('content')

<div class="form-wrapper">

    <div class="form-wrapper-inner third">

        <h3>Assign SIMs</h3>

        <form method="POST" action="/assign-sims">

            <div class="form-wrap">

                {{ csrf_field() }}

                <div class="field">
                    <label class="label">Sim Number</label>
                    <div class="control">
                        <input class="input" type="text" name="sim_number" />
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="carrier">Carrier</label>
                    <div class="select">
                        <select name="carrier" id="carrier">
                            @foreach($carriers as $carrier)
                            <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">User</label>
                    <div class="select">
                        <select name="user_id">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
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

