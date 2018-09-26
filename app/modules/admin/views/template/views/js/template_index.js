$(function() {
	// renders the datatables (datatables.net)
{{datatables_js}}

	// executes functions when the modal closes
	$('body').on('hidden.bs.modal', '.modal', function () {        
		// eg. destroys the wysiwyg editor
	});

});