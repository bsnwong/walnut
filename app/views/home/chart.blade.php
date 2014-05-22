@section('style')
@parent
{{ HTML::style('css/chart.css') }}
@stop
<div><h3 id="title">测试分析</h3></div>
<div id="content">
    {{ Form::label('course', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目:') }}
    {{ Form::macro('selectCourse', function() {
    $course = DB::table('Course')
    ->select('id', 'name')
    ->get();
    $course_item = array();
    foreach($course as $item) {
    $course_item[$item->id] = $item->name;
    }
    return Form::select('course', $course_item);
    }
    ) }}
    *{{ Form::selectCourse() }}
    <div id="chart_options">
        <ul>
            <li class="chart_options" value="line"><a href="javascript:void(0)">折线图</a></li>
            <li class="chart_options" value="spline"><a href="javascript:void(0)">曲线图</a></li>
            <li class="chart_options" value="bar"><a href="javascript:void(0)">柱状图</a></li>
            <li class="chart_options" value="area"><a href="javascript:void(0)">折线面积图</a></li>
            <li class="chart_options" value="areaspline"><a href="javascript:void(0)">曲线面积图</a></li>
            <li class="chart_options" value="scatter"><a href="javascript:void(0)">点状图</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div id="chart"></div>
</div>
@section('script')
{{ HTML::script('javascript/highcharts/js/highcharts.js') }}
{{ HTML::script('javascript/user.js') }}
@stop
