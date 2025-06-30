function ajaxRequest(action, params, response) {
	
	var p = {};
  
	for(param in params) {
		p[param] = params[param];
	}
	
	return $.ajax({
	   url: '/Ajax/' + action,
	   data: p,
	   error: function() {
		   console.log('fail...');
	   },
	   type: 'POST'
	});
}

function HandleResponse(response) {
	if(response != '') {
		alert(response);
	}
}