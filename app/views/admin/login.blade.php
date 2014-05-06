@extends('layouts.master')
<html>
    <head>
    </head>
    <body>
    @section('login')
    <div id="loginForm">
        {{ Form::open(array('url' => 'login')) }}
        {{--Email--}}
        {{ Form::label('email','邮箱:') }}
        {{ Form::text('email', '', array('placeholder' => 'Email...')) }}<br/>
        {{--Password--}}
        {{ Form::label('password', '密码:') }}
        {{ Form::password('password', array('placeholder' => 'Password...')) }}<br/>
        {{ Form::submit('Submit') }}
        {{ Form::close() }}
        {{--Register button--}}
        <a href="register">{{ Form::button('Register', array('id' => 'register')) }}</a>
    </div>
    @stop
    </body>
</html>
