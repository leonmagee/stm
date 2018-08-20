	<div class="modal" id="menu-modal">

		<div class="modal-background"></div>

		<div class="modal-content">
			
			<div class="modal-box">

				<div class="close-button-wrap">

					<button class="menu-modal-close button is-primary">Close Menu</button>

				</div>

				<ul class="mobile-menu">

					<li>
						<a class="has-menu">Sims</a>

						<ul class="sub-menu">

							<li><a href="/sims">All Sims</a></li>

							@foreach( $report_types as $report_type )
							<li><a href="/sims/archive/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a></li>
							@endforeach

							<li><a href="/sims/create">Add Sim</a></li>

							<li><a href="/assign-sims">Assign Sims</a></li>

						</ul>

					</li>



					<li>
						<a class="has-menu">Report Types</a>
						<ul class="sub-menu">
							<li><a href="/report-types">All Report Types</a></li>
							@foreach( $report_types as $report_type )
							<li><a href="/report-types/{{ $report_type->id }}">{{ $report_type->carrier->name }} {{ $report_type->name }}</a></li>
							@endforeach
						</ul>
					</li>

					<li>
						<a href="#">New Report Type</a>
						<ul class="sub-menu">
							<li><a href="/add-report-type-spiff">New Spiff</a></li>
							<li><a href="/add-report-type-residual">New Residual</a></li>
						</ul>
					</li>

					<li><a href="/sims/upload">Upload</a></li>

					<li><a href="/users">Users</a></li>

					<li><a href="/register">New User</a></li>

					<li><a href="/sim-users">Sim Users</a></li>

					<li><a href="/carriers">Carriers</a></li>

					<li><a href="/settings">Settings</a></li>

					<li><a href="/site-settings">Site Settings</a></li>

					<li><a href="/reports">Reports</a></li>

				</ul>

			</div>

		</div>

	</div>