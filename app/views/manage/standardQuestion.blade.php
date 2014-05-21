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
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit')) }}
    {{ Form::close() }}
    {{ Form::open(array('url' => '/user/test/post', 'id' => 'form2')) }}
    <div id="time_div">
        <label>剩余时间：<strong id="time"></strong>分钟</label>
    </div>
    <div id="question">
        @if(isset($data))
            <?php
                $time_limit = 0;
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
                            $time_limit += $item->time_limit;
                            $select_options = explode('|', $item->select_options);
                        ?>
                        {{ Form::hidden('select[]', $item->id) }}
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
                                {{ Form::radio('select'.$index, $options[$i])}}
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
                            $time_limit += $item->time_limit;
                            $select_options = explode('|', $item->select_options);
                        ?>
                        {{ Form::hidden('ms_select[]', $item->id) }}
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
                            {{ Form::checkbox('ms_select'.$index.'[]', $options[$i])}}
                            @endfor
                        @endif
                    @endforeach
                </ul>
            </li>
            <li>三.填空题
                <ul>
                    @foreach($blank as $index => $item)
                    {{ Form::hidden('blank[]', $item->id) }}
                    <p><strong>{{ $index + 1 }}:
                        <?php
                            $time_limit += $item->time_limit;
                            $question = str_replace('@', '______', $item->question);
                        ?>
                        {{ $question }}
                        </strong></p>
                        {{ Form::textarea('blank_answer'.$index, null, array('placeholder' => '请输入对应每个空的答案，以‘|’作为分隔符...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>四.判断题
                <ul>
                    @foreach($judge as $index => $item)
                    <?php
                        $time_limit += $item->time_limit;
                    ?>
                    {{ Form::hidden('judge[]', $item->id) }}
                        <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                        {{ Form::label('right', '对') }}
                        {{ Form::radio('right', 1, null, array('class' => 'input_default', 'name' => 'judge_type'.$index)) }}
                        {{ Form::label('wrong', '错') }}
                        {{ Form::radio('wrong', 2, null, array('class' => 'input_default', 'name' => 'judge_type'.$index)) }}
                    @endforeach
                </ul>
            </li>
            <li>五.简答题
                <ul>
                    @foreach($qanda as $index => $item)
                    <?php
                        $time_limit += $item->time_limit;
                    ?>
                    {{ Form::hidden('qanda[]', $item->id) }}
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                        {{ Form::textarea('qanda_answer'.$index, null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>六.计算题
                <ul>
                    @foreach($calculate as $index => $item)
                    <?php
                        $time_limit += $item->time_limit;
                    ?>
                    {{ Form::hidden('calculate[]', $item->id) }}
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                    {{ Form::textarea('calculate_answer'.$index, null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>七.综合题
                <ul>
                    @foreach($comprehensive as $index => $item)
                    <?php
                        $time_limit += $item->time_limit;
                    ?>
                    {{ Form::hidden('comprehensive[]', $item->id) }}
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                    {{ Form::textarea('comprehensive_answer'.$index, null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
            <li>八.其他
                <ul>
                    @foreach($other as $index => $item)
                    <?php
                        $time_limit += $item->time_limit;
                    ?>
                    {{ Form::hidden('other[]', $item->id) }}
                    <p><strong>{{ $index + 1 }}:{{ $item->question }}</strong></p>
                    {{ Form::textarea('other_answer'.$index, null, array('placeholder' => '请输入您的答案...', 'rows' => 3)) }}
                    @endforeach
                </ul>
            </li>
        </ul>
        {{ Form::hidden('time_limit', $time_limit, array('id' => 'time_limit')) }}
        {{ Form::submit('提交试卷', array('id' => 'submit2', 'class' => 'input_default submit')) }}
        @endif
    </div>
    {{ Form::close() }}
</div>
@section('script')
    @parent
    {{ HTML::script('javascript/standardQuestion.js') }}
@stop

