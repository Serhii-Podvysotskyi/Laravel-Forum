@extends('layouts.master')
@section('head')
    @parent
    <title>Account</title>
@stop
@section('content')
    user
@stop
@section('javascript')
    @parent
    <script type="text/javascript" src="{{ URL::to('/') }}/js/app.js"></script>
    <script type="text/javascript">
        URL = "{{ URL::to('/') }}";
    </script>
@stop