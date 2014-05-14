@section('style')
@parent
{{ HTML::style('css/questionEdit.css') }}
@stop
<div><h3 id="title">试题审核</h3></div>
<div id="content">
    <a href="../audit/1" id="show_all">显示所有</a>
    <div id="search">
        {{ Form::open(array('url' => '/admin/'.Auth::user()->id.'/question/search/1')) }}
        {{ Form::hidden('from', 'audit') }}
        {{ Form::label('search_type', '查询类型:') }}
        {{ Form::select('question_type', array('所有题型', '选择题', '多选题', '填空题', '判断题', '简答题', '计算题', '综合题', '其他')) }}
        {{ Form::label('search_type', '试题类型') }}
        {{ Form::radio('search_type', 1, true) }}
        {{ Form::label('search_type', '试题ID') }}
        {{ Form::radio('search_type', 2, null) }}
        {{ Form::label('search_type', '试题内容') }}
        {{ Form::text('word',null, array('placeholder' => '请输入关键词...')) }}
        {{ Form::submit('搜索', array('id' => 'submit', 'class' => 'input_default submit')) }}
        {{ Form::close() }}
    </div>
    <table id="question_modify">
        <tr>
            <td>试题Id</td>
            <td>类型</td>
            <td>内容</td>
            <td>答案</td>
            <td>解析</td>
            <td>创建时间</td>
            <td>最后修改时间</td>
            <td>审核状态</td>
            <td>操作</td>
        </tr>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                <?php
                switch($item->type) {
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
                        echo '判断题';
                        break;
                    case 4:
                        echo '简答题';
                        break;
                    case 5:
                        echo '计算题';
                        break;
                    case 6:
                        echo '综合题';
                        break;
                    default:
                        echo '其他类型';
                }
                ?>
            </td>
            <td>{{ $item->question }}</td>
            <td>
                @if($item->type == '1')
                {{ $item->answer2 }}
                @endif
                @if($item->type == '2')
                {{ $item->answer4 }}
                @endif
                @if($item->type == '3')
                    @if($item->answer3)
                    对
                    @else
                    错
                    @endif
                @endif
                @if($item->type == '4')
                {{ $item->answer3 }}
                @endif
                @if($item->type == '0')
                {{ $item->answer }}
                @endif
            </td>
            <td>{{ $item->analysis }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->updated_at }}</td>
            <td>
                @if($item->allow)
                通过
                @else
                待审核
                @endif
            </td>
            <td><a class="action" href="javascript:void(0)" action="/admin/{{ Auth::user()->id}}/question/delete/{{ $item->id }}">删除 | </a><a  href="../modify/{{ $item->id }}" >编辑 | </a><a class="action" href="javascript:void(0)" action="/admin/{{ Auth::user()->id}}/question/pass/{{ $item->id }}">通过</a></td>
        </tr>
        @endforeach
    </table>
    @if(isset($page))
    <div id="paginator">
        <ul>
            @for($i = 1; $i <= $page; $i++)
            <a href="{{ $i }}">{{ $i }} </a>
            @endfor
        </ul>
    </div>
    @endif
</div>
@section('script')
@parent
{{ HTML::script('javascript/questionEdit.js') }}
@stop

