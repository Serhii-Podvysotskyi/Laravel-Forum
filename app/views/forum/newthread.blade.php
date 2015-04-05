@extends('layouts.master')

@section('head')
	@parent
	<title>New Thread</title>
@stop

@section('content')
	<form action="{{ URL::route('forum-store-thread', $id) }}" method="post">
		<div class="form-group">
			<label for="title">Title: </label>
			<input type="text" class="form-control" name="title" id="title">
		</div>
		<div class="form-group">
			<label for="body">Body: </label>
			<textarea class="form-control" name="body" id="body"></textarea>
		</div>
		{{ Form::token() }}
		<div class="form-group">
			<input type="submit" value="Add" class="btn btn-primary">
		</div>
	</form>
@stop