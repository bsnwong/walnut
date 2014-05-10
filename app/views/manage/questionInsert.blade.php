<div><h3 id="title">试题录入</h3></div>
<div id="content">
    {{ Form::open(array('url' => 'register', 'enctype' => 'multipart/form-data')) }}
    <div class="float_left">
        {{ Form::label('name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名:') }}
        *{{ Form::text('name', '', array('placeholder' => '请输入您的姓名...')) }}<br/><strong class="tips" id="name_tip"></strong><br/><br/>
        {{ Form::label('type', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题型:') }}
        {{ Form::radio('select', 1, true, array('class' => 'input_default', 'name' => 'question_type')) }}
        {{ Form::label('select', '单选题') }}
        {{ Form::radio('mselect', 2, true, array('class' => 'input_default', 'name' => 'question_type')) }}
        {{ Form::label('mselect', '多选题') }}
        {{ Form::radio('blank', 3, null, array('class' => 'input_default', 'name' => 'question_type')) }}
        {{ Form::label('blank', '填空题') }}
        {{ Form::radio('judge', 4, null, array('class' => 'input_default', 'name' => 'question_type')) }}
        {{ Form::label('judge', '判断题') }}
        {{ Form::radio('judge', 5, null, array('class' => 'input_default', 'name' => 'question_type')) }}
        {{ Form::label('qanda', '简答题') }}
        {{ Form::radio('calculate', 6, null, array('class' => 'input_default', 'name' => 'question_type')) }}
        {{ Form::label('calculate', '计算题') }}
        {{ Form::radio('qanda', 6, null, array('class' => 'input_default', 'name' => 'sexual')) }}
        {{ Form::label('female', '女') }}
        {{ Form::radio('other', 7, null, array('class' => 'input_default', 'name' => 'sexual')) }}
        {{ Form::label('other', '其他') }}<br/><br/><br/>
        {{ Form::label('email', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱:') }}
        *{{ Form::email('email', '', array('placeholder' => '请输入您的邮箱...')) }}<br/><strong class="tips" id="email_tip"></strong><br/><br/>
        {{ Form::label('password', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码:') }}
        *{{ Form::password('password', array('placeholder' => "请输入密码...")) }}<br/><strong class="tips" id="pswd_tip"></strong><br/><br/>
        {{ Form::label('password2', '确认密码:') }}
        *{{ Form::password('password2', array('placeholder' => "请再次输入密码..."))}}<br/><strong class="tips" id="pswd2_tip"></strong><br/><br/>

        {{--Select the course from database--}}
        {{ Form::label('course', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目:') }}
        {{ Form::macro('selectCourse', function() {
            $course = DB::table('Course')
            ->select('id', 'name')
            ->get();
            $course_item = array();
            foreach($course as $item) {
            $course_item[$item->id] = $item->name;
        }
            return Form::select('course', $course_item);
        }
        ) }}
        *{{ Form::selectCourse() }}<br/><strong class="tips" id="course_tip"></strong><br/><br/>
        {{ Form::label('college', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院:') }}
        *{{ Form::select('college', array()) }}<br/><strong class="tips" id="college_tip"></strong><br/><br/>
        {{ Form::label('major', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;专业:') }}
        *{{ Form::select('major', array()) }}<br/><strong class="tips" id="major_tip"></strong><br/><br/>
        {{ Form::label('school_num', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学号:') }}
        *{{ Form::text('school_num', '', array('placeholder' => '请输入您的学号...')) }}<br/><strong class="tips" id="school_num_tip"></strong><br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（注：带*号均为必填项...）
        <br/>
    </div>
    <div class="float_right" id="photo">
        <div id="photo_show"><img id="img_photo" src=""></div>
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
