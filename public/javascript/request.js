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
    $('#name').on('input', function() {
        var reg = /^[0-9a-zA-Z]{6,20}$/;
        var valid = reg.test($(this).val());
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
           url: 'org/' + val,
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
     |return the major info base on the selected college
     | -----------------------------------------------------
     * */
    var is_email = false;
    var email_valid = false;
    $('#email').on('input' , function() {
       var email = $(this).val();
       //test whether the email is valid
       var reg = /^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-\.]+$/
       is_email = reg.test(email);
       if(!is_email) {
           $('#email_tip').text('邮箱不合法...');
           email_valid = false;
           send = false;
       }
       else {
           $('#email_tip').text('');
           email_valid = true;
       }
    });
    $('#email').blur(function() {
        if(is_email) {
            $.ajax({
                type: 'POST',
                url: 'email',
                data: {'email' : $(this).val()},
                success: function(mesg) {
                    var msg = JSON.parse(mesg);
                    $('#email_tip').text(msg.message);
                    if(!msg.success) {
                        send = false;
                    }
                }
            });
        }
    });
    /*
     | -----------------------------------------------------
     |Check the password
     | -----------------------------------------------------
     * */
    var passwd, passwd2;
    var pswd1_valid = false;
    var pswd2_valid = false;
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
     $('#school_num').on('input', function() {
        var reg = /^[0-9]{6,10}$/;
        var is_vaild = reg.test($(this).val());
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
        if(name_valid && college_valid && major_valid && sn_valid && email_valid && pswd1_valid && pswd2_valid) {
            send = true;
        }
        if(send) {
            $('#submit').attr('disabled', false);
            clearInterval(interval);
        }
    }, 20);
});
