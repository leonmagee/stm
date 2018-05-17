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

	@include('layouts.header')

	<div class="main-wrap">

		<div class="middle-content-wrap">
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