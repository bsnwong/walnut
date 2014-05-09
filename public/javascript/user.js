/**
 * Created by bsn on 14-5-8.
 */
$(function () {
    $('.toggle').click(function() {
       $(this).nextAll('ul').toggle();
    });
    $('.detail').click(function() {
        $('#title').text($(this).html());

    });
    $.ajax({
        type: 'POST',
        url: '/static',
        success: function($msg) {
        }
    });
//    $('#content').highcharts({
//        chart: {
//            renderTo: 'content',
//            type: 'line'
//        },
//        title: {
//            text: 'Fruit Consumption'
//        },
//        xAxis: {
//            title: {
//                text: 'Fruit Number'
//            },
//            tickInterval: 1
//        },
//        yAxis: {
//            title: {
//                text: 'Fruit eaten'
//            },
//            tickInterval: 1
//        },
//        series: [{
//            name: 'Jane',
//            data: [1, 0, 4]
//        }, {
//            name: 'John',
//            data: [5, 7, 3]
//        }]
//    });
});