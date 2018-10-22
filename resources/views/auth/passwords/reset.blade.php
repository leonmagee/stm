@extends('layouts.layout-simple')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

    <div class="form-wrapper-inner">

        <h3>Update Password</h3>

        <form method="POST" action="{{ route('password.update') }}">

            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-wrap">

                <div class="form-wrap-flex">

                    <div class="field">
                        <label class="label" for="password">Email Address</label>

                            <div class="control">
                                <input id="email" type="email" class="input" name="email" value="{{ $email ?? old('email') }}">
                            </div>
                    </div>

                    <div class="field">
                        <label class="label" for="password">Password</label>
                        <div class="control">
                            <input class="input" type="password" id="password" name="password" />
                        </div>
                    </div>

                    <div class="field last-item">
                        <label class="label" for="password_2">Password Confirm</label>
                        <div class="control">
                            <input class="input" type="password" id="password_2" name="password_confirmation" />
                        </div>
                    </div>

                </div>

                <div class="field flex-margin">
                    <div class="control">
                        <button class="button is-primary" type="submit">Submit</button>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection
