<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">

            	<h3>About Page</h3>

            	<div>Welcome {{ $name }}</div>
            	<div>Age: {{ $age }}</div>
            	<ul>
					@foreach( $tasks as $task )
						<li>{{ $task }}</li>
					@endforeach
            	</ul>



            </div>
        </div>
    </body>
</html>
