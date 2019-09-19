$(function() {
	
	
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
			estate_name_original: $('#estate_name_original').val(),
			estate_name: $('#estate_name').val(),
			estate_location_id: $('#estate_location_id').val(),
			estate_text: tinyMCE.get('estate_text').getContent(),
			estate_snippet_quote: tinyMCE.get('estate_snippet_quote').getContent(),
			estate_bottom_text: tinyMCE.get('estate_bottom_text').getContent(),
			estate_featured: $('input[name="estate_featured"]:checked').val(),
			estate_latitude: $('#estate_latitude').val(),
			estate_longtitude: $('#estate_longtitude').val(),
			estate_image: $('#estate_image').val(),
			estate_alt_image: $('#estate_alt_image').val(),
			estate_thumb: $('#estate_thumb').val(),
			estate_alt_thumb: $('#estate_alt_thumb').val(),
			estate_status: $('#estate_status').val(),
			estate_alt_logo: $('#estate_alt_logo').val(),
			estate_logo: $('#estate_logo').val(),
			estate_slug: $('#estate_slug').val(),

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
					window.location.replace(site_url + 'properties/estates/form/edit/' + o.id);
				} else {
					// shows the success message
					alertify.success(o.message); 

					setTimeout(function(){ location.reload(); }, 1000);					
				} 
			}

			// reset the button
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

	if(featured_numrows >= 3){
	    $('#estate_featured1').click(function(){
	    	alertify.alert("Information: Latest 3 Featured Estates will be only shown.");
	    	$('#alertify-ok').click(function(){ $(this).fadeOut(100); }); 
	    });
	}

	$('.clear_logo').on('click',function(){
		$('#estate_active_logo').attr('src', site_url + 'ui/images/placeholder.png');
		$('#estate_logo').attr('value',0);
	});

	tinymce.init({
		selector: "#estate_text, #estate_bottom_text, #estate_snippet_quote",
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
    var myLatlng = new google.maps.LatLng($('#estate_latitude').val(), $('#estate_longtitude').val());
    

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
        }

        map.fitBounds(bounds);
        map.setZoom(16);     
        google.maps.event.addListener(map, 'bounds_changed', function() {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);    
            $('#estate_latitude').val(map.getCenter().lat());
            $('#estate_longtitude').val(map.getCenter().lng());
            $('#zoom').val(map.getZoom());
        });
    });

    if(action=='edit'){

    	if($('#estate_latitude').val() != 0  &&  $('#estate_longtitude').val() !=0){ 
		    var geocoder = new google.maps.Geocoder;
		    var infowindow = new google.maps.InfoWindow;
		    geocodeLatLng(geocoder, map, infowindow);
		}
	}


    // drag event
    google.maps.event.addListener(map,'dragend',function(event) {
        $('#estate_latitude').val(map.getCenter().lat());
        $('#estate_longtitude').val(map.getCenter().lng());
    });

    // zoom event
    google.maps.event.addListener(map,'zoom_changed',function(event) {
        $('#zoom').val(map.getZoom());
    });
}

function geocodeLatLng(geocoder, map, infowindow) {
	var latlng = new google.maps.LatLng($('#estate_latitude').val(), $('#estate_longtitude').val());

	geocoder.geocode({'location': latlng}, function(results, status) {
	  if (status === 'OK') {
	    if (results[0]) {
	      map.setZoom(11);
	      var marker = new google.maps.Marker({
	        position: latlng,
	        map: map
	      });
	      // infowindow.setContent(results[0].formatted_address);
	      // infowindow.open(map, marker);
	      map = results[0].formatted_address;
          $('#pac-input').val(map);
	    } else {
	      window.alert('No results found');
	    }
	  } else {
	    window.alert('Geocoder failed due to: ' + status);
	  }
	});
}
