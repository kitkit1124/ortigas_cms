$(function() {
	
	var div_id = $('#career_div').val();
	if(div_id){}
	else{ $('#career_dept').prop( "disabled", true ).css('color','#999'); }

	$('#career_div').change(function() {
		$('#career_dept').prop( "disabled", false ).css('color','#495057');
		var id = $(this).val();
		$('#career_dept').html(' ').append('<option value=""> </option>');

		if(id){
			$.ajax({method: "GET",url: site_url+"careers/careers/get_departments",data: { division_id : id } })
			.done(function( data ) {
				d = jQuery.parseJSON(data);
				$.each(d, function( index, value ) {
					$('#career_dept').append('<option value="' + value.department_id + '">' + value.department_name + '</option>');
				});
			});
		}
		else{
			$('#career_dept').prop( "disabled", true ).css('color','#999').html('<option value="">Please select Division first</option>');
		}
    });	
	
	// handles the submit action
	$('#post').click(function(e){
		// change the button to loading state
		var $this = $(this);
		var loadingText = '<i class="fa fa-spinner fa-spin"></i> Loading...';
		if ($(this).html() !== loadingText) {
			$this.data('original-text', $(this).html());
			$this.html(loadingText);
		}

		// prevents a submit button from submitting a form
		e.preventDefault();

		// submits the data to the backend
		$.post(post_url, {
			career_position_title: $('#career_position_title').val(),
			career_position_title_original: $('#career_position_title_original').val(),
			career_dept: $('#career_dept').val(),
			career_dept_original: $('#career_dept_original').val(),
			career_div: $('#career_div').val(),
			career_div_original: $('#career_div_original').val(),
			career_image: $('#career_image').val(),
			career_req: tinyMCE.get('career_req').getContent(), 
			career_res: tinyMCE.get('career_res').getContent(), 
			career_location: $('#career_location').val(),
			career_latitude: $('#career_latitude').val(),
			career_longitude: $('#career_longitude').val(),
			career_status: $('#career_status').val(),
			career_alt_image: $('#career_alt_image').val(),
			career_slug: $('#career_slug').val(),

			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		},
		function(data, status){
			// handles the returned data
			var o = jQuery.parseJSON(data);
			if (o.success === false) {

				// shows the error message
				alertify.error(o.message);

				// displays individual error messages
				if (o.errors) {
					for (var form_name in o.errors) {
						$('#error-' + form_name).html(o.errors[form_name]);
					}
				}
			} else {
				if (o.action == 'add') {
					alertify.success(o.message); 
					setTimeout(function(){ 
						window.location.replace(site_url + 'careers/careers/form/edit/' + o.id); }, 
					1000);
				} else {
					// shows the success message
					alertify.success(o.message); 
				} 
			}

			$this.html($this.data('original-text'));
		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			$this.html($this.data('original-text'));
		});
	});

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	tinymce.init({
		selector: "#career_req, #career_res",
		theme: "modern",
		statusbar: true,
		menubar: true,
		relative_urls: false,
		remove_script_host : false,
		convert_urls : true,
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern'
		],
		toolbar1: 'insertfile undo redo | styleselect forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link mybutton documents videos',
		image_advtab: true,
	});

});


function initMap() {
    var myLatlng = new google.maps.LatLng($('#career_latitude').val(), $('#career_longitude').val());
    

	var mapOptions = {
      zoom: parseInt('16'),
      center: myLatlng,
    }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    // map marker
    var marker = new google.maps.Marker({
        map: map,
    });
    marker.bindTo('position', map, 'center');

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    google.maps.event.addListener(searchBox, 'places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
             $('#career_location').val((place.name));
        }

        map.fitBounds(bounds);
        map.setZoom(16);     
        google.maps.event.addListener(map, 'bounds_changed', function() {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);    
            $('#career_latitude').val(map.getCenter().lat());
            $('#career_longitude').val(map.getCenter().lng());
            $('#zoom').val(map.getZoom());
        });
    });


    // drag event
    google.maps.event.addListener(map,'dragend',function(event) {
        $('#career_latitude').val(map.getCenter().lat());
        $('#career_longitude').val(map.getCenter().lng());
    });

    // zoom event
    google.maps.event.addListener(map,'zoom_changed',function(event) {
        $('#zoom').val(map.getZoom());
    });
}