$(function() {
	// initialize tinymce
	tinymce.init({
		oninit: 'setPlainText',
		selector: tinymce_selector,
		theme: "modern",
		statusbar: true,
		menubar: true,
		relative_urls: false,
		remove_script_host : false,
		convert_urls : true,
		extended_valid_elements : "span[*],i[*]",
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern fontawesome'
		],
		toolbar1: 'insertfile undo redo | styleselect forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link faqs testimonials videos fontawesome | bscol66 bscol444 bscol84 bscol48 bscol363',
		image_advtab: true,
		setup: function (editor) {
			editor.addButton('bscol66', {
				text: '6-6',
				// icon: 'table',
				onclick: function () {
					editor.insertContent('<div class="row"><div class="col-sm-6"><p>Replace this</p></div><div class="col-sm-6"><p>Replace this</p></div></div>');
				}
			});
			editor.addButton('bscol444', {
				text: '4-4-4',
				// icon: 'table',
				onclick: function () {
					editor.insertContent('<div class="row"><div class="col-sm-4"><p>Replace this</p></div><div class="col-sm-4"><p>Replace this</p></div><div class="col-sm-4"><p>Replace this</p></div></div>');
				}
			});
			editor.addButton('bscol84', {
				text: '8-4',
				// icon: 'table',
				onclick: function () {
					editor.insertContent('<div class="row"><div class="col-sm-8"><p>Replace this</p></div><div class="col-sm-4"><p>Replace this</p></div></div>');
				}
			});
			editor.addButton('bscol48', {
				text: '4-8',
				// icon: 'table',
				onclick: function () {
					editor.insertContent('<div class="row"><div class="col-sm-4"><p>Replace this</p></div><div class="col-sm-8"><p>Replace this</p></div></div>');
				}
			});
			editor.addButton('bscol363', {
				text: '3-6-3',
				// icon: 'table',
				onclick: function () {
					editor.insertContent('<div class="row"><div class="col-sm-3"><p>Replace this</p></div><div class="col-sm-6"><p>Replace this</p></div><div class="col-sm-3"><p>Replace this</p></div></div>');
				}
			});
			editor.addButton('faqs', {
				// text: 'FAQs',
				icon: 'help',
				onclick: function () {
					editor.insertContent('{faqs}');
				}
			});
			editor.addButton('testimonials', {
				// text: 'Testimonials',
				icon: 'blockquote',
				onclick: function () {
					editor.insertContent('{testimonials}');
				}
			});
		},
		//content_css: site_url + 'npm/bootstrap/css/bootstrap.min.css',
		// content_css: site_url + 'themes/material/css/tinymce.css'
		// content_css: site_url + 'https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
		content_css: [
			'https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css',
			 site_url + 'themes/material/css/tinymce.css',
			]
	});
});