/**
* DD_belatedPNG: Adds IE6 support: PNG images for CSS background-image and HTML <IMG/>.
* Author: Drew Diller
* Email: drew.diller@gmail.com
* URL: http://www.dillerdesign.com/experiment/DD_belatedPNG/
* Version: 0.0.3a
* Licensed under the MIT License: http://dillerdesign.com/experiment/DD_belatedPNG/#license
*
* Example usage:
* DD_belatedPNG.addRule('.png_bg'); // argument is a CSS selector
**/

var DD_belatedPNG = {
	ns: 'DD_belatedPNG',
	createVmlNameSpace: function() { /* enable VML */
		if (document.namespaces && !document.namespaces[this.ns]) {
		  document.namespaces.add(this.ns, 'urn:schemas-microsoft-com:vml');
		}
	},
	createVmlStyleSheet: function() { /* style VML, enable behaviors */
		/*
			Just in case lots of other developers have added
			lots of other stylesheets using document.createStyleSheet
			and hit the 31-limit mark, let's not use that method!
			further reading: http://msdn.microsoft.com/en-us/library/ms531194(VS.85).aspx
		*/
		var style = document.createElement('style');
		document.documentElement.firstChild.insertBefore(style, document.documentElement.firstChild.firstChild);
		var styleSheet = style.styleSheet;
		styleSheet.addRule(this.ns + '\\:*', '{behavior:url(#default#VML)}');
		styleSheet.addRule(this.ns + '\\:rect', 'position:absolute;');
		styleSheet.addRule('img.' + this.ns + '_sizeFinder', 'position:absolute; z-index:-1; visibility:hidden;');
		this.styleSheet = styleSheet;
	},
	
	/**
	* This is the method to use in a document.
	* @param {String} selector - REQUIRED - a CSS selector, such as '#doc .container'
	**/
	fix: function(selector) {
		var selectors = selector.split(','); /* multiple selectors supported, no need for multiple calls to this anymore */
		for (var i=0; i<selectors.length; i++) {
			this.styleSheet.addRule(selectors[i], 'behavior:expression(DD_belatedPNG.fixPng.call(this))'); /* seems to execute the function without adding it to the stylesheet - interesting... */
		}
	},
	
	fixPng: function(rad) {
		var lib = DD_belatedPNG;
		this.style.behavior = 'none';
		if (this.nodeName == 'TD' || this.nodeName == 'TR') { /* table elements not supported yet */
			return;
		}
		this.bgSizeFinder = document.createElement('img');
		this.bgSizeFinder.className = lib.ns + '_sizeFinder';
		this.bgSizeFinder.attachEvent('onload', function() {
			self.updateVmlDimensions.call(self);
		});
		document.body.insertBefore(this.bgSizeFinder, document.body.firstChild);
		this.imgRect = document.createElement(lib.ns + ':rect');
		this.imgFill = document.createElement(lib.ns + ':fill');
		this.colorRect = document.createElement(lib.ns + ':rect');
		this.rects = [this.imgRect, this.colorRect];
		for (var r=0; r<2; r++) {
			this.rects[r].stroked = false;
		}
		this.parentNode.insertBefore(this.colorRect, this);
		this.imgRect.appendChild(this.imgFill);
		this.parentNode.insertBefore(this.imgRect, this);
		
		/* methods */
		var self = this;
		this.interceptPropertyChanges = function() {
			if (event.propertyName.search('background') != -1) {
				self.updateVmlFill.call(self);
			}
		};
		this.updateVmlFill = function() {
			var thisStyle = this.currentStyle;
			if (thisStyle.backgroundImage) {
				var knownZ = (thisStyle.zIndex != '0') ? thisStyle.zIndex : -1;
				this.colorRect.style.zIndex = knownZ;
				this.imgRect.style.zIndex = knownZ;
				var giveLayout = function(el) {
					el.style.zoom = 1;
					if (el.currentStyle.position == 'static') {
						el.style.position = 'relative';
					}
				};
				giveLayout(this);
				giveLayout(this.parentNode);
				var bg = thisStyle.backgroundImage;
				bg = bg.split('"')[1];
			}
			if (this.src) {
				var bg = this.src;
			}
			if (thisStyle.backgroundImage || this.src) {
				this.bgSizeFinder.src = bg;
				this.imgFill.src = bg;
				this.imgFill.type = 'tile';
			}
			this.imgRect.filled = true;
			this.colorRect.filled = false;
			this.colorRect.style.backgroundColor = thisStyle.backgroundColor;
			this.runtimeStyle.backgroundImage = 'none';
			this.runtimeStyle.backgroundColor = 'transparent';
			if (this.nodeName == 'IMG') {
				if (thisStyle.position == 'static') {
					this.style.position = 'relative';
				}
				var bAtts = {'Style':true, 'Width':true, 'Color':true};
				for (var b in bAtts) {
					this.imgRect.style['border'+b] = thisStyle['border'+b];
					this.colorRect.style['border'+b] = thisStyle['border'+b];
				}
				this.width = this.clientWidth;
				this.height = this.clientHeight;
				this.style.visibility = 'hidden';
			}
		};
		this.updateVmlDimensions = function() {
			var thisStyle = this.currentStyle;
			var size = {'W':this.clientWidth, 'H':this.clientHeight, 'w':this.bgSizeFinder.width, 'h':this.bgSizeFinder.height, 'L':this.offsetLeft, 'T':this.offsetTop, 'bLW':parseInt(thisStyle.borderLeftWidth), 'bTW':parseInt(thisStyle.borderTopWidth)};
			if (isNaN(size.bLW) || this.nodeName == 'IMG') {size.bLW = 0;} /* contributed: Rémi Prévost, http://ixmedia.com */
			if (isNaN(size.bTW) || this.nodeName == 'IMG') {size.bTW = 0;} /* contributed: Rémi Prévost, http://ixmedia.com */
			if (size.W >= document.body.clientWidth) {--size.W;}
			for (var r=0; r<2; r++) {
				this.rects[r].style.width = size.W + 'px';
				this.rects[r].style.height = size.H + 'px';
				this.rects[r].style.left = (size.L + size.bLW) + 'px';
				this.rects[r].style.top = (size.T + size.bTW) + 'px';
			}
			var bg = {'X':0, 'Y':0};
			var figurePercentage = function(axis, position) {
				var fraction = true;
				switch(position) {
					case 'left':
					case 'top':
						bg[axis] = 0;
						break;
					case 'center':
						bg[axis] = .5;
						break;
					case 'right':
					case 'bottom':
						bg[axis] = 1;
						break;
					default:
						if (position.search('%') != -1) {
							bg[axis] = parseInt(position)*.01;
						}
						else {
							fraction = false;
						}
				}
				var horz = (axis == 'X');
				bg[axis] = Math.ceil(fraction ? ( (size[horz?'W':'H'] * bg[axis]) - (size[horz?'w':'h'] * bg[axis]) ) : parseInt(position));
			};
			for (var b in bg) {
				figurePercentage(b, thisStyle['backgroundPosition'+b]);
			}
			this.imgFill.position = (bg.X/size.W) + ',' + (bg.Y/size.H);
			var bgR = thisStyle.backgroundRepeat;
			var dC = {'T':0, 'R':size.W, 'B':size.H, 'L':0}; // these are defaults for repeat of any kind
			var altC = { 'X': {'b1':'L', 'b2':'R', 'd':'W'}, 'Y': {'b1':'T', 'b2':'B', 'd':'H'} };
			if (bgR != 'repeat') {
				var c = {'T':bg.Y, 'R':bg.X+size.w+((size.bLW==0)?1:0), 'B':bg.Y+size.h, 'L':bg.X+((size.bLW==0)?1:0)}; // these are defaults for no-repeat - clips down to the image location - the parseInt() with the modulo operator is thanks to a rounding error somewhere
				if (bgR.search('repeat-') != -1) {
					var v = bgR.split('repeat-')[1].toUpperCase();
					c[altC[v].b1] = 0;
					c[altC[v].b2] = size[altC[v].d];
				}
				this.imgRect.style.clip = 'rect('+c.T+'px '+c.R+'px '+c.B+'px '+c.L+'px)';
			}
			else {
				this.imgRect.style.clip = 'rect(auto)';
			}
		};
		this.handlePseudoHover = function() {
			setTimeout(function() { /* wouldn't work as intended without setTimeout */
				self.runtimeStyle.backgroundColor = '';
				self.runtimeStyle.backgroundImage = '';
				self.updateVmlFill.call(self);
			}, 1);
		};
		
		/* add change handlers */
		if (this.nodeName == 'A') {
			this.attachEvent('onmouseleave', this.handlePseudoHover);
			this.attachEvent('onmouseenter', this.handlePseudoHover);
		}
		
		/* set up element */
		setTimeout(function() {
			self.updateVmlFill.call(self);
		}, 1);
		
		/* add change handlers */
		this.attachEvent('onpropertychange', this.interceptPropertyChanges);
		var onResize = function() {
			self.updateVmlDimensions.call(self);
		};
		this.attachEvent('onresize', onResize);
		this.attachEvent('onmove', onResize);
	}
};
DD_belatedPNG.createVmlNameSpace();
DD_belatedPNG.createVmlStyleSheet();