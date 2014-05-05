/**
 *
 * Created by bsn on 14-5-5.
 */
$(document).ready(function() {
    $(".has_child").mouseover(function() {
        var current = $(this);
        var children =  current.children();
        children.each(function() {
            if($(this).css('display') == 'none') {
                $(this).fadeIn(200);
            }
        });
    });
    $(".has_child").mouseleave(function() {
        var children =  $(this).children();
        children.each(function() {
            $(this).hide();
        });
    });
    $(".nav1-li").each(function() {
        var r = parseInt(Math.random() * 256 + 1);
        var g = parseInt(Math.random() * 256 + 1);
        var b = parseInt(Math.random() * 256 + 1);
        $(this).css("border-bottom", "5px solid rgb(" + r + "," + g + "," + b + ")");
        $(this).mouseover(function() {
            $(this).css("border-bottom", "5px solid #000");
        });
        $(this).mouseleave(function() {
            $(this).css("border-bottom", "5px solid rgb(" + r + "," + g + "," + b + ")");
        });
    });
});
