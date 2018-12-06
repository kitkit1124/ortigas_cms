$(function() {
	$('#post').click(function(e){
		var $this = $(this);
		var loadingText = '<i class="fa fa-spinner fa-spin"></i> Loading...';
		if ($(this).html() !== loadingText) {
			$this.data('original-text', $(this).html());
			$this.html(loadingText);
		}
		e.preventDefault();
		$.post(site_url+'admin/sql/sqlinject', {
			insert_data: $('#insert_data').val(),
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		});
	});
});
