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
            <div class="modal" id="layout-modal-exclude-users">

              <div class="modal-background"></div>

              <div class="modal-content large">

                <div class="modal-box exclude-users-modal">

                  <h4 class="title">Exclude Users</h4>

                  <div class="columns is-multiline">

                    @foreach($users as $user)
                    <div class="column is-one-third-desktop is-one-fifth-fullhd">
                      {{-- <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option> --}}
                      <label class="checkbox exclude-modal-label">
                        <input type="checkbox" value="{{ $user->id }}" name="exclude_users[]" />
                        <span class="user-details-wrap">
                          <span class="company-name">{{ $user->company }}</span><br />
                          <span class="user-name">{{ $user->name }}</span>
                          <span>
                      </label>
                    </div>
                    @endforeach
                  </div>

                  <a class="modal-close-button button is-primary">Continue</a>

                </div>

              </div>


            </div>
            <a href="#" class="modal-open-exclude-users button is-primary">Exclude Users</a>
            <div class="line-divider"></div>
            <label class="label" for="name">OR Choose One User</label>
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
