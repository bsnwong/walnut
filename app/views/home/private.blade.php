{{ HTML::style('css/userInfo.css') }}
<div><h3 id="title">个人信息</h3></div>
<div id="content">
    <div class="float_left">
        <div id="info">
            <li><strong>用户名：</strong><u>{{ Auth::user()->name }}</u></li>
            <li><strong>邮&nbsp;&nbsp;&nbsp;&nbsp;箱：</strong><u>{{ Auth::user()->email }}</u></li>
            <li><strong>学&nbsp;&nbsp;&nbsp;&nbsp;校：</strong><u>{{ $results['school'] }}</u></li>
            <li><strong>学&nbsp;&nbsp;&nbsp;&nbsp;院：</strong><u>{{ $results['college'] }}</u></li>
            <li><strong>专&nbsp;&nbsp;&nbsp;&nbsp;业：</strong><u>{{ $results['major'] }}</u></li>
        </div>
    </div>

    <div class="float_right" id="photo">
        <div id="photo_show"><img id="img_photo" src="/{{ Auth::user()->photo_url }}" ></div>
    </div>
    <div class="clear"></div>
    <div class="underline"></div>
    <div class="underline"></div>
    <li id="school_num"><strong>No.</strong>{{ Auth::user()->school_num }}</li>
</div>
