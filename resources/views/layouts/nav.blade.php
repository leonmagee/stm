<ul class="menu">

	<li><a href="/home">Dashboard</a></li>

	@if (!Auth::check()) 

	<li><a href="/login">Login</a></li>

	<li><a href="/register">Register</a></li>

	@endif


	<li>
		<a href="/sims">Sims</a>

		<ul class="sub-menu">
			@foreach( $report_types as $report_type )
				<li><a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier }} {{ $report_type->name }}</a></li>
			@endforeach
		</ul>

	</li>

	<li><a href="/add-sim">Add Sim</a></li>

	<li><a href="/assign-sims">Assign Sims</a></li>

	<li>
		<a href="/report_types">Report Types</a>
		<ul class="sub-menu">
			@foreach( $report_types as $report_type )
				<li><a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier }} {{ $report_type->name }}</a></li>
			@endforeach
		</ul>
	</li>
	
	<li><a href="/sims/upload">Upload</a></li>
	
	<li><a href="/sim_users">Sim Users</a></li>

	@if (Auth::check()) 

	<li><a>Welcome {{ Auth::user()->name }}</a></li>

	<li><a href="/logmeout">Log Out</a></li>

	@endif

</ul>