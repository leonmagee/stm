<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Sim Track Manager</title>
		<link rel="stylesheet" href="/css/app.css">
	</head>

	<body class='stm-body'>

		<div class="stm-absolute-wrap" id="loader-wrap">
			<div class="loader"></div>
		</div>

		@include('layouts.header')

		<div class="main-wrap">

			@include('layouts.sidebar')
			
			<div class="middle-content-wrap">

				<div class="container">

					<div id="content">

						@yield('content')

					</div>

				</div>

			</div>

		</div>

		@include('layouts.footer')

		@include('layouts.scripts')

	</body>

</html>