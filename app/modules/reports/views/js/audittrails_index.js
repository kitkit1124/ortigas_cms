/**
 * @package     Codifire
 * @version     1.0
 * @author      Randy Nivales <randynivales@gmail.com>
 * @copyright   Copyright (c) 2014-2015, Randy Nivales
 * @link        randynivales@gmail.com
 */
$(function() {

    $("body").tooltip({ selector: '[tooltip-toggle=tooltip]' });

    var oTable = $('#datatables').DataTable({
        "buttons": [
            'csv'
        ],
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "audittrails/datatables",
        "lengthMenu": [[10, 50, 100, 300, -1], [10, 50, 100, 300, "All"]],
        "pagingType": "full_numbers",
        "language": {
            "paginate": {
                "previous": 'Prev',
                "next": 'Next',
            }
        },
        "bAutoWidth": false,
        "aaSorting": [[ 0, "desc" ]],
        "aoColumnDefs": [
            
            {
                "aTargets": [0],
                "sClass": "text-center",
            },

            {
                "aTargets": [6],
                "bSortable": false,
                 "mRender": function (data, type, full) {
                    html = '<a href="audittrails/view/'+full[0]+'" data-toggle="modal" data-target="#audittrails_details" tooltip-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-success"><span class="fa fa-eye"></span> View</a>';

                    return html;
                },
                "sClass": "text-center",
            },
        ]
    });

    $('.btn-actions').prependTo('div.dataTables_filter');

    $('body').on('hidden.bs.modal', '.modal', function () {

    });

    $('#export').click(function(e){
        var filter = $('#datatables_filter').find('input[type="search"]');
        var href = $(this).attr('href').split('?');

        $(this).attr('href', href[0] + '?q=' + filter.val());
    });

    // modal ajax content
	$('#audittrails_details').on('show.bs.modal', function (e) {
		$(this).find('.modal-content').load(e.relatedTarget.href);
	});

});