<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Sim Track Manager</title>
	<link rel="stylesheet" href="/css/app.css">
	<link rel="stylesheet" href="/fonts/vendor/my-icons-collection/font/flaticon.css">
</head>

<body class='stm-body'>

	<div class="stm-absolute-wrap" id="loader-wrap">
		<div class="loader"></div>
	</div>

	@include('layouts.header')

	@include('layouts.nav-mobile')

	<div class="main-wrap">

		@include('layouts.sidebar')

		<div class="middle-content-wrap">

			<h1 class="title">
				@yield('title')
			</h1>


			<div id="content">

				@include('layouts.alert')

				@yield('content')

			</div>


		</div>

	</div>

	<div class="modal" id="layout-modal">

		<div class="modal-background"></div>

		<div class="modal-content">

			<div class="modal-box">

				@yield('modal')

			</div>

		</div>

		<button class="modal-close is-large" aria-label="close"></button>

	</div>

	@include('layouts.footer')

	@include('layouts.scripts')
	
	@yield('page-script')

</body>

</html>