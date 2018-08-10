@extends('layouts.layout-simple')

@section('title')
Log In
@endsection

@section('content')

<div class="container">

	<form method="POST" action="/login">

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
                <button class="button is-link" type="submit">Log In</button>
            </div>
        </div>

        <div class="field">
        	
        	@include('layouts.errors')
        	
        </div>

	</form>

</div>

@endsection