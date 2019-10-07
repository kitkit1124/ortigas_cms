$(function() {
	$( "#sortable_" ).sortable({
		update: function( event, ui ) {
			var slider_ids = new Array();
			$("#sortable_ li").each(function(key, val){
				slider_ids.push($(this).attr('data-id'));
			});
			
			// submit
			$.post(site_url + 'properties/image_sliders/reorder', {
				slider_ids: slider_ids,
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
    $( "#sortable_" ).disableSelection();

});