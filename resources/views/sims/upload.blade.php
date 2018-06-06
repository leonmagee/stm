@extends('layouts.layout')

@section('content')

<h2>Upload Sims</h2>


<form action="/upload" method="POST" enctype="multipart/form-data">

	<div class="form-wrap">

		{{ csrf_field() }}

		<div class="field">

			<label>Upload</label>
			<input type="file" name="upload-file" />

		</div>

		<div class="control">

			<button class="button is-link" type="submit">Upload</button>

		</div>

	</div>

</form>

@endsection

