<div class="header-wrap">
	
	<div class="logo-wrap">
		<a href="/">
			{{-- <img src="{{ URL::asset('img/stm_logo_white.png') }}" /> --}}
			Sim Track Manager
		</a>
	</div>

	<div class="header-area">
		<div class="login-text">
			@if (Auth::check())

				<div class="field has-addons">
				  <p class="control">
				    <a class="button type" href="/settings">
				      <span class="icon is-small">
				        <i class="fas fa-sitemap"></i>
				      </span>
				      <span class="text">{{ $site }}</span>
				    </a>
				  </p>
				  <p class="control">
				    <a class="button date" href="/settings">
				      <span class="icon is-small">
				        <i class="fas fa-calendar"></i>
				      </span>
				      <span class="text">{{ $current_date }}</span>
				    </a>
				  </p>
				  <p class="control">
				    <a class="button user" href="/profile">
				      <span class="icon is-small">
				        <i class="fas fa-user"></i>
				      </span>
				      <span class="text">{{ Auth::user()->name }}</span>
				    </a>
				  </p>
				  <p class="control">
				    <a class="button logout" href="/logout">
				      <span class="icon is-small">
				        <i class="fas fa-times-circle"></i>
				      </span>
				      <span class="text">Log Out</span>
				    </a>
				  </p>
				  <p class="control">
				    <a class="button settings" href="/settings">
				      <span class="icon is-small">
				        <i class="fas fa-cog"></i>
				      </span>
				      <span class="text">Settings</span>
				    </a>
				  </p>
				  <p class="control">
				    <a class="button mode {{ $mode }}" href="/settings">
				      <span class="icon is-small">
				      	@if($mode == 'online')
				        <i class="fas fa-signal"></i>
				        @else
				        <i class="fas fa-lock"></i>
				        @endif
				      </span>
				      <span class="text">{{ $mode }}</span>
				    </a>
				  </p>
				</div>

			@else
				<div class="field has-addons">
				  <p class="control">
				    <a class="button login" href="/login">
				      <span class="icon is-small">
				        <i class="fas fa-user-check"></i>
				      </span>
				      <span class="text">Log In</span>
				    </a>
				  </p>
				  <p class="control">
				    <a class="button contact" href="/contact">
				      <span class="icon is-small">
				        <i class="fas fa-question-circle"></i>
				      </span>
				      <span class="text">Contact</span>
				    </a>
				  </p>
				</div>
			@endif
		</div>
	</div>

</div>