/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
$(function() {
	
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "users/datatables",
		"lengthMenu": [[50, 100, 300, -1], [50, 100, 300, "All"]],
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
				"aTargets": [6],
				"mRender": function (data, type, full) {
					if (data == 1) {
						return '<span class="badge badge-pill badge-success">Active</span>';
					}
					else {
						return '<span class="badge badge-pill badge-secondary">Pending</span>';
					}
				},
				"sClass": "text-center",
			},

			{
				"aTargets": [4, 5],
				"mRender": function (data, type, full) {
					return convert_php_time(data);
				},
			},

			{
				"aTargets": [7],
				"bSortable": false,
				 "mRender": function (data, type, full) {
					
				 	html = '';
					if (full[0] != 1) {
						html += '<a href="users/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning"><span class="fa fa-pencil"></span></a>';
						if (full[6] == '1') {
							html += ' <a href="users/suspend/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Deactivate" class="btn btn-sm btn-info"><span class="fa fa-thumbs-down"></span></a>';
						}
						else {
							html += ' <a href="users/activate/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Activate" class="btn btn-sm btn-primary"><span class="fa fa-thumbs-up"></span></a>';
						}
						html += ' <a href="users/change_user/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Login" class="btn btn-sm btn-success"><span class="fa fa-lock"></span></a>';               
						html += ' <a href="users/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>';

						
					}
					
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


function convert_php_time(t){
	var dt = new Date(t*1000);
	return dt.toString().substring(0,21);
}