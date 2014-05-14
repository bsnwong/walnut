@section('style')
@parent
{{ HTML::style('css/questionEdit.css') }}
@stop
<div><h3 id="title">已经通过审核的试题</h3></div>
<div id="content">
    <table id="question_modify">
        <tr>
            <td>试题Id</td>
            <td>类型</td>
            <td>内容</td>
            <td>答案</td>
            <td>解析</td>
            <td>创建时间</td>
            <td>最后修改时间</td>
        </tr>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->question }}</td>
            <td>
                @if($item->type == '1')
                {{ $item->answer2 }}
                @endif
                @if($item->type == '2')
                {{ $item->answer4 }}
                @endif
                @if($item->type == '3')
                {{ $item->answer5 }}
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
