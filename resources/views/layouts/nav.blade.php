<ul class="sidebar-menu">

	<li>
		<a href="/sims">Sims</a>

		<ul class="sub-menu">
			@foreach( $report_types as $report_type )
				<li><a href="/sims/archive/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a></li>
			@endforeach
		</ul>

	</li>

	<li><a href="/sims/create">Add Sim</a></li>

	<li><a href="/assign-sims">Assign Sims</a></li>

	<li>
		<a href="/report_types">Report Types</a>
		<ul class="sub-menu">
			@foreach( $report_types as $report_type )
				<li><a href="/report_types/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a></li>
			@endforeach
		</ul>
	</li>
	
	<li><a href="/sims/upload">Upload</a></li>
	
	<li><a href="/users">Users</a></li>
	
	<li><a href="/sim_users">Sim Users</a></li>
	
	<li><a href="/carriers">Carriers</a></li>
	
	<li><a href="/settings">Settings</a></li>
	
	<li><a href="/site_settings">Site Settings</a></li>

</ul>