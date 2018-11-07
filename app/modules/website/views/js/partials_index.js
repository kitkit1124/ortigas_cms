/**
 * @package     Codifire
 * @version     1.0
 * @author      Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright   Copyright (c) 2016, Digify, Inc.
 * @link        http://www.digify.com.ph
 */
$(function() {

	// renders the datatables (datatables.net)
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "partials/datatables",
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
				"sClass": "text-center",
			},

			{
				"aTargets": [1],
				"mRender": function (data, type, full) {
					return '<a href="partials/form/edit/'+full[0]+'" tooltip-toggle="tooltip" data-placement="top" title="Edit">' + data + '</a>';
				},
			},

			{
				"aTargets": [2],
				 "mRender": function (data, type, full) {
					if (data == 'Posted') {
						return '<div class="badge badge-success">' + data + '</div>';
					}
					else if (data == 'Draft') {
						return '<div class="badge badge-danger">' + data + '</div>';
					}
					else {
						return '<div class="badge badge-default">' + data + '</div>';
					}
				 },
				 "sClass": "text-center",
			},

			{
				"aTargets": [7],
				"bSortable": false,
				"mRender": function (data, type, full) {
					html = '<a href="partials/form/view/'+full[0]+'" class="btn btn-xs btn-success" tooltip-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a> ';
					html += '<a href="partials/form/edit/'+full[0]+'" class="btn btn-xs btn-warning" tooltip-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a> ';
					html += '<a href="partials/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-xs btn-danger"><span class="fa fa-trash-o"></span></a>';

					return html;
				},
				"sClass": "text-center",
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