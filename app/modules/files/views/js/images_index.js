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
		"sAjaxSource": "images/datatables",
		"lengthMenu": [[12, 24, 50, 100, 300, -1], [12, 24, 50, 100, 300, "All"]],
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
				"aTargets": [5],
				"mRender": function (data, type, full) {
					return '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3"><div class="thumbnail"><a href="images/crop/' + full[0] + '" style="right:25px; position: absolute;"><i class="fa fa-crop" aria-hidden="true"></i></a><a data-toggle="modal" data-target="#modal" class="close" href="images/delete/' + full[0] + '">&times;</a><a href="' + 'images/view/' + full[0] + '" data-toggle="modal" data-target="#modal"><div class="caption text-center"><strong>' + full[3] + '</strong></div><img src="' + asset_url + data + '" class="img-responsive" width="100%" /></a></div></div>';
				},
			},
			{
				"aTargets": [0,1,2,3,4,6,7,8,9,10,11,12,13],
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