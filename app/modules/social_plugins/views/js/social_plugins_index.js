/**
 * @package     Codifire
 * @version     1.0
 * @author      JP Llapitan <john.llapitan@digify.com.ph>
 * @copyright   Copyright (c) 2016, Digify, Inc.
 * @link        http://www.digify.com.ph
 */
$(function() {

	google.charts.load("current", {packages:["corechart"]});
	
	// initialize line chart report
	get_report();
	window.onresize = get_report;
	
	// get top pages
	get_top_pages();

	// get top channels
	get_channels();

	$('#reportrange').removeClass("hidden");
	
	// initialize date range picker
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

    // display date range picker
    cb(start, end);

    // filter by date range
    $("#reportrange").on("apply.daterangepicker", function(e, picker){
        var start_date = picker.startDate.format('YYYY-MM-DD');
        var end_date = picker.endDate.format('YYYY-MM-DD');

        get_report(start_date, end_date);
        get_top_pages(start_date, end_date);
        get_channels(start_date, end_date);
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

/**
 * get_top_pages
 * 
 * @param date
 * @param date
 */
function get_top_pages(start_date, end_date)
{
	var ajax_url = site_url + 'social_plugins/top_pages';
	var daterange = (start_date && end_date) ? '?start=' + start_date + '&end=' + end_date : '';

	$.getJSON(ajax_url + daterange, function(data){
		var html = '';

		// if no record
		if(!data) $("#top_pages tbody").empty().html('<tr><td class="text-center" colspan="2">No record found</td></tr>');

		$.each(data, function(key, value){
			html += '<tr>';
			html += '	<td><a href="' + value.social_plugin_url + '" target="_blank">' + value.social_plugin_url + '</a></td>';
			html += '	<td class="text-right"><strong>' + value.social_plugin_count + '</strong></td>';
			html += '</tr>';
		});
		
		$("#top_pages tbody").empty().append(html);
		$("#top_pages tfoot").removeClass('hidden');
	});
}

/**
 * get_channels	
 * 
 * @param date
 * @param date
 */
function get_channels(start_date, end_date)
{
	var ajax_url = site_url + 'social_plugins/top_channels';
	var daterange = (start_date && end_date) ? '?start=' + start_date + '&end=' + end_date : '';

	$.getJSON(ajax_url + daterange, function(data){
		var html = '';
		var total = 0;
		
		// if no record
		if(!data) $("#top_channels tbody").empty().html('<tr><td class="text-center" colspan="2">No record found</td></tr>');

		$.each(data, function(key, value){
			html += '<tr>';
			html += '	<td class="capitalize">' + value.social_plugin_channel + '</td>';
			html += '	<td class="text-right"><strong>' + value.social_plugin_count + '</strong></td>';
			html += '</tr>';

			total = total + parseInt(value.social_plugin_count);
		});

		// display all channels
		$("#top_channels tbody").empty().append(html);
		// display total channel's share
		$("#top_channels tfoot .total-shares").empty().html(total);
		$("#top_channels tfoot").removeClass('hidden');
	});
}