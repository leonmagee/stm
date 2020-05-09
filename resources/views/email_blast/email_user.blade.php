@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Email {{ $user->company }}</h3>

    <form method="POST" action="/email-blast" id="email-blast-form" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        <input type="hidden" name="just_one_user" value="{{ $user->id }}" />

        <div class="form-wrap-flex">
          <div class="field full padding-bottom">
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
            <div class="columns">
              <div class="column is-one-third">
                <label class="label">Email Subject<span class="required">*</span></label>
                <div class="control">
                  <input class="input" name="subject" />
                </div>
              </div>
              <div class="column is-one-third">
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
              <div class="column is-one-third">
                <label class="label" for="cc_manual_email">BCC Another User</label>
                <div class="control email-blast-cc-item">
                  <input class="input" type="text" name="cc_manual_email" placeholder="Email Address" />
                </div>
              </div>
            </div>
            <label class="label">Email Text<span class="required">*</span></label>
            <div class="control">
              <div id="quill_editor" class="quill-wrap"></div>
              <textarea name="message" id="quill_text" class="quill_text"></textarea>
            </div>
          </div>
        </div>

        <div class="field flex-margin">
          <div class="control">
            <a class="button is-primary modal-open-email-blast">Send Email</a>
          </div>
        </div>

      </div>

      <div class="modal" id="email-blast-modal">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h4 class="title">Are You Sure?</h4>

            <button class="button is-danger call-loader" type="submit">Send Email</button>

            <a class="modal-email-close button is-primary">Cancel</a>
          </div>

        </div>

        <a class="modal-close is-large" aria-label="close"></a>

      </div>

    </form>

  </div>

</div>

@endsection

@section('page-script')
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
<script>
  var quill_settings = {
    modules: {
    toolbar: [
    [{ header: [1, 2, 3, 4, false] }],
    ['bold', 'italic', 'underline'],
    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }]
    ]
    },
    placeholder: 'Enter Your Text...',
    theme: 'snow'
    };
    new Quill('#quill_editor', quill_settings);
    //new Quill("#quill_editor-add-new", quill_settings);
</script>

@endsection
