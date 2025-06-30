function ajaxLoader(on)
{
	if(on == true)
	{
		var aperture = document.createElement('div');
		var ajaxloader = document.createElement('div');
		var image = document.createElement('div');
		var close = document.createElement('div');
		
		aperture.id = "aperture";
		ajaxloader.id = "ajaxloader";
		image.id = "image";
		close.className = "delete-icon-small";
		close.id = "ajaxclose";
		
		$("body").append(aperture);
		$("body").append(ajaxloader);
		$("#ajaxloader").append(image);
		$("#ajaxloader").append(close);
	}
	else
	{
		$('#apperture').remove();
		$('#ajaxloader').remove();
	}
}

window.location.getUrl = function() {
	var host = window.location.host;
	
	return protocol + '//' + host;
}

testtest = function() {
	var host = window.location.host;
	var protocol = window.location.protocol;
	return protocol + '//' + host;
}

window.location.getFullUrl = function() {
	var protocol = window.location.protocol;
	var host = window.location.host;
	var pathname = window.location.pathname
	
	return protocol + '//' + host + pathname;
}

/**
 * Add loader width
 */
function getLoaderBox() {
	var imgSrc = "../images/loader.gif";
	var loadingBox = $("<div/>",{
		id: "loadingBox"
	});
	var image = $("<img />",{
		src: imgSrc,
		id: "loadingImg",
		border: 0
	});
	
	loadingBox.appendTo("#content");
	image.appendTo(loadingBox);
}

/**
 * Delete Row from Table
 * @param object ref -> <tr>
 */
function deleteRow(ref)
{
	$(ref).parent().parent(setCookie
			).remove();
}

/**
 * Add Row to Table
 */
function addRow(table, row)
{
	$('#'+table+' tr:last').after(row);
}

/**
 * Count Table-Rows
 */
function countRows(table)
{
	return $('#'+table+' tr').length;
}


function getDateTime()
{
	var timestamp = new Date().getTime();
	var date = new Date(timestamp);

	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();

	return day + "." + month + "." + year + "_" + hours + "." + minutes + "." + seconds;
}


/**
 * Check if File Exists
 * @param string filepath
 */
function fileExists(filepath)
{
	$.ajax({
	    type: 'HEAD',
	    url: filepath,
	    success: function() {
	        return "yes1";
	    },  
	    error: function() {
	        return "no1";
	    }
	});
	return 'asdsa';
}




function sleep(milliseconds)
{
	var start = new Date().getTime();
	for (var i = 0; i < 1e7; i++)
	{
		if ((new Date().getTime() - start) > milliseconds)
		{
			break;
		}
	}
}


/**
 * Create a Popup-Box (Delete)
 */
function openDeletePopup(headline, message, set_function, attributes)  {
	var aperture = document.createElement('div');
	aperture.id = 'aperture';
	
	var popup = document.createElement('div');
	popup.id = 'popupbox';
	
	var header = document.createElement('div');
	header.className = 'box-top gradient-dark-blue';
	header.innerHTML = '<h3>'+headline+'</h3>';
	popup.appendChild(header);
	
	var content = document.createElement('div');
	content.className = 'box-content';
	popup.appendChild(content);
	
	var text = document.createElement('div');
	text.id = 'text';
	content.appendChild(text);
	
	text.innerHTML = message;
	
	var yes = document.createElement('div');
	yes.className = 'gradient-dark-blue';
	yes.id = 'yes';
	
	var yes_a = document.createElement('a');
	yes_a.innerHTML = '<span onclick="window[\''+set_function+'\'](\''+attributes+'\');closePopup();">Yes</span>';
	
	yes.appendChild(yes_a);
	
	content.appendChild(yes);
	
	var no = document.createElement('div');
	no.className = 'gradient-dark-blue';
	no.id = 'no';
	
	var no_a = document.createElement('a');
	no_a.innerHTML = '<span onclick="javascript:closePopup();">No</span>';
	no.appendChild(no_a);
	
	content.appendChild(no);
	
	var cb = document.createElement('div');
	cb.className = 'cb';
	content.appendChild(cb);
	
	
	document.body.appendChild(aperture);
	document.body.appendChild(popup);
}


/**
 * Close Popup-Window and aperture
 */
function closePopup()
{
	element = document.getElementById('aperture');
	element.parentNode.removeChild(element);
	
	element = document.getElementById('popupbox');
	element.parentNode.removeChild(element);
}


/**
 * 
 * @param search
 * @param replace
 * @param subject
 * @returns
 */
function str_replace(search, replace, subject)
{
	return subject.split(search).join(replace);
}

/**
 * 
 * @desc TODO
 * @param Cookie-Name
 * @param Cookie-Value
 */
function setCookie(name, value)
{
	document.cookie = name + "=" + value + '; path=/';
	location.reload();
}

