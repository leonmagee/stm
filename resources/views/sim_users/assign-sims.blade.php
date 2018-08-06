@extends('layouts.layout')

@section('content')

<h1 class="title">Assign SIM</h1>

<div class="form-wrapper">

    <form method="POST" action="/assign-sims">

        {{ csrf_field() }}

        <div class="field">
            <label class="label">Sim Number</label>
            <div class="control">
                <input class="input" type="text" name="sim_number" />
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

    </form>

    @include('layouts.errors')

</div>

@endsection

