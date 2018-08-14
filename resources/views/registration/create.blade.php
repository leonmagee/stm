@extends('layouts.layout')

@section('title')
Add New User
@endsection

@section('content')


@include('layouts.errors')


<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>New User Registration</h3>

		<form method="POST" action="/register">

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
						<label class="label" for="email">Email</label>
						<div class="control">
							<input class="input" type="email" id="email" name="email_address" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="company">Company</label>
						<div class="control">
							<input class="input" type="text" id="company" name="company" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="company">Site</label>
						<div class="select">
							<select name="role">
								@foreach ($sites as $site)
								<option 
								value="{{ $site->id }}"
								@if ($current_site_id == $site->id)
								selected="selected"
								@endif
								>{{ $site->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="field">
						<label class="label" for="phone">Phone Number</label>
						<div class="control">
							<input class="input" type="text" id="phone" name="phone" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="address">Address</label>
						<div class="control">
							<input class="input" type="text" id="address" name="address" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="city">City</label>
						<div class="control">
							<input class="input" type="text" id="city" name="city" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="state">State</label>
						<div class="control">
							<input class="input" type="text" id="state" name="state" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="zip">Zip</label>
						<div class="control">
							<input class="input" type="text" id="zip" name="zip" />
						</div>
					</div>

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
						<button class="button is-link" type="submit">Register</button>
					</div>
				</div>

			</div>

		</form>

	</div>


	

</div>



@endsection