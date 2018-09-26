var unknown_form_error = 'An unknown error was encountered or your form token has expired. Please try refreshing this page and submit the form again.';

$(function() {
	// frame buster
	if( self != top ) { 
		top.location = self.location;
	}

	$('[data-toggle="offcanvas-left"]').on('click', function () {
		$('#left-panel').toggleClass('open')
	});

	$('[data-toggle="offcanvas-right"]').on('click', function () {
		$('#right-panel').toggleClass('open')
	});
	

	// tooltip
	if(isTouchDevice()===false) {
		$("body").tooltip({ selector: '[tooltip-toggle=tooltip]' });
	}

	// modal ajax content
	$('#modal, #modal-lg').on('show.bs.modal', function (e) {
		$(this).find('.modal-content').load(e.relatedTarget.href);
	});

	// disable caching of ajax content
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
		restore_modal();
	});
});

function isTouchDevice(){
		return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
}

function restore_modal() {

	$('.modal-content').empty();

	var html =	'<div class="modal-header">\
					<h5 class="modal-title" id="modalLabel">Loading...</h5>\
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
						<span aria-hidden="true">&times;</span>\
					</button>\
				</div>\
				<div class="modal-body">\
					<div class="text-center">\
						<img src="' + site_url + 'ui/images/loading3.gif' + '" alt="Loading" />\
						<p>Loading...</p>\
					</div>\
				</div>\
				<div class="modal-footer">\
					<button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>\
				</div>';

	$('.modal-content').html(html);
}

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// resolve Select2 and Bootstrap 3 modal conflict
// $.fn.modal.Constructor.prototype.enforceFocus =function(){};