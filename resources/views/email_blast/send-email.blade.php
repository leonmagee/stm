@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Send Email to User</h3>

    <form method="POST" action="/send-email" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
            <label class="label" for="name">Choose One User</label>
            <div class="control email-blast-wrap-bottom">
              <div class="select">
                <select name="just_one_user">
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
              <input class="input" name="subject" placeholder="Enter Subject" />
            </div>
            <label class="label">Email Message</label>
            <div class="control">
              <textarea class="textarea" name="message" placeholder="Enter Message"></textarea>
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
