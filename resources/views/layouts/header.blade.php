<div class="header-wrap">
	
	<div class="logo-wrap">
		<a href="/">
			{{-- <img src="{{ URL::asset('img/stm_logo_white.png') }}" /> --}}
			Sim Track Manager
		</a>
	</div>

{{-- 	<div class="login-wrap">
		<div class="login-text">
			@if (Auth::check())
				Welcome <span class="name">{{ Auth::user()->name }}</span> <span>/</span> <a href="/logout">log out</a> <span>/</span> <a href="/contact">contact</a>
			@else
				<a href="/login">log in</a> <span>/</span> <a href="/register">register</a>
			@endif
		</div>
	</div> --}}

	<div class="header-area">
		<div class="login-text">
			@if (Auth::check())
				<div>Welcome <span class="name">{{ Auth::user()->name }}</span></div>
				<div><a href="/logout">log out</a></div>
			@else
				<a href="/login">log in</a> <span>/</span> <a href="/register">register</a>
			@endif
		</div>
	</div>

	<div class="header-area">
		<div class="date-wrap">
				<div>Active Date</div>
				<div>{{ $current_date }}</div>
		</div>
	</div>

	<div class="header-area">
		<div class="date-wrap">
				<div>Current Mode</div>
				<div>Active</div>
		</div>
	</div>

</div>