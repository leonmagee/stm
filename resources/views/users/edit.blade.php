@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>Edit User</h3>

		<form method="POST" action="/update-user/{{ $user->id }}">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="form-wrap-flex">

					<div class="field">
						<label class="label" for="name">Name</label>
						<div class="control">
							<input class="input" value="{{ $user->name }}" type="text" id="name" name="name" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="email">Email</label>
						<div class="control">
							<input class="input" value="{{ $user->email }}" type="email" id="email" name="email" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="company">Company</label>
						<div class="control">
							<input class="input" value="{{ $user->company }}" type="text" id="company" name="company" />
						</div>
					</div>

					@if($is_admin)
					<div class="field">
						<label class="label" for="role">Site</label>
						<div class="select">
							<select name="role_id" id="role_id">
								@foreach ($sites as $site)
								<option 
								@if ($user->role->id == $site->role_id)
								selected="selected"
								@endif
								value="{{ $site->role_id }}">{{ $site->name }}
								</option>	
								@endforeach
							</select>
						</div>
					</div>
					@endif

					<div class="field">
						<label class="label" for="phone">Phone Number</label>
						<div class="control">
							<input class="input" value="{{ $user->phone }}" type="text" id="phone" name="phone" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="address">Address</label>
						<div class="control">
							<input class="input" value="{{ $user->address }}" type="text" id="address" name="address" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="city">City</label>
						<div class="control">
							<input class="input" value="{{ $user->city }}" type="text" id="city" name="city" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="state">State</label>
						<div class="control">
							<input class="input" value="{{ $user->state }}" type="text" id="state" name="state" />
						</div>
					</div>

					<div class="field">
						<label class="label" for="zip">Zip</label>
						<div class="control">
							<input class="input" value="{{ $user->zip }}" type="text" id="zip" name="zip" />
						</div>
					</div>

				</div>

				<div class="field flex-margin">
					<div class="control">
						<button class="button is-primary" type="submit">Update</button>
					</div>
				</div>

			</div>

		</form>

	</div>

</div>

@endsection