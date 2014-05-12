@section('style')
@parent
    {{ HTML::style('css/questionInsert.css') }}
@stop
<div><h3 id="title">试题录入</h3></div>
<div id="content">
    {{ Form::open(array('url' => '/admin/question/insert/')) }}
    <div class="float_left">
        {{--Select the course from database--}}
        {{ Form::label('course', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目:') }}
        {{ Form::macro('selectCourse', function() {
        $course = DB::table('Course')
        ->select('code', 'name')
        ->get();
        $course_item = array();
        foreach($course as $item) {
        $course_item[$item->code] = $item->name;
        }
        return Form::select('course', $course_item);
        }
        ) }}
        *{{ Form::selectCourse() }}<br/><strong class="tips" id="course_tip"></strong><br/><br/>
        {{ Form::label('type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题型:') }}
        {{ Form::radio('select', 1, true, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('select', '单选题') }}
        {{ Form::radio('mselect', 2, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('mselect', '多选题') }}
        {{ Form::radio('blank', 3, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('blank', '填空题') }}
        {{ Form::radio('judge', 4, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('judge', '判断题') }}
        {{ Form::radio('qanda', 5, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('qanda', '简答题') }}
        {{ Form::radio('calculate', 6, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('calculate', '计算题') }}
        {{ Form::radio('comprehensive', 6, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('comprehensive', '综合题') }}
        {{ Form::radio('other', 0, null, array('class' => 'input_default question_type', 'name' => 'question_type')) }}
        {{ Form::label('other', '其他') }}<br/><strong class="tips" id="type_tip"></strong><br/><br/>
        {{ Form::label('question', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题目') }}<br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::textarea('question', null, array('placeholder' => '请输入题目...')) }}
        <div>
            {{--Show the answer type base on the question type--}}
            {{--answer for type 1--}}
            <div id="answer_type1">
                {{ Form::label('ss_type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;单选题') }}<br/>
                {{ Form::label('amount', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选项数量')}}<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::selectRange('amount', '1', '26')}}<br/>
                {{ Form::label('answer1', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;单选答案')}}<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::selectRange('answer1', 'A', 'Z', array('id' => 'selected')) }}<br/>
            </div>
            {{--answer for type 2--}}
            <div id="answer_type2" style="display: none">
                {{ Form::label('ms_type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;多选题') }}<br/>
                {{ Form::label('ms_amount', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选项数量')}}<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::selectRange('ms_amount', '1', '26')}}<br/>
                {{ Form::label('ms_option', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选项')}}<br/>
                <div id="ms_type"></div>
            </div>
            {{--answer for type 3--}}
            <div id="answer_type3" style="display: none">
                {{ Form::label('blank_type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;填空题答案') }}<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::textarea('blank_type', '',  array('placeholder' => '请输入答案，以‘|’作为分隔符...'))}}
            </div>
            {{--answer for type 3--}}
            <div id="answer_type4" style="display: none">
                {{ Form::label('judge_type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;判断题答案') }}<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::label('right', '对') }}
                {{ Form::radio('right', 1, null, array('class' => 'input_default', 'name' => 'judge_type')) }}
                {{ Form::label('wrong', '错') }}
                {{ Form::radio('wrong', 2, null, array('class' => 'input_default', 'name' => 'judge_type')) }}
            </div>
            {{--answer for other type--}}
            <div id="answer_type_other" style="display: none">
                {{ Form::label('other_type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;答案') }}<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::textarea('other_type', '',  array('placeholder' => '请输入答案...'))}}
            </div>
            {{--answer analysis--}}
        </div>
        <div id="answer_analysis">
            {{ Form::label('answer_analysis', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;答案分析') }}<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::textarea('answer_analysis', '',  array('placeholder' => '请输入答案...'))}}
        </div>
        <div id="score">
            {{ Form::label('score', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分值') }}<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::selectRange('score', '0', '100') }}
        </div>
        <div id="level">
            {{ Form::label('question_level', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;试题难度') }}<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::selectRange('question_level', '0', '10', array('name' => 'question_level')) }}
        </div>
        <div id="time_limit">
            {{ Form::label('time_limit', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;时间限制') }}<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::selectRange('time_limit', '0', '60', array('name' => 'time_limit')) }}单位：分钟
        </div>
    </div>
</div>
<div class="clear"></div>
{{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit')) }}
{{ Form::close() }}
</div>
@section('script')
@parent
{{ HTML::script('javascript/questionInsert.js') }}
@stop