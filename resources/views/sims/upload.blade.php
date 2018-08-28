@extends('layouts.layout')

@section('title')
Upload Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Individual Sims Paste</h3>

    <form action="/upload-single-paste" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

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

      <div class="field">
        <label class="label">Carrier</label>
        <div class="select">
          <select name="carrier_id">
            @foreach($carriers as $carrier)
            <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="field">
        <textarea class="textarea" name="sims_paste"></textarea>
      </div>

      <div class="field submit">
        <div class="control">
         <button class="button is-link call-loader" type="submit">Upload</button>
       </div>
     </div>

   </div>

  <div class="field">
    
    @include('layouts.errors')

  </div>

 </form>

</div>

<div class="form-wrapper-inner">

    <h3>Individual Sims File</h3>

    <form action="/upload-single" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

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

      <div class="field">
        <label class="label">Carrier</label>
        <div class="select">
          <select name="carrier_id">
            @foreach($carriers as $carrier)
            <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="field">
      <div class="file has-name">
        <label class="file-label">
          <input class="file-input upload-file-js" type="file" id="file-single" name="upload-file-single">
          <span class="file-cta">
            <span class="file-label">
              Select File
            </span>
          </span>
          <span class="file-name" id="file-name-single">
              <i class="fas fa-upload"></i>
          </span>
        </label>
      </div>
      </div>

      <div class="field submit">
        <div class="control">
         <button class="button is-link call-loader" type="submit">Upload</button>
       </div>
     </div>

   </div>

  <div class="field">
    
    @include('layouts.errors')

  </div>

 </form>

</div>


<div class="form-wrapper-inner">

  <h3>Monthly Sims File</h3>

  <form action="/upload" method="POST" enctype="multipart/form-data">

   <div class="form-wrap">

    {{ csrf_field() }}

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

    <div class="field">
      <div class="file has-name">
        <label class="file-label">
          <input class="file-input upload-file-js" type="file" id="file-monthly" name="upload-file">
          <span class="file-cta">
            <span class="file-label">
              Select File
            </span>
          </span>
          <span class="file-name" id="file-name-monthly">
              <i class="fas fa-upload"></i>
          </span>
        </label>
      </div>
      </div>

    <div class="field submit">
      <div class="control">
       <button class="button is-link call-loader" type="submit">Upload</button>
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

