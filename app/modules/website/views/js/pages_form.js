// Dropzone.autoDiscover = false;

$(function() {

	// $('#my-grid').gridEditor({
		// tinymce: {
		// 	config: { paste_as_text: true }
		// }
	// });

	//grid_editor('#my-grid');

	// handles the post action

	$('.disabled').prop('disabled','true');

	$('#page_properties, #page_posts').select2();

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

		var properties = 0;
		if($('#page_properties').val()) { var properties = $('#page_properties').val(); }

		var articles = 0;
		if($('#page_posts').val()) { var articles = $('#page_posts').val(); }

		// submits the data to the backend
		$.post(post_url, {
			page_parent_id: $('#page_parent_id').val(),
			page_title_orig: $('#page_title_orig').val(),
			page_title: $('#page_title').val(),
			page_heading_text: $('#page_heading_text').val(),
			page_content: tinyMCE.get('page_content').getContent(),
			page_bottom_content: tinyMCE.get('page_bottom_content').getContent(),
			page_rear_content: tinyMCE.get('page_rear_content').getContent(),
			page_layout: $('#page_layout').val(),
			page_status: $('.page_status:checked').val(),
			page_map_name: $('#page_map_name').val(),
			page_latitude: $('#page_latitude').val(),
			page_longitude: $('#page_longitude').val(),
			page_slug: $('#page_slug').val(),
			page_properties: properties,
			page_tagposts: articles,
			// page_sidebar_id: $('#page_sidebar_id').val(),
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
						$('#error-asterisk-' + form_name).html('<span style="color:red">*</span>');
					}
				}
			} else {
				if (o.action == 'add') {
					window.location.replace(site_url + 'website/pages/form/edit/' + o.id);
				} else {
					// shows the success message
					alertify.success(o.message); 
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

	// select page layout
	var layout = $("#page_layout");
	var option = layout.find('option');

	if(option.is(':selected')) page_layout(layout);

	layout.on("change", function(e){
		page_layout($(this));
	});

	function page_layout(elem)
	{
		var layout = elem.find("option:selected").val();		

		if (layout == 'right_sidebar' || layout == 'left_sidebar') {
			$("#frontend_sidebar").removeClass('d-none');
		} else {
			$("#frontend_sidebar").addClass('d-none');
			$("#frontend_sidebar").find('option:eq(0)').prop('selected', true);
		}
	}
});


function initMap() {
    var myLatlng = new google.maps.LatLng($('#page_latitude').val(), $('#page_longitude').val());
    

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
            $('#page_latitude').val(map.getCenter().lat());
            $('#page_longitude').val(map.getCenter().lng());
            $('#zoom').val(map.getZoom());
        });
    });

 //    if(action=='edit'){

 //    	if($('#page_latitude').val() != 0  &&  $('#page_longitude').val() !=0){ 
	// 	    var geocoder = new google.maps.Geocoder;
	// 	    var infowindow = new google.maps.InfoWindow;
	// 	    geocodeLatLng(geocoder, map, infowindow);
	// 	}
	// }


    // drag event
    google.maps.event.addListener(map,'dragend',function(event) {
        $('#page_latitude').val(map.getCenter().lat());
        $('#page_longitude').val(map.getCenter().lng());
    });

    // zoom event
    google.maps.event.addListener(map,'zoom_changed',function(event) {
        $('#zoom').val(map.getZoom());
    });
}

function geocodeLatLng(geocoder, map, infowindow) {
	var latlng = new google.maps.LatLng($('#page_latitude').val(), $('#page_longitude').val());

	geocoder.geocode({'location': latlng}, function(results, status) {
	  if (status === 'OK') {
	    if (results[0]) {
	      map.setZoom(11);
	      var marker = new google.maps.Marker({
	        position: latlng,
	        map: map
	      });
	      infowindow.setContent(results[0].formatted_address);
	      infowindow.open(map, marker);
	    } else {
	      window.alert('No results found');
	    }
	  } else {
	    window.alert('Geocoder failed due to: ' + status);
	  }
	});
}