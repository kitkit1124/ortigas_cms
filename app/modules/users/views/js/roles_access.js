/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
$(function() {

	// $("body").tooltip({ selector: '[tooltip-toggle=tooltip]' });

	// $('#datatables').dataTable({
	// 	"bRetrieve": true,
	// 	"lengthMenu": [[-1, 5, 100, 300], ["All", 50, 100, 300]],
	// 	"pagingType": "simple",
	// 	"language": {
	// 		"paginate": {
	// 			"previous": 'Prev',
	// 			"next": 'Next',
	// 		}
	// 	},
	// 	"bAutoWidth": false,
	// 	"aoColumns": [{ "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false }],
	// });

    // // positions the button next to searchbox
    // $('.btn-actions').appendTo('div.dataTables_filter');

    // // executes functions when the modal closes
    // $('body').on('hidden.bs.modal', '.modal', function () {        
    //     // eg. destroys the wysiwyg editor
    // });
    
	// $('.group_permission').addClass('border-red');

	// console.log($('.group_permission').children());
});

var no_of_response = 0;
var no_of_checkbox = 0;

$('.select_all').click(function(e) {
	e.preventDefault();

	var module 	= $(this).attr('data-module');
	var btn 	= $(this);

	if (! btn.attr("data-action"))
	{
		// change status
		$('.' + module).prop('checked', true).change();
		
		// count affected checkbox
		no_of_checkbox = $('.' + module).prop('checked', true).length;
	}
	else
	{
		var action = btn.attr("data-action");
		
		$('.'+module+'.'+action).prop('checked', true).change();
		
		// count affected checkbox
		no_of_checkbox = $('.'+module+'.'+action).prop('checked', true).length;
	}
	// dim the page
	$.blockUI({ message: '<h4><i class="fa fa-spinner fa-spin"></i> Processing...</h4>' });
});


$('.select_none').click(function(e) {
	e.preventDefault();

	var module 	= $(this).attr('data-module');
	var btn 	= $(this);

	if (! btn.attr("data-action"))
	{
		// change status
		$('.' + module).prop('checked', false).change();
		
		// count affected checkbox
		no_of_checkbox = $('.' + module).prop('checked', false).length;
	}
	else
	{
		var action = btn.attr("data-action");
		
		// change status
		$('.'+module+'.'+action).prop('checked', false).change();

		// count affected checkbox
		no_of_checkbox = $('.'+module+'.'+action).prop('checked', false).length;
	}
	// dim the page
	$.blockUI({ message: '<h4><i class="fa fa-spinner fa-spin"></i> Processing...</h4>' });
});

$(document).on("change", ".access", function(){
	var ajax_url = site_url + 'users/roles/update_access'
	$.post(ajax_url, {
		group_id: $(this).attr('data-group-id'),
		permission_id: $(this).attr('data-permission-id'),
		permission_level: ($(this).is(":checked")) ? 1 : 0,
	},
	function(data, status){
		// handles the returned data
		var o = jQuery.parseJSON(data);

		if (o.success === false) {
			// shows the error message
			alertify.error('Update failed');

		} else {

			no_of_response++;
			
			if (no_of_response == no_of_checkbox)
			{
				// shows the success message
				alertify.success('Update successful', 2);
				
				// remove the dim
				$.unblockUI();
				
				// reset
				no_of_response = 0;
			}

		}
	});

}).on("click", "#expand_collapse_all", function(e){
	e.preventDefault();
	if ($(this).hasClass('collapsed'))
		$(this).html('Collapse All <i class="fa fa-caret-up"></i>').removeClass("collapsed");
	else
		$(this).html('Expand All <i class="fa fa-caret-down"></i>').addClass("collapsed");
	$(".toggle-accordion").trigger("click");
});

// $(document).on("change", ".group_permission", function(){
// 	var group_id = $(this).attr('group_id');
// 	var permission_id = $(this).attr('permission_id');
// 	var permission_level = $(this).val();
// 	var post_url = '../update_permission/' + group_id + '/' + permission_id + '/' + permission_level;
// 	var ajax_load = '...';
// 	$.post(post_url);
// 	console.log(permission_level);

	
// 	if (permission_level > 0) {
// 		$(this).removeClass('border-red');
// 	    $(this).addClass('border-green');
// 	}
// 	else {
// 		$(this).removeClass('border-green');
// 	    $(this).addClass('border-red');
// 	}
// });

// list
$("#list-all").click(function() {
	$(".perm-list").val("1").change();
});
$("#list-none").click(function() {
	$(".perm-list").val("0").change();
});

// view
$("#view-all").click(function() {
	$(".perm-view").val("1").change();
});
$("#view-none").click(function() {
	$(".perm-view").val("0").change();
});

// add
$("#add-all").click(function() {
	$(".perm-add").val("1").change();
});
$("#add-none").click(function() {
	$(".perm-add").val("0").change();
});

// edit
$("#edit-all").click(function() {
	$(".perm-edit").val("1").change();
});
$("#edit-none").click(function() {
	$(".perm-edit").val("0").change();
});

// delete
$("#delete-all").click(function() {
	$(".perm-delete").val("1").change();
});
$("#delete-none").click(function() {
	$(".perm-delete").val("0").change();
});