@extends('layouts.layout')

@section('title')
Edit User
@endsection

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>Edit User</h3>

		<form method="POST" action="/update-user-password/{{ $user->id }}">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="form-wrap-flex">

					<div class="field">
						<label class="label" for="password">Password</label>
						<div class="control">
							<input class="input" type="password" id="password" name="password" />
						</div>
					</div>

					<div class="field last-item">
						<label class="label" for="password_2">Password Confirm</label>
						<div class="control">
							<input class="input" type="password" id="password_2" name="password_confirmation" />
						</div>
					</div>

				</div>

				<div class="field flex-margin">
					<div class="control">
						<button class="button is-link" type="submit">Update</button>
					</div>
				</div>

			</div>

		</form>

	</div>

</div>

@endsection