/**
 * @package     Codifire
 * @version     1.0
 * @author      Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright   Copyright (c) 2016, Digify, Inc.
 * @link        http://www.digify.com.ph
 */
$(function() {

	$('.dd').nestable({
		maxDepth: 3,
	});

	// executes functions when the modal closes
	$('body').on('hidden.bs.modal', '.modal', function () {        
		// eg. destroys the wysiwyg editor
	});

});

// adds nav item
$('.navadd').click(function () {
	// console.log($(this));
	// var nav_id = $(this).attr('data-id');
	var nav_name = $(this).attr('data-name');
	var nav_link = $(this).attr('data-link');
	var nav_res = $(this).attr('data-res');
	var nav_resid = $(this).attr('data-resid');

	$('ol.outer').append('<li class="dd-item" data-name="' + nav_name + '" data-link="' + nav_link + '" data-target="_top" data-res="' + nav_res + '" data-resid="' + nav_resid + '"><div class="dd-handle"><span class="dd-nodrag"><a href=\"javascript:;\" class=\"dd-name\">' + nav_name + '</a></span><span class="dd-nodrag"><a href="javascript:;" class="pull-right"><span class="fa fa-times navdel"></span></a></span></div></li>');
});

// adds custom nav item
$('.btn-custom-link').click(function () {
	var nav_name = $('#custom_nav_name').val();
	var nav_link = $('#custom_nav_link').val();
	var nav_target = $('#custom_nav_target').val();

	$('ol.outer').append('<li class="dd-item" data-name="' + nav_name + '" data-link="' + nav_link + '" data-target="' + nav_target +'"><div class="dd-handle"><span class="dd-nodrag"><a href=\"javascript:;\" class=\"dd-name\">' + nav_name + '</a></span><span class="dd-nodrag"><a href="javascript:;" class="pull-right"><span class="fa fa-times navdel"></span></a></span></div></li>');
});

// deletes nav item
$('body').on("click", '.navdel', function () {
	$(this).closest('li').remove();
});

// opens the edit nav item panel
$('body').on("click", '.dd-name', function () {
	var nav_name = $(this).parent().parent().parent().attr('data-name');
	var nav_link = $(this).parent().parent().parent().attr('data-link');
	var nav_target = $(this).parent().parent().parent().attr('data-target');
	// console.log(nav_name); 
	// console.log($(this).parent().parent());
	// $('.dd-name').popover('hide')

	// check if link form should be shown
	var show_link_form = ($(this).parent().parent().parent().attr('data-resid') > 0) ? 'hide' : '';

	// 
	var nav_target_list = '<option value="_top" ' + (nav_target=="_top" ? "selected" : "") + '>Same Window</option>' +
							'<option value="_blank" ' + (nav_target=="_blank" ? "selected" : "") + '>New Window</option>';

	// remove open panels
	$('.panel-edit-nav').remove();

	// open the edit panel
	$(this).parent().parent().parent().append('<div class="panel panel-default panel-edit-nav"><div class="panel-body"><form class="form-horizontal">' +
		'<div class="form-group"><label class="col-sm-2 control-label" for="nav_name">Name:</label>' + 
		'<div class="col-sm-10"><input type="text" name="nav_name" class="nav_name form-control input-sm" value="' + nav_name + '"></div></div>' +
		'<div class="form-group ' + show_link_form + '"><label class="col-sm-2 control-label" for="nav_link">Link:</label>' + 
		'<div class="col-sm-10"><input type="text" name="nav_link" class="nav_link form-control input-sm" value="' + nav_link + '"></div></div>' +
		'<div class="form-group"><label class="col-sm-2 control-label" for="nav_name">Target:</label>' +
		// '<div class="col-sm-10"><input type="text" name="nav_target" class="nav_target form-control input-sm" value="' + nav_target + '"></div></div>' +
		'<div class="col-sm-10"><select name="nav_target" class="nav_target form-control input-sm">' + nav_target_list + '</select></div></div>' +
		'<div class="form-group bottom-margin"><div class="col-sm-offset-2 col-sm-10"><a href="javascript:;" class="btn btn-success btn-sm btn-save-nav">Save Changes</a> <a href="javascript:;" class="btn-cancel-nav btn-sm btn-warning">Cancel</a></div></div> </div></div>');
});

// edits nav item
$('body').on("click", '.btn-save-nav', function () {
	// get the new values
	var nav_name = $('.nav_name').val();
	var nav_link = $('.nav_link').val();
	var nav_target = $('.nav_target').val();
	
	// target the parents
	var target = $(this).parent().parent().parent().parent().parent().parent();

	// replace the current values
	target.find('.dd-name').first().text(nav_name);
	target.attr('data-name', nav_name);
	target.attr('data-link', nav_link);
	target.attr('data-target', nav_target);

	// close the panel
	$('.panel-edit-nav').remove();
});

// $('.dd-name').popover({
// 	trigger: 'click',
// 	content: '<input type="text" name="name" />',
// 	placement: 'bottom',
// 	html: true,
// });

// saves changes
$('.btn-save').click(function () {
	// change the button to loading state
	var btn = $(this);
	btn.button('loading');

	var navigations = $('.dd').nestable('serialize');
	// console.log(($(this).attr('data-id')));

	// submits the data to the backend
	$.post(site_url + 'website/navigations/save', {
		navigroup_id: $(this).attr('data-id'),
		navigations: navigations,
		[csrf_name]: $('input[name=' + csrf_name + ']').val(),
	},
	function(data, status){
		// handles the returned data
		var o = jQuery.parseJSON(data);
		if (o.success === false) {
			// shows the error message
			alertify.error(o.message);
		} else {
			// shows the success message
			alertify.success(o.message); 
		}
		// reset the button
		btn.button('reset');
	}).fail(function() {
		// shows the error message
		alertify.alert('Error', unknown_form_error);

		// reset the button
		btn.button('reset');
	});
});

// saves changes
$('body').on("click", '.btn-cancel-nav', function () {
	console.log($(this))
	// close the panel
	$('.panel-edit-nav').remove();
});