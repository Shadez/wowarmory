var Browser = {
	a : navigator.userAgent.toLowerCase()
}
Browser = {
	ie : /*@cc_on ! @*/ false,
	ie6 : Browser.a.indexOf('msie 6') != -1,
	ie7 : Browser.a.indexOf('msie 7') != -1,
	opera : !!window.opera,
	safari : Browser.a.indexOf('safari') != -1,
	safari3 : Browser.a.indexOf('applewebkit/5') != -1,
	mac : Browser.a.indexOf('mac') != -1
}
function $blizz(e) {
	if(typeof e == 'string')
		return document.getElementById(e);
	return e;
}
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g, '');
}
function indexOf(array, elt /*, from*/) {
	// SpiderMonkey implementation
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
		elm = doc.createElementNS(xmlns || 'http://www.w3.org/1999/xhtml', name);
	else
		elm = doc.createElement(name);
	if(attrs)
		for(attr in attrs)
			elm.setAttribute(attr, attrs[attr]);
	return elm;
}
function appendText(node, text, replaceNewlines) {
	if(replaceNewlines) {
		var frag = document.createDocumentFragment();
		var lines = text.split(/\n/g);
		for(var i = 0; i < lines.length; i++) {
			frag.appendChild(document.createTextNode(lines[i]))
			if(i < lines.length - 1)
				frag.appendChild(createElement('br'));
		}
		node.appendChild(frag);
	} else
		node.appendChild(document.createTextNode(text));
}
function removeText(parent) {
	var nodes = parent.childNodes;
	for(var node, i = 0; node = nodes[i]; i++) {
		if(node.nodeType == 3 || node.nodeName.toLowerCase() == 'br') { // Node.TEXT_NODE == 3
			parent.removeChild(node);
			i--;
		}
	}
}
function setDisplay(e, display) {
	$blizz(e).style.display = display;
}
function hide(e) {
	setDisplay(e, 'none');
}
function show(e) {
	setDisplay(e, '');
}
function visible(e) {
	return $blizz(e).style.display != 'none';
}
function toggle(e) {
	(visible(e) ? hide : show)(e);
}
function getElementsByClassName(className, element, tagName) { // non live list
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
	return indexOf($blizz(e).className.split(/\s+/), className) > -1;
}
function addClassName(e, className) {
	var e = $blizz(e);
	if(!hasClassName(e, className))
		e.className += (e.className ? ' ' : '') + className;
}
function removeClassName(e, classNames) {
	var e = $blizz(e);
	var classes = e.className.split(/\s+/);
	var rem = classNames.split(/\s+/);
	var ret = [];
	for(var i = 0; i < classes.length; i++)
		if(indexOf(rem, classes[i]) == -1)
			ret.push(classes[i]);
	e.className = ret.join(' ');
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
function bindWithArgs(method, scope, args) { // TODO replace bind()
	if(!args)
		args = [];
	return function() {
		var len = arguments.length;
		var arr = new Array(len);
		while(len--)
			arr[len] = arguments[len];
		return method.apply(scope, args.concat(arr));
	}
}
function bindEventListener(method, scope, args) {
	if(!args)
		args = [];
	return function(event) {
		return method.apply(scope, [(event || window.event)].concat(args));
	}
}
function addEvent(obj, type, func) {
	if(obj.addEventListener) {
		obj.addEventListener(type, func, false);
		return true;
	} else if(obj.attachEvent || Browser.ie)
		return obj.attachEvent('on' + type, func);
	return false;
}
function stopEvent(e) {
	if(e.stopPropagation)
		e.stopPropagation();
	else
		e.cancelBubble = true; // IE
}
function addStylesheet(href, media) {
	document.getElementsByTagName('head')[0].appendChild(createElement('link', {
		rel: 'stylesheet',
		type: 'text/css',
		media: media || 'screen, projection',
		href: href
	}));
}
function loadScript(src, id) {
	var head = document.getElementsByTagName('head')[0];
	var script = createElement('script', {
		'type': 'text/javascript',
		'src': src
	});
	if(id) {
		var old = document.getElementById(id);
		if(old)
			old.parentNode.removeChild(old);
		script.id = id;
	}
	head.appendChild(script);
}
function padLeft(str, len, fillChar) {
	while(str.length < len)
		str = fillChar + str;
	return str;
}
function printf(str) {
	var argc = arguments.length;
	for(var i = 1; i < argc; i++) {
		var re = new RegExp('\\{' + (i-1) + '\\}', 'g');
	    str = str.replace(re, arguments[i]);
	}
	return str;
}
function duplicateNodes(parent, searchClassName, resultClassName, insertAfter) {
	var nodes = getElementsByClassName(searchClassName, parent);
	for(var node, i = 0; node = nodes[i]; i++) {
		var clone = node.cloneNode(true);
		removeClassName(clone, searchClassName);
		addClassName(clone, resultClassName);
		node.parentNode.insertBefore(clone, insertAfter ? node.nextSibling : node);
	}
}
var Timer = {
	_ids: {},
	set: function(id, code, timeout, allowMultiple) {
		if(Timer._ids[id] != null && !allowMultiple)
			Timer.clear(id);
		Timer._ids[id] = window.setTimeout(code, timeout);
	},
	clear: function(id) {
		window.clearTimeout(Timer._ids[id]);
		delete Timer._ids[id];
	}
}
function CustomSelect(handle, options, handleActive, optionsActive, multiClick, closeDelay) {
	this.handle = $blizz(handle);
	this.options = $blizz(options);
	this.closeDelay = closeDelay || CustomSelect.DEFAULT_HIDE_DELAY;
	this.classNames = {
		handleActive: handleActive,
		optionsActive: optionsActive || handleActive
	}
	this.timerId = 'select' +  CustomSelect.instances;
	CustomSelect.instances++;
	CustomSelect._attachEventListeners(this, multiClick);
}
CustomSelect.DEFAULT_HIDE_DELAY = 1000;
CustomSelect.instances = 0;
CustomSelect.openInstance = null;
CustomSelect.init = function(selects) {
	for(var select, i = 0; select = selects[i]; i++)
		new CustomSelect(select[0], select[1], select[2], select[3], select[4], select[5]);
}
CustomSelect._attachEventListeners = function(s, multiClick) {
	var eventListeners = [
		[s.options, 'mousedown', s.cancelCloseDelayed],
		[s.handle,  'mousedown', s.toggle],
		[s.options, 'mouseover', s.cancelClose],
		[s.handle,  'mouseover', s.cancelClose],
		[s.options, 'mouseout',  s.closePassive],
		[s.handle,  'mouseout',  s.closePassive]
	];
	if(!multiClick)
		eventListeners.push([s.options, 'click', s.close]);
	// not implemented: closing options after blur on element within multi-click options node
	eventListeners.push([s.handle, 'blur', s.close]);
	for(var el, i = 0; el = eventListeners[i]; i++)
		addEvent(el[0], el[1], bind(el[2], s));
}
// small delays to account for browsers firing events in different orders
CustomSelect.prototype = {
	toggle: function() {

		this.cancelClose();

		if(this.options.style.display == "block"){
			this._deactivate()
		}else{
			this._activate();
		}
	},
	close: function() {
		this.closePassive(50);
	},
	closePassive: function(delay) {
		Timer.set(this.timerId, bind(this._deactivate, this), delay || this.closeDelay);
	},
	cancelClose: function() {
		Timer.clear(this.timerId);
	},
	cancelCloseDelayed : function() {
		window.setTimeout(bind(this.cancelClose, this), 10);
	},
	_activate: function() {
		if(CustomSelect.openInstance) // deactivate other menu instantly, no delay
			CustomSelect.openInstance._deactivate();
		CustomSelect.openInstance = this;

		this.options.style.display = "block";
	},
	_deactivate: function() {
		if(CustomSelect.openInstance == this)
			CustomSelect.openInstance = null;

		this.options.style.display = "none";
	}
}
var XHR = {
		getJSON: function(uri, preventCaching, callback, errorCallback) {
			// IE 6 compatibility
			var xhr = (typeof XMLHttpRequest != "undefined") ? new XMLHttpRequest() : new window.ActiveXObject("Microsoft.XMLHTTP");
			xhr.open("GET", uri, true);
			if(preventCaching)
				xhr.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4) {
					if(xhr.status == 200 && xhr.responseText) {
						if(callback)
							callback(xhr.responseText);
						else
							eval(xhr.responseText);
					} else if(errorCallback)
						errorCallback(xhr.status);
				}
			}
			xhr.send(null);
		}
	}

