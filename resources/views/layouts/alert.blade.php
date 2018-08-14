@if($flash = session('message'))

<div class="notification is-success">

 	<button class="delete"></button>

	{{ $flash }}

</div>

@endif