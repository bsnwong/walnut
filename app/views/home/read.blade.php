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
@section('script')
@parent
{{ HTML::script('javascript/read.js') }}
@stop
