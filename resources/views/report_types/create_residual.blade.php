@extends('layouts.layout')

@section('title')
Add New Report Type
@endsection

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>New Residual Report Type</h3>

		<form method="POST" action="/new-report-type-residual">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="form-wrap-flex">

					<div class="field half">
						<label class="label" for="name">Name</label>
						<div class="control">
							<input class="input" type="text" id="name" name="name" />
						</div>
					</div>

					<div class="field half">
						<label class="label" for="carrier">Carrier</label>
						<div class="select">
							<select name="carrier" id="carrier">
								@foreach($carriers as $carrier)
								<option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					@foreach ($sites as $site)

						<div class="field">
							<label class="label" for="residual_{{ $site->id }}">{{ $site->name }} Residual</label>
							<div class="control">
								<input class="input" type="number" id="residual_{{ $site->id }}" name="residual_{{ $site->id }}" />
							</div>
						</div>

					@endforeach

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