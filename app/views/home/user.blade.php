@extends('layouts.master')

@section('style')
    {{ HTML::style('css/user.css') }}
@stop
@section('middle')
    <div id="sider">
        <ul> <strong>功能选项</strong>
            <li>个人信息
                <ul>
                    <li><a class="detail" href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/private">查看个人信息</a>
                    <li><a class="detail" href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/edit">修改个人信息</a></li>
                </ul>
            </li>
            <li>开始测试
                <ul>
                    <li><a class="test" type="1" href="/user/test/standard">标准测试</a></li>
                    <li><a class="test" type="2" href="/user/test/diy">自定义测试</a></li>
                </ul>
            </li>
            <li>我的试题管理
                <ul>
                    <li><a href="/user/action/denote">贡献试题</a></li>
                    <li><a href="/user/denote/pass">已经通过</a></li>
                    <li><a href="/user/denote/wait">待审核</a></li>
                </ul>
            </li>
            <li>测试分析
                <ul>
                    <li><a href="/user/action/chart">个人情况</a></li>
                    <li><a href="/user/action/allchart">总体情况</a></li>
                    <li><a href="/user/action/compare">对比</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div id="container">
        @if(isset($childView))
            {{ $childView }}
        @endif
    </div>
@stop
@section('script')
{{ HTML::script('javascript/highcharts/js/highcharts.js') }}
{{ HTML::script('javascript/user.js') }}
@stop
