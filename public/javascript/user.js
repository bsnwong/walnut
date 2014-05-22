/**
 * Created by bsn on 14-5-8.
 */
$(function () {
    var json;
    $('.chart_options').click(function() {
        json.chart.type = $(this).attr('value');
        $('#chart').highcharts(json);
    });
    $('#course').change(function() {
        $.ajax({
            type: 'POST',
            url: '/user/chart',
            data: {'c_id':$('#course').val()},
            success: function(msg) {
                msg = JSON.parse(msg);
                json = msg;
                $('#chart').highcharts(json);
            }
        });
    });
    $('#course').change();
});