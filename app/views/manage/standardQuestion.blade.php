@section('style')
@parent
{{ HTML::style('css/standardQuestion.css') }}
@stop
<div><h3 id="title">标准试题选择</h3></div>
<div id="content">
    {{ Form::open(array('url' => '/user/test/standard')) }}
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
    {{ Form::selectCourse() }}
    {{ Form::label('question_level', '试题难度') }}
    {{ Form::selectRange('question_level', '0', '10', array('name' => 'question_level')) }}<br/><br/><br/>
    {{--
    {{ Form::label('type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题型:') }}
    {{ Form::checkbox('select', 1, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('select', '单选题') }}
    {{ Form::checkbox('mselect', 2, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('mselect', '多选题') }}
    {{ Form::checkbox('blank', 3, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('blank', '填空题') }}
    {{ Form::checkbox('judge', 4, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('judge', '判断题') }}
    {{ Form::checkbox('qanda', 5, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('qanda', '简答题') }}
    {{ Form::checkbox('calculate', 6, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('calculate', '计算题') }}
    {{ Form::checkbox('comprehensive', 6, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('comprehensive', '综合题') }}
    {{ Form::checkbox('other', 0, null, array('class' => 'input_default question_type', 'name' => 'question_type[]')) }}
    {{ Form::label('other', '其他') }}<br/><strong class="tips" id="type_tip"></strong><br/><br/>
    --}}
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit')) }}
    {{ Form::close() }}
    {{ Form::open(array('url' => '/user/test/random')) }}
    {{--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::submit('随机', array('class' => 'input_default submit')) }}
    --}}
    {{ Form::open(array('url' => '/user/test/post')) }}
    <div id="question">
        @if(isset($data))
            <?php
                $options = array(
                    '1' => 'A',
                    '2' => 'B',
                    '3' => 'C',
                    '4' => 'D',
                    '5' => 'E',
                    '6' => 'F',
                    '7' => 'G',
                    '8' => 'H',
                    '9' => 'I',
                    '10' => 'J',
                    '11' => 'K',
                    '12' => 'L',
                    '13' => 'M',
                    '14' => 'N',
                    '15' => 'O',
                    '16' => 'P',
                    '17' => 'Q',
                    '18' => 'R',
                    '19' => 'S',
                    '20' => 'T',
                    '21' => 'U',
                    '22' => 'V',
                    '23' => 'W',
                    '24' => 'X',
                    '25' => 'Y',
                    '26' => 'Z',
                );
            ?>
            @foreach($data as $index => $item)
                <?php
                    $$index = $item;
                ?>
            @endforeach
        <ul>
            <li>一.单选题
                <ul>
                    @foreach($select as $index => $item)
                        <p><strong>{{ $index + 1 }}： {{ $item->question }}</strong></p>
                        <?php
                            $select_options = explode('|', $item->select_options);
                        ?>
                        @if(count($select_options) == $item->answer_num)
                            @foreach($select_options as $k => $v)
                                {{ Form::label('select', $options[$k+1].':') }}
                                {{ $v.'&nbsp;&nbsp;&nbsp;&nbsp;' }}
                                @if(($k+1)%4 == 0)
                                    <br/>
                                @endif
                            @endforeach
                            <br/>
                            @for($i = 1; $i <= $item->answer_num; $i++)
                                {{ Form::label('select', $options[$i]) }}
                                {{ Form::radio('select'.$index, $i)}}
                            @endfor
                            <br/>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li>二.多选题
                <ul>
                    @foreach($ms_select as $index => $item)
                        <p><strong>{{ $index + 1 }}: {{ $item->question }}</strong></p>
                        <?php
                            $select_options = explode('|', $item->select_options);
                        ?>
                        @if(count($select_options) == $item->answer_num)
                            @foreach($select_options as $k => $v)
                                {{ Form::label('select', $options[$k+1].':') }}
                                {{ $v.'&nbsp;&nbsp;&nbsp;&nbsp;' }}
                                @if(($k+1)%4 == 0)
                                <br/>
                                @endif
                            @endforeach
                            <br/>
                            @for($i = 1; $i <= $item->answer_num; $i++)
                            {{ Form::label('select', $options[$i]) }}
                            {{ Form::checkbox('select'.$index.'[]', $i)}}
                            @endfor
                        @endif
                    @endforeach
                </ul>
            </li>
            <li>三.填空题
                <ul>
                    @foreach($blank as $index => $item)
                    <p><strong>{{ $index + 1 }}:
                        <?php
                            $question = str_replace('@', '______', $item->question);
                        ?>
                        {{ $question }}
                        </strong></p>
                        {{ Form::textarea('blank_answer', null, array('placeholder' => '请输入对应每个空的答案，以‘|’作为分隔符...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>四.判断题
                <ul>
                    @foreach($judge as $index => $item)
                        <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                        {{ Form::label('right', '对') }}
                        {{ Form::radio('right', 1, null, array('class' => 'input_default', 'name' => 'judge_type')) }}
                        {{ Form::label('wrong', '错') }}
                        {{ Form::radio('wrong', 2, null, array('class' => 'input_default', 'name' => 'judge_type')) }}
                    @endforeach
                </ul>
            </li>
            <li>五.简答题
                <ul>
                    @foreach($qanda as $item)
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                        {{ Form::textarea('qanda_answer', null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>六.计算题
                <ul>
                    @foreach($calculate as $item)
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                    {{ Form::textarea('calculate_answer', null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>七.综合题
                <ul>
                    @foreach($comprehensive as $item)
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                    {{ Form::textarea('comprehensive_answer', null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>八.其他
                <ul>
                    @foreach($other as $item)
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                    {{ Form::textarea('comprehensive_answer', null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
        </ul>
        {{ Form::submit('提交试卷', array('id' => 'submit2', 'class' => 'input_default submit')) }}
        @endif
    </div>
    {{ Form::close() }}
</div>

