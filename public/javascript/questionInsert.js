/**
 * Created by bsn on 14-5-10.
 */
$(document).ready(function() {
    /*
     |---------------------------------------------------------------------
     |Show the select items based on the select amount
     |---------------------------------------------------------------------
     * */
    var amount = $('#amount').val();
    var children = $('#answer1').children();
    var checkboxItems = {
        0:'A',14:'O',
        1:'B',15:'P',
        2:'C',16:'Q',
        3:'D',17:'R',
        4:'E',18:'S',
        5:'F',19:'T',
        6:'G',20:'U',
        7:'H',21:'V',
        8:'I',22:'W',
        9:'J',23:'X',
        10:'K',24:'Y',
        11:'L',25:'Z',
        12:'M',
        13:'N',
    };
    children.each(function() {
        $(this).hide();
    });
    children.each(function() {
        if(amount > 0) {
            $(this).show();
            amount--;
        }
    });
    $('#amount').change(function() {
        amount = $(this).val();
        children.each(function() {
            $(this).hide();
        });
        children.each(function() {
            if(amount > 0) {
                $(this).show();
                amount--;
            }
        });
    });
    var ms_amount = $('#ms_amount').val();
    for(var i=0; i < ms_amount; i++) {
        var object = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="' + 'c_' + i + '"' + '">' + checkboxItems[i] + '</label>';
        object += '<input type="checkbox" name="selected_answer[]" value="'+checkboxItems[i]+ '"/>';
        $('#ms_type').append(object);
    }
    $('#ms_amount').change(function() {
        $('#ms_type').empty();
        ms_amount = $(this).val();
        for(var i=0; i < ms_amount; i++) {
            var object = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="' + 'c_' + i + '"' + '">' + checkboxItems[i] + '</label>';
            object += '<input type="checkbox" name="selected_answer[]" value="'+checkboxItems[i]+ '"/>';
            $('#ms_type').append(object);
        }
    });

    /*
    |-----------------------------------------------------------------
    |Show the answer type base on the question type
    |-----------------------------------------------------------------
    * */
    $('.question_type').click(function() {
        var type = $(this).val();
        switch(type) {
            case '1':
                $('#answer_type1').show();
                $('#answer_type1').prevAll().hide();
                $('#answer_type1').nextAll().hide();
                break;
            case '2':
                $('#answer_type2').show();
                $('#answer_type2').nextAll().hide();
                $('#answer_type2').prevAll().hide();
                break;
            case '3':
                $('#answer_type3').show();
                $('#answer_type3').nextAll().hide();
                $('#answer_type3').prevAll().hide();
                break;
            case '4':
                $('#answer_type4').show();
                $('#answer_type4').nextAll().hide();
                $('#answer_type4').prevAll().hide();
                break;
            default :
                $('#answer_type_other').show();
                $('#answer_type_other').nextAll().hide();
                $('#answer_type_other').prevAll().hide();
        }
    });
});