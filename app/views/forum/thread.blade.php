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
	@if(Auth::check() && Auth::user()->isAdmin())
            <a href="{{ URL::route('forum-delete-thread', $thread->id) }}" class="btn btn-danger pull-right thread_delete">Delete</a>
        @endif
    </div>
    <div class="panel panel-primary">
	<div class="panel-heading">
            <div class="row thread-body">
                <div class="col-md-4 col-sm-6 col-lg-3 col-xs-6">
                    <a href="{{ URL::route('forum-user', $thread->author->id) }}" class="thumbnail" id="avatar">
                        <img src="{{ asset('img/'.$thread->author->info->avatar) }}" class="img-rounded" id="avatar">
                    </a>
                </div>
                <div class="col-md-8 col-sm-6 col-lg-9 col-xs-6">
                    @if(Auth::check())
                        <a class="btn {{ ($thread->isFavourite())? 'btn-warning' : 'btn-default'  }} add_favourite" id="favourite">
                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                        </a>
                    @endif
                    <h4><b>{{ $thread->title }}</b></h4>
                    <hr/>
                    By: <strong>{{ $author }}</strong> on {{ $thread->created_at }}
                    <br/><br/>
                    <div class="panel thread-body">
                        {{ nl2br(BBCode::parse($thread->body)) }}
                    </div>
                </div>
            </div>
        </div>	
    </div>
    <hr/>
    @foreach ($thread->comments()->get() as $comment)
        <div class="row" id="{{ $comment->id }}">
            <div class="col-md-3 col-sm-5s col-lg-2 col-xs-5">
                <a href="{{ URL::route('forum-user', $comment->author->id) }}" class="thumbnail">
                    <img src="{{ asset('img/'.$comment->author->info->avatar) }}" class="img-rounded" id="avatar">
                </a>
            </div>
            <div class="col-md-9 col-sm-7 col-lg-10 col-xs-7">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="pull-left">By:
                            <strong>
                                <a href="{{ URL::route('forum-user', $comment->author->id) }}">{{ $comment->author->username }}</a>
                            </strong> on {{ $comment->created_at }}</p>
                        @if (Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ URL::route('forum-delete-comment', $comment->id) }}" class="btn btn-danger pull-right btn-xs comment_dalete">Delete</a>
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
        <hr/>
    @endforeach
    @if(Auth::check())
        <form action="{{ URL::route('forum-store-comment', $thread->id) }}" method="post" class="col-md-8 col-md-offset-2" style="margin-bottom: 80px;">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group{{ ($errors->has('body')) ? ' has-error' : ''}}">
                        <label for="body">Comment: </label>
                        <textarea class="form-control" name="body" id="body">{{ (Input::has('body'))? Input::get('body') : '' }}</textarea>
                    </div>
                    {{ Form::token() }}
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" value="Add" class="btn btn-primary btn-lg pull-right" id="add_comment" style="margin-top: 15px; margin-left: 15px;">
                        <div class="g-recaptcha pull-right" data-sitekey="6Lfn7gQTAAAAAH1nPaiMYmFE44X5Gz9Fs-2JT6bw"></div>
                        <br/>
                    </div>
                    <br/><br/>
                </div>
            </div>
        </form>
    @endif
@stop
@section('javascript')
    @parent
    <script type="text/javascript" src="{{ URL::to('/') }}/js/app.js"></script>
    <script type="text/javascript">
        URL = "{{ URL::to('/') }}";
    </script>
@stop