var Browser = {
	a : navigator.userAgent.toLowerCase()
}
Browser = {
	ie : /*@cc_on true || @*/ false,
	ie6 : Browser.a.indexOf('msie 6') != -1,
	ie7 : Browser.a.indexOf('msie 7') != -1,
	opera : !!window.opera,
	safari : Browser.a.indexOf('safari') != -1,
	safari3 : Browser.a.indexOf('applewebkit/5') != -1,
	mac : Browser.a.indexOf('mac') != -1
}
function $(e) {
	if(typeof e == 'string')
    	return document.getElementById(e);
	return e;
}
function createElement(name, attrs, doc, xmlns) {
	var doc = doc ? doc : document;
	var elm;
	if(doc.createElementNS)
		elm = doc.createElementNS(xmlns ? xmlns : "http://www.w3.org/1999/xhtml", name);
	else
		elm = doc.createElement(name);
	if(attrs)
		for(attr in attrs)
			elm.setAttribute(attr, attrs[attr]);
	return elm;
}
function setDisplay(e, display) {
	$(e).style.display = display;
}
function hide(e) {
	setDisplay(e, 'none');
}
function show(e) {
	setDisplay(e, '');
}
function visible(e) {
	return $(e).style.display != 'none';
}
function toggle(e) {
	(visible(e) ? hide : show)(e);
}
function visibleInverse(e) {
	return $(e).style.display != '';
}
function toggleInverse(e, display) {
	setDisplay(e, visibleInverse(e) ? '' : display);
}
function getChildElementsByTagName(e, tagName) {
	var nodes = [];
	for(var i = 0; i < e.childNodes.length; i++)
		if(e.childNodes[i].nodeName.toLowerCase() == tagName)
			nodes.push(e.childNodes[i]);
	return nodes;
}
function removeChildren(e) {
	while(e.firstChild)
		e.removeChild(e.firstChild);
}
function addEvent(obj, evType, fn) {
	if(obj.addEventListener) {
		obj.addEventListener(evType, fn, false);
		return true;
	} else if(obj.attachEvent)
		return obj.attachEvent("on" + evType, fn);
	return false;
}

function getFormQueryString(form) {
	var pairs = [];
	var inputs = form.getElementsByTagName('input');
	var textareas = form.getElementsByTagName('textarea');
	var selects = form.getElementsByTagName('select');

	for(var i = 0, input; input = inputs[i]; i++)
		pairs.push(input.name + '=' + encodeURI(input.value));

	for(var i = 0, input; input = textareas[i]; i++)
		pairs.push(input.name + '=' + encodeURI(input.value));

	for(var i = 0, input; input = selects[i]; i++)
		for(var j = 0, option; option = input.options[j]; j++)
			if(option.selected)
				pairs.push(input.name + '=' + encodeURI(option.value));

	return pairs.join('&');
}

function getURLParams() {
	var map = {};
	var entries = document.location.search.substr(1).split('&');
	for(var i = 0; i < entries.length; i++) {
		var entry = entries[i].split('=', 2);
		if(!map[entry[0]])
			map[entry[0]] = [];
		map[entry[0]].push(entry.length == 2 ? decodeURIComponent(entry[1]) : null);
	}
	return map;
}

function createURLSearchString(map) {
	var search = '';
	for(field in map)
		if(!Object.prototype[field]) {
			var array = map[field];
			for(var i = 0; i < array.length; i++) {
				if(search != '')
					search += '&';
				search += field;
				if(array[i] != null)
					search += '=' + array[i];
			}
		}
	if(search != '')
		search = '?' + search;
	return search;
}

function setURLParam(parameter, value) {
	var url = document.location.protocol + '//' + document.location.host + document.location.pathname;
	var params = getURLParams();
	params[parameter] = [value];
	url += createURLSearchString(params);
	url += document.location.hash;
	return url;
}

function addStylesheet(href, media) {
	document.getElementsByTagName("head")[0].appendChild(createElement('link', {
		'rel': 'stylesheet',
		'type': 'text/css',
		'media': media ? media : 'screen, projection',
		'href': href
	}));
}

