<!doctype html>

<html lang="en">

@include('layouts.head')

<body class='stm-body'>

	@include('layouts.header')

	<div class="main-wrap">

		<div class="middle-content-wrap">
			<h1 class="title">
				@yield('title')
			</h1>
			<div class="container">
				<div id="content">
					@yield('content')
				</div>
			</div>
		</div>

	</div>

	@include('layouts.footer')

</body>

</html>

@include('layouts.scripts')

</body>

</html>