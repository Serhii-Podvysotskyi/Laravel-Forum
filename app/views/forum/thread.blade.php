@extends('layouts.master')
@section('head')
    @parent
    <title>Forum | {{ $thread->title }}</title>
@stop
@section('content')
    <div class="clearfix">
	<ol class="breadcrumb pull-left">
            <li><a href="{{ URL::route('forum-home') }}">Forums</a></li>
            <li><a href="{{ URL::route('forum-category', $thread->category_id) }}">{{ $thread->category->title }}</a></li>
            <li class="active">{{ $thread->title }}</li>
	</ol>
	@if(Auth::check())
            @if(Auth::user()->isAdmin())
                <a href="{{ URL::route('forum-delete-thread', $thread->id) }}" class="btn btn-danger pull-right">Delete</a>
            @endif
            <a class="btn {{ ($thread->isFavourite())? 'btn-warning' : 'btn-default'  }} pull-right" id="favourite">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </a>
	@endif
    </div>
    <div class="panel panel-primary">
	<div class="panel-heading">
            <div class="row">
                <div class="col-md-2 col-sm-4 col-lg-2 col-xs-5">
                    <a href="{{ URL::route('forum-user', $thread->author->id) }}" class="thumbnail">
                        <img src="{{ asset('img/'.$thread->author->info->avatar) }}" class="img-thumbnail" id="avatar">
                    </a>
                </div>
                <div class="col-md-10 col-sm-8 col-lg-10 col-xs-7">
                    <h4><b>{{ $thread->title }}</b></h4>
                    <hr/>
                    By: <strong>{{ $author }}</strong> on {{ $thread->created_at }}
                </div>
            </div>
        </div>
	<div class="panel-body">
            {{ nl2br(BBCode::parse($thread->body)) }}
	</div>		
    </div>
    @foreach ($thread->comments()->get() as $comment)
        <div class="row" id="{{ $comment->id }}">
            <div class="col-md-2 col-sm-2 col-lg-1 col-xs-4">
                <a href="{{ URL::route('forum-user', $thread->author->id) }}" class="thumbnail">
                    <img src="{{ asset('img/'.$comment->author->info->avatar) }}" class="img-thumbnail" id="avatar">
                </a>
            </div>
            <div class="col-md-10 col-sm-10 col-lg-11 col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="pull-left">By: <strong>{{ $comment->author->username }}</strong> on {{ $comment->created_at }}</p>
                        @if (Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ URL::route('forum-delete-comment', $comment->id) }}" class="btn btn-danger pull-right btn-sm">Delete</a>
                        @endif
                        <div class="{{ (Auth::check())? 'like ' : ''}}pull-right{{ (Auth::check() && $comment->isLike())? ' active' : ''}}" id="like">
                            <span class="badge glyphicon glyphicon-heart">{{ $comment->likes->count() }}</span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <p>{{ nl2br(BBCode::parse($comment->body)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if(Auth::check())
	<form action="{{ URL::route('forum-store-comment', $thread->id) }}" method="post">
            <div class="form-group">
		<label for="body">Comment: </label>
		<textarea class="form-control" name="body" id="body"></textarea>
            </div>
            {{ Form::token() }}
            <div class="form-group">
		<input type="submit" value="Add" class="btn btn-primary">
            </div>
	</form>
    @endif
    <br/><br/><br/><br/><br/>
@stop
@section('javascript')
    @parent
    <script type="text/javascript" src="{{ URL::to('/') }}/js/app.js"></script>
    <script type="text/javascript">
        URL = "{{ URL::to('/') }}";
    </script>
@stop