function createObject(type, data, width, height, params, doc, fallback) {
	var obj = createElement('object', {
		'type': type,
		'data': data,
		'width': width,
		'height': height
	}, doc);
	if(params)
		for(var i = 0, pair; pair = params[i]; i++)
			obj.appendChild(createElement("param", {
				'name': pair[0],
				'value': pair[1]
			}, doc));
	if(fallback)
		obj.appendChild(fallback);
	return obj;
}

function setFlash(target, data, width, height, params, fallbackMsg) { // avoids IE Eolas patent UI workarounds
	// IE ignores objects created with DOM. Serialize & use innerHTML
	var doc = Browser.ie ? new ActiveXObject('Microsoft.XMLDOM') : document;
	var obj = createObject('application/x-shockwave-flash', data, width, height, params, doc,
			doc.createTextNode(fallbackMsg));
	var targetNode = $(target);
	if(Browser.ie)
		targetNode.innerHTML = obj.xml;
	else {
		removeChildren(targetNode);
		targetNode.appendChild(obj);
	}
}

function selectLanguage(lang) {
	window.location = HTTP.setURLParam('locale', lang);
}

var HTTP = {
	URL_SPACE_REGEXP : /%20/g,
	getURLParams : function(url) {
		var map = {};
		if(url) {
			var queryStart = url.indexOf('?');
			var hashStart = url.indexOf('#');
			if(queryStart != -1) {
				if(hashStart != -1)
					url = url.substring(queryStart + 1, hashStart);
				else
					url = url.substr(queryStart + 1);
			} else
				return map;
		} else
			url = window.location.search.substr(1);
		var entries = url.split('&');
		for(var i = 0; i < entries.length; i++) {
			var entry = entries[i].split('=', 2);
			if(!map[entry[0]])
				map[entry[0]] = [];
			map[entry[0]].push(entry.length == 2 ? decodeURIComponent(entry[1]) : null);
		}
		return map;
	},
	setURLParam : function(parameter, value, url) {
		var hash = '';
		var path;
		if(url) {
			var queryStart = url.indexOf('?');
			var hashStart = url.indexOf('#');
			if(queryStart != -1)
				path = url.substring(0, queryStart);
			else if(hashStart != -1)
				path = url.substring(0, hashStart);
			else
				path = url;
			if(hashStart != -1)
				hash = url.substr(hashStart);
		} else {
			url = false;
			path = window.location.pathname;
			hash = window.location.hash;
		}
		var params = HTTP.getURLParams(url);
		params[parameter] = [value];
		return path + HTTP._createQueryString(params) + hash;
	},
	encodeForm : function(form, post) {
		var pairs = [];
		var inputs = form.getElementsByTagName('input');
		var textareas = form.getElementsByTagName('textarea');
		var selects = form.getElementsByTagName('select');

		for(var i = 0, input; input = inputs[i]; i++)
			if(!input.disabled && input.name && ((input.type != 'radio' && input.type != 'checkbox') || input.checked))
				pairs.push(HTTP._formUrlEncode(input.name, post) + '=' + HTTP._formUrlEncode(input.value, post));

		for(var i = 0, input; input = textareas[i]; i++)
			if(!input.disabled && input.name)
				pairs.push(HTTP._formUrlEncode(input.name, post) + '=' + HTTP._formUrlEncode(input.value, post));

		for(var i = 0, input; input = selects[i]; i++)
			if(!input.disabled && input.name)
				for(var j = 0, option; option = input.options[j]; j++)
					if(option.selected)
						pairs.push(HTTP._formUrlEncode(input.name, post) + '=' + HTTP._formUrlEncode(option.value, post));

		return pairs.join('&');
	},
	_createQueryString : function(map) {
		var search = '';
		for(field in map)
			if(!Object.prototype[field]) {
				var array = map[field];
				for(var i = 0; i < array.length; i++) {
					if(search != '')
						search += '&';
					search += field;
					if(array[i] != null)
						search += '=' + array[i];
				}
			}
		if(search != '')
			search = '?' + search;
		return search;
	},
	_formUrlEncode : function(val, post) {
		if(post)
			return encodeURIComponent(val).replace(HTTP.URL_SPACE_REGEXP, '+');
		return encodeURIComponent(val);
	}
}