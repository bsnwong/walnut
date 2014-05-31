@section('style')
@parent
{{ HTML::style('css/read.css') }}
@stop
<div><h3 id="title">阅卷</h3></div>
<div id="content">
    {{ Form::open(array('url' => '/admin/'.Auth::user()->id.'/question/postScore')) }}
    <table id="read">
        <tr>
            <td>题目</td>
            <td>类型</td>
            <td>标准答案</td>
            <td>分值</td>
            <td>用户答案</td>
            <td>评分</td>
        </tr>
        @foreach($data as $index => $value)
            @foreach($value as $k1 => $v1)
                @foreach($value as $k2 => $v2)
                    @foreach($v2 as $k3 => $v3)
                        <tr>
                            <td>{{ $v3['question']->question }}</td>
                            <td>
                                <?php
                                switch($v3['question']->type) {
                                    case 0:
                                        echo '其他类型';
                                        break;
                                    case 1:
                                        echo '选择题';
                                        break;
                                    case 2:
                                        echo '多选题';
                                        break;
                                    case 3:
                                        echo '填空题';
                                        break;
                                    case 4:
                                        echo '判断题';
                                        break;
                                    case 5:
                                        echo '简答题';
                                        break;
                                    case 6:
                                        echo '计算题';
                                        break;
                                    case 7:
                                        echo '综合题';
                                        break;
                                    default:
                                        echo '其他类型';
                                }
                                ?>
                            </td>
                            <td>{{ $v3['question']->answer }}</td>
                            <td>{{ $v3['question']->score }}</td>
                            <td>{{ $v3['result']->answer }}</td>
                            <td>
                                {{ Form::hidden('result[]', $v3['result']->id) }}
                                {{ Form::selectRange('score[]', -1, $v3['question']->score, null,array('r_id' => $v3['result']->id))}}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </table>
    {{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit')) }}
</div>
