@section('style')
@parent
{{ HTML::style('css/chart.css') }}
@stop
<div><h3 id="title">测试分析</h3></div>
<div id="content">
    <div id="chart"></div>
</div>
@section('script')
@parent
{{ HTML::script('javascript/user.js') }}
@stop
