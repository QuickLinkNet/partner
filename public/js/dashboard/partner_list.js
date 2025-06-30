$(document).ready(function() {
	var site_first = $('#site-first').val();
	var site_second = $('#site-second').val();
	var site_third = $('#site-third').val();
	var site_fourth = $('#site-fourth').val();
	var site_fifth = $('#site-fifth').val();
	var site_sixth = $('#site-sixth').val();
	var site_seventh = $('#site-seventh').val();
    var site_eighth = $('#site-eighth').val();

	var max_first = $('#max_first').val();
	var max_second = $('#max_second').val();
	var max_third = $('#max_third').val();
	var max_fourth = $('#max_fourth').val();
	var max_fifth = $('#max_fifth').val();
	var max_sixth = $('#max_sixth').val();
	var max_seventh = $('#max_seventh').val();
    var max_eighth = $('#max_eighth').val();

	var count_first = 0;
	var count_second = 0;
	var count_third = 0;
	var count_fourth = 0;
	var count_fifth = 0;
	var count_sixth = 0;
	var count_seventh = 0;
    var count_eighth = 0;

	var order_first = 'partner_offer_datetime';
	var order_second = 'partner_offer_datetime';
	var order_third = 'partner_offer_datetime';
	var order_fourth = 'partner_offer_datetime';
	var order_fifth = 'partner_offer_datetime';
	var order_sixth = 'partner_offer_datetime';
	var order_seventh = 'partner_offer_datetime';
    var order_eighth = 'partner_offer_datetime';

	var sort_first = 'asc';
	var sort_second = 'asc';
	var sort_third = 'asc';
	var sort_fourth = 'asc';
	var sort_fifth = 'asc';
	var sort_sixth = 'asc';
	var sort_seventh = 'asc';
    var sort_eighth = 'asc';

	var interval_first = new Array();
	var interval_second = new Array();
	var interval_third = new Array();
	var interval_fourth = new Array();
	var interval_fifth = new Array();
	var interval_sixth = new Array();
	var interval_seventh = new Array();
    var interval_eighth = new Array();

	const jobTypes = [
		{ id: 1, name: "CityStar" },
		{ id: 2, name: "GF-U Wand" },
		{ id: 3, name: "GFB Wand" },
		{ id: 4, name: "GFU Doppelseitig" },
		{ id: 6, name: "CityStar einseitig" },
		{ id: 7, name: "GFU Freistehend" },
		{ id: 8, name: "GFB Freistehend" },
		{ id: 10, name: "GFB Doppelseitig" },
		{ id: 16, name: "PB Wand" },
		{ id: 17, name: "PB freistehend einseitig" },
		{ id: 18, name: "PB doppelseitig" },
		{ id: 19, name: "PB einseitig auf Monofuß" },
		{ id: 20, name: "PB doppelseitig auf Monofuß" },
		{ id: 21, name: "LED einseitig Monofuß" },
		{ id: 22, name: "LED doppelseitig Monofuß" },
		{ id: 23, name: "LED freistehend" },
		{ id: 24, name: "LED Wand" },
		{ id: 25, name: "Riesenposter" },
		{ id: 26, name: "Banner" },
		{ id: 27, name: "Flag" },
		{ id: 28, name: "Outdoor Screen" }
	];

	var partner_id = '';
	
	$('.decline_25').bind('click', function() {
		$('#partner-popup').fadeOut();
		$('#aperture').fadeOut();
		$('#send').unbind('click');
	})
	
	$('#first-search-button').bind('click', function() {
		getFirstAcquisitions();
	});
        
	$('#max_first').bind('change', function () {
		site_first = 1;
		max_first = $('#max_first').val();
		getFirstAcquisitions();
		displayCountFirst();
	})
	
	$('#max_second').bind('change', function () {
		site_second = 1;
		max_second = $('#max_second').val();
		getSecondAcquisitions();
		displayCountSecond();
	})
	
	$('#max_third').bind('change', function () {
		site_third = 1;
		max_third = $('#max_third').val();
		getThirdAcquisitions();
		displayCountThird();
	})
	
	$('#max_fourth').bind('change', function () {
		site_fourth = 1;
		max_fourth = $('#max_fourth').val();
		getFourthAcquisitions();
		displayCountFourth();
	})
	
	$('#max_fifth').bind('change', function () {
		site_fifth = 1;
		max_fifth = $('#max_fifth').val();
		getFifthAcquisitions();
		displayCountFifth();
	})
	
	$('#max_sixth').bind('change', function () {
		site_sixth = 1;
		max_sixth = $('#max_sixth').val();
		getSixthAcquisitions();
		displayCountSixth();
	})

    $('#max_seventh').bind('change', function () {
        site_seventh = 1;
        max_seventh = $('#max_seventh').val();
        getSeventhAcquisitions();
        displayCountSeventh();
    })

    $('#max_eighth').bind('change', function () {
        site_eighth = 1;
        max_eighth = $('#max_eighth').val();
        getEighthAcquisitions();
        displayCountEighth();
    })
	
	$('.back.first').bind('click', function() {
		if(site_first > 1) {
			$('#site-first').val((parseInt(site_first) - 1));
			site_first = $('#site-first').val();
			getFirstAcquisitions();
			displayCountFirst();
		}
	})
	
	$('.back.second').bind('click', function() {
		if(site_second > 1) {
			$('#site-second').val((parseInt(site_second) - 1));
			site_second = $('#site-second').val();
			getSecondAcquisitions();
			displayCountSecond();
		}
	})
	
	$('.back.third').bind('click', function() {
		if(site_third > 1) {
			$('#site-third').val((parseInt(site_third) - 1));
			site_third = $('#site-third').val();
			getThirdAcquisitions();
			displayCountThird();
		}
	})
	
	$('.back.fourth').bind('click', function() {
		if(site_fourth > 1) {
			$('#site-fourth').val((parseInt(site_fourth) - 1));
			site_fourth = $('#site-fourth').val();
			getFourthAcquisitions();
			displayCountFourth();
		}
	})
	
	$('.back.fifth').bind('click', function() {
		if(site_fifth > 1) {
			$('#site-fifth').val((parseInt(site_fifth) - 1));
			site_fifth = $('#site-fifth').val();
			getFifthAcquisitions();
			displayCountFifth();
		}
	})
	
	$('.back.sixth').bind('click', function() {
		if(site_sixth > 1) {
			$('#site-sixth').val((parseInt(site_sixth) - 1));
			site_sixth = $('#site-sixth').val();
			getSixthAcquisitions();
			displayCountSixth();
		}
	})

    $('.back.seventh').bind('click', function() {
        if(site_seventh > 1) {
            $('#site-seventh').val((parseInt(site_seventh) - 1));
            site_seventh = $('#site-seventh').val();
            getSeventhAcquisitions();
            displayCountSeventh();
        }
    })

    $('.back.eighth').bind('click', function() {
        if(site_eighth > 1) {
            $('#site-eighth').val((parseInt(site_eighth) - 1));
            site_eighth = $('#site-eighth').val();
            getEighthAcquisitions();
            displayCountEighth();
        }
    })
	
	$('.forward.first').bind('click', function() {
		if(((site_first - 1) * max_first) < (count_first - max_first)) {
			$('#site-first').val((parseInt(site_first) + 1));
			site_first = $('#site-first').val();
			getFirstAcquisitions();
			displayCountFirst();
		}
	})
	
	$('.forward.second').bind('click', function() {
		if(((site_second - 1) * max_second) < (count_second - max_second)) {
			$('#site-second').val((parseInt(site_second) + 1));
			site_second = $('#site-second').val();
			getSecondAcquisitions();
			displayCountSecond();
		}
	})
	
	$('.forward.third').bind('click', function() {
		if(((site_third - 1) * max_third) < (count_third - max_third)) {
			$('#site-third').val((parseInt(site_third) + 1));
			site_third = $('#site-third').val();
			getThirdAcquisitions();
			displayCountThird();
		}
	})
	
	$('.forward.fourth').bind('click', function() {
		if(((site_fourth - 1) * max_fourth) < (count_fourth - max_fourth)) {
			$('#site-fourth').val((parseInt(site_fourth) + 1));
			site_fourth = $('#site-fourth').val();
			getFourthAcquisitions();
			displayCountFourth();
		}
	})
	
	$('.forward.fifth').bind('click', function() {
		if(((site_fifth - 1) * max_fifth) < (count_fifth - max_fifth)) {
			$('#site-fifth').val((parseInt(site_fifth) + 1));
			site_fifth = $('#site-fifth').val();
			getFifthAcquisitions();
			displayCountFifth();
		}
	})
	
	$('.forward.sixth').bind('click', function() {
		if(((site_sixth - 1) * max_sixth) < (count_sixth - max_sixth)) {
			$('#site-sixth').val((parseInt(site_sixth) + 1));
			site_sixth = $('#site-sixth').val();
			getSixthAcquisitions();
			displayCountSixth();
		}
	})

    $('.forward.seventh').bind('click', function() {
        if(((site_seventh - 1) * max_seventh) < (count_seventh - max_seventh)) {
            $('#site-seventh').val((parseInt(site_seventh) + 1));
            site_seventh = $('#site-seventh').val();
            getSeventhAcquisitions();
            displayCountSeventh();
        }
    })

    $('.forward.eighth').bind('click', function() {
        if(((site_eighth - 1) * max_eighth) < (count_eighth - max_eighth)) {
            $('#site-eighth').val((parseInt(site_eighth) + 1));
            site_eighth = $('#site-eighth').val();
            getEighthAcquisitions();
            displayCountEighth();
        }
    })

    // $('#partner-active')

	$('#partner-active').bind('click', function() {
		$(this).addClass('active');
		$('#partner-inactive').removeClass('active');
		$('#partner-progress').removeClass('active');
		$('#partner-contract-interest').removeClass('active');
		$('#partner-contract-cancel').removeClass('active');
		$('#partner-ba-completed').removeClass('active');
		
		$('#sheet-pagination-first').removeClass('dnone');
		$('#sheet-pagination-second').addClass('dnone');
		$('#sheet-pagination-third').addClass('dnone');
		$('#sheet-pagination-fourth').addClass('dnone');
		$('#sheet-pagination-fifth').addClass('dnone');
		$('#sheet-pagination-sixth').addClass('dnone');
		$('#sheet-pagination-seventh').addClass('dnone');
        $('#sheet-pagination-eighth').addClass('dnone');

		$('#first').removeClass('dnone');
		$('#second').addClass('dnone');
		$('#third').addClass('dnone');
		$('#fourth').addClass('dnone');
		$('#fifth').addClass('dnone');
		$('#sixth').addClass('dnone');
		$('#seventh').addClass('dnone');
        $('#eighth').addClass('dnone');
	})
	
	$('#partner-inactive').bind('click', function() {
		$('#partner-active').removeClass('active');
		$(this).addClass('active');
		$('#partner-progress').removeClass('active');
		$('#partner-contract-interest').removeClass('active');
		$('#partner-contract-cancel').removeClass('active');
		$('#partner-ba-completed').removeClass('active');
		
		$('#sheet-pagination-first').addClass('dnone');
		$('#sheet-pagination-second').removeClass('dnone');
		$('#sheet-pagination-third').addClass('dnone');
		$('#sheet-pagination-fourth').addClass('dnone');
		$('#sheet-pagination-fifth').addClass('dnone');
		$('#sheet-pagination-sixth').addClass('dnone');
		$('#sheet-pagination-seventh').addClass('dnone');
        $('#sheet-pagination-eighth').addClass('dnone');

		$('#first').addClass('dnone');
		$('#second').removeClass('dnone');
		$('#third').addClass('dnone');
		$('#fourth').addClass('dnone');
		$('#fifth').addClass('dnone');
		$('#sixth').addClass('dnone');
		$('#seventh').addClass('dnone');
        $('#eighth').addClass('dnone');
	})
	
	$('#partner-progress').bind('click', function() {
		$('#partner-active').removeClass('active');
		$('#partner-inactive').removeClass('active');
		$(this).addClass('active');
		$('#partner-contract-interest').removeClass('active');
		$('#partner-contract-cancel').removeClass('active');
		$('#partner-ba-completed').removeClass('active');
		
		$('#sheet-pagination-first').addClass('dnone');
		$('#sheet-pagination-second').addClass('dnone');
		$('#sheet-pagination-third').removeClass('dnone');
		$('#sheet-pagination-fourth').addClass('dnone');
		$('#sheet-pagination-fifth').addClass('dnone');
		$('#sheet-pagination-sixth').addClass('dnone');
		$('#sheet-pagination-seventh').addClass('dnone');
        $('#sheet-pagination-eighth').addClass('dnone');

		$('#first').addClass('dnone');
		$('#second').addClass('dnone');
		$('#third').removeClass('dnone');
		$('#fourth').addClass('dnone');
		$('#fifth').addClass('dnone');
		$('#sixth').addClass('dnone');
		$('#seventh').addClass('dnone');
        $('#eighth').addClass('dnone');
	})
	
	$('#partner-contract-interest').bind('click', function() {
		$('#partner-active').removeClass('active');
		$('#partner-inactive').removeClass('active');
		$('#partner-progress').removeClass('active');
		$(this).addClass('active');
		$('#partner-contract-cancel').removeClass('active');
		$('#partner-ba-completed').removeClass('active');
		
		$('#sheet-pagination-first').addClass('dnone');
		$('#sheet-pagination-second').addClass('dnone');
		$('#sheet-pagination-third').addClass('dnone');
		$('#sheet-pagination-fourth').removeClass('dnone');
		$('#sheet-pagination-fifth').addClass('dnone');
		$('#sheet-pagination-sixth').addClass('dnone');
		$('#sheet-pagination-seventh').addClass('dnone');
        $('#sheet-pagination-eighth').addClass('dnone');

		$('#first').addClass('dnone');
		$('#second').addClass('dnone');
		$('#third').addClass('dnone');
		$('#fourth').removeClass('dnone');
		$('#fifth').addClass('dnone');
		$('#sixth').addClass('dnone');
		$('#seventh').addClass('dnone');
        $('#eighth').addClass('dnone');
	})
	
	$('#partner-contract-cancel').bind('click', function() {
		$('#partner-active').removeClass('active');
		$('#partner-inactive').removeClass('active');
		$('#partner-progress').removeClass('active');
		$('#partner-contract-interest').removeClass('active');
		$(this).addClass('active');
		$('#partner-ba-completed').removeClass('active');
		
		$('#sheet-pagination-first').addClass('dnone');
		$('#sheet-pagination-second').addClass('dnone');
		$('#sheet-pagination-third').addClass('dnone');
		$('#sheet-pagination-fourth').addClass('dnone');
		$('#sheet-pagination-fifth').removeClass('dnone');
		$('#sheet-pagination-sixth').addClass('dnone');
		$('#sheet-pagination-seventh').addClass('dnone');
        $('#sheet-pagination-eighth').addClass('dnone');

		$('#first').addClass('dnone');
		$('#second').addClass('dnone');
		$('#third').addClass('dnone');
		$('#fourth').addClass('dnone');
		$('#fifth').removeClass('dnone');
		$('#sixth').addClass('dnone');
		$('#seventh').addClass('dnone');
        $('#eighth').addClass('dnone');
	})
	
	$('#partner-ba-completed').bind('click', function() {
		$('#partner-active').removeClass('active');
		$('#partner-inactive').removeClass('active');
		$('#partner-progress').removeClass('active');
		$('#partner-contract-interest').removeClass('active');
		$('#partner-contract-cancel').removeClass('active');
		$(this).addClass('active');
		
		$('#sheet-pagination-first').addClass('dnone');
		$('#sheet-pagination-second').addClass('dnone');
		$('#sheet-pagination-third').addClass('dnone');
		$('#sheet-pagination-fourth').addClass('dnone');
		$('#sheet-pagination-fifth').addClass('dnone');
		$('#sheet-pagination-sixth').removeClass('dnone');
		$('#sheet-pagination-seventh').removeClass('dnone');
        $('#sheet-pagination-eighth').removeClass('dnone');

		$('#first').addClass('dnone');
		$('#second').addClass('dnone');
		$('#third').addClass('dnone');
		$('#fourth').addClass('dnone');
		$('#fifth').addClass('dnone');
		$('#sixth').removeClass('dnone');
		$('#seventh').removeClass('dnone');
        $('#eighth').removeClass('dnone');
	})
	
	
	/**
	 * Set search fields
	 */
	if($('#search_first').length > 0) {
		
		var search_values_selected_first = new Array();
		var empty_first = false;
		var search = false;
		
		var search_values_first = new Array();
		search_values_first['location_number_first'] = 'Standortnummer';
		search_values_first['location_plz_first'] = 'Standort Postleitzahl';
		search_values_first['location_city_first'] = 'Standort Ort';
		search_values_first['location_address_first'] = 'Standort Adresse';
		search_values_first['location_job_type_first'] = 'Standort Stellenart';
		
		/**
		 * Renew the select field
		 */
		function renewSelect() {
			$('#set-search-first').find('option').remove();
			for(var key in search_values_first) {
				if($.inArray(key, search_values_selected_first) < 0) {
					$('#set-search-first').append($('<option></option>').val(key).text(search_values_first[key]));
				}
			}
			
			/**
			 * Set no search values available
			 */
			if($('#set-search-first').find('option').length == 0) {
				empty_first = true;
				$('#set-search-first').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
			} else {
				empty_first = false;
			}
			
			if(search_values_selected_first.length > 0) {
				$('#search-now-first').css('display', 'block');				
			} else {
				$('#search-now-first').css('display', 'none');
			}
		}
		
		/**
		 * Plus button
		 */
		var button = '';
		button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
		button = $(button);
		
		button.bind('click', function() {
			if(!empty_first) {
				var template = '';
				
				if($('#set-search-first').val() == 'status_first') {
					ajaxRequest('getStatusAll').success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-first').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-first').val()+'" name="'+$('#set-search-first').val()+'">';
						
						for(var group in response) {
							template += '    <optgroup label="'+group+'">';
							for(var status in response[group]) {
								template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
							}
							template += '    </optgroup>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_first.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_first), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_first .last'));
						
						search_values_selected_first.push($('#set-search-first').val());
						
						renewSelect();
					});
				} else if ($('#set-search-first').val() == 'acquisiteur') {
					
					var params = new Array();
					params['ids'] = new Array('3', '8');
					
					ajaxRequest('getUsersByRoleId', params).success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-first').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-first').val()+'" name="'+$('#set-search-first').val()+'">';
						
						for(var user in response) {
							template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_first.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_first), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_first .last'));
						
						search_values_selected_first.push($('#set-search-first').val());
						
						renewSelect();
					});
				} else if ($('#set-search-first').val() === 'location_job_type_first') {
					template += '<div class="fl" id="location_job_type_first_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_first" name="location_job_type_first">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_first.splice($.inArray('location_job_type_first', search_values_selected_first), 1);
						renewSelect();
					});

					template.insertBefore($('#search_first .last'));
					search_values_selected_first.push('location_job_type_first');
					renewSelect();
				} else {
					template += '<div class="fl" id="'+$('#set-search-first').val()+'_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-first').val()+'" type="text" name="'+$('#set-search-first').val()+'" placeholder="'+$('#set-search-first option:selected').text()+'"></div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('input').bind('focus', function() {
						$(document).keypress(function(e) {
							if(e.keyCode == 13) {
								$('#search-now-first').click();
							}
						})
					})

					template.find('input').bind('blur', function() {
						$(document).unbind("keypress");
					})

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_first.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_first), 1 );
						renewSelect();
					})

					template.insertBefore($('#search_first .last'));

					search_values_selected_first.push($('#set-search-first').val());

					renewSelect();
				}
			}
		});
		
		$('#search_first').append(button);
		
		
		/**
		 * Search button
		 */
		var search_button = '';
		search_button += '<div class="button fr" id="search-now-first" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
		search_button = $(search_button);
		
		search_button.bind('click', function() {
			getFirstAcquisitions();
		})
		
		$('#search_first').append(search_button);
		
		var a = '';
		a += '<select class="fl" id="set-search-first" style="margin-left:15px;">';
		for(var key in search_values_first) {
			a += '  <option value="'+key+'">'+search_values_first[key]+'</option>';
		}
		a += '</select>';
		a += '<div class="cb"></div>';
		
		a = $(a);
		
		$('#search_first').append(a);
		
		$('#search_first').append('<div class="last cb"></div>');
		
	}
	
	
	
	/**
	 * Set search fields
	 */
	if($('#search_second').length > 0) {
		
		var search_values_selected_second = new Array();
		var empty_second = false;
		var search = false;
		
		var search_values_second = new Array();
		search_values_second['location_number_second'] = 'Standortnummer';
		search_values_second['location_plz_second'] = 'Standort Postleitzahl';
		search_values_second['location_city_second'] = 'Standort Ort';
		search_values_second['location_address_second'] = 'Standort Adresse';
		search_values_second['location_address_second'] = 'Standort Adresse';
		search_values_second['location_job_type_second'] = 'Standort Stellenart';
		
		/**
		 * Renew the select field
		 */
		function renewSelect() {
			$('#set-search-second').find('option').remove();
			for(var key in search_values_second) {
				if($.inArray(key, search_values_selected_second) < 0) {
					$('#set-search-second').append($('<option></option>').val(key).text(search_values_second[key]));
				}
			}
			
			/**
			 * Set no search values available
			 */
			if($('#set-search-second').find('option').length == 0) {
				empty_second = true;
				$('#set-search-second').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
			} else {
				empty_second = false;
			}
			
			if(search_values_selected_second.length > 0) {
				$('#search-now-second').css('display', 'block');				
			} else {
				$('#search-now-second').css('display', 'none');
			}
		}
		
		/**
		 * Plus button
		 */
		var button = '';
		button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
		button = $(button);
		
		button.bind('click', function() {
			if(!empty_second) {
				var template = '';
				
				if($('#set-search-second').val() == 'status_second') {
					ajaxRequest('getStatusAll').success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-second').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-second').val()+'" name="'+$('#set-search-second').val()+'">';
						
						for(var group in response) {
							template += '    <optgroup label="'+group+'">';
							for(var status in response[group]) {
								template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
							}
							template += '    </optgroup>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_second.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_second), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_second .last'));
						
						search_values_selected_second.push($('#set-search-second').val());
						
						renewSelect();
					});
				} else if ($('#set-search-second').val() == 'acquisiteur') {
					var params = new Array();
					params['ids'] = new Array('3', '8');
					
					ajaxRequest('getUsersByRoleId', params).success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-second').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-second').val()+'" name="'+$('#set-search-second').val()+'">';
						
						for(var user in response) {
							template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_second.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_second), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_second .last'));
						
						search_values_selected_second.push($('#set-search-second').val());
						
						renewSelect();
					});
				} else if ($('#set-search-second').val() === 'location_job_type_second') {
					template += '<div class="fl" id="location_job_type_second_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_second" name="location_job_type_second">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_second.splice($.inArray('location_job_type_second', search_values_selected_second), 1);
						renewSelect();
					});

					template.insertBefore($('#search_second .last'));
					search_values_selected_second.push('location_job_type_second');
					renewSelect();
				} else {
					
					template += '<div class="fl" id="'+$('#set-search-second').val()+'_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-second').val()+'" type="text" name="'+$('#set-search-second').val()+'" placeholder="'+$('#set-search-second option:selected').text()+'"></div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);
					
					template.find('input').bind('focus', function() {
						$(document).keypress(function(e) {
							if(e.keyCode == 13) {
								$('#search-now-second').click();
							}
						})
					})
					
					template.find('input').bind('blur', function() {
						$(document).unbind("keypress");
					})
					
					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_second.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_second), 1 );
						renewSelect();
					})
					
					template.insertBefore($('#search_second .last'));
					
					search_values_selected_second.push($('#set-search-second').val());
					
					renewSelect();
				}
			}
		});
		
		$('#search_second').append(button);
		
		
		/**
		 * Search button
		 */
		var search_button = '';
		search_button += '<div class="button fr" id="search-now-second" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
		search_button = $(search_button);
		
		search_button.bind('click', function() {
			getSecondAcquisitions();
		})
		
		$('#search_second').append(search_button);
		
		var a = '';
		a += '<select class="fl" id="set-search-second" style="margin-left:15px;">';
		for(var key in search_values_second) {
			a += '  <option value="'+key+'">'+search_values_second[key]+'</option>';
		}
		a += '</select>';
		a += '<div class="cb"></div>';
		
		a = $(a);
		
		$('#search_second').append(a);
		
		$('#search_second').append('<div class="last cb"></div>');
		
	}
	
	/**
	 * Set search fields
	 */
	if($('#search_third').length > 0) {
		
		var search_values_selected_third = new Array();
		var empty_third = false;
		var search = false;
		
		var search_values_third = new Array();
		search_values_third['location_number_third'] = 'Standortnummer';
		search_values_third['location_plz_third'] = 'Standort Postleitzahl';
		search_values_third['location_city_third'] = 'Standort Ort';
		search_values_third['location_address_third'] = 'Standort Adresse';
		search_values_third['location_job_type_third'] = 'Standort Stellenart';
		
		/**
		 * Renew the select field
		 */
		function renewSelect() {
			$('#set-search-third').find('option').remove();
			for(var key in search_values_third) {
				if($.inArray(key, search_values_selected_third) < 0) {
					$('#set-search-third').append($('<option></option>').val(key).text(search_values_third[key]));
				}
			}
			
			/**
			 * Set no search values available
			 */
			if($('#set-search-third').find('option').length == 0) {
				empty_third = true;
				$('#set-search-third').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
			} else {
				empty_third = false;
			}
			
			if(search_values_selected_third.length > 0) {
				$('#search-now-third').css('display', 'block');				
			} else {
				$('#search-now-third').css('display', 'none');
			}
		}
		
		/**
		 * Plus button
		 */
		var button = '';
		button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
		button = $(button);
		
		button.bind('click', function() {
			if(!empty_third) {
				var template = '';
				
				if($('#set-search-third').val() == 'status_third') {
					ajaxRequest('getStatusAll').success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-third').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-third').val()+'" name="'+$('#set-search-third').val()+'">';
						
						for(var group in response) {
							template += '    <optgroup label="'+group+'">';
							for(var status in response[group]) {
								template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
							}
							template += '    </optgroup>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_third.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_third), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_third .last'));
						
						search_values_selected_third.push($('#set-search-third').val());
						
						renewSelect();
					});
				}  else if ($('#set-search-third').val() == 'acquisiteur') {
					
					var params = new Array();
					params['ids'] = new Array('3', '8');
					
					ajaxRequest('getUsersByRoleId', params).success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-third').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-third').val()+'" name="'+$('#set-search-third').val()+'">';
						
						for(var user in response) {
							template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_third.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_third), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_third .last'));
						
						search_values_selected_third.push($('#set-search-third').val());
						
						renewSelect();
					});
				} else if ($('#set-search-third').val() === 'location_job_type_third') {
					template += '<div class="fl" id="location_job_type_third_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_third" name="location_job_type_third">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_third.splice($.inArray('location_job_type_third', search_values_selected_third), 1);
						renewSelect();
					});

					template.insertBefore($('#search_third .last'));
					search_values_selected_third.push('location_job_type_third');
					renewSelect();
				} else {
					template += '<div class="fl" id="'+$('#set-search-third').val()+'_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-third').val()+'" type="text" name="'+$('#set-search-third').val()+'" placeholder="'+$('#set-search-third option:selected').text()+'"></div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);
					
					template.find('input').bind('focus', function() {
						$(document).keypress(function(e) {
							if(e.keyCode == 13) {
								$('#search-now-third').click();
							}
						})
					})
					
					template.find('input').bind('blur', function() {
						$(document).unbind("keypress");
					})
					
					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_third.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_third), 1 );
						renewSelect();
					})
					
					template.insertBefore($('#search_third .last'));
					
					search_values_selected_third.push($('#set-search-third').val());
					
					renewSelect();
				}
			}
		});
		
		$('#search_third').append(button);
		
		
		/**
		 * Search button
		 */
		var search_button = '';
		search_button += '<div class="button fr" id="search-now-third" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
		search_button = $(search_button);
		
		search_button.bind('click', function() {
			getThirdAcquisitions();
		})
		
		$('#search_third').append(search_button);
		
		var a = '';
		a += '<select class="fl" id="set-search-third" style="margin-left:15px;">';
		for(var key in search_values_third) {
			a += '  <option value="'+key+'">'+search_values_third[key]+'</option>';
		}
		a += '</select>';
		a += '<div class="cb"></div>';
		
		a = $(a);
		
		$('#search_third').append(a);
		
		$('#search_third').append('<div class="last cb"></div>');
	}
	
	/**
	 * Set search fields
	 */
	if($('#search_fourth').length > 0) {
		
		var search_values_selected_fourth = new Array();
		var empty_fourth = false;
		var search = false;
		
		var search_values_fourth = new Array();
		search_values_fourth['location_number_fourth'] = 'Standortnummer';
		search_values_fourth['location_plz_fourth'] = 'Standort Postleitzahl';
		search_values_fourth['location_city_fourth'] = 'Standort Ort';
		search_values_fourth['location_address_fourth'] = 'Standort Adresse';
		search_values_fourth['location_job_type_fourth'] = 'Standort Stellenart';
		
		/**
		 * Renew the select field
		 */
		function renewSelect() {
			$('#set-search-fourth').find('option').remove();
			for(var key in search_values_fourth) {
				if($.inArray(key, search_values_selected_fourth) < 0) {
					$('#set-search-fourth').append($('<option></option>').val(key).text(search_values_fourth[key]));
				}
			}
			
			/**
			 * Set no search values available
			 */
			if($('#set-search-fourth').find('option').length == 0) {
				empty_fourth = true;
				$('#set-search-fourth').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
			} else {
				empty_fourth = false;
			}
			
			if(search_values_selected_fourth.length > 0) {
				$('#search-now-fourth').css('display', 'block');				
			} else {
				$('#search-now-fourth').css('display', 'none');
			}
		}
		
		/**
		 * Plus button
		 */
		var button = '';
		button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
		button = $(button);
		
		button.bind('click', function() {
			if(!empty_fourth) {
				var template = '';
				
				if($('#set-search-fourth').val() == 'status_fourth') {
					ajaxRequest('getStatusAll').success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-fourth').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-fourth').val()+'" name="'+$('#set-search-fourth').val()+'">';
						
						for(var group in response) {
							template += '    <optgroup label="'+group+'">';
							for(var status in response[group]) {
								template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
							}
							template += '    </optgroup>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_fourth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_fourth), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_fourth .last'));
						
						search_values_selected_fourth.push($('#set-search-fourth').val());
						
						renewSelect();
					});
				}  else if ($('#set-search-fourth').val() == 'acquisiteur') {
					
					var params = new Array();
					params['ids'] = new Array('3', '8');
					
					ajaxRequest('getUsersByRoleId', params).success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-fourth').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-fourth').val()+'" name="'+$('#set-search-fourth').val()+'">';
						
						for(var user in response) {
							template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_fourth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_fourth), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_fourth .last'));
						
						search_values_selected_fourth.push($('#set-search-fourth').val());
						
						renewSelect();
					});
				} else if ($('#set-search-fourth').val() === 'location_job_type_fourth') {
					template += '<div class="fl" id="location_job_type_fourth_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_fourth" name="location_job_type_fourth">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_fourth.splice($.inArray('location_job_type_fourth', search_values_selected_fourth), 1);
						renewSelect();
					});

					template.insertBefore($('#search_fourth .last'));
					search_values_selected_fourth.push('location_job_type_fourth');
					renewSelect();
				} else {
					template += '<div class="fl" id="'+$('#set-search-fourth').val()+'_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-fourth').val()+'" type="text" name="'+$('#set-search-fourth').val()+'" placeholder="'+$('#set-search-fourth option:selected').text()+'"></div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);
					
					template.find('input').bind('focus', function() {
						$(document).keypress(function(e) {
							if(e.keyCode == 13) {
								$('#search-now-fourth').click();
							}
						})
					})
					
					template.find('input').bind('blur', function() {
						$(document).unbind("keypress");
					})
					
					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_fourth.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_fourth), 1 );
						renewSelect();
					})
					
					template.insertBefore($('#search_fourth .last'));
					
					search_values_selected_fourth.push($('#set-search-fourth').val());
					
					renewSelect();
				}
			}
		});
		
		$('#search_fourth').append(button);
		
		
		/**
		 * Search button
		 */
		var search_button = '';
		search_button += '<div class="button fr" id="search-now-fourth" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
		search_button = $(search_button);
		
		search_button.bind('click', function() {
			getFourthAcquisitions();
		})
		
		$('#search_fourth').append(search_button);
		
		var a = '';
		a += '<select class="fl" id="set-search-fourth" style="margin-left:15px;">';
		for(var key in search_values_fourth) {
			a += '  <option value="'+key+'">'+search_values_fourth[key]+'</option>';
		}
		a += '</select>';
		a += '<div class="cb"></div>';
		
		a = $(a);
		
		$('#search_fourth').append(a);
		
		$('#search_fourth').append('<div class="last cb"></div>');
		
	}
	
	
	/**
	 * Set search fields
	 */
	if($('#search_fifth').length > 0) {
		
		var search_values_selected_fifth = new Array();
		var empty_fifth = false;
		var search = false;
		
		var search_values_fifth = new Array();
		search_values_fifth['location_number_fifth'] = 'Standortnummer';
		search_values_fifth['location_plz_fifth'] = 'Standort Postleitzahl';
		search_values_fifth['location_city_fifth'] = 'Standort Ort';
		search_values_fifth['location_address_fifth'] = 'Standort Adresse';
		search_values_fifth['location_job_type_fifth'] = 'Standort Stellenart';
		
		/**
		 * Renew the select field
		 */
		function renewSelect() {
			$('#set-search-fifth').find('option').remove();
			for(var key in search_values_fifth) {
				if($.inArray(key, search_values_selected_fifth) < 0) {
					$('#set-search-fifth').append($('<option></option>').val(key).text(search_values_fifth[key]));
				}
			}
			
			/**
			 * Set no search values available
			 */
			if($('#set-search-fifth').find('option').length == 0) {
				empty_fifth = true;
				$('#set-search-fifth').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
			} else {
				empty_fifth = false;
			}
			
			if(search_values_selected_fifth.length > 0) {
				$('#search-now-fifth').css('display', 'block');				
			} else {
				$('#search-now-fifth').css('display', 'none');
			}
		}
		
		/**
		 * Plus button
		 */
		var button = '';
		button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
		button = $(button);
		
		button.bind('click', function() {
			if(!empty_fifth) {
				var template = '';
				
				if($('#set-search-fifth').val() == 'status_fifth') {
					ajaxRequest('getStatusAll').success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-fifth').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-fifth').val()+'" name="'+$('#set-search-fifth').val()+'">';
						
						for(var group in response) {
							template += '    <optgroup label="'+group+'">';
							for(var status in response[group]) {
								template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
							}
							template += '    </optgroup>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_fifth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_fifth), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_fifth .last'));
						
						search_values_selected_fifth.push($('#set-search-fifth').val());
						
						renewSelect();
					});
				}  else if ($('#set-search-fifth').val() == 'acquisiteur') {
					
					var params = new Array();
					params['ids'] = new Array('3', '8');
					
					ajaxRequest('getUsersByRoleId', params).success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-fifth').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-fifth').val()+'" name="'+$('#set-search-fifth').val()+'">';
						
						for(var user in response) {
							template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_fifth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_fifth), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_fifth .last'));
						
						search_values_selected_fifth.push($('#set-search-fifth').val());
						
						renewSelect();
					});
				} else if ($('#set-search-fifth').val() === 'location_job_type_fifth') {
					template += '<div class="fl" id="location_job_type_fifth_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_fifth" name="location_job_type_fifth">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_fifth.splice($.inArray('location_job_type_fifth', search_values_selected_fifth), 1);
						renewSelect();
					});

					template.insertBefore($('#search_fifth .last'));
					search_values_selected_fifth.push('location_job_type_fifth');
					renewSelect();
				} else {
					template += '<div class="fl" id="'+$('#set-search-fifth').val()+'_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-fifth').val()+'" type="text" name="'+$('#set-search-fifth').val()+'" placeholder="'+$('#set-search-fifth option:selected').text()+'"></div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);
					
					template.find('input').bind('focus', function() {
						$(document).keypress(function(e) {
							if(e.keyCode == 13) {
								$('#search-now-fifth').click();
							}
						})
					})
					
					template.find('input').bind('blur', function() {
						$(document).unbind("keypress");
					})
					
					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_fifth.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_fifth), 1 );
						renewSelect();
					})
					
					template.insertBefore($('#search_fifth .last'));
					
					search_values_selected_fifth.push($('#set-search-fifth').val());
					
					renewSelect();
				}
			}
		});
		
		$('#search_fifth').append(button);
		
		
		/**
		 * Search button
		 */
		var search_button = '';
		search_button += '<div class="button fr" id="search-now-fifth" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
		search_button = $(search_button);
		
		search_button.bind('click', function() {
			getFifthAcquisitions();
		})
		
		$('#search_fifth').append(search_button);
		
		var a = '';
		a += '<select class="fl" id="set-search-fifth" style="margin-left:15px;">';
		for(var key in search_values_fifth) {
			a += '  <option value="'+key+'">'+search_values_fifth[key]+'</option>';
		}
		a += '</select>';
		a += '<div class="cb"></div>';
		
		a = $(a);
		
		$('#search_fifth').append(a);
		
		$('#search_fifth').append('<div class="last cb"></div>');
		
	}
	
	/**
	 * Set search fields
	 */
	if($('#search_sixth').length > 0) {
		
		var search_values_selected_sixth = new Array();
		var empty_sixth = false;
		var search = false;
		
		var search_values_sixth = new Array();
		search_values_sixth['location_number_sixth'] = 'Standortnummer';
		search_values_sixth['location_plz_sixth'] = 'Standort Postleitzahl';
		search_values_sixth['location_city_sixth'] = 'Standort Ort';
		search_values_sixth['location_address_sixth'] = 'Standort Adresse';
		search_values_sixth['location_job_type_sixth'] = 'Standort Stellenart';
		
		/**
		 * Renew the select field
		 */
		function renewSelect() {
			$('#set-search-sixth').find('option').remove();
			for(var key in search_values_sixth) {
				if($.inArray(key, search_values_selected_sixth) < 0) {
					$('#set-search-sixth').append($('<option></option>').val(key).text(search_values_sixth[key]));
				}
			}
			
			/**
			 * Set no search values available
			 */
			if($('#set-search-sixth').find('option').length == 0) {
				empty_sixth = true;
				$('#set-search-sixth').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
			} else {
				empty_sixth = false;
			}
			
			if(search_values_selected_sixth.length > 0) {
				$('#search-now-sixth').css('display', 'block');				
			} else {
				$('#search-now-sixth').css('display', 'none');
			}
		}
		
		/**
		 * Plus button
		 */
		var button = '';
		button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
		button = $(button);
		
		button.bind('click', function() {
			if(!empty_sixth) {
				var template = '';
				
				if($('#set-search-sixth').val() == 'status_sixth') {
					ajaxRequest('getStatusAll').success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-sixth').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-sixth').val()+'" name="'+$('#set-search-sixth').val()+'">';
						
						for(var group in response) {
							template += '    <optgroup label="'+group+'">';
							for(var status in response[group]) {
								template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
							}
							template += '    </optgroup>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_sixth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_sixth), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_sixth .last'));
						
						search_values_selected_sixth.push($('#set-search-sixth').val());
						
						renewSelect();
					});
				}  else if ($('#set-search-sixth').val() == 'acquisiteur') {
					
					var params = new Array();
					params['ids'] = new Array('3', '8');
					
					ajaxRequest('getUsersByRoleId', params).success(function(response) {
						response = JSON.parse(response);
						
						template += '<div class="fl" id="'+$('#set-search-sixth').val()+'_holder" style="margin-right:25px;">';
						template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
						template += '  <div class="fl" style=" margin-top:10px;">';
						template += '  <select style="width:256px;" id="'+$('#set-search-sixth').val()+'" name="'+$('#set-search-sixth').val()+'">';
						
						for(var user in response) {
							template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
						}
						
						template += '  </select>';
						template += '  </div>';
						template += '  <div class="cb"></div>';
						template += '</div>';
						template = $(template);
						
						template.find('.remove').bind('click', function(e) {
							$('#'+$(e.currentTarget).parent().attr('id')).remove();
							search_values_selected_sixth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_sixth), 1 );
							renewSelect();
						})
						
						template.insertBefore($('#search_sixth .last'));
						
						search_values_selected_sixth.push($('#set-search-sixth').val());
						
						renewSelect();
					});
				} else if ($('#set-search-sixth').val() === 'location_job_type_sixth') {
					template += '<div class="fl" id="location_job_type_sixth_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_sixth" name="location_job_type_sixth">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_sixth.splice($.inArray('location_job_type_sixth', search_values_selected_sixth), 1);
						renewSelect();
					});

					template.insertBefore($('#search_sixth .last'));
					search_values_selected_sixth.push('location_job_type_sixth');
					renewSelect();
				} else {
					template += '<div class="fl" id="'+$('#set-search-sixth').val()+'_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-sixth').val()+'" type="text" name="'+$('#set-search-sixth').val()+'" placeholder="'+$('#set-search-sixth option:selected').text()+'"></div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);
					
					template.find('input').bind('focus', function() {
						$(document).keypress(function(e) {
							if(e.keyCode == 13) {
								$('#search-now-sixth').click();
							}
						})
					})
					
					template.find('input').bind('blur', function() {
						$(document).unbind("keypress");
					})
					
					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_sixth.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_sixth), 1 );
						renewSelect();
					})
					
					template.insertBefore($('#search_sixth .last'));
					
					search_values_selected_sixth.push($('#set-search-sixth').val());
					
					renewSelect();
				}
			}
		});
		
		$('#search_sixth').append(button);
		
		
		/**
		 * Search button
		 */
		var search_button = '';
		search_button += '<div class="button fr" id="search-now-sixth" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
		search_button = $(search_button);
		
		search_button.bind('click', function() {
			getSixthAcquisitions();
		})
		
		$('#search_sixth').append(search_button);
		
		var a = '';
		a += '<select class="fl" id="set-search-sixth" style="margin-left:15px;">';
		for(var key in search_values_sixth) {
			a += '  <option value="'+key+'">'+search_values_sixth[key]+'</option>';
		}
		a += '</select>';
		a += '<div class="cb"></div>';
		
		a = $(a);
		
		$('#search_sixth').append(a);
		
		$('#search_sixth').append('<div class="last cb"></div>');
		
	}

    /**
     * Set search fields
     */
    if($('#search_seventh').length > 0) {

        var search_values_selected_seventh = new Array();
        var empty_seventh = false;
        var search = false;

        var search_values_seventh = new Array();
        search_values_seventh['location_number_seventh'] = 'Standortnummer';
        search_values_seventh['location_plz_seventh'] = 'Standort Postleitzahl';
        search_values_seventh['location_city_seventh'] = 'Standort Ort';
        search_values_seventh['location_address_seventh'] = 'Standort Adresse';
		search_values_seventh['location_job_type_seventh'] = 'Standort Stellenart';

        /**
         * Renew the select field
         */
        function renewSelect() {
            $('#set-search-seventh').find('option').remove();
            for(var key in search_values_seventh) {
                if($.inArray(key, search_values_selected_seventh) < 0) {
                    $('#set-search-seventh').append($('<option></option>').val(key).text(search_values_seventh[key]));
                }
            }

            /**
             * Set no search values available
             */
            if($('#set-search-seventh').find('option').length == 0) {
                empty_seventh = true;
                $('#set-search-seventh').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
            } else {
                empty_seventh = false;
            }

            if(search_values_selected_seventh.length > 0) {
                $('#search-now-seventh').css('display', 'block');
            } else {
                $('#search-now-seventh').css('display', 'none');
            }
        }

        /**
         * Plus button
         */
        var button = '';
        button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
        button = $(button);

        button.bind('click', function() {
            if(!empty_seventh) {
                var template = '';

                if($('#set-search-seventh').val() == 'status_seventh') {
                    ajaxRequest('getStatusAll').success(function(response) {
                        response = JSON.parse(response);

                        template += '<div class="fl" id="'+$('#set-search-seventh').val()+'_holder" style="margin-right:25px;">';
                        template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
                        template += '  <div class="fl" style=" margin-top:10px;">';
                        template += '  <select style="width:256px;" id="'+$('#set-search-seventh').val()+'" name="'+$('#set-search-seventh').val()+'">';

                        for(var group in response) {
                            template += '    <optgroup label="'+group+'">';
                            for(var status in response[group]) {
                                template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
                            }
                            template += '    </optgroup>';
                        }

                        template += '  </select>';
                        template += '  </div>';
                        template += '  <div class="cb"></div>';
                        template += '</div>';
                        template = $(template);

                        template.find('.remove').bind('click', function(e) {
                            $('#'+$(e.currentTarget).parent().attr('id')).remove();
                            search_values_selected_seventh.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_seventh), 1 );
                            renewSelect();
                        })

                        template.insertBefore($('#search_seventh .last'));

                        search_values_selected_seventh.push($('#set-search-seventh').val());

                        renewSelect();
                    });
                }  else if ($('#set-search-seventh').val() == 'acquisiteur') {

                    var params = new Array();
                    params['ids'] = new Array('3', '8');

                    ajaxRequest('getUsersByRoleId', params).success(function(response) {
                        response = JSON.parse(response);

                        template += '<div class="fl" id="'+$('#set-search-seventh').val()+'_holder" style="margin-right:25px;">';
                        template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
                        template += '  <div class="fl" style=" margin-top:10px;">';
                        template += '  <select style="width:256px;" id="'+$('#set-search-seventh').val()+'" name="'+$('#set-search-seventh').val()+'">';

                        for(var user in response) {
                            template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
                        }

                        template += '  </select>';
                        template += '  </div>';
                        template += '  <div class="cb"></div>';
                        template += '</div>';
                        template = $(template);

                        template.find('.remove').bind('click', function(e) {
                            $('#'+$(e.currentTarget).parent().attr('id')).remove();
                            search_values_selected_seventh.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_seventh), 1 );
                            renewSelect();
                        })

                        template.insertBefore($('#search_seventh .last'));

                        search_values_selected_seventh.push($('#set-search-seventh').val());

                        renewSelect();
                    });
				} else if ($('#set-search-seventh').val() === 'location_job_type_seventh') {
					template += '<div class="fl" id="location_job_type_seventh_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_seventh" name="location_job_type_seventh">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_seventh.splice($.inArray('location_job_type_seventh', search_values_selected_seventh), 1);
						renewSelect();
					});

					template.insertBefore($('#search_seventh .last'));
					search_values_selected_seventh.push('location_job_type_seventh');
					renewSelect();
				} else {
                    template += '<div class="fl" id="'+$('#set-search-seventh').val()+'_holder" style="margin-right:25px;">';
                    template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
                    template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-seventh').val()+'" type="text" name="'+$('#set-search-seventh').val()+'" placeholder="'+$('#set-search-seventh option:selected').text()+'"></div>';
                    template += '  <div class="cb"></div>';
                    template += '</div>';
                    template = $(template);

                    template.find('input').bind('focus', function() {
                        $(document).keypress(function(e) {
                            if(e.keyCode == 13) {
                                $('#search-now-seventh').click();
                            }
                        })
                    })

                    template.find('input').bind('blur', function() {
                        $(document).unbind("keypress");
                    })

                    template.find('.remove').bind('click', function(e) {
                        $('#'+$(e.currentTarget).parent().attr('id')).remove();
                        search_values_selected_seventh.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_seventh), 1 );
                        renewSelect();
                    })

                    template.insertBefore($('#search_seventh .last'));

                    search_values_selected_seventh.push($('#set-search-seventh').val());

                    renewSelect();
                }
            }
        });

        $('#search_seventh').append(button);


        /**
         * Search button
         */
        var search_button = '';
        search_button += '<div class="button fr" id="search-now-seventh" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
        search_button = $(search_button);

        search_button.bind('click', function() {
            getSeventhAcquisitions();
        })

        $('#search_seventh').append(search_button);

        var a = '';
        a += '<select class="fl" id="set-search-seventh" style="margin-left:15px;">';
        for(var key in search_values_seventh) {
            a += '  <option value="'+key+'">'+search_values_seventh[key]+'</option>';
        }
        a += '</select>';
        a += '<div class="cb"></div>';

        a = $(a);

        $('#search_seventh').append(a);

        $('#search_seventh').append('<div class="last cb"></div>');

    }

    /**
     * Set search fields
     */
    if($('#search_eighth').length > 0) {

        var search_values_selected_eighth = new Array();
        var empty_eighth = false;
        var search = false;

        var search_values_eighth = new Array();
        search_values_eighth['location_number_eighth'] = 'Standortnummer';
        search_values_eighth['location_plz_eighth'] = 'Standort Postleitzahl';
        search_values_eighth['location_city_eighth'] = 'Standort Ort';
        search_values_eighth['location_address_eighth'] = 'Standort Adresse';
		search_values_eighth['location_job_type_eigth'] = 'Standort Stellenart';

        /**
         * Renew the select field
         */
        function renewSelect() {
            $('#set-search-eighth').find('option').remove();
            for(var key in search_values_eighth) {
                if($.inArray(key, search_values_selected_eighth) < 0) {
                    $('#set-search-eighth').append($('<option></option>').val(key).text(search_values_eighth[key]));
                }
            }

            /**
             * Set no search values available
             */
            if($('#set-search-eighth').find('option').length == 0) {
                empty_eighth = true;
                $('#set-search-eighth').append($('<option></option>').val('').text('Keine weiteren kriterien möglich'));
            } else {
                empty_eighth = false;
            }

            if(search_values_selected_eighth.length > 0) {
                $('#search-now-eighth').css('display', 'block');
            } else {
                $('#search-now-eighth').css('display', 'none');
            }
        }

        /**
         * Plus button
         */
        var button = '';
        button += '<div class="button fl" style="width:150px; padding:4px 10px;">Suchkriterium Hnzufügen</div>';
        button = $(button);

        button.bind('click', function() {
            if(!empty_eighth) {
                var template = '';

                if($('#set-search-eighth').val() == 'status_eighth') {
                    ajaxRequest('getStatusAll').success(function(response) {
                        response = JSON.parse(response);

                        template += '<div class="fl" id="'+$('#set-search-eighth').val()+'_holder" style="margin-right:25px;">';
                        template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
                        template += '  <div class="fl" style=" margin-top:10px;">';
                        template += '  <select style="width:256px;" id="'+$('#set-search-eighth').val()+'" name="'+$('#set-search-eighth').val()+'">';

                        for(var group in response) {
                            template += '    <optgroup label="'+group+'">';
                            for(var status in response[group]) {
                                template += '    <option value="'+response[group][status]['id']+'">'+response[group][status]['name']+'</option>';
                            }
                            template += '    </optgroup>';
                        }

                        template += '  </select>';
                        template += '  </div>';
                        template += '  <div class="cb"></div>';
                        template += '</div>';
                        template = $(template);

                        template.find('.remove').bind('click', function(e) {
                            $('#'+$(e.currentTarget).parent().attr('id')).remove();
                            search_values_selected_eighth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_eighth), 1 );
                            renewSelect();
                        })

                        template.insertBefore($('#search_eighth .last'));

                        search_values_selected_eighth.push($('#set-search-eighth').val());

                        renewSelect();
                    });
                }  else if ($('#set-search-eighth').val() == 'acquisiteur') {

                    var params = new Array();
                    params['ids'] = new Array('3', '8');

                    ajaxRequest('getUsersByRoleId', params).success(function(response) {
                        response = JSON.parse(response);

                        template += '<div class="fl" id="'+$('#set-search-eighth').val()+'_holder" style="margin-right:25px;">';
                        template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
                        template += '  <div class="fl" style=" margin-top:10px;">';
                        template += '  <select style="width:256px;" id="'+$('#set-search-eighth').val()+'" name="'+$('#set-search-eighth').val()+'">';

                        for(var user in response) {
                            template += '    <option value="'+response[user]['id']+'">'+response[user]['first_name']+' '+response[user]['last_name']+'</option>';
                        }

                        template += '  </select>';
                        template += '  </div>';
                        template += '  <div class="cb"></div>';
                        template += '</div>';
                        template = $(template);

                        template.find('.remove').bind('click', function(e) {
                            $('#'+$(e.currentTarget).parent().attr('id')).remove();
                            search_values_selected_eighth.splice( $.inArray($(e.currentTarget).parent().find('select').attr('id'), search_values_selected_eighth), 1 );
                            renewSelect();
                        })

                        template.insertBefore($('#search_eighth .last'));

                        search_values_selected_eighth.push($('#set-search-eighth').val());

                        renewSelect();
                    });
				} else if ($('#set-search-eighth').val() === 'location_job_type_eigth') {
					template += '<div class="fl" id="location_job_type_eigth_holder" style="margin-right:25px;">';
					template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
					template += '  <div class="fl" style="margin-top:10px;">';
					template += '    <select style="width:256px;" id="location_job_type_eigth" name="location_job_type_eigth">';
					jobTypes.forEach(jt => {
						template += `<option value="${jt.id}">${jt.name}</option>`;
					});
					template += '    </select>';
					template += '  </div>';
					template += '  <div class="cb"></div>';
					template += '</div>';
					template = $(template);

					template.find('.remove').bind('click', function(e) {
						$('#'+$(e.currentTarget).parent().attr('id')).remove();
						search_values_selected_eighth.splice($.inArray('location_job_type_eigth', search_values_selected_eighth), 1);
						renewSelect();
					});

					template.insertBefore($('#search_eighth .last'));
					search_values_selected_eighth.push('location_job_type_eigth');
					renewSelect();
				} else {
                    template += '<div class="fl" id="'+$('#set-search-eighth').val()+'_holder" style="margin-right:25px;">';
                    template += '  <div class="remove button fl" style="width:150px; padding:4px 10px; margin-right:15px; margin-top:10px;">Remove</div>';
                    template += '  <div class="fl" style=" margin-top:10px;"><input style="width:250px;" id="'+$('#set-search-eighth').val()+'" type="text" name="'+$('#set-search-eighth').val()+'" placeholder="'+$('#set-search-eighth option:selected').text()+'"></div>';
                    template += '  <div class="cb"></div>';
                    template += '</div>';
                    template = $(template);

                    template.find('input').bind('focus', function() {
                        $(document).keypress(function(e) {
                            if(e.keyCode == 13) {
                                $('#search-now-eighth').click();
                            }
                        })
                    })

                    template.find('input').bind('blur', function() {
                        $(document).unbind("keypress");
                    })

                    template.find('.remove').bind('click', function(e) {
                        $('#'+$(e.currentTarget).parent().attr('id')).remove();
                        search_values_selected_eighth.splice( $.inArray($(e.currentTarget).parent().find('input').attr('id'), search_values_selected_eighth), 1 );
                        renewSelect();
                    })

                    template.insertBefore($('#search_eighth .last'));

                    search_values_selected_eighth.push($('#set-search-eighth').val());

                    renewSelect();
                }
            }
        });

        $('#search_eighth').append(button);


        /**
         * Search button
         */
        var search_button = '';
        search_button += '<div class="button fr" id="search-now-eighth" style="width:150px; padding:4px 10px; display:none;">Suche</div>';
        search_button = $(search_button);

        search_button.bind('click', function() {
            getEighthAcquisitions();
        })

        $('#search_eighth').append(search_button);

        var a = '';
        a += '<select class="fl" id="set-search-eighth" style="margin-left:15px;">';
        for(var key in search_values_eighth) {
            a += '  <option value="'+key+'">'+search_values_eighth[key]+'</option>';
        }
        a += '</select>';
        a += '<div class="cb"></div>';

        a = $(a);

        $('#search_eighth').append(a);

        $('#search_eighth').append('<div class="last cb"></div>');

    }
	
	function setStatusCourse(id) {
		var params = new Array();
		params['acquisition_id'] = id;
		params['status_id'] = '52';
		
		ajaxRequest('setStatusCourse', params).success(function(response) {
			var response = JSON.parse(response);
			if(response[0]) {
				$('#acquisition_' + id).fadeOut(function() {
					$('#acquisition_' + id).remove();
				});
			}
		});
	}
	
	function displayCountFirst() {
		var until = (site_first * max_first) < count_first ? (site_first * max_first) : count_first;
		var data = (((site_first - 1) * max_first) + 1) + '-' + until + ' von ' + count_first;
		
		$('#first-pagination').html(data);
	}
	
	function displayCountSecond() {
		var until = (site_second * max_second) < count_second ? (site_second * max_second) : count_second;
		var data = (((site_second - 1) * max_second) + 1) + '-' + until + ' von ' + count_second;
		
		$('#second-pagination').html(data);
	}
	
	function displayCountThird() {
		var until = (site_third * max_third) < count_third ? (site_third * max_third) : count_third;
		var data = (((site_third - 1) * max_third) + 1) + '-' + until + ' von ' + count_third;
		
		$('#third-pagination').html(data);
	}

	function displayCountFourth() {
		var until = (site_fourth * max_fourth) < count_fourth ? (site_fourth * max_fourth) : count_fourth;
		var data = (((site_fourth - 1) * max_fourth) + 1) + '-' + until + ' von ' + count_fourth;
		
		$('#fourth-pagination').html(data);
	}
	
	function displayCountFifth() {
		var until = (site_fifth * max_fifth) < count_fifth ? (site_fifth * max_fifth) : count_fifth;
		var data = (((site_fifth - 1) * max_fifth) + 1) + '-' + until + ' von ' + count_fifth;
		
		$('#fifth-pagination').html(data);
	}
	
	function displayCountSixth() {
		var until = (site_sixth * max_sixth) < count_sixth ? (site_sixth * max_sixth) : count_sixth;
		var data = (((site_sixth - 1) * max_sixth) + 1) + '-' + until + ' von ' + count_sixth;
		
		$('#sixth-pagination').html(data);
	}

    function displayCountSeventh() {
        var until = (site_seventh * max_seventh) < count_seventh ? (site_seventh * max_seventh) : count_seventh;
        var data = (((site_seventh - 1) * max_seventh) + 1) + '-' + until + ' von ' + count_seventh;

        $('#seventh-pagination').html(data);
    }

    function displayCountEighth() {
        var until = (site_eighth * max_eighth) < count_eighth ? (site_eighth * max_eighth) : count_eighth;
        var data = (((site_eighth - 1) * max_eighth) + 1) + '-' + until + ' von ' + count_eighth;

        $('#eighth-pagination').html(data);
    }
    
	$('.table-sort-first').each(function() {
		
		/**
		 * Table head click
		 * Change sort if same order
		 */
		$(this).bind('click', function(e) {
			
			$('.triangle-down').each(function() {
				$(this).hide();
			});
			
			$('.triangle-up').each(function() {
				$(this).hide();
			})
			
			if($(e.currentTarget).attr('data') == order_first) {
				sort_first == 'desc' ? sort_first = 'asc' : sort_first = 'desc';
			} else {
				sort_first == 'desc';				
			}
			
			order_first = $(e.currentTarget).attr('data');
			
			if($(this).attr('data') == order_first) {
				if(sort_first == 'desc') {
					$(this).find('.triangle-down').show();
					$(this).find('.triangle-up').hide();
				} else {
					$(this).find('.triangle-down').hide();
					$(this).find('.triangle-up').show();
				}
			}
			
			getFirstAcquisitions();
		})
		
		$(this).find('.triangle-down').hide();
		$(this).find('.triangle-up').hide();
		
		if($(this).attr('data') == order_first) {
			sort_first == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
		}
		
	})
	
	$('.table-sort-second').each(function() {
		
		/**
		 * Table head click
		 * Change sort if same order
		 */
		$(this).bind('click', function(e) {
			
			$('.triangle-down').each(function() {
				$(this).hide();
			});
			
			$('.triangle-up').each(function() {
				$(this).hide();
			})
			
			if($(e.currentTarget).attr('data') == order_second) {
				sort_second == 'desc' ? sort_second = 'asc' : sort_second = 'desc';
			} else {
				sort_second == 'desc';				
			}
			
			order_second = $(e.currentTarget).attr('data');
			
			if($(this).attr('data') == order_second) {
				if(sort_second == 'desc') {
					$(this).find('.triangle-down').show();
					$(this).find('.triangle-up').hide();
				} else {
					$(this).find('.triangle-down').hide();
					$(this).find('.triangle-up').show();
				}
			}
			
			getSecondAcquisitions();
		})
		
		$(this).find('.triangle-down').hide();
		$(this).find('.triangle-up').hide();
		
		if($(this).attr('data') == order_second) {
			sort_second == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
		}
		
	})
	
	$('.table-sort-third').each(function() {
		
		/**
		 * Table head click
		 * Change sort if same order
		 */
		$(this).bind('click', function(e) {
			
			$('.triangle-down').each(function() {
				$(this).hide();
			});
			
			$('.triangle-up').each(function() {
				$(this).hide();
			})
			
			if($(e.currentTarget).attr('data') == order_third) {
				sort_third == 'desc' ? sort_third = 'asc' : sort_third = 'desc';
			} else {
				sort_third == 'desc';				
			}
			
			order_third = $(e.currentTarget).attr('data');
			
			if($(this).attr('data') == order_third) {
				if(sort_third == 'desc') {
					$(this).find('.triangle-down').show();
					$(this).find('.triangle-up').hide();
				} else {
					$(this).find('.triangle-down').hide();
					$(this).find('.triangle-up').show();
				}
			}
			
			getThirdAcquisitions();
		})
		
		$(this).find('.triangle-down').hide();
		$(this).find('.triangle-up').hide();
		
		if($(this).attr('data') == order_third) {
			sort_third == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
		}
		
	})
	
	$('.table-sort-fourth').each(function() {
		
		/**
		 * Table head click
		 * Change sort if same order
		 */
		$(this).bind('click', function(e) {
			
			$('.triangle-down').each(function() {
				$(this).hide();
			});
			
			$('.triangle-up').each(function() {
				$(this).hide();
			})
			
			if($(e.currentTarget).attr('data') == order_fourth) {
				sort_fourth == 'desc' ? sort_fourth = 'asc' : sort_fourth = 'desc';
			} else {
				sort_fourth == 'desc';				
			}
			
			order_fourth = $(e.currentTarget).attr('data');
			
			if($(this).attr('data') == order_fourth) {
				if(sort_fourth == 'desc') {
					$(this).find('.triangle-down').show();
					$(this).find('.triangle-up').hide();
				} else {
					$(this).find('.triangle-down').hide();
					$(this).find('.triangle-up').show();
				}
			}
			
			getFourthAcquisitions();
		})
		
		$(this).find('.triangle-down').hide();
		$(this).find('.triangle-up').hide();
		
		if($(this).attr('data') == order_fourth) {
			sort_fourth == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
		}
		
	})
	
	$('.table-sort-fifth').each(function() {
		
		/**
		 * Table head click
		 * Change sort if same order
		 */
		$(this).bind('click', function(e) {
			
			$('.triangle-down').each(function() {
				$(this).hide();
			});
			
			$('.triangle-up').each(function() {
				$(this).hide();
			})
			
			if($(e.currentTarget).attr('data') == order_fifth) {
				sort_fifth == 'desc' ? sort_fifth = 'asc' : sort_fifth = 'desc';
			} else {
				sort_fifth == 'desc';				
			}
			
			order_fifth = $(e.currentTarget).attr('data');
			
			if($(this).attr('data') == order_fifth) {
				if(sort_fifth == 'desc') {
					$(this).find('.triangle-down').show();
					$(this).find('.triangle-up').hide();
				} else {
					$(this).find('.triangle-down').hide();
					$(this).find('.triangle-up').show();
				}
			}
			
			getFifthAcquisitions();
		})
		
		$(this).find('.triangle-down').hide();
		$(this).find('.triangle-up').hide();
		
		if($(this).attr('data') == order_fifth) {
			sort_fifth == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
		}
		
	})
	
	$('.table-sort-sixth').each(function() {
		
		/**
		 * Table head click
		 * Change sort if same order
		 */
		$(this).bind('click', function(e) {
			
			$('.triangle-down').each(function() {
				$(this).hide();
			});
			
			$('.triangle-up').each(function() {
				$(this).hide();
			})
			
			if($(e.currentTarget).attr('data') == order_sixth) {
				sort_sixth == 'desc' ? sort_sixth = 'asc' : sort_sixth = 'desc';
			} else {
				sort_sixth == 'desc';				
			}
			
			order_sixth = $(e.currentTarget).attr('data');
			
			if($(this).attr('data') == order_sixth) {
				if(sort_sixth == 'desc') {
					$(this).find('.triangle-down').show();
					$(this).find('.triangle-up').hide();
				} else {
					$(this).find('.triangle-down').hide();
					$(this).find('.triangle-up').show();
				}
			}
			
			getSixthAcquisitions();
		})
		
		$(this).find('.triangle-down').hide();
		$(this).find('.triangle-up').hide();
		
		if($(this).attr('data') == order_sixth) {
			sort_sixth == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
		}
		
	})

    $('.table-sort-seventh').each(function() {

        /**
         * Table head click
         * Change sort if same order
         */
        $(this).bind('click', function(e) {

            $('.triangle-down').each(function() {
                $(this).hide();
            });

            $('.triangle-up').each(function() {
                $(this).hide();
            })

            if($(e.currentTarget).attr('data') == order_seventh) {
                sort_seventh == 'desc' ? sort_seventh = 'asc' : sort_seventh = 'desc';
            } else {
                sort_seventh == 'desc';
            }

            order_seventh = $(e.currentTarget).attr('data');

            if($(this).attr('data') == order_seventh) {
                if(sort_seventh == 'desc') {
                    $(this).find('.triangle-down').show();
                    $(this).find('.triangle-up').hide();
                } else {
                    $(this).find('.triangle-down').hide();
                    $(this).find('.triangle-up').show();
                }
            }

            getSeventhAcquisitions();
        })

        $(this).find('.triangle-down').hide();
        $(this).find('.triangle-up').hide();

        if($(this).attr('data') == order_seventh) {
            sort_seventh == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
        }

    })

    $('.table-sort-eighth').each(function() {

        /**
         * Table head click
         * Change sort if same order
         */
        $(this).bind('click', function(e) {

            $('.triangle-down').each(function() {
                $(this).hide();
            });

            $('.triangle-up').each(function() {
                $(this).hide();
            })

            if($(e.currentTarget).attr('data') == order_eighth) {
                sort_eighth == 'desc' ? sort_eighth = 'asc' : sort_eighth = 'desc';
            } else {
                sort_eighth == 'desc';
            }

            order_eighth = $(e.currentTarget).attr('data');

            if($(this).attr('data') == order_eighth) {
                if(sort_eighth == 'desc') {
                    $(this).find('.triangle-down').show();
                    $(this).find('.triangle-up').hide();
                } else {
                    $(this).find('.triangle-down').hide();
                    $(this).find('.triangle-up').show();
                }
            }
            getEighthAcquisitions()
        })

        $(this).find('.triangle-down').hide();
        $(this).find('.triangle-up').hide();

        if($(this).attr('data') == order_eighth) {
            sort_eighth == 'desc' ? $(this).find('.triangle-down').show() : $(this).find('.triangle-up').show();
        }

    })
	
	function getFirstAcquisitions() {
		
		$('#active_acquisitions').find('tbody').find('tr').each(function() {
			$(this).remove();
		});
		
		if(interval_first.length > 0) {
			for(var int in interval_first) {
				clearInterval(interval_first[int]);
			}
		}
		
		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		if($('#status').val()) {
			params.filter.status = $('#status').val();
		}
		
		if(partner_id != '' && partner_id.length > 0) {
			params.filter.partner_id = partner_id;
		}
		
		params.filter.list = 'dashboard_partner_offer_active';
		params.filter.acquisition_id = $('#location_number_first').val();
		params.filter.acquisition_zip_code = $('#location_plz_first').val();
		params.filter.acquisition_city = $('#location_city_first').val();
		params.filter.acquisition_address = $('#location_address_first').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_first').val();
		params.filter.partner_offer = true;
		
		if($('#user_select').length > 0) {
			params.filter.partner_id = $('#user_select').val();
		}
		
		params.order.site = site_first;
		params.order.max = max_first;
		params.order.order = order_first;
		params.order.sort = sort_first;
		
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
			
			$('.spinner').css('display', 'block');
			
			response = JSON.parse(response);
			var offer = response.data;
			count_first = response.count;
			displayCountFirst();
			
			var table = $('#active_acquisitions');
			table.find('tbody').html('');
			
			var data = new Array();
			
			for(var o in offer) {
				
				var tr = '';
				tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_id;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
				tr += '  </td>';
				
				var odate = offer[o].partner_offer_datetime;
				odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)
				
				tr += '  <td>';
				tr += '    ' + odate;
				tr += '  </td>';
				
				if(offer[o].rest_time) {
					tr += '  <td class="time">';
					tr += '    ' + String(offer[o].rest_time).toHHMMSS();
					tr += '  </td>';
				} else {
					tr += '  <td>';
					tr += '    -';
					tr += '  </td>';
				}
				
				if(offer[o].partner_offer_accepted == 0) {
					if(offer[o].partner_offer_offer == 1) {
						tr += '  <td class="not">';
						tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
						tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
						tr += '    <div class="cb"></div>';
						tr += '  </td>';
					} else {
						tr += '  <td>';
						tr += '    Nur zur Ansicht';
						tr += '  </td>';
					}
				} else if(offer[o].partner_offer_accepted == 1) {
					tr += '  <td>';
					tr += '    Standort akzeptiert';
					tr += '  </td>';
				} else if(offer[o].partner_offer_accepted == 2) {
					tr += '  <td>';
					tr += '    Standort abgelehnt';
					tr += '  </td>';
				}
				
				tr += '  <td class="not">';
				if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
					tr += '    <div class="icon-info">';
					tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
					tr += '      <div class="info-holder dnone">';
					tr += '        <div class="info-arrow-top"</div>';
					tr += '        <div class="info-holder-inner">';
					tr += '          ' + offer[o].partner_offer_comment;
					tr += '        </div>';
					tr += '      </div>';
					tr += '    </div>';
				}
				tr += '  </td>';
				
				tr += '</tr>';
				
				
				tr += '<tr>';
				
				
				tr += '    </div>';
				tr += '  </td>';
				tr += '</tr>';
				
				tr = $(tr);
				
				tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('acceptOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('rejectOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('td').not('.not').each(function() {
					$(this).bind('click', {'instance':offer[o]}, function(e) {
	                    single(e.data.instance.acquisition_id);
					});
				});
				
				data.push(tr);
			}
			
			$('.spinner').fadeOut('slow');
			
			for(var row in data) {
				table.find('tbody').append(data[row]);
			}
			
			table.find('.icon-info').each(function() {
				$(this).bind('click', function(e) {
					if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
						$(e.currentTarget).find('.info-holder').removeClass('dnone');
					} else {
						$(e.currentTarget).find('.info-holder').addClass('dnone');
					}
				})
			})
			
			interval_first.push(setInterval(function() {
				table.find('.time').each(function() {
					var time = $(this).html();
					var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
					var seconds = seconds - 1;
					
					$(this).html(String(seconds).toHHMMSS());
				})
			}, 1000));
			
		})
	}
	
	
	function getSecondAcquisitions() {
		
		$('#inactive_acquisitions').find('tbody').find('tr').each(function() {
			$(this).remove();
		});
		
		if(interval_second.length > 0) {
			for(var int in interval_second) {
				clearInterval(interval_second[int]);
			}
		}
		
		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		if($('#status').val()) {
			params.filter.status = $('#status').val();
		}
		
		if(partner_id != '' && partner_id.length > 0) {
			params.filter.partner_id = partner_id;
		}
		
		params.filter.list = 'dashboard_partner_offer_inactive';
		params.filter.acquisition_id = $('#location_number_second').val();
		params.filter.acquisition_zip_code = $('#location_plz_second').val();
		params.filter.acquisition_city = $('#location_city_second').val();
		params.filter.acquisition_address = $('#location_address_second').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_second').val();
		params.filter.partner_offer = true;
		
		if($('#user_select').length > 0) {
			params.filter.partner_id = $('#user_select').val();
		}
		
		params.order.site = site_second;
		params.order.max = max_second;
		params.order.order = order_second;
		params.order.sort = sort_second;
		
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
			
			$('.spinner').css('display', 'block');
			
			response = JSON.parse(response);
			var offer = response.data;
			count_second = response.count;
			displayCountSecond();
			
			var table = $('#inactive_acquisitions');
			table.find('tbody').html('');
			
			var data = new Array();
			
			for(var o in offer) {
				
				var tr = '';
				tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_id;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
				tr += '  </td>';
				
				var odate = offer[o].partner_offer_datetime;
				odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)
				
				tr += '  <td>';
				tr += '    ' + odate;
				tr += '  </td>';
				
				if(offer[o].rest_time) {
					tr += '  <td class="time">';
					tr += '    ' + String(offer[o].rest_time).toHHMMSS();
					tr += '  </td>';
				} else {
					tr += '  <td>';
					tr += '    -';
					tr += '  </td>';
				}
				
				if(offer[o].partner_offer_accepted == 0) {
					if(offer[o].partner_offer_offer == 1) {
						tr += '  <td class="not">';
						tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
						tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
						tr += '    <div class="cb"></div>';
						tr += '  </td>';
					} else {
						tr += '  <td>';
						tr += '    Nur zur Ansicht';
						tr += '  </td>';
					}
				} else if(offer[o].partner_offer_accepted == 1) {
					tr += '  <td>';
					tr += '    Standort akzeptiert';
					tr += '  </td>';
				} else if(offer[o].partner_offer_accepted == 2) {
					tr += '  <td>';
					tr += '    Standort abgelehnt';
					tr += '  </td>';
				}
				
				tr += '  <td class="not">';
				if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
					tr += '    <div class="icon-info">';
					tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
					tr += '      <div class="info-holder dnone">';
					tr += '        <div class="info-arrow-top"</div>';
					tr += '        <div class="info-holder-inner">';
					tr += '          ' + offer[o].partner_offer_comment;
					tr += '        </div>';
					tr += '      </div>';
					tr += '    </div>';
				}
				tr += '  </td>';
				
				tr += '</tr>';
				
				
				tr += '<tr>';
				
				
				tr += '    </div>';
				tr += '  </td>';
				tr += '</tr>';
				
				tr = $(tr);
				
				tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('acceptOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('rejectOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('td').not('.not').each(function() {
					$(this).bind('click', {'instance':offer[o]}, function(e) {
	                    single(e.data.instance.acquisition_id);
					});
				});
				
				data.push(tr);
			}
			
			$('.spinner').fadeOut('slow');
			
			for(var row in data) {
				table.find('tbody').append(data[row]);
			}
			
			table.find('.icon-info').each(function() {
				$(this).bind('click', function(e) {
					if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
						$(e.currentTarget).find('.info-holder').removeClass('dnone');
					} else {
						$(e.currentTarget).find('.info-holder').addClass('dnone');
					}
				})
			})
			
			interval_second.push(setInterval(function() {
				table.find('.time').each(function() {
					var time = $(this).html();
					var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
					var seconds = seconds - 1;
					
					$(this).html(String(seconds).toHHMMSS());
				})
			}, 1000));
			
		})
	}
	
	
	function getThirdAcquisitions() {
		
		$('#in_progress_acquisitions').find('tbody').find('tr').each(function() {
			$(this).remove();
		});
		
		if(interval_third.length > 0) {
			for(var int in interval_third) {
				clearInterval(interval_third[int]);
			}
		}

		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		if($('#status').val()) {
			params.filter.status = $('#status').val();
		}
		
		if(partner_id != '' && partner_id.length > 0) {
			params.filter.partner_id = partner_id;
		}
		
		params.filter.list = 'dashboard_partner_offer_in_progress';
		params.filter.acquisition_id = $('#location_number_third').val();
		params.filter.acquisition_zip_code = $('#location_plz_third').val();
		params.filter.acquisition_city = $('#location_city_third').val();
		params.filter.acquisition_address = $('#location_address_third').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_third').val();
		params.filter.partner_offer = true;

		if($('#user_select').length > 0) {
			params.filter.partner_id = $('#user_select').val();
		}
		
		params.order.site = site_third;
		params.order.max = max_third;
		params.order.order = order_third;
		params.order.sort = sort_third;
		
		params.fields = new Array('acquisition_id',
								  'acquisition_zip_code',
								  'acquisition_city',
								  'acquisition_address',
								  'acquisition_frequency',
								  'acquisition_okz',
								  'acquisition_job_type_name',
								  'acquisition_quantity',
								  'acquisition_rent_offer',
								  'acquisition_contract_duration',
								  'manufacturer_name',
								  'partner_offer_datetime',
								  'partner_offer_visible',
								  'partner_offer_offer',
								  'partner_offer_accepted',
								  'partner_offer_comment');
		
		
		ajaxRequest('getAcquisitionsNew', params).success(function(response) {
			
			$('.spinner').css('display', 'block');
			
			response = JSON.parse(response);
			
			var offer = response.data;
			count_third = response.count;
			displayCountThird();
			
			var table = $('#in_progress_acquisitions');
			table.find('tbody').html('');
			
			var data = new Array();
			
			for(var o in offer) {
				
				var tr = '';
				tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_id;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_okz;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
				tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_job_type_name;
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_quantity;
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_rent_offer;
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_contract_duration;
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + (offer[o].manufacturer_name != undefined ? offer[o].manufacturer_name : 'N/A');
                tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
				tr += '  </td>';
				
				var odate = offer[o].partner_offer_datetime;
				odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)
				
				tr += '  <td>';
				tr += '    ' + odate;
				tr += '  </td>';
				
				if(offer[o].rest_time) {
					tr += '  <td class="time noExl not">';
					tr += '    ' + String(offer[o].rest_time).toHHMMSS();
					tr += '  </td>';
				} else {
					tr += '  <td class="noExl not">';
					tr += '    -';
					tr += '  </td>';
				}
				
				if(offer[o].partner_offer_accepted == 0) {
					if(offer[o].partner_offer_offer == 1) {
						tr += '  <td class="noExl not">';
						tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
						tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
						tr += '    <div class="cb"></div>';
						tr += '  </td>';
					} else {
						tr += '  <td class="noExl not">';
						tr += '    Nur zur Ansicht';
						tr += '  </td>';
					}
				} else if(offer[o].partner_offer_accepted == 1) {
					tr += '  <td class="noExl">';
					tr += '    Standort akzeptiert';
					tr += '  </td>';
				} else if(offer[o].partner_offer_accepted == 2) {
					tr += '  <td class="noExl">';
					tr += '    Standort abgelehnt';
					tr += '  </td>';
				}
				
				tr += '  <td class="noExl not">';
				if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
					tr += '    <div class="icon-info">';
					tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
					tr += '      <div class="info-holder dnone">';
					tr += '        <div class="info-arrow-top"</div>';
					tr += '        <div class="info-holder-inner">';
					tr += '          ' + offer[o].partner_offer_comment;
					tr += '        </div>';
					tr += '      </div>';
					tr += '    </div>';
				}
				tr += '  </td>';
				
				tr += '</tr>';
				
				tr = $(tr);
				
				tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('acceptOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('rejectOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('td').not('.not').each(function() {
					$(this).bind('click', {'instance':offer[o]}, function(e) {
	                    single(e.data.instance.acquisition_id);
					});
				});
				
				data.push(tr);
			}
			
			$('.spinner').fadeOut('slow');
			
			for(var row in data) {
				table.find('tbody').append(data[row]);
			}
			
			table.find('.icon-info').each(function() {
				$(this).bind('click', function(e) {
					if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
						$(e.currentTarget).find('.info-holder').removeClass('dnone');
					} else {
						$(e.currentTarget).find('.info-holder').addClass('dnone');
					}
				})
			})
			
			interval_third.push(setInterval(function() {
				table.find('.time').each(function() {
					var time = $(this).html();
					var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
					var seconds = seconds - 1;
					
					$(this).html(String(seconds).toHHMMSS());
				})
			}, 1000));
		})
	}

    $("#export").click(function(){
        $("#in_progress_acquisitions").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Worksheet Name",
            filename: "Liste" //do not include extension
        });
    });
	
	function getFourthAcquisitions() {
		
		$('#contract_interest_acquisitions').find('tbody').find('tr').each(function() {
			$(this).remove();
		});
		
		if(interval_fourth.length > 0) {
			for(var int in interval_fourth) {
				clearInterval(interval_fourth[int]);
			}
		}
		
//		var params = new Array();
//		params['site'] = site_fourth;
//		params['max'] = max_fourth;
//		params['order'] = order_fourth;
//		params['sort'] = sort_fourth;
//		params['location_number'] = $('#location_number_fourth').val();
//		params['location_plz'] = $('#location_plz_fourth').val();
//		params['location_city'] = $('#location_city_fourth').val();
//		params['location_address'] = $('#location_address_fourth').val();
////		params['has_status_id'] = '16';
//		
//		if($('#user_select').length > 0) {
//			params['pid'] = $('#user_select').val();
//		}
//		
//		params['status'] = new Array('6', '13', '14', '15', '17', '30', '71', '74', '79');
		
		
		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		if($('#status').val()) {
			params.filter.status = $('#status').val();
		}
		
		if(partner_id != '' && partner_id.length > 0) {
			params.filter.partner_id = partner_id;
		}
		
		params.filter.list = 'dashboard_partner_offer_interested_parties';
		params.filter.acquisition_id = $('#location_number_fourth').val();
		params.filter.acquisition_zip_code = $('#location_plz_fourth').val();
		params.filter.acquisition_city = $('#location_city_fourth').val();
		params.filter.acquisition_address = $('#location_address_fourth').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_fourth').val();
		params.filter.partner_offer = true;
		
		if($('#user_select').length > 0) {
			params.filter.partner_id = $('#user_select').val();
		}
		
		params.order.site = site_fourth;
		params.order.max = max_fourth;
		params.order.order = order_fourth;
		params.order.sort = sort_fourth;
		
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
			
			$('.spinner').css('display', 'block');
			
			response = JSON.parse(response);
			var offer = response.data;
			count_fourth = response.count;
			displayCountFourth();
			
			var table = $('#contract_interest_acquisitions');
			table.find('tbody').html('');
			
			var data = new Array();
			
			for(var o in offer) {
				
				var tr = '';
				tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_id;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
				tr += '  </td>';
				
				var odate = offer[o].partner_offer_datetime;
				odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)
				
				tr += '  <td>';
				tr += '    ' + odate;
				tr += '  </td>';
				
				if(offer[o].rest_time) {
					tr += '  <td class="time">';
					tr += '    ' + String(offer[o].rest_time).toHHMMSS();
					tr += '  </td>';
				} else {
					tr += '  <td>';
					tr += '    -';
					tr += '  </td>';
				}
				
				if(offer[o].partner_offer_accepted == 0) {
					if(offer[o].partner_offer_offer == 1) {
						tr += '  <td class="not">';
						tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
						tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
						tr += '    <div class="cb"></div>';
						tr += '  </td>';
					} else {
						tr += '  <td>';
						tr += '    Nur zur Ansicht';
						tr += '  </td>';
					}
				} else if(offer[o].partner_offer_accepted == 1) {
					tr += '  <td>';
					tr += '    Standort akzeptiert';
					tr += '  </td>';
				} else if(offer[o].partner_offer_accepted == 2) {
					tr += '  <td>';
					tr += '    Standort abgelehnt';
					tr += '  </td>';
				}
				
				tr += '  <td class="not">';
				if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
					tr += '    <div class="icon-info">';
					tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
					tr += '      <div class="info-holder dnone">';
					tr += '        <div class="info-arrow-top"</div>';
					tr += '        <div class="info-holder-inner">';
					tr += '          ' + offer[o].partner_offer_comment;
					tr += '        </div>';
					tr += '      </div>';
					tr += '    </div>';
				}
				tr += '  </td>';
				
				tr += '</tr>';
				
				
				tr += '<tr>';
				
				
				tr += '    </div>';
				tr += '  </td>';
				tr += '</tr>';
				
				tr = $(tr);
				
				tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('acceptOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('rejectOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('td').not('.not').each(function() {
					$(this).bind('click', {'instance':offer[o]}, function(e) {
	                    single(e.data.instance.acquisition_id);
					});
				});
				
				data.push(tr);
			}
			
			$('.spinner').fadeOut('slow');
			
			for(var row in data) {
				table.find('tbody').append(data[row]);
			}
			
			table.find('.icon-info').each(function() {
				$(this).bind('click', function(e) {
					if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
						$(e.currentTarget).find('.info-holder').removeClass('dnone');
					} else {
						$(e.currentTarget).find('.info-holder').addClass('dnone');
					}
				})
			})
			
			interval_fourth.push(setInterval(function() {
				table.find('.time').each(function() {
					var time = $(this).html();
					var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
					var seconds = seconds - 1;
					
					$(this).html(String(seconds).toHHMMSS());
				})
			}, 1000));
		})
	}
	
	
	
	function getFifthAcquisitions() {
		
		$('#contract_canceled_acquisitions').find('tbody').find('tr').each(function() {
			$(this).remove();
		});
		
		if(interval_fifth.length > 0) {
			for(var int in interval_fifth) {
				clearInterval(interval_fifth[int]);
			}
		}
		
//		var params = new Array();
//		params['site'] = site_fifth;
//		params['max'] = max_fifth;
//		params['order'] = order_fifth;
//		params['sort'] = sort_fifth;
//		params['location_number'] = $('#location_number_fifth').val();
//		params['location_plz'] = $('#location_plz_fifth').val();
//		params['location_city'] = $('#location_city_fifth').val();
//		params['location_address'] = $('#location_address_fifth').val();
////		params['has_status_id'] = '16';
//		
//		if($('#user_select').length > 0) {
//			params['pid'] = $('#user_select').val();
//		}
//		
//		params['status'] = new Array('12');
		
		
		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		if($('#status').val()) {
			params.filter.status = $('#status').val();
		}
		
		if(partner_id != '' && partner_id.length > 0) {
			params.filter.partner_id = partner_id;
		}
		
		params.filter.list = 'dashboard_partner_offer_contract_cancel';
		params.filter.acquisition_id = $('#location_number_fifth').val();
		params.filter.acquisition_zip_code = $('#location_plz_fifth').val();
		params.filter.acquisition_city = $('#location_city_fifth').val();
		params.filter.acquisition_address = $('#location_address_fifth').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_fifth').val();
		params.filter.partner_offer = true;
		
		if($('#user_select').length > 0) {
			params.filter.partner_id = $('#user_select').val();
		}
		
		params.order.site = site_fifth;
		params.order.max = max_fifth;
		params.order.order = order_fifth;
		params.order.sort = sort_fifth;
		
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
			
			$('.spinner').css('display', 'block');
			
			response = JSON.parse(response);
			var offer = response.data;
			count_fifth = response.count;
			displayCountFifth();
			
			var table = $('#contract_canceled_acquisitions');
			table.find('tbody').html('');
			
			var data = new Array();
			
			for(var o in offer) {
				
				var tr = '';
				tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_id;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
				tr += '  </td>';
				
				var odate = offer[o].partner_offer_datetime;
				odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)
				
				tr += '  <td>';
				tr += '    ' + odate;
				tr += '  </td>';
				
				if(offer[o].rest_time) {
					tr += '  <td class="time">';
					tr += '    ' + String(offer[o].rest_time).toHHMMSS();
					tr += '  </td>';
				} else {
					tr += '  <td>';
					tr += '    -';
					tr += '  </td>';
				}
				
				if(offer[o].partner_offer_accepted == 0) {
					if(offer[o].partner_offer_offer == 1) {
						tr += '  <td class="not">';
						tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
						tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
						tr += '    <div class="cb"></div>';
						tr += '  </td>';
					} else {
						tr += '  <td>';
						tr += '    Nur zur Ansicht';
						tr += '  </td>';
					}
				} else if(offer[o].partner_offer_accepted == 1) {
					tr += '  <td>';
					tr += '    Standort akzeptiert';
					tr += '  </td>';
				} else if(offer[o].partner_offer_accepted == 2) {
					tr += '  <td>';
					tr += '    Standort abgelehnt';
					tr += '  </td>';
				}
				
				tr += '  <td class="not">';
				if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
					tr += '    <div class="icon-info">';
					tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
					tr += '      <div class="info-holder dnone">';
					tr += '        <div class="info-arrow-top"</div>';
					tr += '        <div class="info-holder-inner">';
					tr += '          ' + offer[o].partner_offer_comment;
					tr += '        </div>';
					tr += '      </div>';
					tr += '    </div>';
				}
				tr += '  </td>';
				
				tr += '</tr>';
				
				
				tr += '<tr>';
				
				
				tr += '    </div>';
				tr += '  </td>';
				tr += '</tr>';
				
				tr = $(tr);
				
				tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('acceptOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('rejectOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('td').not('.not').each(function() {
					$(this).bind('click', {'instance':offer[o]}, function(e) {
	                    single(e.data.instance.acquisition_id);
					});
				});
				
				data.push(tr);
			}
			
			$('.spinner').fadeOut('slow');
			
			for(var row in data) {
				table.find('tbody').append(data[row]);
			}
			
			table.find('.icon-info').each(function() {
				$(this).bind('click', function(e) {
					if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
						$(e.currentTarget).find('.info-holder').removeClass('dnone');
					} else {
						$(e.currentTarget).find('.info-holder').addClass('dnone');
					}
				})
			})
			
			interval_fifth.push(setInterval(function() {
				table.find('.time').each(function() {
					var time = $(this).html();
					var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
					var seconds = seconds - 1;
					
					$(this).html(String(seconds).toHHMMSS());
				})
			}, 1000));
		})
	}
	
	
	function getSixthAcquisitions() {
		
		$('#ba_completed_acquisitions').find('tbody').find('tr').each(function() {
			$(this).remove();
		});
		
		if(interval_sixth.length > 0) {
			for(var int in interval_sixth) {
				clearInterval(interval_sixth[int]);
			}
		}
		
//		var params = new Array();
//		params['site'] = site_sixth;
//		params['max'] = max_sixth;
//		params['order'] = order_sixth;
//		params['sort'] = sort_sixth;
//		params['location_number'] = $('#location_number_sixth').val();
//		params['location_plz'] = $('#location_plz_sixth').val();
//		params['location_city'] = $('#location_city_sixth').val();
//		params['location_address'] = $('#location_address_sixth').val();
////		params['has_status_id'] = '16';
//		
//		if($('#user_select').length > 0) {
//			params['pid'] = $('#user_select').val();
//		}
//		
//		params['status'] = new Array('34', '35');
		
		var params = {}
		params.filter = {};
		params.order = {};
		params.fields = {};
		params.extra = {};
		
		if($('#status').val()) {
			params.filter.status = $('#status').val();
		}
		
		if(partner_id != '' && partner_id.length > 0) {
			params.filter.partner_id = partner_id;
		}
		
		params.filter.list = 'dashboard_ba_completed';
		params.filter.acquisition_id = $('#location_number_sixth').val();
		params.filter.acquisition_zip_code = $('#location_plz_sixth').val();
		params.filter.acquisition_city = $('#location_city_sixth').val();
		params.filter.acquisition_address = $('#location_address_sixth').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_sixth').val();
		params.filter.partner_offer = true;
		
		if($('#user_select').length > 0) {
			params.filter.partner_id = $('#user_select').val();
		}
		
		params.order.site = site_sixth;
		params.order.max = max_sixth;
		params.order.order = order_sixth;
		params.order.sort = sort_sixth;
		
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
			
			$('.spinner').css('display', 'block');
			
			response = JSON.parse(response);
			var offer = response.data;
			count_sixth = response.count;
			displayCountSixth();
			
			var table = $('#ba_completed_acquisitions');
			table.find('tbody').html('');
			
			var data = new Array();
			
			for(var o in offer) {
				
				var tr = '';
				tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_id;
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
				tr += '  </td>';
				tr += '  <td>';
				tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
				tr += '  </td>';
				
				var odate = offer[o].partner_offer_datetime;
				odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)
				
				tr += '  <td>';
				tr += '    ' + odate;
				tr += '  </td>';
				
				if(offer[o].rest_time) {
					tr += '  <td class="time">';
					tr += '    ' + String(offer[o].rest_time).toHHMMSS();
					tr += '  </td>';
				} else {
					tr += '  <td>';
					tr += '    -';
					tr += '  </td>';
				}
				
				if(offer[o].partner_offer_accepted == 0) {
					if(offer[o].partner_offer_offer == 1) {
						tr += '  <td class="not">';
						tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
						tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
						tr += '    <div class="cb"></div>';
						tr += '  </td>';
					} else {
						tr += '  <td>';
						tr += '    Nur zur Ansicht';
						tr += '  </td>';
					}
				} else if(offer[o].partner_offer_accepted == 1) {
					tr += '  <td>';
					tr += '    Standort akzeptiert';
					tr += '  </td>';
				} else if(offer[o].partner_offer_accepted == 2) {
					tr += '  <td>';
					tr += '    Standort abgelehnt';
					tr += '  </td>';
				}
				
				tr += '  <td class="not">';
				if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
					tr += '    <div class="icon-info">';
					tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
					tr += '      <div class="info-holder dnone">';
					tr += '        <div class="info-arrow-top"</div>';
					tr += '        <div class="info-holder-inner">';
					tr += '          ' + offer[o].partner_offer_comment;
					tr += '        </div>';
					tr += '      </div>';
					tr += '    </div>';
				}
				tr += '  </td>';
				
				tr += '</tr>';
				
				
				tr += '<tr>';
				
				
				tr += '    </div>';
				tr += '  </td>';
				tr += '</tr>';
				
				tr = $(tr);
				
				tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('acceptOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
					var params = new Array();
					params['aid'] = e.data.instance.acquisition_id
					
					$('#partner-popup').fadeIn();
					$('#aperture').fadeIn();
					$('#partner-comment').val('');
					
					$('#send').bind('click', function() {
						params['comment'] = $('#partner-comment').val();
						ajaxRequest('rejectOffer', params).success(function(response) {
							response = JSON.parse(response);
							if(response == true) {
								$('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
								location.reload(); 
							} else {
								/**
								 * TODO Error
								 */
							}
						})
					})
				})
				
				tr.find('td').not('.not').each(function() {
					$(this).bind('click', {'instance':offer[o]}, function(e) {
	                    single(e.data.instance.acquisition_id);
					});
				});
				
				data.push(tr);
			}
			
			$('.spinner').fadeOut('slow');
			
			for(var row in data) {
				table.find('tbody').append(data[row]);
			}
			
			table.find('.icon-info').each(function() {
				$(this).bind('click', function(e) {
					if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
						$(e.currentTarget).find('.info-holder').removeClass('dnone');
					} else {
						$(e.currentTarget).find('.info-holder').addClass('dnone');
					}
				})
			})
			
			interval_sixth.push(setInterval(function() {
				table.find('.time').each(function() {
					var time = $(this).html();
					var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
					var seconds = seconds - 1;
					
					$(this).html(String(seconds).toHHMMSS());
				})
			}, 1000));
		})
	}

    function getSeventhAcquisitions() {

        $('#obi_de_acquisitions').find('tbody').find('tr').each(function() {
            $(this).remove();
        });

        if(interval_seventh.length > 0) {
            for(var int in interval_seventh) {
                clearInterval(interval_seventh[int]);
            }
        }

        var params = {}
        params.filter = {};
        params.order = {};
        params.fields = {};
        params.extra = {};

        if($('#status').val()) {
            params.filter.status = $('#status').val();
        }

        params.filter.status_id = 96;


        params.filter.list = 'obi';
        params.filter.acquisition_id = $('#location_number_seventh').val();
        params.filter.acquisition_zip_code = $('#location_plz_seventh').val();
        params.filter.acquisition_city = $('#location_city_seventh').val();
        params.filter.acquisition_address = $('#location_address_seventh').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_seventh').val();
        params.filter.partner_offer = true;

        if($('#user_select').length > 0) {
            params.filter.partner_id = $('#user_select').val();
        }

        params.order.site = site_seventh;
        params.order.max = max_seventh;
        params.order.order = order_seventh;
        params.order.sort = sort_seventh;

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

            $('.spinner').css('display', 'block');

            response = JSON.parse(response);
            var offer = response.data;
            count_seventh = response.count;
            displayCountSeventh();

            var table = $('#obi_de_acquisitions');
            table.find('tbody').html('');

            var data = new Array();

            for(var o in offer) {

                var tr = '';
                tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_id;
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_zip_code && offer[o].acquisition_zip_code != null && offer[o].acquisition_zip_code != '' ? offer[o].acquisition_zip_code : 'N/A';
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_city && offer[o].acquisition_city != null && offer[o].acquisition_city != '' ? offer[o].acquisition_city : 'N/A';
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
                tr += '  </td>';

                var odate = offer[o].partner_offer_datetime;
                odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)

                tr += '  <td>';
                tr += '    ' + odate;
                tr += '  </td>';

                if(offer[o].rest_time) {
                    tr += '  <td class="time">';
                    tr += '    ' + String(offer[o].rest_time).toHHMMSS();
                    tr += '  </td>';
                } else {
                    tr += '  <td>';
                    tr += '    -';
                    tr += '  </td>';
                }

                if(offer[o].partner_offer_accepted == 0) {
                    if(offer[o].partner_offer_offer == 1) {
                        tr += '  <td class="not">';
                        tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
                        tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
                        tr += '    <div class="cb"></div>';
                        tr += '  </td>';
                    } else {
                        tr += '  <td>';
                        tr += '    Nur zur Ansicht';
                        tr += '  </td>';
                    }
                } else if(offer[o].partner_offer_accepted == 1) {
                    tr += '  <td>';
                    tr += '    Standort akzeptiert';
                    tr += '  </td>';
                } else if(offer[o].partner_offer_accepted == 2) {
                    tr += '  <td>';
                    tr += '    Standort abgelehnt';
                    tr += '  </td>';
                }

                tr += '  <td class="not">';
                if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
                    tr += '    <div class="icon-info">';
                    tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
                    tr += '      <div class="info-holder dnone">';
                    tr += '        <div class="info-arrow-top"</div>';
                    tr += '        <div class="info-holder-inner">';
                    tr += '          ' + offer[o].partner_offer_comment;
                    tr += '        </div>';
                    tr += '      </div>';
                    tr += '    </div>';
                }
                tr += '  </td>';

                tr += '</tr>';


                tr += '<tr>';


                tr += '    </div>';
                tr += '  </td>';
                tr += '</tr>';

                tr = $(tr);

                tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
                    var params = new Array();
                    params['aid'] = e.data.instance.acquisition_id

                    $('#partner-popup').fadeIn();
                    $('#aperture').fadeIn();
                    $('#partner-comment').val('');

                    $('#send').bind('click', function() {
                        params['comment'] = $('#partner-comment').val();
                        ajaxRequest('acceptOffer', params).success(function(response) {
                            response = JSON.parse(response);
                            if(response == true) {
                                $('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
                                location.reload();
                            } else {
                                /**
                                 * TODO Error
                                 */
                            }
                        })
                    })
                })

                tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
                    var params = new Array();
                    params['aid'] = e.data.instance.acquisition_id

                    $('#partner-popup').fadeIn();
                    $('#aperture').fadeIn();
                    $('#partner-comment').val('');

                    $('#send').bind('click', function() {
                        params['comment'] = $('#partner-comment').val();
                        ajaxRequest('rejectOffer', params).success(function(response) {
                            response = JSON.parse(response);
                            if(response == true) {
                                $('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
                                location.reload();
                            } else {
                                /**
                                 * TODO Error
                                 */
                            }
                        })
                    })
                })

                tr.find('td').not('.not').each(function() {
                    $(this).bind('click', {'instance':offer[o]}, function(e) {
                        single(e.data.instance.acquisition_id);
                    });
                });

                data.push(tr);
            }

            $('.spinner').fadeOut('slow');

            for(var row in data) {
                table.find('tbody').append(data[row]);
            }

            table.find('.icon-info').each(function() {
                $(this).bind('click', function(e) {
                    if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
                        $(e.currentTarget).find('.info-holder').removeClass('dnone');
                    } else {
                        $(e.currentTarget).find('.info-holder').addClass('dnone');
                    }
                })
            })

            interval_seventh.push(setInterval(function() {
                table.find('.time').each(function() {
                    var time = $(this).html();
                    var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
                    var seconds = seconds - 1;

                    $(this).html(String(seconds).toHHMMSS());
                })
            }, 1000));
        })
    }

    function getEighthAcquisitions() {

        $('#obi_de_acquisitions').find('tbody').find('tr').each(function() {
            $(this).remove();
        });

        if(interval_eighth.length > 0) {
            for(var int in interval_eighth) {
                clearInterval(interval_eighth[int]);
            }
        }

        var params = {}
        params.filter = {};
        params.order = {};
        params.fields = {};
        params.extra = {};

        if($('#status').val()) {
            params.filter.status = $('#status').val();
        }

        params.filter.status_id = 120;


        params.filter.list = 'obi';
        params.filter.acquisition_id = $('#location_number_eighth').val();
        params.filter.acquisition_zip_code = $('#location_plz_eighth').val();
        params.filter.acquisition_city = $('#location_city_eighth').val();
        params.filter.acquisition_address = $('#location_address_eighth').val();
		params.filter.acquisition_job_type_name = $('#location_job_type_eight').val();
        params.filter.partner_offer = true;

        if($('#user_select').length > 0) {
            params.filter.partner_id = $('#user_select').val();
        }

        params.order.site = site_eighth;
        params.order.max = max_eighth;
        params.order.order = order_eighth;
        params.order.sort = sort_eighth;

        params.fields = new Array('acquisition_id',
            'acquisition_zip_code',
            'acquisition_city',
            'acquisition_address',
            'acquisition_frequency',
            'partner_offer_datetime',
            'partner_offer_visible',
            'partner_offer_offer',
            'partner_offer_accepted',
            'partner_offer_comment',
			'owner_zip_code',
            'owner_city');

        ajaxRequest('getAcquisitionsNew', params).success(function(response) {

            $('.spinner').css('display', 'block');

            response = JSON.parse(response);
            var offer = response.data;
            count_eighth = response.count;
            displayCountEighth();

            var table = $('#obi_at_acquisitions');
            table.find('tbody').html('');

            var data = new Array();

            for(var o in offer) {

                var tr = '';
                tr += '<tr id="acquisition_'+offer[o].acquisition_id+'">';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_id;
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].owner_zip_code && offer[o].owner_zip_code != null && offer[o].owner_zip_code != '' ? offer[o].owner_zip_code : 'N/A';
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].owner_city && offer[o].owner_city != null && offer[o].owner_city != '' ? offer[o].owner_city : 'N/A';
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_address && offer[o].acquisition_address != null && offer[o].acquisition_address != '' ? offer[o].acquisition_address : 'N/A';
                tr += '  </td>';
                tr += '  <td>';
                tr += '    ' + offer[o].acquisition_frequency && offer[o].acquisition_frequency != 0 && offer[o].acquisition_frequency != '' ? offer[o].acquisition_frequency : 'N/A';
                tr += '  </td>';

                var odate = offer[o].partner_offer_datetime;
                odate = odate.substring(8,10) + '.' + odate.substring(5,7) + '.' + odate.substring(0,4) + ' ' + odate.substring(11,19)

                tr += '  <td>';
                tr += '    ' + odate;
                tr += '  </td>';

                if(offer[o].rest_time) {
                    tr += '  <td class="time">';
                    tr += '    ' + String(offer[o].rest_time).toHHMMSS();
                    tr += '  </td>';
                } else {
                    tr += '  <td>';
                    tr += '    -';
                    tr += '  </td>';
                }

                if(offer[o].partner_offer_accepted == 0) {
                    if(offer[o].partner_offer_offer == 1) {
                        tr += '  <td class="not">';
                        tr += '    <div class="button accept fl" style="width:80px;">Annehmen</div>';
                        tr += '    <div class="button reject fl" style="width:80px;">Ablehnen</div>';
                        tr += '    <div class="cb"></div>';
                        tr += '  </td>';
                    } else {
                        tr += '  <td>';
                        tr += '    Nur zur Ansicht';
                        tr += '  </td>';
                    }
                } else if(offer[o].partner_offer_accepted == 1) {
                    tr += '  <td>';
                    tr += '    Standort akzeptiert';
                    tr += '  </td>';
                } else if(offer[o].partner_offer_accepted == 2) {
                    tr += '  <td>';
                    tr += '    Standort abgelehnt';
                    tr += '  </td>';
                }

                tr += '  <td class="not">';
                if(offer[o].partner_offer_comment != '' && offer[o].partner_offer_comment != undefined) {
                    tr += '    <div class="icon-info">';
                    tr += '      <span style="font-size:21px; font-weight:bold; color:#fff; margin:0 0 0 10px;">i</span>';
                    tr += '      <div class="info-holder dnone">';
                    tr += '        <div class="info-arrow-top"</div>';
                    tr += '        <div class="info-holder-inner">';
                    tr += '          ' + offer[o].partner_offer_comment;
                    tr += '        </div>';
                    tr += '      </div>';
                    tr += '    </div>';
                }
                tr += '  </td>';

                tr += '</tr>';


                tr += '<tr>';


                tr += '    </div>';
                tr += '  </td>';
                tr += '</tr>';

                tr = $(tr);

                tr.find('.accept').bind('click', {'instance':offer[o]}, function(e) {
                    var params = new Array();
                    params['aid'] = e.data.instance.acquisition_id

                    $('#partner-popup').fadeIn();
                    $('#aperture').fadeIn();
                    $('#partner-comment').val('');

                    $('#send').bind('click', function() {
                        params['comment'] = $('#partner-comment').val();
                        ajaxRequest('acceptOffer', params).success(function(response) {
                            response = JSON.parse(response);
                            if(response == true) {
                                $('#acquisition_' + e.data.instance.acquisition_id).find('.not').html('Standort akzeptiert');
                                location.reload();
                            } else {
                                /**
                                 * TODO Error
                                 */
                            }
                        })
                    })
                })

                tr.find('.reject').bind('click', {'instance':offer[o]}, function(e) {
                    var params = new Array();
                    params['aid'] = e.data.instance.acquisition_id

                    $('#partner-popup').fadeIn();
                    $('#aperture').fadeIn();
                    $('#partner-comment').val('');

                    $('#send').bind('click', function() {
                        params['comment'] = $('#partner-comment').val();
                        ajaxRequest('rejectOffer', params).success(function(response) {
                            response = JSON.parse(response);
                            if(response == true) {
                                $('#acquisition_' + e.data.instance.acquisition_id).fadeOut();
                                location.reload();
                            } else {
                                /**
                                 * TODO Error
                                 */
                            }
                        })
                    })
                })

                tr.find('td').not('.not').each(function() {
                    $(this).bind('click', {'instance':offer[o]}, function(e) {
                        single(e.data.instance.acquisition_id);
                    });
                });

                data.push(tr);
            }

            $('.spinner').fadeOut('slow');

            for(var row in data) {
                table.find('tbody').append(data[row]);
            }

            table.find('.icon-info').each(function() {
                $(this).bind('click', function(e) {
                    if($(e.currentTarget).find('.info-holder').hasClass('dnone')) {
                        $(e.currentTarget).find('.info-holder').removeClass('dnone');
                    } else {
                        $(e.currentTarget).find('.info-holder').addClass('dnone');
                    }
                })
            })

            interval_eighth.push(setInterval(function() {
                table.find('.time').each(function() {
                    var time = $(this).html();
                    var seconds = (time.trim().substring(0, 2) * 60 * 60) + (time.trim().substring(3, 5) * 60) + (time.trim().substring(6, 8) * 1)
                    var seconds = seconds - 1;

                    $(this).html(String(seconds).toHHMMSS());
                })
            }, 1000));
        })
    }

	ajaxRequest('getUserId').success(function(response) {

		var obiDeButton = document.querySelector('#obi-de')
        var obiAtButton = document.querySelector('#obi-at')

        var obiDePag = document.querySelector('#sheet-pagination-seventh');
        var obiAtPag = document.querySelector('#sheet-pagination-eighth');

        var obiDe = document.querySelector('#seventh');
        var obiAt = document.querySelector('#eighth');

        if(obiDe !== null) {
                obiDeButton.addEventListener('click', function() {
                obiDeButton.classList.add('active');
                obiAtButton.classList.remove('active');
                obiDe.classList.remove('dnone');
                obiAt.classList.add('dnone');
                obiDePag.classList.remove('dnone');
                obiAtPag.classList.add('dnone');
            })
        }

        if(obiAt !== null) {
            obiAtButton.addEventListener('click', function() {
                obiDeButton.classList.remove('active');
                obiAtButton.classList.add('active');
                obiAt.classList.remove('dnone');
                obiDe.classList.add('dnone');
                obiDePag.classList.add('dnone');
                obiAtPag.classList.remove('dnone');
            })
        }

		response = JSON.parse(response);
		partner_id = response;
		
		getFirstAcquisitions();
		getSecondAcquisitions();
		getThirdAcquisitions();
		getFourthAcquisitions();
		getFifthAcquisitions();
		getSixthAcquisitions();
		getSeventhAcquisitions();
        getEighthAcquisitions();
	});
})

function single(id) {
	window.open('https://' + window.location.host + '/Dashboard/Partner/Id/' + id + '/', '_blank');
}
