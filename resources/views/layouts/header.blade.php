<div class="header-wrap">
	
	<div class="logo-wrap">
		<a href="/">
			<img src="{{ URL::asset('img/stm_logo.png') }}" />
		</a>
	</div>

	<div class="login-wrap">
		<div class="login-text">
			@if (Auth::check())
				Welcome {{ Auth::user()->name }} - <a href="/logout">log out</a>
			@else
				<a href="/login">log in</a> - <a href="/register">register</a>
			@endif
		</div>
	</div>

</div>