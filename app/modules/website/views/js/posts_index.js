/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
$(function() {

	// renders the datatables (datatables.net)
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "posts/datatables",
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
			{ "width": "5%", "targets": 0 },
			{ "width": "10%", "targets": 4 },
			{ "width": "200", "targets": 9 },
			{
				"aTargets": [0],
				"sClass": "text-center",
			},

			{
				"aTargets": [1],
				"mRender": function (data, type, full) {
					return '<a href="posts/form/edit/'+full[0]+'" tooltip-toggle="tooltip" data-placement="top" title="Edit">' + data + '</a>';
				},
			},

			// {
			// 	"aTargets": [2],
			// 	"mRender": function (data, type, full) {
			// 		return site_url + 'posts/' + data;
			// 	},
			// },

			{
				"aTargets": [4],
				 "mRender": function (data, type, full) {
					if (data == 'Posted') {
						return '<div class="badge badge-pill badge-success">' + data + '</div>';
					}
					else if (data == 'Draft') {
						return '<div class="badge badge-pill badge-warning">' + data + '</div>';
					}
					else {
						return '<div class="badge badge-pill badge-default">' + data + '</div>';
					}
				 },
				 "sClass": "text-center",
			},

			{
				"aTargets": [9],
				"bSortable": false,
				 "mRender": function (data, type, full) {
				 	html = '<a href="' + site_url + 'metatags/form/website/posts/' + full[0] + '" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Meta Tags" class="btn btn-sm btn-info"><span class="fa fa-cogs"></span></a> ';
					html += '<a href="posts/form/view/'+full[0]+'" tooltip-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-success"><span class="fa fa-eye"></span></a> ';
					html += '<a href="posts/form/edit/'+full[0]+'" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning"><span class="fa fa-pencil"></span></a> ';
					html += '<a href="posts/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>';

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