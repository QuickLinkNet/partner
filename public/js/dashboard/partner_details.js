$(document).ready(function() {
	
	$('#client-attachment-upload').bind('change', function() {
		$('#client-att-form').submit();
	});
	
	$('#land-registry-attachment-upload').bind('change', function() {
		$('#land-registry-att-form').submit();
	});
	
	$('#court-attachment-upload').bind('change', function() {
		$('#court-att-form').submit();
	});
	
	$('#lawyer-attachment-upload').bind('change', function() {
		$('#lawyer-att-form').submit();
	});
	
	/**
	 * Attachment layers
	 */
	var attachment_layers = new Array();
	
	$('.attachment-click').each(function(e) {
		attachment_layers.push($(this).attr('id').replace('button_', ''));
		$(this).bind('click', function(e) {
			for(layer in attachment_layers) {
				$('#'+attachment_layers[layer]).hide();
				$('#button_'+attachment_layers[layer]).removeClass('active');
			}
			
			$('#'+$(e.currentTarget).attr('id').replace('button_', '')).show();
			$('#'+$(e.currentTarget).attr('id')).addClass('active');
		})
	})
	
	$('#save-status').bind('click', function() {
		
		var params = new Array();
		params['aid'] = $('#aid').val();
		params['sid'] = $('#status').val();
		params['description'] = $('#description').val();
		params['period'] = $('#period').val();
		
		/**
		 * TODO
		 * Ajax: refresh status course
		 */
		ajaxRequest('changeStatus', params).success(function(response) {
			$('#error_msg').addClass('dnone');
			$('#success_msg').addClass('dnone');
			
			window.scrollTo(0, 0);
			
			$('#form-error').find('li').each(function() {
				$(this).remove();
			});
			$('#form-sucess').find('li').each(function() {
				$(this).remove();
			});
			
			response = JSON.parse(response);
			
			if(response.error_msg.length > 0) {
				$('#error_msg').removeClass('dnone');
				for(var msg in response.error_msg) {
					$('#form-error').append('<li>'+response.error_msg[msg]+'</li>');
				}
			}
			
			if(response.success_msg.length > 0) {
				$('#success_msg').removeClass('dnone');
				for(var msg in response.success_msg) {
					$('#form-success').append('<li>'+response.success_msg[msg]+'</li>');
				}
			}
			
			if(response.success) {
				setTimeout(function(){ location.reload() }, 3000);
			}
		});
	})
	
	/**
	 * Set Fancybox
	 */
	$("a#original").fancybox({
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	
	/**
	 * Set Fancybox
	 */
	$("a#retouched").fancybox({
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	
	var address = $('#google_address').html();
	var zip_code = $('#google_zip_code').html();
	var city = $('#google_city').html();
	
	// initialize('google_map',address + ' ' + zip_code + ' ' + city,mapvar1)

    if($('#longitude').length > 0 && $('#latitude').length > 0) {

        var map;
        function initMap() {

            var myLatLng = {lat: Number($('#latitude').val()), lng: Number($('#longitude').val())};

            map = new google.maps.Map(document.getElementById('google_map'), {
                center: myLatLng,
                zoom: 10
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
            });
        }

        initMap();
    }
	
})

var map = null;
var geocoder = null;
var mapvar1=null;
var mapvar2=null;

function getPDF(file) {
	var path = '/user/offer_pdf/' + file;
	window.open(window.location.protocol + '//' + window.location.host + path, '_blank');
}

// function initialize(mapnummer,address,mapvar) {
//   if (GBrowserIsCompatible()) {
//     mapvar = new GMap2(document.getElementById(mapnummer));
//     geocoder = new GClientGeocoder();
//     showAddress(address,mapvar, mapnummer);
//   }
// }

function showAddress(address,mapvar, mapnummer) {
  if (geocoder) {
    geocoder.getLatLng(
      address,
      function(point) {
        if (!point) {
          $('#' + mapnummer).html('Nicht gefunden');
        } else {
          mapvar.setCenter(point, 13);
          var marker = new GMarker(point);
          mapvar.addOverlay(marker);              
        }
      }
    );
  }
}

function deleteFile(e, file) {
	var params = new Array();
	params['file'] = file;
	
	ajaxRequest('deleteFile', params).success(function(response) {
		response = JSON.parse(response);
		if(response == true) {
			$(e).parent().parent().fadeOut();
		}
	})
}