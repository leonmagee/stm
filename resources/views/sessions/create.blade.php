@extends('layouts.layout-simple')

@section('content')

<div class="form-wrapper">

	<div class="form-wrapper-inner banner-image-wrap">
		<img src="{{ $banner_1 }}" />
	</div>

	<div class="form-wrapper-inner third">

		<h3>Log In</h3>

		<form method="POST" action="/login">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="email">Email</label>
					<div class="control">
						<input class="input" type="email" id="email" name="email" />
					</div>
				</div>

				<div class="field">
					<label class="label" for="password">Password</label>
					<div class="control">
						<input class="input" type="password" id="password" name="password" />
					</div>
				</div>

				<div class="field">
					<div class="control">
						<button class="button is-primary" type="submit">Log In</button>
					</div>
				</div>

				<a href="/password/reset">Reset Password</a>

				<div class="field">

					@include('layouts.errors')

				</div>

			</div>

		</form>

	</div>

	<div class="form-wrapper-inner banner-image-wrap">
		<img src="{{ $banner_2 }}" />
	</div>

</div>

@endsection