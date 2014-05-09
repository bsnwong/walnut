<!doctype html>
<html>
<head>
    {{ HTML::style('css/main.css')}}
    @yield('style')
</head>
<body>
    <div id="wrap">
        <div id="header">
            <div id="logo">{{ Form::image('image/logo.png', 'logo', array('width' => 380)) }}</div>
            <div>
                <ul class="nav1">
                    <li class="nav1-li"><a href="/home">主页</a></li>
                    <li class="nav1-li has_child">个人
                        <ul class="nav2 nav">
                            <li class="nav2-li">成绩查询</li>
                            <li class="nav2-li">个人信息</li>
                        </ul>
                    </li>
                    <li class="nav1-li has_child">功能
                        @if( Auth::check() )
                        <ul class="nav2 nav">
                            @if( Auth::user()->type == 0)
                            <li class="nav2-li">管理试题</li>
                            @endif
                            <li class="nav2-li">选择试题</li>
                            <li class="nav2-li">测试分析</li>
                            <li class="nav2-li">生成成绩单</li>
                        </ul>
                        @endif
                    </li>
                    <li class="nav1-li">公告</li>
                    <li class="nav1-li">关于</li>
                    @if( Auth::check() )
<!--                        <div hidde></div>-->
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
