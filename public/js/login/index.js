$(document).ready(function() {
	$('#get-recovery').bind('click', function() {
		$('#login-wrapper').hide();
		$('#password-recovery-wrapper').show();
	})
	
	$('#get-login').bind('click', function() {
		$('#login-wrapper').show();
		$('#password-recovery-wrapper').hide();
	})
	
	$('#login-now').click(function(){
		document.forms['log_form'].submit();
	})
	
	$('#recover_password').click(function(){
		document.forms['recovery_form'].submit();
	})
	
	$('#get_password_btn').click(function(){
		$('#error').html('');
		$('#error').removeClass('error');
		if($('#get_password_email').val() != '') {
			if(validateEmail($('#get_password_email').val())) {
				$.ajax({
					url: window.location,
					type: "POST",
					
					data: {	get_password_email : $('#get_password_email').val() },
							
			        success: function(data) {
			        	
			        	$('#get_password_email').val('');
			        	
			        	$('#error').addClass('error');
			        	$('#error').html(data);
			        	
			        	setTimeout(function() {
		        		  window.location.href = window.location;
		        		}, 2000);
			        }
				});
			} else {
				$('#error').addClass('error');
				$('#error').html('<b>Error:</b> Given email is not valid.');
			}
		} else {
			$('#error').addClass('error');
			$('#error').html('<b>Error:</b> No email given');
		}
	});
	
	$('#set_password_btn').click(function() {
		if($('#new_password').val() == $('#new_password_repeat').val()) {
			$.ajax({
				url: document.domain,
				type: "POST",
				
				data: {	set_password : $('#new_password').val(),
						uid : $('#uid').val() },
						
		        success: function(data) {
		        	
		        	var foo = jQuery.parseJSON(data);
		        	
		        	$('#error').addClass('error');
		        	$('#error').html(foo['msg']);
		        	
		        	
		        	if(foo['boolean'] == true) {
		        		$('#set_password').val('');
			        	$('#set_password_repeat').val('');
			        	
			        	setTimeout(function() {
		        		  window.location.href = location.protocol + "//" + document.domain;
		        		}, 2000);
		        	}
		        }
			});
		}
	});
	
	$('#get_username_btn').click(function(){
		$('#error').html('');
		if(validateEmail($('#get_password_email').val())) {
			alert('password');
		}
	})
});


var frames = new Array('get_password_form', 'login_form');
function getForm(form) {
	for(var frame in frames) {
		if(form == frames[frame]) {
			$('#'+frames[frame]).css('display', 'block');
		} else {
			$('#'+frames[frame]).css('display', 'none');
		}
	}
}


if (window.captureEvents) {
	function Ausgabe(Ereignis) {
		if(Ereignis.which == "13") {
			document.forms['log_form'].submit();
		}
	}
	window.captureEvents(Event.KEYPRESS);
	window.onkeypress = Ausgabe;
}