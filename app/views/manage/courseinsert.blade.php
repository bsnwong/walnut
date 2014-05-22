@section('style')
    @parent
    {{ HTML::style('css/courseinsert.css') }}
@stop
<div><h3 id="title">添加学科信息</h3></div>
<div id="content">
    <div id="course_insert">
         {{ Form::open(array('url' => '/admin/action/courseinsert')) }}
         {{ Form::label('course', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目')}}
         {{ Form::text('course', null, array('placeholder' => '请输入科目名称...')) }}

         {{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit'))}}
         {{ Form::close() }}
    </div>
</div>