function strpos (haystack, needle, offset)
{
  var i = (haystack + '').indexOf(needle, (offset || 0));
  return i === -1 ? false : i;
}


/**
 * 
 * @desc TODO
 * @param Cookie-Name
 * @returns Cookie[name] -> Value
 */
function getCookieValue(name)
{
	var bar = document.cookie.split (";");
	var value = '';
	
	for(foo in bar)
	{
		if(strpos(bar[foo], name) !== false)
		{
			value = bar[foo].replace(name, '');
			value = value.replace('=', '');
		}
	}
	return value;
}

/**
 * TODO
 * @param string
 * @param lang
 * @returns
 */
function getLanguageContent(string, lang)
{
	var lang = getCookieValue('lang');
	lang = lang.replace(' ', '');
	
	var lang_list = {};
	lang_list.de = {};
	lang_list.en = {};
	
	
	lang_list.de['projekt_waehlen'] = 'Projekt wählen';
	lang_list.en['projekt_waehlen'] = 'Chose project';
	
	lang_list.de['alle_tags'] = 'Alle Tags';
	lang_list.en['alle_tags'] = 'All tags';
	
	lang_list.de['chart_speichern'] = 'Chart speichern';
	lang_list.en['chart_speichern'] = 'Save chart';
	
	lang_list.de['von_datum'] = 'Von (Datum)';
	lang_list.en['von_datum'] = 'From (Date)';
	
	lang_list.de['bis_datum'] = 'Bis (Datum)';
	lang_list.en['bis_datum'] = 'To (Date)';
	
	lang_list.de['tag_waehlen'] = 'Tag wählen';
	lang_list.en['tag_waehlen'] = 'Choose tag';
	
	if(lang == 'DE')
	{
		return lang_list.de[string];
	}
	else if(lang == 'EN')
	{
		return lang_list.en[string];
	}
}


/**
 * 
 * @desc Validate an E-Mail Adress
 * @param email
 * @returns boolean
 */
function validateEmail(email)
{
	var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return reg.test(email);
}


/**
 * 
 * @param str
 * @returns
 */
function mysql_real_escape_string (str) {
    return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {
        switch (char) {
            case "\0":
                return "\\0";
            case "\x08":
                return "\\b";
            case "\x09":
                return "\\t";
            case "\x1a":
                return "\\z";
            case "\n":
                return "\\n";
            case "\r":
                return "\\r";
            case "\"":
            case "'":
            case "\\":
            case "%":
                return "\\"+char; // prepends a backslash to backslash, percent,
                                  // and double/single quotes
        }
    });
}

/**
 * 
 * @param charts
 */
function printCharts(charts) {
	var origDisplay = [],
	    origParent = [],
	    body = document.body,
	    childNodes = body.childNodes;

    // hide all body content
    Highcharts.each(childNodes, function (node, i) {
        if (node.nodeType === 1) {
            origDisplay[i] = node.style.display;
            node.style.display = "none";
        }
    });

    // put the charts back in
    $.each(charts, function (i, chart) {
        origParent[i] = chart.container.parentNode;
        body.appendChild(chart.container);
    });

    // print
    window.print();

    // allow the browser to prepare before reverting
    setTimeout(function () {
        // put the charts back in
        $.each(charts, function (i, chart) {
            origParent[i].appendChild(chart.container);
        });

        // restore all body content
        Highcharts.each(childNodes, function (node, i) {
            if (node.nodeType === 1) {
                node.style.display = origDisplay[i];
            }
        });
    }, 500);
}

/**
 * @desc Convert the given html table into a csv-string
 * @param table
 * @param download
 * @returns
 */
function html2csv(table, download) {
	
	var rowCount = $(table).find('tr').length;
	
	var columnCount = $(table).find('thead th').length + 1;
	
	var data = '';
	
	for(var i = 1; i <= rowCount; i++) {
		for(var j = 1; j < columnCount; j++) {
			if(i <= 1) {
				data += $.trim($( table).find('thead th:nth-child('+ j +')').text()) + '; ';
			}
			
			if(i > 1) {
				data += $.trim($( table).find(' tbody tr:nth-child('+ (i-1) +') td:nth-child('+ j +')').text())  + '; ';
			}
		}
		data += "\n";
	}
	return $.trim(data);
}

/**
 * Slide up and down the content-box (".box-content")
 */
function toggleSlide(x)  {
	$(x).next(".box-content").slideToggle();
}

/**
 * Jquery only allow numeric
 */
