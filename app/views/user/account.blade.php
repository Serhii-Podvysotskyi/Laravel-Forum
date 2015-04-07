@extends('layouts.master')
@section('head')
    @parent
    <title>Account</title>
@stop
@section('content')
    <div class="panel panel-primary">
	<div class="panel-heading">
            <div class="row">
                <div class="col-md-4 col-sm-5 col-lg-3 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding: 10px;">
                            <img src="{{ asset('img/'.$user->info->avatar) }}" class="img-rounded" id="avatar"/>
                            @if(Auth::check() && Auth::user()->id == $user->id)
                            <form style="margin-top: 10px;" method="post" enctype="multipart/form-data" action="{{ URL::route('user-avatar-upload') }}" style="z-index: 2;">
                                    <input type="file" id="image" name="image" data-filename-placement="inside">
                                    <button type="submit" class="btn btn-success" style="margin-top: 10px; width: 100%; z-index: 3;">Change</button>
                                    {{ Form::token() }}
                                </form>
                            @endif
                            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->id == $user->id))
                                <a href="{{ URL::route('user-delete-avatar', $user->id) }}" class="btn btn-danger" style="width: 100%; margin-top: 10px;">Delete</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-7 col-lg-9 col-xs-12">
                    <h4><b>{{ $user->username }}</b></h4>
                    <hr/>
                    @if(Auth::check() && Auth::user()->id == $user->id)
                        <p><form class="form-inline" action="{{ URL::route('user-set-name', 1) }}" method="post">
                            <div class="form-group">
                                <label for="Name">First Name : </label>
                                <input type="text" class="form-control" id="Name" name="Name" value="{{ $user->info->name1 }}">
                            </div>
                            {{ Form::token() }}
                            <button type="submit" class="btn btn-default">
                                {{ ($user->info->name1 == NULL)? 'Set' : 'Change' }}
                            </button>
                        </form></p>
                        <p><form class="form-inline" action="{{ URL::route('user-set-name', 2) }}" method="post">
                            <div class="form-group">
                                <label for="Name">Last Name : </label>
                                <input type="text" class="form-control" id="Name" name="Name" value="{{ $user->info->name2 }}">
                            </div>
                            {{ Form::token() }}
                            <button type="submit" class="btn btn-default">
                                {{ ($user->info->name2 == NULL)? 'Set' : 'Change' }}
                            </button>
                        </form></p>
                        <hr/>
                        @if($user->info->email == NULL)
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#email_modal">Set Email</a>
                        @endif
                    @else
                        @if($user->info->name1 != NULL)
                            <h4>
                                <b>First Name : </b>
                                {{ $user->info->name1 }}
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <a href="{{ URL::route('user-delete-name', $user->id).'/1' }}" class="btn btn-danger">Delete</a>
                                @endif
                            </h4>
                        @endif
                        @if($user->info->name2 != NULL)
                            <h4>
                                <b>First Name : </b>
                                {{ $user->info->name2 }}
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <a href="{{ URL::route('user-delete-name', $user->id).'/2' }}" class="btn btn-danger">Delete</a>
                                @endif
                            </h4>
                        @endif
                        @if($user->info->name1 != NULL && $user->info->name2 != NULL)
                            <hr/>
                        @endif
                    @endif
                    @if($user->info->email != NULL)
                        <h4>
                            <b>Email : </b>
                            <a class="email" href="mailto:{{ $user->info->email }}">{{ $user->info->email }}</a>
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <a href="{{ URL::route('user-delete-email', $user->id) }}" class="btn btn-danger">Delete</a>
                            @endif
                        </h4>
                    @endif
                </div>
            </div>
        </div>
	<div class="panel-body">
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist" id="myTab">
                    <li role="presentation" class="active"><a href="#threads" aria-controls="threads" role="tab" data-toggle="tab">Threads</a></li>
                    @if(Auth::check())
                        <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
                    @endif
                    @if(Auth::check() && (Auth::user()->id == $user->id || Auth::user()->isAdmin()))
                        <li role="presentation"><a href="#favourites" aria-controls="favourites" role="tab" data-toggle="tab">Favourites</a></li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="threads">
                        <div class="list-group">
                            @if($user->threads()->get()->count() != 0)
                                @foreach($user->threads as $thread)
                                    <a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item">
                                        @if(Auth::check() && (Auth::user()->id == $user->id) && $thread->isFavourite())
                                            <span class="glyphicon glyphicon-star favourite" aria-hidden="true"></span>
                                        @endif
                                        {{ $thread->title }}
                                        <span class="badge" style="background-color: #337ab7;">{{ $thread->size() }}</span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @if(Auth::check())
                        <div role="tabpanel" class="tab-pane fade" id="comments">
                            <div class="list-group">
                                @if($user->comments()->get()->count() != 0)
                                    @foreach($user->getThreads() as $thread)
                                        <a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item">
                                            @if(Auth::check() && (Auth::user()->id == $user->id) && $thread->isFavourite())
                                                <span class="glyphicon glyphicon-star favourite" aria-hidden="true"></span>
                                            @endif
                                            {{ $thread->title }}
                                            <span class="badge" style="background-color: #337ab7;">
                                                <span class="badge pull-right" style="background-color: white; color: #337ab7;">{{ $thread->size() }}</span>
                                                <span class="badge pull-right" style="background-color: #337ab7;">{{ $thread->getSize($user->id) }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(Auth::check() && (Auth::user()->id == $user->id || Auth::user()->isAdmin()))
                        <div role="tabpanel" class="tab-pane fade" id="favourites">
                            <div class="list-group">
                                @if($user->favourites()->get()->count() != 0)
                                    @foreach($user->getFavoriteThreads() as $thread)
                                        <a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item">
                                            @if(Auth::check() && (Auth::user()->id == $user->id) && $thread->isFavourite())
                                                <span class="glyphicon glyphicon-star favourite" aria-hidden="true"></span>
                                            @endif
                                            {{ $thread->title }}
                                            <span class="badge" style="background-color: #337ab7;">{{ $thread->size() }}</span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
	</div>
    </div>
    @if(Auth::check() && $user->info->email == NULL)
        <div class="modal fade" id="email_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
		<div class="modal-content">
                    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">
                            <span aria-dissen="true">&times;</span>
                            <span class="sr-only">Close</span>
			</button>
			<h4 class="modal-title">Set Email</h4>
                    </div>
                    <div class="modal-body">
			<form id="target_form" action="{{ URL::route('user-set-email') }}" method="post">
                            <div class="form-group{{ ($errors->has('email_body')) ? ' has-error' : ''}}">
				<label for="email_body">Email: </label>
				<input type="email_body" class="form-control" name="email_body" id="email_body" placeholder="Enter email">
                                @if($errors->has('email_body'))
                                    <p>{{ $errors->first('email_body') }}</p>
                                @endif
                            </div>
                            {{ Form::token() }}
			</form>
                    </div>
                    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" id="form_submit">Save</button>
                    </div>
		</div>
            </div>
	</div>
    @endif
@stop
@section('javascript')
    @parent
    <script type="text/javascript" src="{{ URL::to('/') }}/js/app.js"></script>
    <script type="text/javascript">
        URL = "{{ URL::to('/') }}";
    </script>
    @if(Session::has('modal'))
        <script type="text/javascript">
            $("{{ Session::get('modal') }}").modal('show');
        </script>
    @endif
@stop