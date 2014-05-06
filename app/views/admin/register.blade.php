@extends('layouts.master')

@section('style')
    {{ HTML::style('css/form.css')}}
@stop

{{--The register form--}}
@section('middle')
<div id="register_form">
    <div id="form_input">
        <div class="float_left">
            {{ Form::open(array('url' => 'register')) }}
            {{ Form::label('name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名:') }}
            {{ Form::text('name', '', array('placeholder' => '请输入您的姓名...')) }}<br/><br/>
            {{ Form::label('name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;性别:') }}
            {{ Form::radio('male', 0, true, array('class' => 'input_default', 'name' => 'sexual')) }}
            {{ Form::label('male', '男') }}
            {{ Form::radio('female', 1, null, array('class' => 'input_default', 'name' => 'sexual')) }}
            {{ Form::label('female', '女') }}
            {{ Form::radio('other', 2, null, array('class' => 'input_default', 'name' => 'sexual')) }}
            {{ Form::label('other', '其他') }}<br/><br/>
            {{ Form::label('email', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱:') }}
            {{ Form::email('email', '', array('placeholder' => '请输入您的邮箱...')) }}<br/><br/>
            {{ Form::label('password', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码:') }}
            {{ Form::password('password', array('placeholder' => "请输入密码...")) }}<br/><br/>
            {{ Form::label('password2', '确认密码:') }}
            {{ Form::password('password2', array('placeholder' => "请再次输入密码..."))}}<br/><br/>

            {{--Select the school from database--}}
            {{ Form::label('school', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学校:') }}
            {{ Form::macro('selectSchool', function() {
                $school = DB::table('Organization')
                ->where('parent_node', '=', 0)
                ->select('id', 'name')
                ->get();
                $school_item = array();
                foreach($school as $item) {
                $school_item[$item->id] = $item->name;
                }
                return Form::select('school', $school_item);
                }
            ) }}
            {{ Form::selectSchool() }}<br/><br/>
            {{ Form::label('college', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院:') }}
            {{ Form::select('college', array()) }}<br/><br/>
            {{ Form::label('major', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;专业:') }}
            {{ Form::select('major', array()) }}<br/><br/>
            {{ Form::label('school_num', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学号:') }}
            {{ Form::text('school_num', '', array('placeholder' => '请输入您的学号...')) }}<br/><br/>
        </div>
        <div class="float_right" id="photo">
            <div id="photo_show">相片</div>
            <div id="photo_upload">
                {{ Form::file('photo', array('id' => 'upload_button', 'placeholder' => '选择一张图片作为您的头像')) }}
            </div>
        </div>
    </div>
    <div class="clear"></div>
    {{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default')) }}
    {{ Form::close() }}
</div>
@stop

@section('script')
    {{ HTML::script('javascript/request.js') }}
@stop
