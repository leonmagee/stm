<ul class="sidebar-menu">

	@foreach($menu as $item)

		<li>

			<div class="icon-wrap">
				<i class="fi {{ $item['icon'] }}"></i>
			</div>

			@if($item['link'])

				<a href="{{ $item['link'] }}">{{ $item['name'] }}</a>

			@else

				@if($item['default'])
				
					<a href="{{ $item['default'] }}">{{ $item['name'] }}</a>

				@else

					<a>{{ $item['name'] }}</a>

				@endif

			<ul class="sub-menu">

				@foreach( $item['sub'] as $sub)

					<li><a href="{{ $sub['link'] }}">{{ $sub['name'] }}</a></li>

				@endforeach
				
			</ul>

			@endif

		</li>

	@endforeach

</ul>