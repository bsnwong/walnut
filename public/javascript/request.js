/**
 * Created by bsn on 14-5-5.
 */
$(document).ready(function() {
    /*
    | -----------------------------------------------------
    |return the college info base on the selected school
    | -----------------------------------------------------
    * */
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
            success: function(data) {
                data = JSON.parse(data);
                $("#" + child_item).empty();
                if(data.length) {
                    $.each(data, function(index, item) {
                        var opt = "<option value='" + item.id + "'>" + item.name + "</option>";
                        $("#" + child_item).append(opt);
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
//    $('#college').change(function() {
//        college = $(this).val();
//        $.
//    });

});
