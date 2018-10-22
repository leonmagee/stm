@extends('layouts.layout-simple')

@section('content')

@include('layouts.errors')

<div class="form-wrapper center">

    <div class="form-wrapper-inner third">

        <h3>Update Password</h3>

        <form method="POST" action="{{ route('password.email') }}">

            @csrf

            <div class="form-wrap">

                <div class="field">
                    <label class="label" for="password">Email Address</label>

                        <div class="control">
                            <input id="email" type="email" class="input" name="email" value="{{ $email ?? old('email') }}">
                        </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-primary" type="submit">Submit</button>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection