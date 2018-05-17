@extends('layouts.layout-simple')

@section('content')

<div class="container">

	<h1 class="title">Register</h1>

	<form method="POST" action="/register">

		{{ csrf_field() }}

		<div class="field">
			<label class="label">Name</label>
			<div class="control">
				<input class="input" type="text" name="name" />
			</div>
		</div>

		<div class="field">
			<label class="label">Email</label>
			<div class="control">
				<input class="input" type="email" name="email" />
			</div>
		</div>

		<div class="field">
			<label class="label">Password</label>
			<div class="control">
				<input class="input" type="text" name="password" />
			</div>
		</div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Register</button>
            </div>
        </div>

	</form>

	@include('layouts.errors')

</div>

@endsection