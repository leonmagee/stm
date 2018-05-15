@extends('layouts.layout')

@section('content')

    <h2>Upload Sims</h2>


    	<form action="/upload" method="POST" enctype="multipart/form-data">

			{{ csrf_field() }}
			<label>Upload</label>
			<input type="file" name="upload-file" />

			<button class="button" type="submit">Upload</button>

    	</form>

@endsection

