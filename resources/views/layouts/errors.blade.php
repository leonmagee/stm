@if(count($errors))
<div class="callout alert">
	@foreach($errors->all() as $error)

	    <div>{{ $error }}</div>

	@endforeach
</div>
@endif


<div class="notification is-danger">
  <button class="delete"></button>
  Primar lorem ipsum dolor sit amet, consectetur
  adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
  consectetur adipiscing elit
</div>