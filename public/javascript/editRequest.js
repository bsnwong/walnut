/**
 /**
 * Created by bsn on 14-5-5.
 */
$(document).ready(function() {
    /*
     |------------------------------------------------------
     |Check user name
     |------------------------------------------------------
     * */
    var name_valid = false;
    var reg1 = /^[0-9a-zA-Z]{6,20}$/;
    $('#name').on('input', function() {
        var valid = reg1.test($(this).val());
        if(!valid) {
            $('#name_tip').text('用户名只能包含数字和字母，长度6到20位...');
            name_valid = false;
        }
        else {
            $('#name_tip').text('');
            name_valid = true;
        }
    });
    /*
     | -----------------------------------------------------
     |return the college info base on the selected school
     | -----------------------------------------------------
     * */
    var send = false;
    var college_valid = false;
    var major_valid = false;
    $('#school,#college').change(function() {
        var id = $(this).attr('id');
        var val = $(this).val();
        var child_item;
        switch(id) {
            case 'school' : child_item = "college";
                break;
            case 'college': child_item = "major";
        }
        $.ajax({
            type: 'POST',
            url: '/org/' + val,
            success: function(msg) {
                msg = JSON.parse(msg);
                result = msg.result;
                $("#" + child_item).empty();
                if(result.length) {
                    $.each(result, function(index, item) {
                        var opt = "<option value='" + item.id + "'>" + item.name + "</option>";
                        $("#" + child_item).append(opt);
                        switch(id) {
                            case 'school' :
                                major_valid = true;
                                break;
                            case 'college':
                                college_valid = true;
                        }
                    });
                }
            }
        });
    });
    /*
     | -----------------------------------------------------
     |Check the password
     | -----------------------------------------------------
     * */
    var passwd, passwd2, passwd_old;
    var pswd1_valid = false;
    var pswd2_valid = false;
    var pswd_old_valid = false;
    $('#password_old').on('input', function() {
        passwd_old = $(this).val();
        if(passwd_old.length < 6) {
            $('#pswd_tip').text('密码长度必须大于6位...');
            send = false;
            pswd_old_valid = false;
        }
        else {
            $('#pswd_tip').text('');
            pswd_old_valid = true;
        }
    });
    $('#password').on('input', function() {
        passwd = $(this).val();
        if(passwd.length < 6) {
            $('#pswd_tip').text('密码长度必须大于6位...');
            send = false;
            pswd1_valid = false;
        }
        else {
            $('#pswd_tip').text('');
            pswd1_valid = true;
        }
    });
    $('#password').blur(function() {
        $('#password2').on('input', function() {
            passwd2 = $(this).val();
            if(passwd2 !== passwd) {
                $('#pswd2_tip').text('两次密码输入不一致...');
                send = false;
                pswd2_valid = false;
            }
            else {
                $('#pswd2_tip').text('');
                pswd2_valid = true;
            }
        });
    });
    $('#password, #password2').blur(function() {
        if(passwd && passwd2) {
            if(passwd2 !== passwd) {
                $('#pswd2_tip').text('两次密码输入不一致...');
                send = false;
                pswd1_valid = false;
                pswd2_valid = false;
            }
            else {
                $('#pswd2_tip').text('');
                pswd1_valid = true;
                pswd2_valid = true;
            }
        }
    });
    /*
     | -----------------------------------------------------
     |Check the school number
     | -----------------------------------------------------
     * */
    var sn_valid = false;
    var sn;
    var reg2 = /^[0-9]{6,10}$/;
    $('#school_num').on('input', function() {
        sn = $(this).val();
        var is_vaild = reg2.test(sn);
        if(!is_vaild) {
            $('#school_num_tip').text('长度不在6-10位之间或包含非数字...');
            send = false;
            sn_valid = false;
        }
        else {
            $('#school_num_tip').text('');
            sn_valid = true;
        }
    });
    /*
     | -----------------------------------------------------
     |Display the selected picture
     | -----------------------------------------------------
     * */
    $('#upload_button').change(function(evt) {
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    $('#img_photo').attr('src', e.target.result);
                };
            })(f);
            reader.readAsDataURL(f);
        }
    });
    /*
     |---------------------------------------------------------------
     |Disable the submit button before everything is valid
     |---------------------------------------------------------------
     * */
    var interval = setInterval(function(){
        if(reg1.test($('#name').val())) name_valid = true;
        passwd = $('#password').val();
        passwd2 = $('#password2').val();
        if(passwd && passwd2 && (passwd==passwd2)) {
            pswd1_valid = true;
            pswd2_valid = true;
        }
        if(reg2.test($('#school_num').val())) sn_valid = true;
        if(name_valid && college_valid && pswd_old_valid && major_valid && sn_valid &&  pswd1_valid && pswd2_valid) {
            send = true;
        }
        if(send) {
            $('#submit').attr('disabled', false);
            clearInterval(interval);
        }
    }, 20);
});
