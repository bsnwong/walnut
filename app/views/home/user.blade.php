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
            <li><a href="javascript:void(0);" class="toggle"></a><a class="detail" href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/private">个人信息</a>
                <ul>
                    <li> <a class="detail" href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/edit">修改个人信息</a></li>
                    <li><a href="javascript:void(0);" class="toggle"></a>修改
                        <ul>
                            <li>asdas</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>最近状况</li>
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