/**
 * @package     Codifire
 * @version     1.0
 * @author      JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright   Copyright (c) 2016, Digify, Inc.
 * @link        http://www.digify.com.ph
 */
$(function() {

	var ajax_url = 'social_plugins/datatables';   
    
    var oTable = $('#datatables');
    
    oTable.dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": ajax_url,
        "lengthMenu": [[10, 50, 100, 300, -1], [10, 50, 100, 300, "All"]],
        "pagingType": "full_numbers",
        "language": {
            "paginate": {
                "previous": 'Prev',
                "next": 'Next',
            }
        },
        "bAutoWidth": false,
        "aaSorting": [[ 0, "desc" ]],
        "aoColumnDefs": [
            
            {
                "aTargets": [0],
                "mRender": function (data, type, full) {
                    html = '<a href="' + full[0] + '" target="_blank" title="Go to page">' + full[0] + '</a>';
                    return html;
                },
                "sClass": "text-left",
            },
            {
                "aTargets": [1],
                "mRender": function (data, type, full) {
                    html = '<strong>' + full[1] + '</strong>';
                    return html;
                },
                "bSearchable" : false,
                "bSortable": false,
                "sClass": "col-md-1 text-right",
            },
        ]
    });

    $('#reportrange').removeClass("hidden");

    $('body').on('hidden.bs.modal', '.modal', function(){

    });

    // initialize line chart
    google.charts.load("current", {packages:["corechart"]});
    get_report();
    window.onresize = get_report;

    // date range picker
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $("#reportrange").on("apply.daterangepicker", function(e, picker){
        var start_date = picker.startDate.format('YYYY-MM-DD');
        var end_date = picker.endDate.format('YYYY-MM-DD');

        var daterange = (start_date && end_date) ? '?start=' + start_date + '&end=' + end_date : '';

        // reload data table
        oTable.api().ajax.url(ajax_url + daterange).load();

        // reload line chart
        get_report(start_date, end_date);
    });

});

/**
 * get_report
 * 
 * @param date
 * @param date
 */
function get_report(start_date, end_date)
{
    var ajax_url = site_url + 'social_plugins/report_line_chart';
    var daterange = (start_date && end_date) ? '?start=' + start_date + '&end=' + end_date : '';

    // clear placeholder
    $('#report_line_chart').empty().html('<br /><h5 class="text-center lighter"><i class="fa fa-spinner fa-spin fa-lg"></i> Loading...</h5>');

    // get record
    $.getJSON(ajax_url + daterange, function(result){

        google.charts.setOnLoadCallback(drawChart);     
        function drawChart()
        {
            var data = google.visualization.arrayToDataTable(result);
            var options = {
                colors: ['#2746aa', '#96b01c'],
                animation: {
                    duration: 800,
                    startup: true,
                    easing: 'out',
                },
                // pointSize: 8,
                // curveType: 'function',
                height: 250,
                lineWidth: 3,
                vAxis: { 
                    minValue: 0,
                    gridlines: {
                        count: 5
                    },
                    textStyle: { 
                        color: '#999',
                        fontSize: 11,
                    },
                    baselineColor: '#000'
                },
                hAxis: { 
                    minValue: 0,
                    gridlines: {
                        count: 5
                    },
                    textStyle: { 
                        color: '#999',
                        fontSize: 11,
                    },
                    baselineColor: '#000'
                },
                legend: {
                    position: 'none'
                },
                chartArea: {
                        left: 30,
                        top: 20,
                        width: '96%',
                        height: '80%'
                }
            };
            var chart = new google.visualization.LineChart(document.getElementById('report_line_chart'));
            chart.draw(data, options);
        }
    });
}
