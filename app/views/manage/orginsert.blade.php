@section('style')
    @parent
    {{ HTML::style('css/orginsert.css') }}
@stop
<div><h3 id="title">添加组织信息</h3></div>
<div id="content">
    {{ Form::open(array('url' => '/admin/action/orginsert')) }}
    <div id="select_org">
        {{ Form::label('org', '需要添加的项目：') }}
        {{ Form::select('org', array('学校','学院','专业') )}}
    </div>
    <div id="school_select" class="hide">
        {{ Form::label('school_insert', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学校:') }}
        {{ Form::text('school_insert', null ,array('placeholder' => '输入学校名...')) }}
    </div>
    <div id="college_select" class="hide">
        {{--Select the school from database--}}
        {{ Form::label('school_options', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学校:') }}
        {{ Form::macro('selectSchool', function() {
        $school = DB::table('Organization')
        ->where('parent_node', '=', 0)
        ->select('id', 'name')
        ->get();
        $school_item = array();
        foreach($school as $item) {
        $school_item[$item->id] = $item->name;
        }
        return Form::select('school_options', $school_item);
        }
        ) }}
        {{ Form::selectSchool() }}<br/><strong class="tips" id="school_tip"></strong><br/><br/>
        <div id="college_div">
            {{ Form::label('college_insert', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院:') }}
            {{ Form::text('college_insert', null, array('placeholder' => '请输入学院名...')) }}<br/><strong class="tips" id="college_tip"></strong><br/><br/>
        </div>
    </div>
    <div id="major_select" class="hide">
        {{ Form::label('college_options', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院:') }}
        {{ Form::select('college_options') }}<br/><strong class="tips" id="college_tip"></strong><br/><br/>
        {{ Form::label('major_insert', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;专业:') }}
        {{ Form::text('major_insert', null, array('placeholder' => '请输入专业名...')) }}<br/><strong class="tips" id="college_tip"></strong><br/><br/>
    </div>
    <div class="clear"></div>
    {{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit'))}}
    {{ Form::close() }}
</div>
@section('script')
    @parent
    {{ HTML::script('javascript/orginsert.js') }}
@stop
