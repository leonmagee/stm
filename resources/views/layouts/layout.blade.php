<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sim Track Manager</title>
	<link rel="stylesheet" href="/css/app.css">
</head>

<body class='stm-body'>

	@include('layouts.header')

	<div class="main-wrap">

		@include('layouts.sidebar')
		
		<div class="middle-content-wrap">
			<div class="max-width-wrap">
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