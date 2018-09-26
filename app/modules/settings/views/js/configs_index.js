$(document).ready(function() {
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "configs/datatables",
		"lengthMenu" : [[50, 100, 300, -1], [50, 100, 300, "All"]],
		"pagingType" : "full_numbers",
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
				"sClass": "text-center"
			}, 
			{
				"aTargets": [1],
				"mRender": function (data, type, full) {
					html = '<a href="configs/form/edit/'+full[0]+'" data-toggle="modal" data-target="#modal">' + data + '</a>';
					return html;
				},
			},
			// {
			// 	"aTargets": [2],
			// 	"mRender": function (data, type, full) {
					
			// 		var html = data;

			// 		if (IsJsonString(data))
			// 		{
			// 			var d = JSON.parse(data);
			// 			html = '';
			// 			$.each(d, function(key, value){
			// 				if (value.status)
			// 					html += '<label class="btn btn-minier btn-white">' + (value.icon ? '<i class="' + value.icon + '"></i>' : value.name) + '</label> ';
			// 			});
			// 		}
					
			// 		return html;
			// 	},
			// }
		]
	});

	function IsJsonString(str) {
	    try {
	        JSON.parse(str);
	    } catch (e) {
	        return false;
	    }
    	return true;
	}
});