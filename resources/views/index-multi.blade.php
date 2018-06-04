@extends('layouts.layout-simple')

@section('content')

<div class="homepage-wrap">

	<h3>Choose Your Site</h3>

	<div class="sites-wrap">

		@if(count($sites))

			@foreach($sites as $site)

				<div class="site"><a href="/{{ str_replace(' ', '-', strtolower($site->name) )}}">{{ $site->name }}</a></div>	

			@endforeach

		@endif

	</div>

</div>

@endsection