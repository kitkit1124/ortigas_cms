/**
 * @package		Codifire
 * @version		1.0
 * @author 		Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

$(function() {

	// renders the datatables (datatables.net)
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "videos/datatables",
		"lengthMenu": [[12, 20, 50, 100, 300, -1], [12, 20, 50, 100, 300, "All"]],
		"pagingType": "simple",
		"language": {
			"paginate": {
				"previous": 'Prev',
				"next": 'Next',
			}
		},
		"bAutoWidth": false,
		"aaSorting": [[ 5, "desc" ]],
		"stateSave": true,
		"aoColumnDefs":
			[
				{
					"aTargets": [0],
					"mRender": function (data, type, full) {
						return '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3"><div class="thumbnail"><a data-toggle="modal" data-target="#modal" class="close" href="videos/delete/' + full[0] + '">&times;</a><a data-toggle="modal" data-target="#modal" href="videos/view/' + full[0] + '"><div class="caption text-center"><strong>' + full[1] + '</strong><img src="' + full[4] + '" alt="' + full[1] + '" class="img-vid img-responsive" /></div></a><div></div>';
					},
				},

				{
					"aTargets": [0,1,2,3,4,6,7,8,9,10,11,12],
					"mRender": function (data, type, full) {
						return '<span class="d-none">' + data + '</span>';
					},
				},
			],
		"fnDrawCallback": function( oTable ) {
			// hide the table
			$('#datatables').hide();

			// then recreate the table as divs
			var html = '';
			$('tr', this).each(function() {
				$('td', this).each(function() {
					html += $(this).html();
					// console.log(html);
				});
			});

			$('#thumbnails').html(html);
		}
	});

	// positions the button next to searchbox
	$('.btn-actions').prependTo('div.dataTables_filter');

	// executes functions when the modal closes
	$('body').on('hidden.bs.modal', '.modal', function () {
		// eg. destroys the wysiwyg editor
	});

	//equalHeight($("#thumbnails .thumbnail .caption"));

});

/*
$(function() {

	// renders the datatables (datatables.net)
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "videos/datatables",
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
					return '<a href="videos/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit">' + data + '</a>';
				},
			},

			// {
			//     "aTargets": [9],
			//      "mRender": function (data, type, full) {
			//         if (data == 'Active') {
			//             return '<div class="badge badge-info">' + data + '</div>';
			//         }
			//         else if (data == 'Disabled') {
			//             return '<div class="badge badge-danger">' + data + '</div>';
			//         }
			//         else {
			//             return '<div class="badge badge-default">' + data + '</div>';
			//         }
			//      },
			//      "sClass": "col-md-1 text-center",
			// },

			{
				"aTargets": [8],
				"bSortable": false,
				"mRender": function (data, type, full) {
					html = '<a href="videos/form/view/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="View" class="btn btn-xs btn-success"><span class="fa fa-eye"></span></a> ';
					html += '<a href="videos/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs btn-warning"><span class="fa fa-pencil"></span></a> ';
					html += '<a href="videos/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-xs btn-danger"><span class="fa fa-trash-o"></span></a>';

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

}); */