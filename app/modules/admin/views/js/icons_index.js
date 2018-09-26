/**
 * @package     Codifire
 * @version     1.0
 * @author      Ghem Gatchalian <densetsu.ghem@gmail.com>
 * @copyright   Copyright (c) 2016, Digify, Inc.
 * @link        http://www.digify.com.ph
 */
$(function() {

	// renders the datatables (datatables.net)
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "icons/datatables",
		"lengthMenu": [[10, 20, 50, 100, 300, -1], [10, 20, 50, 100, 300, "All"]],
		"pagingType": "full_numbers",
		"language": {
			"paginate": {
				"previous": 'Prev',
				"next": 'Next',
			}
		},
		"bAutoWidth": false,
		"aaSorting": [[ 0, "asc" ]],
		"aoColumnDefs": [
			
			{
				"aTargets": [0],
				"sClass": "col-md-1 text-center",
			},

			{
				"aTargets": [1],
				"mRender": function (data, type, full) {
					return '<a href="icons/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit">' + data + '</a>';
				},
			},

			// {
			// 	"aTargets": [9],
			// 	 "mRender": function (data, type, full) {
			// 		if (data == 'Active') {
			// 			return '<div class="label label-info">' + data + '</div>';
			// 		}
			// 		else if (data == 'Disabled') {
			// 			return '<div class="label label-danger">' + data + '</div>';
			// 		}
			// 		else {
			// 			return '<div class="label label-default">' + data + '</div>';
			// 		}
			// 	 },
			// 	 "sClass": "col-md-1 text-center",
			// },

			{
				"aTargets": [8],
				"bSortable": false,
				"mRender": function (data, type, full) {
					html = '<a href="icons/form/view/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="View" class="btn btn-xs btn-success"><span class="fa fa-eye"></span></a> ';
					html += '<a href="icons/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs btn-warning"><span class="fa fa-pencil"></span></a> ';
					html += '<a href="icons/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-xs btn-danger"><span class="fa fa-trash-o"></span></a>';

					return html;
				},
				"sClass": "col-md-2 text-center",
			},
		]
	});

	// positions the button next to searchbox
	$('.btn-actions').prependTo('div.dataTables_filter');

	// executes functions when the modal closes
	$('body').on('hidden.bs.modal', '.modal', function () {        
		// eg. destroys the wysiwyg editor
	});

});