$(document).ready(function() {
	/************************************************************************/
	/*								Partner-offer							*/
	
	if($('#bell_partner_offer').length > 0) {
		$('#bell_partner_offer').bind('click', function(e) {
			
			if($(e.target).parents('#bell-partner-offer-wrapper').length <= 0) {
				if($('#bell-partner-offer-wrapper').is(':visible')) {
					$('#bell-partner-offer-wrapper').hide();
				} else {
					$('#bell-partner-offer-wrapper').show();
					
					setTimeout(function(){
						$(document).bind('click', function(e) {
							if($(e.target).parents('#bell-partner-offer-wrapper').length <= 0) {
								$('#bell-partner-offer-wrapper').hide();
								$(document).unbind('click')
							}
						})
					}, 1000);
				}
			}
		})
	}
	
	var date = new Date();
	date.setDate(date.getDate() + 1);
	
	ajaxRequest('getUser').success(function(response) {
		response = JSON.parse(response);
	
		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		params.filter.status_id = '86';
		params.filter.partner_id = response.id;
		
		params.fields = new Array('acquisition_id',
				  'acquisition_zip_code',
				  'acquisition_city',
				  'acquisition_address',
				  'acquisition_frequency',
				  'partner_offer_datetime',
				  'partner_offer_visible',
				  'partner_offer_offer',
				  'partner_offer_accepted',
				  'partner_offer_comment');
	
		ajaxRequest('getAcquisitionsNew', params).success(function(response) {
			
			response = JSON.parse(response);
			var appointments = response['data'];
			var count = response['count'];
			
			/**
			 * Template
			 */
			var div = '';
			div += '<div id="bell-partner-offer-wrapper" class="dnone" style="cursor:default;">';
			div += '  <div class="bell-arrow-top"></div>';
			div += '  <div id="bell-partner-offer-holder">';
			
			div += '      <div class="this-week-button fl cp active" style="width:298px;">Ausstehende Anforderungen</div>';
			div += '      <div class="cb"></div>';
			
			div += '    <div id="bell-partner-offer-inner">';
			
			div += '      <div class="this-week-appointments">';
			for(var app in appointments) {
				
				var tmp = appointments[app];
				
				div += '        <div id="partner-offer-'+tmp.id+'">';
				div += '          <div class="appointment" onClick="getSingle(\''+tmp.acquisition_id+'\')">';
				div += '            <div class="name">'+tmp.acquisition_address + '<br>' + tmp.acquisition_zip_code + ' ' + tmp.acquisition_city+'</div>';
				div += '          </div>';
				div += '          <hr style="border-bottom:1px solid #fff; border-top:none; margin:0px;">';
				div += '        </div>';
			}
			div += '      </div>';
			div += '    </div>';
			div += '  </div>';
			div += '</div>';
			
			div = $(div);
			
			$('#bell_partner_offer').append(div);
			
			$('#bell_partner_offer').append('<div class="counter">'+count+'</div>');
		});
	});
	
	
	/*								Appointments							*/
	/************************************************************************/
})

function getSingle(id) {
	window.open('https://' + window.location.host + '/Dashboard/Partner/Id/' + id, '_blank');
}