@extends('layouts.layout')

@section('content')

<h1 class="title">Upload Sims</h1>

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
        <label class="label">User</label>
        <div class="select">
            <select name="report_type">
                @foreach($report_types as $report_type)
                <option value="{{ $report_type->id }}">{{ $report_type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="control">

     <button class="button is-link" type="submit">Upload</button>

   </div>

 </div>

</form>

@endsection

