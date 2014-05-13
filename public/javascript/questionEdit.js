/**
 * Created by bsn on 14-5-12.
 */
$(document).ready(function() {
    $('.action').click(function() {
        var del = confirm('删除该试题');
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
