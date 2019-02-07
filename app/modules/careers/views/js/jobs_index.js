$(function() {
	// renders the datatables (datatables.net)
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "jobs/datatables",
		"lengthMenu": [[10, 20, 50, 100, 300, -1], [10, 20, 50, 100, 300, "All"]],
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
				"sClass": "text-center",
			},
			{
				"aTargets": [1],
				"mRender": function (data, type, full) {
					return '<a href="jobs/form/view/'+full[0]+'" data-toggle="modal" data-target="#modal-lg" tooltip-toggle="tooltip" data-placement="top" title="View">' + data + '</a>';
				},
			},
			{
				"aTargets": [3],
				"mRender": function (data, type, full) {
					
					return dateToString(full[8]);
				},
			},
			// {
			// 	"aTargets": [6],
			// 	 "mRender": function (data, type, full) {
			// 		if (data == 'Active') {
			// 			return '<div class="badge badge-info">' + data + '</div>';
			// 		}
			// 		else if (data == 'Disabled') {
			// 			return '<div class="badge badge-danger">' + data + '</div>';
			// 		}
			// 		else {
			// 			return '<div class="badge badge-default">' + data + '</div>';
			// 		}
			// 	 },
			// 	 "sClass": "text-center",
			// },
			{
				"aTargets": [11],
				"bSortable": false,
				"mRender": function (data, type, full) {
					html = '<a href="jobs/form/view/'+full[0]+'" data-toggle="modal" data-target="#modal-lg" tooltip-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-success"><span class="fa fa-eye"></span></a> ';
					/*html += '<a href="jobs/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal-lg" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning"><span class="fa fa-pencil"></span></a> ';
					html += '<a href="jobs/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>';*/

					return html;
				},
				"sClass": " text-center",
			},
		]
	});

	$('.btn-actions').prependTo('div.dataTables_filter');

	// executes functions when the modal closes
	$('body').on('hidden.bs.modal', '.modal', function () {        
		// eg. destroys the wysiwyg editor
	});

	function dateToString(date) {
	  var month = new Array();
	  month[0] = "January";
	  month[1] = "February";
	  month[2] = "March";
	  month[3] = "April";
	  month[4] = "May";
	  month[5] = "June";
	  month[6] = "July";
	  month[7] = "August";
	  month[8] = "September";
	  month[9] = "October";
	  month[10] = "November";
	  month[11] = "December";

	  var d = new Date (date);

	  var time = tConvert(d.getHours() +':'+ d.getSeconds());

	  return   month[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear() + ' - ' + time;
	}

	function tConvert (time) {
	  // Check correct time format and split into components
	  time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

	  if (time.length > 1) { // If time format correct
	    time = time.slice (1);  // Remove full string match value
	    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
	    time[0] = +time[0] % 12 || 12; // Adjust hours
	  }
	  return time.join (''); // return adjusted time or original string
	}


});