@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Commission Ready or Custom Mass Email</h3>

    <form method="POST" action="/email-blast" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
            <label class="label" for="name">Choose All Users or All Users from One Site</label>
            <div class="control email-blast-wrap-top">
              <label class="radio" id="all-users-radio">
                <input type="radio" name="email_site" value="all_users">
                All Users
              </label>
              @foreach($sites as $site)
              <label class="radio one-site-radio">
                <input type="radio" name="email_site" value="{{ $site->role_id }}">
                {{ $site->name }}
              </label>
              @endforeach
            </div>

            <div class="line-divider"></div>

            <div id="exclude-sites-wrap">
              <label class="label" for="name">Choose Sites to Exclude</label>
              <div class="control email-blast-wrap-top">
                @foreach($sites_exclude as $site)
                <label class="checkbox">
                  <input type="checkbox" name="exclude_sites[]" value="{{ $site->role_id }}">
                  {{ $site->name }}
                </label>
                @endforeach
              </div>
              <div class="line-divider"></div>
            </div>

            <div class="columns">
              <div class="column is-one-third is-one-quarter-fullhd">
                <label class="label" for="just_one_user">OR Choose One User</label>
                <div class="control email-blast-cc-item">
                  <div class="select">
                    <select name="just_one_user">
                      <option value="0">---</option>
                      @foreach($users as $user)
                      <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="column is-one-third is-one-quarter-fullhd">
                <label class="label" for="cc_just_one_user">BCC User</label>
                <div class="control email-blast-cc-item">
                  <div class="select">
                    <select name="cc_just_one_user">
                      <option value="0">---</option>
                      @foreach($users as $user)
                      <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="column is-one-third is-one-quarter-fullhd">
                <label class="label" for="cc_manual_email">BCC Another User</label>
                <div class="control email-blast-cc-item">
                  <input class="input" type="text" name="cc_manual_email" placeholder="Email Address" />
                </div>
              </div>
            </div>
            <label class="label">Add Attachments</label>
            <div class="control attachment-wrap">
              <div class="field">
                <div class="file has-name">
                  <label class="file-label">
                    <input class="file-input upload-file-js" type="file" id="upload-file" name="upload-file-email">
                    <span class="file-cta">
                      <span class="file-label">
                        Select File
                      </span>
                    </span>
                    <span class="file-name" id="upload-file-email">
                      <i class="fas fa-upload"></i>
                    </span>
                  </label>
                </div>
              </div>
              <div class="field">
                <div class="file has-name">
                  <label class="file-label">
                    <input class="file-input upload-file-js" type="file" id="upload-file" name="upload-file-email-2">
                    <span class="file-cta">
                      <span class="file-label">
                        Select File
                      </span>
                    </span>
                    <span class="file-name" id="upload-file-email">
                      <i class="fas fa-upload"></i>
                    </span>
                  </label>
                </div>
              </div>

              <div class="field">
                <div class="file has-name">
                  <label class="file-label">
                    <input class="file-input upload-file-js" type="file" id="upload-file" name="upload-file-email-3">
                    <span class="file-cta">
                      <span class="file-label">
                        Select File
                      </span>
                    </span>
                    <span class="file-name" id="upload-file-email">
                      <i class="fas fa-upload"></i>
                    </span>
                  </label>
                </div>
              </div>
            </div>
            <label class="label">Email Subject</label>
            <div class="control email-blast-wrap-bottom">
              <input class="input" name="subject" />
            </div>
            <label class="label">Email Text</label>
            <div class="control">
              <textarea class="textarea" name="message"></textarea>
            </div>
          </div>
        </div>

        <div class="field flex-margin">
          <div class="control">
            <a class="button is-primary modal-open-email-blast">Email Selected Users</a>
          </div>
        </div>

      </div>

      <div class="modal" id="email-blast-modal">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h4 class="title">Are You Sure?</h4>

            <button class="button is-danger call-loader" type="submit">Email Selected Users</button>

            <a class="modal-email-close button is-primary">Cancel</a>
          </div>

        </div>

        <a class="modal-close is-large" aria-label="close"></a>

      </div>

    </form>

  </div>

</div>

@endsection
