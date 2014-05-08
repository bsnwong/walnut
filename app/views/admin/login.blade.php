@extends('layouts.master')
<html>
    <head>
        @section('style')
            {{ HTML::style('css/form.css')}}
        @stop
    </head>
    <body>
    @section('middle')
    <div id="login_Form">
        {{ Form::open(array('url' => 'login')) }}
        {{--Email--}}
        {{ Form::label('email','邮箱:') }}
        {{ Form::text('email', '', array('placeholder' => 'Email...')) }}<br/>
        {{--Password--}}
        {{ Form::label('password', '密码:') }}
        {{ Form::password('password', array('placeholder' => 'Password...')) }}<br/>
        {{--User type--}}
        {{ Form::label('type', '用户类型:') }}
        {{ Form::label('normal', '普通', array('class' => 'label_default')) }}
        {{ Form::radio('normal', 0, true, array('class' => 'input_default', 'name' => 'type')) }}
        {{ Form::label('admin', '管理员:', array('class' => 'label_default')) }}
        {{ Form::radio('admin', 0, null, array('class' => 'input_default', 'name' => 'type')) }}
        {{ Form::submit('提交', array('id' => 'login_submit', 'class' => 'input_default submit')) }}
        {{--Register button--}}
        <a href="register">{{ Form::button('注册', array('id' => 'register', 'class' => 'submit input_default')) }}</a>
        {{ Form::close() }}
    </div>
    @stop
    </body>
</html>
