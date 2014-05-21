/**
 * Created by bsn on 14-5-20.
 */
$(document).ready(function() {
    var time_limit = $('#time_limit').val();
    $('#time').text(time_limit);
    var time = setInterval(function() {
        time_limit -= 1;
        if(time_limit <= 0) {
            alert("时间到，自动提交试卷...");
            $('#form2').submit();
            clearInterval(time);
        }
        $('#time').text(time_limit);
    },60000);
});