jQuery.fn.NumericOnly =
function() {
	$(this).keypress(function(event) {
	  // Backspace, tab, enter, end, home, left, right
	  // We don't support the del key in Opera because del == . == 46.
	  var controlKeys = [8, 9, 13, 35, 36, 37, 39, 44, 46];
	  // IE doesn't support indexOf
	  var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
	  // Some browsers just don't raise events for control keys. Easy.
	  // e.g. Safari backspace.
	  if (!event.which || // Control keys in most browsers. e.g. Firefox tab is 0
	      (49 <= event.which && event.which <= 57) || // Always 1 through 9
	      (48 == event.which && $(this).attr("value")) || // No 0 first digit
	      isControlKey) { // Opera assigns values for control keys.
	    return;
	  } else {
	    event.preventDefault();
	  }
	});
};




/**
 * 
 */
function getDaysInMonth(date) {
	
	var year = date.getFullYear();
	var month = date.getMonth();
	
     var date = new Date(year, month, 1);
     var days = [];
     
     while (date.getMonth() === month) {
        days.push(new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate())));
        date.setDate(date.getDate() + 1);
     }
     
     return days;
}


function fillMonthDays(dates) {
	
	var new_dates = new Array();
	var ii = new Array();
	
	
	/**
	 * Set last Month dates
	 */
	if(dates[0].getDay() != 1) {
		
		var day = dates[0].getDay();
		var monday = getMonday(dates[0]);
		
		var diff = new Date(dates[0].getTime() - monday.getTime());
		diff = diff.getUTCDate() - 1;
		
		for(i = 0; i < diff; i++) {
			var test = new Date(monday.getTime());
			var temp = new Date(test.setDate(test.getDate() + i));
			
			ii.push(temp);
			
			new_dates.push(new Date(temp.getTime()));
		}
	}
	
	
	/**
	 * Set original dates
	 */
	for(date in dates) {
		new_dates.push(dates[date]);
	}
	
	
	/**
	 * Set next month dates
	 */
	var last_date = new_dates[(new_dates.length - 1)];
	
	var temp = last_date.getTime();
	temp = new Date(temp);
	
	var lastday = new Date(temp.setDate(temp.getDate() - temp.getDay()+7));
	
	var diff = new Date(lastday.getTime() - last_date.getTime());
	diff = diff.getUTCDate() - 1;
	
	
	for(i = 1; i <= diff; i++) {
		var test = new Date(last_date.getTime());
		new_dates.push(new Date(test.setDate(test.getDate() + i)));
	}
	
	return new_dates;
}

function getMonday(d) {
  d = new Date(d);
  var day = d.getDay(),
      diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
  return new Date(d.setDate(diff));
}


/**
 * Prototypes
 */

Date.prototype.toUTCDate = function() {
	var date = this;
	
	var year = date.getFullYear();
	var month = date.getMonth();
	var day = date.getDate();

	var hour = date.getHours();
	var minute = date.getMinutes();
	var second = date.getSeconds();

	return new Date(Date.UTC(year, month, day, hour, minute, second));
}

Date.prototype.toGermanDate = function() {
	var date = this;
	console.log(this);
	return '123';
}


Date.prototype.formatDate = function (format) {
    var date = this,
        day = date.getDate(),
        month = date.getMonth() + 1,
        year = date.getFullYear(),
        hours = date.getHours(),
        minutes = date.getMinutes(),
        seconds = date.getSeconds();
    
    var months = new Array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
    
    if (!format) {
        format = "MM/dd/yyyy";
    }
    
    if (format.indexOf("MM") > -1) {
    	format = format.replace("MM", month.toString().replace(/^(\d)$/, '0$1'));
    } else if(format.indexOf("M") > -1) {
    	if(months[parseInt(format.replace("M", month.toString().replace(/^(\d)$/, '0$1')))] != '') {
    		format = months[parseInt(format.replace("M", month.toString().replace(/^(\d)$/, '0$1')))];
    	}
    }

    if (format.indexOf("yyyy") > -1) {
        format = format.replace("yyyy", year.toString());
    } else if (format.indexOf("yy") > -1) {
        format = format.replace("yy", year.toString().substr(2, 2));
    }

    format = format.replace("dd", day.toString().replace(/^(\d)$/, '0$1'));

    if (format.indexOf("t") > -1) {
        if (hours > 11) {
            format = format.replace("t", "pm");
        } else {
            format = format.replace("t", "am");
        }
    }

    if (format.indexOf("HH") > -1) {
        format = format.replace("HH", hours.toString().replace(/^(\d)$/, '0$1'));
    }

    if (format.indexOf("hh") > -1) {
        if (hours > 12) {
            hours -= 12;
        }

        if (hours === 0) {
            hours = 12;
        }
        format = format.replace("hh", hours.toString().replace(/^(\d)$/, '0$1'));
    }

    if (format.indexOf("mm") > -1) {
        format = format.replace("mm", minutes.toString().replace(/^(\d)$/, '0$1'));
    }

    if (format.indexOf("ss") > -1) {
        format = format.replace("ss", seconds.toString().replace(/^(\d)$/, '0$1'));
    }

    return format;
};





String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
}
