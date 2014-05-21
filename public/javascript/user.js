/**
 * Created by bsn on 14-5-8.
 */
$(function () {
    var json;
    $.ajax({
        type: 'POST',
        url: '/user/chart',
        success: function(msg) {
            msg = JSON.parse(msg);
            json = msg;
            $('#chart').highcharts(json);
        }
    });
    $('.chart_options').click(function() {
        json.chart.type = $(this).attr('value');
        $('#chart').highcharts(json);
    });
});