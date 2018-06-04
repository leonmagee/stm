@extends('layouts.layout')

@section('content')
<div class="form-wrapper">
    <form method="POST" action="/assign-sims">
        {{ csrf_field() }}

        
        <div class="grid-x grid-padding-x">

            <div class="cell small-8">
                <label>Sim Number</label>
                <input type="text" name="sim_number" />
            </div>

            <div class="cell small-4">
                <label>User</label>
                <select name="user_id">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

            </div>

        </div> 

        <button class="button" type="submit" value="Publish">Publish</button>
    </form>

    @include('layouts.errors')
</div>
@endsection

