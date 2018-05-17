@extends('layouts.layout-simple')

@section('content')

<div class="container">

	<h1 class="title">Log In!!!!!!!!</h1>

	<form method="POST" action="/login">

		{{ csrf_field() }}

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
                <button class="button is-link" type="submit">Log In</button>
            </div>
        </div>

	</form>

	@include('layouts.errors')

</div>

@endsection