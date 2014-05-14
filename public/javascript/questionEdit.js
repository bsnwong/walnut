/**
 * Created by bsn on 14-5-12.
 */
$(document).ready(function() {
    $('.action').click(function() {
        var del = confirm('是否执行此项操作？');
        if(del) {
            $.ajax({
                type : 'POST',
                url : $(this).attr('action'),
                success : function(msg) {
                    var data = JSON.parse(msg);
                    alert(data.message);
                    window.location.reload();
                }
            });
        }
    });

});