function toggle_first(targ)
{
	targ.className = (targ.className.indexOf("open")>1)?"firsts_achievement firsts_closed":"firsts_achievement firsts_open"
}

function fnews_close(targ)
{ gfather = document.getElementById("featured_module")
  thisn = targ.parentNode.parentNode.parentNode
  thisn.parentNode.removeChild(thisn)
  gf = gfather.getElementsByTagName("div"); nentry = new Array();
  for(x=0;x<gf.length;x++){ if(gf[x].className.indexOf("news_mod_entry")>-1) nentry.push(gf[x]); }
  if(!nentry.length) gfather.parentNode.removeChild(gfather)
}

function frst_valid(frm,fld)
{ if(fld.value =='') { fld.style.borderColor='#e00900'; } 
  else { frm.submit(); }
}


//The ARMORY_QUERY object provides Query String parameters to JS
var armory_query = new Object();
if(location.href.indexOf("?") > 0)
{
	try{ 	var qs = location.href.split("?")[1].split("&"); 
			for(i=0; i<qs.length; i++){ armory_query[qs[i].split("=")[0]] = decodeURIComponent(qs[i].split("=")[1]) }
			//console.log(armory_query)
	   } 
	catch(err){}
}

//uses ZeroClipboard in Shared/Third Party to copy data to the clipboard (Assumes source is a form field)
function clipboard_init(target,source) {
	var clip = null;
	clip = new ZeroClipboard.Client();
	clip.setHandCursor( true );
	
	clip.addEventListener('mouseOver', function(){ clip.setText($("#"+source).val());} );
	clip.addEventListener('complete', zClipboard_complete);
	
	clip.glue(target,target+"_container");
}



//boolean for displaying dual tooltips or not
function setDualTooltipCookie() {
    if (document.getElementById('checkboxDualTooltip').checked)
		{ setcookie("armory.cookieDualTooltip", 1);
		  dualTipsEnabled = true;
		}
    else
        { setcookie("armory.cookieDualTooltip", 0);
		  dualTipsEnabled = false; 
		}
}