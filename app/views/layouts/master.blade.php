<!doctype html>
<html>
<head>
    {{ HTML::style('css/main.css')}}
</head>
<body>
    <div id="wrap">
        <div id="header">
            <div>
                <ul class="nav1">
                    <li class="nav1-li">主页
                        <ul class="nav2">

                        </ul>
                    </li>
                    <li class="nav1-li">个人
                        <ul class="nav2">
                            <li class="nav2-li">成绩查询</li>
                            <li class="nav2-li">个人信息</li>
                        </ul>
                    </li>
                    <li class="nav1-li">功能
                        <ul class="nav2">
                            <li class="nav2-li">管理试题</li>
                            <li class="nav2-li">选择试题</li>
                            <li class="nav2-li">测试分析</li>
                            <li class="nav2-li">生成成绩单</li>
                        </ul>
                    </li>
                    <li class="nav1-li">公告</li>
                    <li class="nav1-li">关于</li>
                </ul>

            </div>
        </div>

        <div id="middle">
            <div id="sider">

            </div>
            <div id="content">

            </div>
        </div>
        <div id="footer"></div>
    </div>
</body>
{{ HTML::script('javascript/main.js') }}
</html>
