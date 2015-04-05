<!doctype html>
<html lang="en">
<head>
	@yield('head')
		<meta charset="UTF-8">
		<link rel="stylesheet" href="http://{{ Request::server("HTTP_HOST") }}/Bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/style.css">
	@show
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://{{ Request::server("HTTP_HOST") }}">HOME</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ URL::route('forum-home') }}">Forums</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(!Auth::check())
						<li><a href="{{ URL::route('getCreate') }}">Register</a></li>
						<li><a href="{{ URL::route('getLogin') }}">Login</a></li>
					@else
						<li><a href="{{ URL::route('getLogout') }}">Logout</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">@yield('content')</div>

	@section('javascript')
		<script src=<?php echo '"http://'.Request::server("HTTP_HOST").'/jQuery/jquery-2.1.3.min.js"';?>></script>
		<script src=<?php echo '"http://'.Request::server("HTTP_HOST").'/Bootstrap/3.3.4/js/bootstrap.min.js"';?>></script>
	@show
</body>
</html>