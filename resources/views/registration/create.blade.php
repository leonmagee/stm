@extends('layouts.layout-simple')

@section('content')

<div class="container">

	<h1 class="title">Add New User</h1>

	<form method="POST" action="/register">

		{{ csrf_field() }}

		<div class="field">
			<label class="label" for="name">Name</label>
			<div class="control">
				<input class="input" type="text" id="name" name="name" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="email">Email</label>
			<div class="control">
				<input class="input" type="email" id="email" name="email" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="company">Company</label>
			<div class="control">
				<input class="input" type="text" id="company" name="company" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="company">Site</label>
			<div class="select">
				<select name="role">
					@foreach ($sites as $site)
						<option value="{{ $site->id }}">{{ $site->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="field">
			<label class="label" for="phone">Phone Number</label>
			<div class="control">
				<input class="input" type="text" id="phone" name="phone" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="address">Address</label>
			<div class="control">
				<input class="input" type="text" id="address" name="address" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="city">City</label>
			<div class="control">
				<input class="input" type="text" id="city" name="city" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="state">State</label>
			<div class="control">
				<input class="input" type="text" id="state" name="state" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="zip">Zip</label>
			<div class="control">
				<input class="input" type="text" id="zip" name="zip" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="password">Password</label>
			<div class="control">
				<input class="input" type="password" id="password" name="password" required/>
			</div>
		</div>

		<div class="field">
			<label class="label" for="password_2">Password Confirm</label>
			<div class="control">
				<input class="input" type="password" id="password_2" name="password_confirmation" required/>
			</div>
		</div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Register</button>
            </div>
        </div>

        <div class="field">
        	
        	@include('layouts.errors')

        </div>

	</form>

	

</div>

@endsection