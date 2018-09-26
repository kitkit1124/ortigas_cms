$(function() {
	$( "#sortable" ).sortable({
		update: function( event, ui ) {
			var banner_ids = new Array();
			$("#sortable li").each(function(key, val){
				banner_ids.push($(this).attr('data-id'));
			});
			
			// submit
			$.post(site_url + 'website/banners/reorder', {
				banner_ids: banner_ids,
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
