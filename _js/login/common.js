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
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g, '');
}
// Do not prototype Object or Array if using for-in loops
function indexOf(array, elt /*, from*/) {
	// SpiderMonkey imlementation
	var len = array.length;

	var from = Number(arguments[2]) || 0;
	from = (from < 0) ? Math.ceil(from) : Math.floor(from);
	if(from < 0)
		from += len;

	for(; from < len; from++)
		if(from in array && array[from] === elt)
			return from;

	return -1;
}
function createElement(name, attrs, doc, xmlns) {
	var doc = doc || document;
	var elm;
	if(doc.createElementNS)
		elm = doc.createElementNS(xmlns || "http://www.w3.org/1999/xhtml", name);
	else
		elm = doc.createElement(name);
	if(attrs)
		for(attr in attrs)
			elm.setAttribute(attr, attrs[attr]);
	return elm;
}
function createElementStr(name, attrs) {
	return new NodeStr(name, attrs);
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
function getElementsByClassName(className, element, tagName) {
	var regexp = new RegExp('(^|\\s)' + className + '(\\s|$)');
	var tagName = tagName || '*';
	var element = element || document;
	var elements = (tagName == '*' && element.all) ? element.all : element.getElementsByTagName(tagName);
	var found = [];
	for(var i = 0, elm; elm = elements[i]; i++)
		if(regexp.test(elm.className))
			found.push(elm);
	return found;
}
function hasClassName(e, className) {
	return (new RegExp('(^|\\s)' + className + '(\\s|$)').test($(e).className));
}
function addClassName(e, className) {
	var e = $(e);
	if(!hasClassName(e, className))
		e.className += (e.className ? ' ' : '') + className;
}
function removeClassName(e, className) {
	var e = $(e);
	e.className = e.className.replace(new RegExp('(^|\\s+)' + className + '(\\s+|$)'), ' ').trim();
}
function removeChildren(e) {
	while(e.firstChild)
		e.removeChild(e.firstChild);
}
function bind(method, scope, args) {
	if(!args)
		args = [];
	return function() {
		return method.apply(scope, args);
	}
}
function addEvent(obj, evType, fn) {
	if(obj.addEventListener) {
		obj.addEventListener(evType, fn, false);
		return true;
	} else if(obj.attachEvent || Browser.ie)
		return obj.attachEvent('on' + evType, fn);
	return false;
}
function removeEvent(obj, evType, fn) {
	if(obj.removeEventListener) {
		obj.removeEventListener(evType, fn, false);
		return true;
	} else if(obj.detatchEvent || Browser.ie)
		return obj.detachEvent('on' + evType, fn);
	return false;
}
function setBgPos(e, y, x) {
	$(e).style.backgroundPosition = y ? (x ? x + ' ' + y : '0 ' + y) : '0 0';
}
function hasScrolledToBottom(target) {
	return target.scrollTop >= (target.scrollHeight - target.offsetHeight);
}

function loadScript(src, id) {
    var head = document.getElementsByTagName('head')[0];
    var script = createElement('script', {'type': 'text/javascript', 'src': src} );
    if(id) {
        var old = document.getElementById(id);
        if(old)
            old.parentNode.removeChild(old);
        script.id = id;
    }
    head.appendChild(script);
}

function addStylesheet(href, media) {
	document.getElementsByTagName("head")[0].appendChild(createElement('link', {
		'rel': 'stylesheet',
		'type': 'text/css',
		'media': media || 'screen, projection',
		'href': href
	}));
}

// used for DOM-like creation of object elements in IE
var NodeStr = function(name, attrs) {
	this.name = name;
	if(attrs)
		this.attrs = attrs;
	else
		this.attrs = {};
	this.childNodes = [];
}
NodeStr.prototype = {
	appendChild : function(node) {
		this.childNodes.push(node);
		return node;
	},
	setAttribute : function(name, value) {
		this.attrs[name] = value;
	},
	toString : function() {
		var str = '<' + this.name;
		if(this.attrs)
			for(attr in this.attrs)
				str += ' ' + attr + '="' + this.attrs[attr] + '"';
		str += '>';
		for(child in this.childNodes)
			str += this.childNodes[child];

		return str + '</' + this.name + '>';
	}
}

function selectLanguage(lang) {
	window.location = HTTP.setURLParams({'locale':lang});
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
		setURLParams : function(params, url) {
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
			var curParams = HTTP.getURLParams(url);
			for(paramName in params)
				if(params[paramName] instanceof Array)
					curParams[paramName] = params[paramName];
				else
					curParams[paramName] = [params[paramName]];
			return path + HTTP._createQueryString(curParams) + hash;
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


var Form = {
	getForm : function(node) {
		while(node.nodeName.toLowerCase() != 'form')
			node = node.parentNode;
		return node;
	},
	/* Allows an anchor tag or other element to act as a form submission button. Emulates correct
	 * implementation of the DOM Level 2 method HTMLFormElement::submit. All supported browers
	 * implement the submit method consistently incorrect, so duplicate calls to the onsubmit event
	 * listener is not a concern at this time.
	 *
	 * If the parent form has an onsubmit event handler, the handler must return a value that will
	 * resolve to true when the form submission should take place.
	 */
	submit : function(node) {
		var form = Form.getForm(node);
		if(!form.onsubmit || form.onsubmit()) {
			/* Under SSL with server-side HTML generation, submit() will fail when called in
			 * an onclick event handler on anchor tags in IE 6.
			 */
			if(Browser.ie6) {
				window.setTimeout(function() {
					form.submit();
				}, 50);
			} else
				form.submit();
		}
	},
	getFields : function(element) {
		var fields = [];
		var fieldSets = [
			element.getElementsByTagName('input'),
			element.getElementsByTagName('textarea'),
			element.getElementsByTagName('select')
		];

		for(var i = 0, fieldSet; fieldSet = fieldSets[i]; i++)
			for(var j = 0, field; field = fieldSet[j]; j++)
				fields.push(field);

		return fields;
	},
	showFields : function(e) {
		var fields = Form.getFields(e);
		for(field in fields)
			fields[field].disabled = false;
		show(e);
	},
	hideFields : function(e) {
		var fields = Form.getFields(e);
		hide(e);
		for(field in fields)
			fields[field].disabled = true;
	}
}

var CustomSelect = {
	toggleSelect : function(select, optionContainer, visibleClass, hiddenClass, inverse) {
		var optionContainer = $(optionContainer);
		if(inverse ? visibleInverse(optionContainer) : visible(optionContainer))
			CustomSelect._hideSelect(select, optionContainer, hiddenClass, inverse);
		else
			CustomSelect._showSelect(select, optionContainer, visibleClass, inverse);
	},
	hideSelectDelayed : function(index, select, optionContainer, className, inverse, delay) {
		var funcRef = function() {
			CustomSelect._hideSelect(select, optionContainer, className, inverse);
		}
		Timers.set('select' + index, funcRef, delay || 50);
	},
	onblur : function(index, select, optionContainer, className, inverse) {
		if(Browser.opera) // Opera handles focus/blur events differently than other browsers
			return;
		CustomSelect.hideSelectDelayed(index, select, optionContainer, className, inverse);
	},
	cancelHideSelect : function(index) {
		Timers.clear('select' + index);
	},
	cancelHideSelectDelayed : function(index) {
		window.setTimeout(function() {
			CustomSelect.cancelHideSelect(index)
		}, 10);
	},
	_showSelect : function(select, optionContainer, className, inverse) {
		var optionContainer = $(optionContainer);
		$(select).className = className;
		inverse ? setDisplay(optionContainer, 'block') : show(optionContainer);
	},
	_hideSelect : function(select, optionContainer, className, inverse) {
		var optionContainer = $(optionContainer);
		$(select).className = className;
		inverse ? setDisplay(optionContainer, '') : hide(optionContainer);
	}
}
var Timers = {
	set: function(id, code, timeout, allowMultiple) {
		if(Timers[id] != null && !allowMultiple)
			Timers.clear(id);
		Timers[id] = window.setTimeout(code, timeout);
	},
	clear: function(id) {
		window.clearTimeout(Timers[id]);
		Timers[id] = null;
	}
};


var login = {
    disableButton: function(linkClass, parentForm) {
        $j("a." + linkClass, parentForm).addClass("submitDisabled").removeAttr("onclick").html("<span>" + processingStr + "</span>");
    },
	scrollAccept : 
	{
		scroll : function(node, checkboxID)
		{
			var checkbox = document.getElementById(checkboxID);	
	
			//if scrolled to bottom, show/enable checkbox
			if(node.scrollTop >= (node.scrollHeight - node.offsetHeight)){				
				$j(checkbox).removeAttr("disabled","false").css("visibility","visible").parent().addClass("enabled");				
			}
		},
		accept : function(checkbox)
		{						
			$j(checkbox).parent().bind('mousedown', function() { return false } )
			
			if(checkbox.checked)
			{
				$j(checkbox).parent().addClass("accepted");
				
				if(login.scrollAccept.validateCheckboxes(checkbox)){
					$j("a.submit").removeClass("submitDisabled");
					$j("a.submit").click(function(){
						Form.submit(checkbox);
					});
				}				
			}
			//otherwise disable submit button
			else
			{
				$j(checkbox).parent().removeClass("accepted").addClass("enabled");
				$j("a.submit").addClass("submitDisabled");
				$j("a.submit").unbind("click");
			}
			
			return false;
		},
		validateCheckboxes : function(node)
		{
			//check all checkboxes within form
			var form = Form.getForm(node);
			
			var allChecked = true;
			
			$j(".scrollContainer input.legalCheckbox",form).each(function(){
				if(!this.checked){	
					allChecked = false;
					return false;
				}
			});
			
			return allChecked;
		}
	}
}