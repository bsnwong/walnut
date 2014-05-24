/**
 * Created by bsn on 14-5-21.
 */
$(document).ready(function() {
    /*
    |---------------------------------------------------------------------
    |Show the insert option based on the selected item
    |---------------------------------------------------------------------
    * */
    $('#org').change(function() {
//        alert($(this).val());
        switch($(this).val()){
            case '0' :
                $('#school_select').show();
                $('#school_select').prevAll('.hide').hide();
                $('#school_select').nextAll('.hide').hide();
                break;
            case '1' :
                $('#college_select').show();
                $('#college_div').show();
                $('#college_select').prevAll('.hide').hide();
                $('#college_select').nextAll('.hide').hide();
                break;
            case '2' :
                $('#school_select').hide();
                $('#college_select').show();
                $('#college_div').hide();
                $('#major_select').show();
                break;

        }
    });
    $('#school_options,#college_options').change(function() {
        var id = $(this).attr('id');
        var val = $(this).val();
        var child_item;
        switch(id) {
            case 'school_options' : child_item = "college_options";
                break;
            case 'college_options': child_item = "major";
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
        $('#'+ child_item).change();
    });

});
