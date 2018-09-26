/**
 * @package     Codifire
 * @version     1.0
 * @author      Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright   Copyright (c) 2015, Digify, Inc.
 * @link        http://www.digify.com.ph
 */
$(function() {

    // renders the datatables (datatables.net)
    var oTable = $('#datatables').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "categories/datatables",
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
            { "width": "10%", "targets": 3 },
			{ "width": "200", "targets": 8 },
            {
                "aTargets": [0],
                "sClass": " text-center",
            },

            {
                "aTargets": [1],
                "mRender": function (data, type, full) {
                    return '<a href="categories/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit">' + data + '</a>';
                },
            },

            {
                "aTargets": [3],
                 "mRender": function (data, type, full) {
                    if (data == 'Active') {
                        return '<div class="badge badge-pill badge-info">' + data + '</div>';
                    }
                    else if (data == 'Disabled') {
                        return '<div class="badge badge-pill badge-danger">' + data + '</div>';
                    }
                    else {
                        return '<div class="badge badge-pill badge-default">' + data + '</div>';
                    }
                 },
                 "sClass": " text-center",
            },

            {
                "aTargets": [8],
                "bSortable": false,
                 "mRender": function (data, type, full) {
                    html = '<a href="' + site_url + 'metatags/form/website/categories/' + full[0] + '" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Meta Tags" class="btn btn-sm btn-info"><span class="fa fa-cogs"></span></a> ';
                    html += '<a href="categories/form/view/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-success"><span class="fa fa-eye"></span></a> ';
                    html += '<a href="categories/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning"><span class="fa fa-pencil"></span></a> ';
                    html += '<a href="categories/delete/'+full[0]+'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>';

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