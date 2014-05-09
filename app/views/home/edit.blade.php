    {{ HTML::style('css/editForm.css')}}
<div><h3 id="title">修改个人信息</h3></div>
<div id="edit_form">
    <div id="form_input">
        {{ Form::open(array('url' => '/edit/user/'.Auth::user()->id, 'enctype' => 'multipart/form-data')) }}
        <div class="float_left">
            {{ Form::hidden('MAX_FILE_SIZE', 1024*1024) }}
            {{ Form::label('name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名:') }}
            *{{ Form::text('name', Auth::user()->name) }}<br/><strong class="tips" id="name_tip"></strong><br/><br/>
            {{ Form::label('name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;性别:') }}
            {{ Form::radio('male', 0, true, array('class' => 'input_default', 'name' => 'sexual')) }}
            {{ Form::label('male', '男') }}
            {{ Form::radio('female', 1, null, array('class' => 'input_default', 'name' => 'sexual')) }}
            {{ Form::label('female', '女') }}
            {{ Form::radio('other', 2, null, array('class' => 'input_default', 'name' => 'sexual')) }}
            {{ Form::label('other', '其他') }}<br/><br/><br/>
            {{ Form::label('email', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱:') }}
            *{{ Form::email('email', Auth::user()->email, array('disabled' =>true)) }}<br/><strong class="tips" id="email_tip"></strong><br/><br/>
            {{ Form::label('password_old', '&nbsp;&nbsp;&nbsp;&nbsp;旧密码:') }}
            *{{ Form::password('password_old', array('placeholder' => "请输入旧密码...")) }}<br/><strong class="tips" id="pswd_old_tip"></strong><br/><br/>
            {{ Form::label('password', '&nbsp;&nbsp;&nbsp;&nbsp;新密码:') }}
            *{{ Form::password('password', array('placeholder' => "请输入新密码...")) }}<br/><strong class="tips" id="pswd_tip"></strong><br/><br/>
            {{ Form::label('password2', '确认密码:') }}
            *{{ Form::password('password2', array('placeholder' => "请再次输入新密码..."))}}<br/><strong class="tips" id="pswd2_tip"></strong><br/><br/>
            {{--Select the school from database--}}
            {{ Form::label('school', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学校:') }}
            {{ Form::macro('selectSchool', function() {
            $school = DB::table('Organization')
            ->where('parent_node', '=', 0)
            ->select('id', 'name')
            ->get();
            $school_item = array();
            foreach($school as $item) {
            $school_item[$item->id] = $item->name;
            }
            return Form::select('school', $school_item);
            }
            ) }}
            *{{ Form::selectSchool() }}<br/><strong class="tips" id="school_tip"></strong><br/><br/>
            {{ Form::label('college', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院:') }}
            *{{ Form::select('college', array()) }}<br/><strong class="tips" id="college_tip"></strong><br/><br/>
            {{ Form::label('major', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;专业:') }}
            *{{ Form::select('major', array()) }}<br/><strong class="tips" id="major_tip"></strong><br/><br/>
            {{ Form::label('school_num', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学号:') }}
            *{{ Form::text('school_num', Auth::user()->school_num) }}<br/><strong class="tips" id="school_num_tip"></strong><br/>
            <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（注：带*号均为必填项...）
            <br/>
        </div>
        <div class="float_right" id="photo">
            <div id="photo_show"><img id="img_photo" src="/{{ Auth::user()->photo_url }}"></div>
            <div class="clear"></div>
            <div id="photo_upload">
                {{ Form::label('photo', '头像:') }}
                {{ Form::file('photo', array('id' => 'upload_button', 'placeholder' => '选择一张图片作为您的头像')) }}
            </div>
        </div>
    </div>
    <div class="clear"></div>
    {{ Form::submit('提交', array('id' => 'submit', 'class' => 'input_default submit', 'disabled' => true)) }}
    {{ Form::close() }}
</div>
@section('script')
{{ HTML::script('javascript/editRequest.js') }}
@stop
