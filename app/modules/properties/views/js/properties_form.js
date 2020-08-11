$(function() {
	initMap();
	
	var map;
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
			property_name_original: $('#property_name_original').val(),
			property_estate_id: $('#property_estate_id').val(),
			property_category_id: $('#property_category_id').val(),
			property_location_id: $('#property_location_id').val(),
			property_name: $('#property_name').val(),
			property_slug: $('#property_name').val(),
			property_price_range_id: $('#property_price_range_id').val(),
			property_prop_type_id: $('#property_prop_type_id').val(),
			property_is_featured: $('input[name="property_featured"]:checked').val(),
			property_overview: tinyMCE.get('property_overview').getContent(),
			property_snippet_quote: tinyMCE.get('property_snippet_quote').getContent(),
			property_bottom_overview: tinyMCE.get('property_bottom_overview').getContent(),
			property_page_id: $('#property_page_id').val(),
			property_image: $('#property_image').val(),
			property_alt_image: $('#property_alt_image').val(),
			property_thumb: $('#property_thumb').val(),
			property_alt_thumb: $('#property_alt_thumb').val(),
			property_logo: $('#property_logo').val(),
			property_alt_logo: $('#property_alt_logo').val(),
			property_link_label: $('#property_link_label').val(), 
			property_website: $('#property_website').val(), 
			property_facebook: $('#property_facebook').val(),
			property_twitter: $('#property_twitter').val(),
			property_instagram: $('#property_instagram').val(),
			property_linkedin: $('#property_linkedin').val(),
			property_map_name: $('#property_map_name').val(),
			property_latitude: $('#property_latitude').val(),
			property_latitude: $('#property_latitude').val(),
			property_longitude: $('#property_longitude').val(),
			property_nearby_malls: tinyMCE.get('property_nearby_malls').getContent(),
			property_nearby_markets: tinyMCE.get('property_nearby_markets').getContent(),
			property_nearby_hospitals: tinyMCE.get('property_nearby_hospitals').getContent(),
			property_nearby_schools: tinyMCE.get('property_nearby_schools').getContent(),
			property_tags: $('#property_tags').val(),
			property_status: $('#property_status').val(),
			property_construction_update: $('#property_construction_update').val(),
			property_ground: $('#property_ground').val(),
			property_presell: $('#property_presell').val(),
			property_turnover: $('#property_turnover').val(),
			property_slug: $('#property_slug').val(),
			property_availability: $('#property_availability').val(),
			property_location_description: $('#property_location_description').val(),
			property_amenities_description: $('#property_amenities_description').val(),
			
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
					window.location.replace(site_url + 'properties/properties/form/edit/' + o.id);
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


	$('.clear_logo').on('click',function(){
		$('#property_active_logo').attr('src', site_url + 'ui/images/placeholder.png');
		$('#property_logo').attr('value','');
	});

	tinymce.init({
		selector: "#property_overview, #property_snippet_quote, #property_bottom_overview, #property_nearby_malls, #property_nearby_schools, #property_nearby_hospitals, #property_nearby_markets",
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

    if(featured_numrows == 1){
	    $('#property_featured1').click(function(){
	    	alertify.alert("Information: Latest 3 Featured Properties will be only shown.");
	    	$('#alertify-ok').click(function(){ $(this).fadeOut(100); }); 
	    });
	}
});


function initMap() {
    var myLatlng = new google.maps.LatLng($('#property_latitude').val(), $('#property_longitude').val());
    

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
            $('#property_latitude').val(map.getCenter().lat());
            $('#property_longitude').val(map.getCenter().lng());
          
            $('#zoom').val(map.getZoom());
        });
    });

    if(action=='edit'){
	    if($('#property_latitude').val() != 0  &&  $('#property_longitude').val() !=0){ 
		    var geocoder = new google.maps.Geocoder;
		    var infowindow = new google.maps.InfoWindow;
		    geocodeLatLng(geocoder, map, infowindow);
		}

	}
    
    // drag event
    google.maps.event.addListener(map,'dragend',function(event) {
        $('#property_latitude').val(map.getCenter().lat());
        $('#property_longitude').val(map.getCenter().lng());
    });

    // zoom event
    google.maps.event.addListener(map,'zoom_changed',function(event) {
        $('#zoom').val(map.getZoom());
    });
}


function geocodeLatLng(geocoder, map, infowindow) {
    var latlng = new google.maps.LatLng($('#property_latitude').val(), $('#property_longitude').val());

    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          map.setZoom(16);
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