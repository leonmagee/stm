@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Commission Ready Mass Email</h3>

    <form method="POST" action="/email-blast">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
            <label class="label" for="name">Choose All Users or All Users from One Site</label>
            <div class="control email-blast-wrap-top">
              <label class="radio">
                <input type="radio" name="email_site" value="all_users">
                All Users
              </label>
              @foreach($sites as $site)
              <label class="radio">
                <input type="radio" name="email_site" value="{{ $site->role_id }}">
                {{ $site->name }}
              </label>
              @endforeach
            </div>
            <label class="label" for="name">Choose One User</label>
            <div class="control email-blast-wrap-bottom">
              <div class="select">
                <select name="just_one_user">
                  <option value="0">---</option>
                  @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="control">
              <textarea class="textarea"
                name="message">Sim Track Manager is now unlocked. Please log in to view your monthly activation commission report.</textarea>
            </div>
          </div>

        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Email All Users</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
