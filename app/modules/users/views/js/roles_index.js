/**
 * @package     Codifire
 * @version     1.0
 * @author      Randy Nivales <randynivales@gmail.com>
 * @copyright   Copyright (c) 2014-2015, Randy Nivales
 * @link        randynivales@gmail.com
 */
$(function() {
    
    var oTable = $('#datatables').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "roles/datatables",
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
                "aTargets": [3],
                "bSortable": false,
                 "mRender": function (data, type, full) {
                    // html = '<a href="groups/view/'+full[0]+'"><button data-toggle="modal" data-target="#groups_form" title="View" class="btn btn-xs btn-success"><span class="fa fa-eye"></span></button></a>';

                    html = '<a href="roles/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning"><span class="fa fa-pencil"></span></a>';
                    
                    html += ' <a href="roles/access/'+full[0]+'" tooltip-toggle="tooltip" data-placement="top" title="Permissions" class="btn btn-sm btn-info"><span class="fa fa-lock"></span></a>';

                    if (full[0] != 1) {
                        html += ' <a href="roles/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>';
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

} );
