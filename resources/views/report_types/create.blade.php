@extends('layouts.layout')

@section('title')
Add New Report Type
@endsection

@section('content')


@include('layouts.errors')


<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>New Report Type</h3>

		<form method="POST" action="/new-report-type">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="form-wrap-flex">

					<div class="field">
						<label class="label" for="name">Name</label>
						<div class="control">
							<input class="input" type="text" id="name" name="name" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="type">Type</label>
						<div class="select">
							<select name="type" id="type">
								<option value=1>Spiff / Activation</option>
								<option value=0>Residual</option>
							</select>
						</div>
					</div>

					<div class="field">
						<label class="label" for="company">Site</label>
						<div class="select">
							<select name="role">
								@foreach ($sites as $site)
								<option 
								value="{{ $site->id }}"
								>{{ $site->name }}</option>
								@endforeach
							</select>
						</div>
					</div>


				</div>

				<div class="field flex-margin">
					<div class="control">
						<button class="button is-link" type="submit">Add Report Type</button>
					</div>
				</div>

			</div>

		</form>

	</div>


	

</div>



@endsection