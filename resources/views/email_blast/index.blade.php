@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>User Email Blast</h3>

		<form method="POST" action="/email-blast">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="form-wrap-flex">

					<div class="field full padding-bottom">
						<label class="label" for="name">Email Message</label>
						<div class="control">
							<textarea class="textarea" name="message">Sim Track Manager is now unlocked. Please log in to view your monthly commission report.</textarea>
						</div>
					</div>

				</div>

				<div class="field flex-margin">
					<div class="control">
						<button class="button is-primary call-loader" type="submit">Email All Users</button>
					</div>
				</div>

			</div>

		</form>

	</div>

</div>

@endsection