@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Create New Invoice</h3>

    <form method="POST" action="/new-invoice">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">

          <div class="field">
            <label class="label" for="name">Name</label>
            <div class="control">
              <input class="input" type="text" id="name" name="name" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="email">Email</label>
            <div class="control">
              <input class="input" type="email" id="email" name="email" readonly
                onfocus="this.removeAttribute('readonly');" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="company">Company</label>
            <div class="control">
              <input class="input" type="text" id="company" name="company" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="role_id">Site</label>
            <div class="select">
              <select name="role_id" id="role_id">
                @foreach ($sites_array as $site)
                <option value="{{ $site['role'] }}" @if ($current_site_id==$site['site']) selected="selected" @endif>
                  {{ $site['name'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="field">
            <label class="label" for="phone">Phone Number</label>
            <div class="control">
              <input class="input" type="number" id="phone" name="phone" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="address">Address</label>
            <div class="control">
              <input class="input" type="text" id="address" name="address" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="city">City</label>
            <div class="control">
              <input class="input" type="text" id="city" name="city" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="state">State</label>
            <div class="select">
              <select name="state" id="state">
                @foreach ($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="field">
            <label class="label" for="zip">Zip</label>
            <div class="control">
              <input class="input" type="text" id="zip" name="zip" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="password">Password</label>
            <div class="control">
              <input class="input" type="password" id="password" name="password" readonly
                onfocus="this.removeAttribute('readonly');" />
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
            <button class="button is-primary" type="submit">Register</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
