@extends('layouts.master')
@section('script')
    {{ HTML::script('javascript/highcharts/js/highcharts.js') }}
    {{ HTML::script('javascript/user.js') }}
@stop
@section('style')
    {{ HTML::style('css/user.css') }}
@stop
@section('middle')
    <div id="sider">
        <ul> <strong>功能选项</strong>
            <li></a><a class="detail">个人信息</a>
                <ul>
                    <li><a class="detail" href="/admin/0/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/private">查看个人信息</a></li>
                    <li><a class="detail" href="/admin/0/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/edit">修改个人信息</a></li>
                </ul>
            </li>
            <li><a>试题管理</a>
                <ul>
                    <li><a class="detail" href="/admin/{{ Auth::user()->id }}/question/insert">试题录入</a></li>
                    <li><a class="detail" href="/admin/{{ Auth::user()->id }}/question/audit/1">试题审核</a></li>
                    <li><a class="detail" href="/admin/{{ Auth::user()->id }}/question/edit/1">试题编辑</a></li>
                    <li><a class="detail" href="/admin/{{ Auth::user()->id }}/question/read">阅卷</a></li>
                </ul>
            </li>
            <li><a href="/admin/action/orginsert">添加组织信息</a></li>
            <li><a href="/admin/action/courseinsert">添加学科信息</a></li>
            <li>测试分析
                <ul>
                    <li>test</li>
                </ul>
            </li>
            <li>所在区域情况</li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div id="container">
        @if(isset($childView))
        {{ $childView }}
        @endif
    </div>
@stop