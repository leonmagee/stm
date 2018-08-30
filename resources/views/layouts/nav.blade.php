<ul class="sidebar-menu">

{{-- 	.flaticon-memory-card:before { content: "\f100"; } good
.flaticon-sim-card:before { content: "\f101"; }
.flaticon-sim-card-1:before { content: "\f102"; }
.flaticon-sim:before { content: "\f103"; }
.flaticon-growth:before { content: "\f104"; }
.flaticon-report:before { content: "\f105"; }
.flaticon-report-1:before { content: "\f106"; }
.flaticon-user:before { content: "\f107"; }
.flaticon-group:before { content: "\f108"; }
.flaticon-user-1:before { content: "\f109"; }
.flaticon-user-2:before { content: "\f10a"; }
.flaticon-user-3:before { content: "\f10b"; }
.flaticon-gear:before { content: "\f10c"; }
.flaticon-gear-1:before { content: "\f10d"; }
.flaticon-gear-2:before { content: "\f10e"; }
.flaticon-upload-arrow:before { content: "\f10f"; }
.flaticon-upload:before { content: "\f110"; }
.flaticon-file-upload:before { content: "\f111"; } --}}

	<li>

		<div class="icon-wrap">
			<i class="flaticon-sim-card"></i>
		</div>

		<a>Monthly Sims</a>

		<ul class="sub-menu">
			
			<li><a href="/sims">All Sims</a></li>

			@foreach( $report_types as $report_type )
				<li><a href="/sims/archive/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a></li>
			@endforeach

			<li><a href="/sims/create">Add Sim</a></li>

		</ul>

	</li>

	<li>

		<div class="icon-wrap">
			<i class="flaticon-report"></i>
		</div>

		<a>Report Types</a>

		<ul class="sub-menu">

			<li><a href="/report-types">All Report Types</a></li>

			@foreach( $report_types as $report_type )
				<li><a href="/report-types/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a></li>
			@endforeach

			<li><a href="/add-report-type-spiff">Add New Spiff</a></li>
						
			<li><a href="/add-report-type-residual">Add New Residual</a></li>

		</ul>

	</li>

	<li>

		<div class="icon-wrap">
			<i class="flaticon-upload"></i>
		</div>

		<a href="/sims/upload">Upload Sims</a>

	</li>
	
	<li>

		<div class="icon-wrap">
			<i class="flaticon-group"></i>
		</div>

		<a>Users</a>
	
		<ul class="sub-menu">

			<li><a href="/users">All Users</a></li>
		
			<li><a href="/register">Add New User</a></li>

		</ul>

	</li>
	
	
	<li>

		<div class="icon-wrap">
			<i class="flaticon-report-1"></i>
		</div>

		<a>User Sims</a>

		<ul class="sub-menu">

			<li><a href="/user-sims">All Sims</a></li>

			<li><a href="/assign-sims">Assign Sims</a></li>
			
			<li><a href="/find-sims">Look Up Sims</a></li>
			
			<li><a href="/delete-sims">Delete Sims</a></li>

		</ul>

	</li>
	
	<li>

		<div class="icon-wrap">
			<i class="flaticon-gear"></i>
		</div>

		<a>Settings</a>

		<ul class="sub-menu">

			<li><a href="/settings">Default Settings</a></li>
	
			<li><a href="/site-settings">Site Settings</a></li>

			<li><a href="/carriers">Carriers</a></li>

		</ul>

	</li>
	
	<li>

		<div class="icon-wrap">
			<i class="flaticon-growth"></i>
		</div>

		<a href="/reports">Reports</a>

	</li>

</ul>