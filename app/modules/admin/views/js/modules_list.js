/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */

$(function() {
	$('.migration-files').change(function(){
		var version = $(this).val();

		var href = $(this).next().children('.btn-rollback').attr('href');
		var new_url = href.replace(/(\d+)$/, version);
		$(this).next().children('.btn-rollback').attr('href', new_url)
		// console.log(new_url)
		// console.log(href.substr(href.lastIndexOf('/') + 1));
	});

	// $("body").addClass('sidebar-collapse');
});

$('body').on('show.bs.modal', function (e) {
	var invoker = $(e.relatedTarget);
	console.log(invoker.parent().prev().val());
});