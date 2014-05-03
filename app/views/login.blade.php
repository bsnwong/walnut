@extends('layouts.master')
<html>
    <head>
    </head>
    <body>
    @section('login')
    <div id="loginForm">
        {{ Form::open(array('url' => 'login')) }}
        {{--Username--}}
        {{ Form::label('username','用户名:') }}
        {{ Form::text('username', '', array('placeholder' => 'Username...')) }}<br/>
        {{--Password--}}
        {{ Form::label('password', '密码:') }}
        {{ Form::password('password', array('placeholder' => 'Password...')) }}<br/>
        {{--Password2--}}
        {{ Form::label('password2', '确认密码') }}
        {{ Form::password('password2', array('placeholder' => 'Password again...')) }}<br/>
        {{ Form::submit('Submit') }}
        {{ Form::close() }}
    </div>
    @stop
    </body>
</html>
