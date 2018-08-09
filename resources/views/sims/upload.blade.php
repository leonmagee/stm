@extends('layouts.layout')

@section('content')

<h1 class="title">Upload Sims</h1>

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Upload Individual Sims</h3>

    <form action="/upload_single" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

      <div class="field">
        <div class="file">
          <label class="file-label">
            <input class="file-input" type="file" name="upload-file-single">
            <span class="file-cta">
              <span class="file-icon">
                <i class="fas fa-file-upload"></i>
              </span>
              <span class="file-label">
                Select File
              </span>
            </span>
          </label>
        </div>
      </div>

      <div class="field">
        <label class="label">Paste Sims</label>
        <textarea class="textarea" name="sims_paste"></textarea>
      </div>

      <div class="field">
        <label class="label">User</label>
        <div class="select">
          <select name="user_id">
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->company }} | {{ $user->name }}</option>
            @endforeach
          </select>
        </div>
      </div>


      <div class="field submit">
        <div class="control">
         <button class="button is-link" type="submit">Upload</button>
       </div>
     </div>

   </div>

  <div class="field">
    
    @include('layouts.errors')

  </div>

 </form>

</div>


<div class="form-wrapper-inner">

  <h3>Upload Monthly Sims</h3>

  <form action="/upload" method="POST" enctype="multipart/form-data">

   <div class="form-wrap">

    {{ csrf_field() }}

    <div class="field">
      <div class="file">
        <label class="file-label">
          <input class="file-input" type="file" name="upload-file">
          <span class="file-cta">
            <span class="file-icon">
              <i class="fas fa-file-upload"></i>
            </span>
            <span class="file-label">
              Select File
            </span>
          </span>
        </label>
      </div>
    </div>

    <div class="field">
      <label class="label">Report Type</label>
      <div class="select">
        <select name="report_type">
          @foreach($report_types as $report_type)
          <option value="{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="field submit">
      <div class="control">
       <button class="button is-link" type="submit">Upload</button>
     </div>
   </div>

 </div>

  <div class="field">
    
    @include('layouts.errors')

  </div>

</form>

</div>

</div>

@endsection

