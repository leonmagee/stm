@if(count($errors))

<div class="notification is-danger">

  <button class="delete"></button>

	@foreach($errors->all() as $error)

	    <div>{{ $error }}</div>

	@endforeach
	
</div>

@endif