@extends('layouts.master')

@section('head')
	@parent
	<title>Register Page</title>
@stop

@section('content')
	<div class="container">
		<h1>Login</h1>
		<form role="form" method="post" action="{{ URL::route('postLogin') }}">
			<div class="form-group {{ ($errors->has('username')) ? ' has-error' : '' }}">
				<label for="username">Username: </lable>
					<input id="username" name="username" type="text" class="form-control">
					@if($errors->has('username'))
						{{ $errors->first('username') }}
					@endif
			</div>
			<div class="form-group {{ ($errors->has('pass1')) ? ' has-error' : '' }}">
				<label for="pass1">Password: </lable>
					<input id="pass1" name="pass1" type="password" class="form-control">
					@if($errors->has('pass1'))
						{{ $errors->first('pass1') }}
					@endif
			</div>
			<div class="checkbox">
				<label for="remember">
					<input type="checkbox" name="remember" id="remember">
					Remember me!
				</label>
				</label>
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" value="Login" class="btn btn-default">
			</div>
		</form>
	</div>	
@stop