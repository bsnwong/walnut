/**
 * Created by bsn on 14-5-8.
 */
$(function () {
    $.ajax({
        type: 'POST',
        url: '/static',
        success: function($msg) {
        }
    });
    var json = {
        chart: {
            renderTo: 'chart',
            type: 'line'
        },
        title: {
            text: '个人测试情况'
        },
        xAxis: {
            title: {
                text: '次数'
            },
            tickInterval: 1
        },
        yAxis: {
            title: {
                text: '分数'
            },
            tickInterval: 1
        },
        series: [{
            name: 'Jane',
            data: [1, 0, 4]
        }, {
            name: 'John',
            data: [5, 7, 3]
        }]
    };
//    $('#chart').highcharts(json);
});