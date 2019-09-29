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
                <input checked="checked" type="radio" name="email_site" value="all_users">
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
            <label class="label">Add Attachments</label>
            <div class="control email-blast-wrap-bottom">
              <div class="file has-name">
                <label class="file-label">
                  <input class="file-input" type="file" name="resume">
                  <span class="file-cta">
                    <span class="file-icon">
                      <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                      Choose a file…
                    </span>
                  </span>
                  <span class="file-name">
                    Screen Shot 2017-07-29 at 15.54.25.png
                  </span>
                </label>
              </div>
            </div>
            <label class="label">Email Subject</label>
            <div class="control email-blast-wrap-bottom">
              <input class="input" name="subject" value="Commission Report Ready" />
            </div>
            <label class="label">Email Text</label>
            <div class="control">
              <textarea class="textarea"
                name="message">Sim Track Manager is now unlocked. Please log in to view your monthly activation commission report.</textarea>
            </div>
          </div>
        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Email Selected Users</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
