@extends('layouts.layout')

@section('content')

<form method="POST" action="send_test_email">

	{{ csrf_field() }}

	<input type="submit" value="send test email" class="button is-primary" />

</form>

@endsection