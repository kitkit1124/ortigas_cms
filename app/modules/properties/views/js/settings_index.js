$(function() {
	$( "#sortable" ).sortable({
		update: function( event, ui ) {
			var ids = new Array();
			$("#sortable li").each(function(key, val){
				ids.push($(this).attr('data-id'));
			});
			
			// submit
			$.post(site_url + 'properties/settings/reorder', {
				ids: ids,
			},
			function(data, status){
				// handles the returned data
				var o = jQuery.parseJSON(data);
				if (o.success === false) {
					// shows the error message
					alertify.error(o.message);

				} else {
					// // shows the success message
					// alertify.success(o.message); 
				}
			}).fail(function() {
				// shows the error message
				alertify.alert('Error', unknown_form_error);

				// reset the button
				btn.button('reset');
			});
		}
	});
    $( "#sortable" ).disableSelection();

});