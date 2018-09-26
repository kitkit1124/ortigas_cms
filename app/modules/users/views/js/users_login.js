$(function() {
	// handles the submit action
	$('#submit').click(function(e){
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');
	});
});