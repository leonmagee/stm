<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sim Track Manager - Working?</title>
	<link rel="stylesheet" href="{{ URL::asset('vendor/foundation/css/foundation.min.css') }}">
	<link rel="stylesheet" href="/css/app.css">
</head>

<body class='stm-body'>

	@include('layouts.header')

	<div class="middle-content-wrap">
		<div class="max-width-wrap">
			<div id="content">
				@yield('content')
			</div>
		</div>
	</div>

	@include('layouts.footer')

</body>

</html>

@include('layouts.scripts')

</body>

</html>