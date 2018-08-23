@if($flash = session('message'))

<div class="notification is-success">

 	<button class="delete"></button>

	{{ $flash }}

</div>

@endif

@if($duplicates = session('duplicates'))

<div class="notification is-danger">

 	<button class="delete"></button>

 	<span>Duplicate Sims Not Uploaded</span>
 	
	<ul>
		@foreach($duplicates as $duplicate)
			
			<li>{{ $duplicate }}</li>

		@endforeach
	</ul>

</div>

@endif