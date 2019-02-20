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
		"sAjaxSource": "documents/datatables",
		"lengthMenu": [[12, 20, 50, 100, 300, -1], [12, 20, 50, 100, 300, "All"]],
		"pagingType": "simple",
		"language": {
			"paginate": {
				"previous": 'Prev',
				"next": 'Next',
			}
		},
		"bAutoWidth": false,
		"aaSorting": [[ 0, "desc" ]],
		"stateSave": true,
		"aoColumnDefs":
		[
			{
				"aTargets": [0],
				"mRender": function (data, type, full) {

					return '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2"><div class="thumbnails"><a data-toggle="modal" data-target="#modal" class="close" href="documents/delete/' + full[0] + '">&times;</a><a href="' + asset_url + full[2] + '" download><div class="caption text-center"><strong>' + full[1] + '</strong></div><i class="' + full[3] + '" aria-hidden="true"></i></a></div></div>';
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

	equalHeight($("#thumbnails .thumbnail .caption"));

});

$(window).resize(function() {
	equalHeight($("#thumbnails .thumbnail .caption"));
});

function equalHeight(group) {
	var tallest = 0;
	group.each(function() {
		var thisHeight = $(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.each(function() { $(this).height(tallest); });
}