@extends('layouts.layout')

@section('title')
Edit Report Type
@endsection

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

	<div class="form-wrapper-inner">

		<h3>Edit Spiff Report Type</h3>

		<form method="POST" action="/new-report-type">

			<div class="form-wrap">

				{{ csrf_field() }}

				<div class="form-wrap-flex">

					<div class="field">
						<label class="label" for="name">Name</label>
						<div class="control">
							<input class="input" type="text" id="name" name="name" value="{{ $reportType->name }}" />
						</div>
					</div>

					<div class="field">
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
							<label class="label" for="spiff_{{ $site->id }}">{{ $site->name }} Spiff</label>
							<div class="control">
								<input 
								value="{{ $site->spiff_value($reportType->id) }}"
								class="input" type="number" id="spiff_{{ $site->id }}" name="spiff_{{ $site->id }}" />
							</div>
						</div>

					@endforeach

				</div>

				<div class="field flex-margin">
					<div class="control">
						<button class="button is-link" type="submit">Update Report Type</button>
					</div>
				</div>

			</div>

		</form>

	</div>

</div>

@endsection