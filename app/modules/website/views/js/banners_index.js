$(function() {

	// $('input[name="banner_display"]').change(function(){

	$('#banner_display_button').click(function(){
		// var text = $(this).attr('data-text');
		$.post(site_url + 'website/banners/main_video_save', {
			video_id: 1,
			video_status: $('#banner_display').val() //$('input[name="banner_display"]:checked').val(),
		},
		function(){
			alertify.success('Selected Dislay Banner Updated');
			setTimeout(function(){location.reload(); }, 1500);
		});

	});
		

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

    $('#post').click(function(){
    	$.post(site_url + 'website/banners/video_form', {
			video_id: 1,
			video_title: $('#video_title').val(),
			video_caption: $('#video_caption').val(),
			video_text_pos: $('#video_text_pos').val(),
			video_button_text: $('#video_button_text').val(),
			video_link: $('#video_link').val(),

			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		},
		function(data, status){
			// handles the returned data
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				// shows the error message
				alertify.error(o.message);

				if (o.errors) {
					for (var form_name in o.errors) {
						$('#error-' + form_name).html(o.errors[form_name]);
					}
				}

			} else {
				// shows the success message
				alertify.success(o.message); 
			}
		});
    });
});
