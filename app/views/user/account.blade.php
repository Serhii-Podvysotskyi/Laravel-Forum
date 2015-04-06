@extends('layouts.master')
@section('head')
    @parent
    <title>Account</title>
@stop
@section('content')
    <div class="panel panel-primary">
	<div class="panel-heading">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                    <img src="{{ asset('img/'.$user->info->avatar) }}" class="img-thumbnail" id="avatar">
                    @if(Auth::check() && Auth::user()->id == $user->id)
                        <button class="btn btn-success" style="width: 100%; margin-top: 10px;">Change</button>
                    @endif
                </div>
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
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
                            <button type="button" class="btn btn-warning">Set Email</button>
                        @endif
                    @else
                        @if($user->info->name1 != NULL)
                            <h4>
                                <b>First Name : </b>
                                {{ $user->info->name1 }}
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ URL::route('forum-delete-thread', $user->id) }}" class="btn btn-danger">Delete</a>
                                @endif
                            </h4>
                        @endif
                        @if($user->info->name2 != NULL)
                            <h4>
                                <b>First Name : </b>
                                {{ $user->info->name2 }}
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ URL::route('forum-delete-thread', $user->id) }}" class="btn btn-danger">Delete</a>
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
                            @if(Auth::user()->isAdmin())
                                <a href="{{ URL::route('forum-delete-thread', $user->id) }}" class="btn btn-dangert">Delete</a>
                            @endif
                        </h4>
                        
                    @endif
                </div>
            </div>
        </div>
	<div class="panel-body">
            body
	</div>		
    </div>
@stop
@section('javascript')
    @parent
    <script type="text/javascript" src="{{ URL::to('/') }}/js/app.js"></script>
    <script type="text/javascript">
        URL = "{{ URL::to('/') }}";
    </script>
@stop