<!doctype html>
<html>
<head>
    {{ HTML::style('css/main.css')}}
    @yield('style')
</head>
<body>
    <div id="wrap">
        <div id="header">
            <div id="logo">{{ Form::image('image/logo.png', 'logo', array('width' => 380, 'style' => 'background:none;border:none')) }}</div>
            <div>
                <ul class="nav1">
                    @if(Auth::check())
                    @if(Auth::user()->type == 0)
                    <li class="nav1-li"><a href="/admin/action/allchart">主页</a></li>
                    @elseif(Auth::user()->type == 1)
                    <li class="nav1-li"><a href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section">主页</a></li>
                    @endif
                    @endif
                    <li class="nav1-li has_child">个人
                        <ul class="nav2 nav">
                            @if( Auth::check() )
                            @if(Auth::user()->type == 0)
                            <li><a class="detail nav2-li" href="/admin/0/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/private">查看个人信息</a></li>
                            <li><a class="detail nav2-li" href="/admin/0/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/edit">修改个人信息</a></li>
                            @elseif(Auth::user()->type == 1)
                            <li><a class="detail nav2-li" href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/private">查看个人信息</a>
                            <li><a class="detail nav2-li" href="/user/1/{{ Auth::user()->name }}/{{ Auth::user()->id }}/section/edit">修改个人信息</a></li>
                            @endif
                            @endif
                        </ul>
                    </li>
                    <li class="nav1-li has_child">功能
                        @if( Auth::check() )
                        <ul class="nav2 nav">
                            @if( Auth::user()->type == 0)
                            <li><a class="nav2-li" href="/admin/{{ Auth::user()->id }}/question/insert">试题录入</a></li>
                            <li><a class="nav2-li" href="/admin/{{ Auth::user()->id }}/question/audit/1">试题审核</a></li>
                            <li><a class="nav2-li" href="/admin/{{ Auth::user()->id }}/question/edit/1">试题编辑</a></li>
                            <li><a class="nav2-li" href="/admin/{{ Auth::user()->id }}/question/read">阅卷</a></li>
                            @endif
                            @if( Auth::user()->type == 1)
                            <li><a class="nav2-li" href="/user/action/denote">贡献试题</a></li>
                            <li><a class="nav2-li"  href="/user/denote/pass">已经通过</a></li>
                            <li><a class="nav2-li"  href="/user/denote/wait">待审核</a></li>
                            <li><a  class="nav2-li"href="/user/action/chart">个人情况</a></li>
                            @endif
                        </ul>
                        @endif
                    </li>
                    <li class="nav1-li">公告</li>
                    <li class="nav1-li"><a href="/about">关于</a></li>
                    @if( Auth::check() )
                        <li class="nav1-li"><a href="/logout">退出</a></li>
                    @else
                        <li class="nav1-li has_child"><a href="/login">登入</a>
                            <ul class="nav2 nav">
                                <li class="nav2-li"><a href="/register">注册</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

            </div>
        </div>
        <div class="clear"></div>
        <div id="middle">
            @if(Auth::check())
            <div class="float_right" id="back"><a href="{{ URL::previous() }}">返回上一页</a></div>
            @endif
            <div class="clear"></div>
            @yield('middle')
        </div>
        <div class="clear"></div>
        <div id="footer">
            Powered by<a style="color: #FF6347"> Laravel </a> | Designed by <a style="color: #FF6347">Bsn</a>
        </div>
    </div>
</body>
{{ HTML::script('javascript/jquery.js') }}
{{ HTML::script('javascript/main.js') }}
@yield('script')
</html>
