@if($flash = session('message'))

<div class="notification is-primary">

 	<button class="delete"></button>

	{{ $flash }}

</div>

@endif