if(!this['Armory'])
	Armory = {};

Armory.Achievements = {
	init: function(type, mode, characters) {
		Armory.Achievements.isAchievements = type == "achievements";
		Armory.Achievements.dataURI = Armory.Achievements.isAchievements ? "character-achievements.xml" : "character-statistics.xml";

		var modeFunctions = Armory.Achievements.functions[mode];
		for(var funcName in modeFunctions)
			Armory.Achievements[funcName] = modeFunctions[funcName];

		Armory.Achievements.characters = characters;

		for(var i = 0, character, chars = Armory.Achievements.characters, enc = Armory.Achievements.charactersEncoded; character = chars[i]; i++) {
			enc.realms.push(encodeURIComponent(character[0]));
			enc.names.push(encodeURIComponent(character[1]));
		}

		new Armory.DropdownForm($('#achievements-characterCompareEntry > div:last'), $('#achievements-characterCompareEntry > div:first'));
	},
	charactersEncoded: {
		realms: [],
		names: []
	},
	cache: {
		summary: $('#achievements-content .summary')[0],
		loading: $('#achievements-content .loading')[0]
	},
	select: function(node, allowToggle) {
		var siblings = node.parentNode.childNodes;
		for(var sibling, i = 0; sibling = siblings[i]; i++)
			if(sibling.nodeName == node.nodeName && (!allowToggle || sibling != node))
				$(sibling).removeClass('selected');
		$(node).toggleClass('selected');
	},
	toggleCategory: function(node, categoryId, achOpenCallback) {
		Armory.Achievements.select(node);

		if(categoryId == undefined)
			Armory.Achievements.load('summary');
		else {
			var subcats = $('div', node);
			for(var subcat, i = 0; subcat = subcats[i]; i++)
				$(subcat).removeClass('selected');
			Armory.Achievements.load(categoryId, achOpenCallback);
		}
	},
	addCharacter: function(name, realm) {
		if(!jQuery.trim(name).length || !jQuery.trim(realm).length)
			return;

		var enc = Armory.Achievements.charactersEncoded;

		// destructive, but leaving page
		enc.realms.push(encodeURIComponent(realm));
		enc.names.push(encodeURIComponent(name));

		document.location = "?" + Armory.Achievements._getParams();
	},
	openCategory: function(categoryId, categoryIndex, achievementId) {
		var catNavNode = $('.achievements .category-root > div')[categoryIndex];
		Armory.Achievements.toggleCategory(catNavNode, categoryId, function() {
			var achNode = $('#ach' + achievementId);

			// superseded achievement - target parent achievement
			if(achNode.is('li'))
				achNode = achNode.parent().parent();

			// achievement is part of a subcategory - open subcategory
			if(achNode.parent().is(':hidden')) {
				var subcatIndex = achNode.parent().prevAll().length - 1;
				Armory.Achievements.openSubcategory($(catNavNode).find('.nav-subcat')[subcatIndex], subcatIndex + 1);
			}

			achNode.addClass('selected');
			// recent achievements at top, level with nav - no need to call scrollIntoView
		});
	},
	_load: function(container, categoryId, achOpenCallback, append) {
		var cacheEntry = Armory.Achievements.cache[categoryId];

		if(cacheEntry) {
			if(categoryId != 'summary')
				Armory.Achievements._resetRootCategory(cacheEntry);
			container.append(cacheEntry);
			if(achOpenCallback)
				achOpenCallback();
		} else {
			// TODO show error on non HTTP 200 response
			var loadingMsg = Armory.Achievements.cache['loading'];
			var query = Armory.Achievements._getParams() + "&c=" + categoryId;

			loadingMsg.style.display = '';
			container.append(loadingMsg);
			Sarissa.updateContentFromURIMultiRoot(Armory.Achievements.dataURI + "?" + query, container[0],
					function(url, nodes) {
						if(append)
							loadingMsg.parentNode.removeChild(loadingMsg);
						Armory.Achievements.cache[categoryId] = nodes;
						if(achOpenCallback)
							achOpenCallback();
					},
					append);
		}
	},
	_getParams: function() {
		return "r=" + Armory.Achievements.charactersEncoded.realms.join() + "&n=" + Armory.Achievements.charactersEncoded.names.join();
	}
}

Armory.Achievements.functions = {
	single: {
		load: function(categoryId, achOpenCallback) {
			var container = $('#achievements-content');

			container.empty();
			Armory.Achievements._load(container, categoryId, achOpenCallback, false);
		},
		openSubcategory: function(node, position) {
			Armory.Achievements.select(node);
			// only to get to subcategory is to have the parent category open already
			for(var cat, i = 0, subcats = $('#achievements-content > div'); cat = subcats[i]; i++)
				$(cat)[i == position ? 'show' : 'hide']();
			Armory.Achievements._resetCategory(subcats[position]);
		},
		_resetRootCategory: function(nodeList) {
			nodeList[0].style.display = '';
			var resetFuncName = Armory.Achievements.isAchievements ? 'hide' : 'show';

			for(var cat, i = 1; cat = nodeList[i]; i++)
				$(cat)[resetFuncName]();
			Armory.Achievements._resetCategory(nodeList[0]);
		},
		_resetCategory: function(category) {
			var selectedNodes = $('.selected', category);
			for(var node, i = 0; node = selectedNodes[i]; i++)
				$(node).removeClass('selected');
		}
	},
	compare: {
		load: function(categoryId, achievementId) {
			var container = $('#achievements-content');

			while(container[0].tBodies.length)
				container[0].removeChild(container[0].tBodies[0]);

			Armory.Achievements._load(container, categoryId, achievementId, true);
		},
		openSubcategory: function(node, position) {
			Armory.Achievements.select(node);

			for(var cat, i = 0, subcats = $('#achievements-content > tbody'); cat = subcats[i]; i++)
				$(cat)[i == position ? 'show' : 'hide']();
		},
		removeCharacter: function(index) {
			var enc = Armory.Achievements.charactersEncoded;

			enc.names.splice(index, 1); // destructive, but leaving the page
			enc.realms.splice(index, 1);

			document.location = "?" + Armory.Achievements._getParams();
		},
		_resetRootCategory: function(nodeList) {
			nodeList[0].style.display = '';
			var resetFuncName = Armory.Achievements.isAchievements ? 'hide' : 'show';

			for(var cat, i = 1; cat = nodeList[i]; i++)
				$(cat)[resetFuncName]();
		}
	}
}

Armory.DropdownForm = function(handle, content) {
	// TODO listen to document clicks to emulate arbitrary element blur
	this.handle = handle;
	this.content = content;
	this.hasFocus = false;
	this.hasHover = false;
	this.isOpen = false;
	var inputs = content.find('input');

	handle.bind('mousedown', {scope:this,primaryField:inputs[0]}, this.open);
	content.mouseover(bind(this.mouseover, this));
	content.mouseout(bind(this.mouseout, this));
	inputs.focus(bind(this.focus, this));
	inputs.blur(bind(this.blur, this));

	this.timerId = 'Armory.DropdownForm.' +  Armory.DropdownForm.instances;
	Armory.DropdownForm.instances++;
}

Armory.DropdownForm.instances = 0;

// TODO only listen to mouseover/mouseout on relevant nodes
Armory.DropdownForm.prototype = {
	focus: function() {
		this.hasFocus = true;
		this.cancelClose();
	},
	blur: function() {
		this.hasFocus = false;
		if(!this.hasHover)
			this.closeDelayed();
	},
	mouseover: function() {
		this.hasHover = true;
	},
	mouseout: function() {
		this.hasHover = false;
		if(!this.hasFocus)
			this.closeDelayed(1000);
	},
	open: function(e) {
		var scope = e.data.scope;
		if(scope.isOpen)
			scope.close();
		else {
			scope.content.show();
			scope.isOpen = true;
			if(e.data.primaryField) {
				// timeout to work around IE failure to focus when called in mousedown listener
				window.setTimeout(function() { e.data.primaryField.focus() }, 10);
			}
			scope.focus();
			e.preventDefault();
		}
	},
	closeDelayed: function(delay) {
		Timer.set(this.timerId, bind(this.close, this), delay || 100);
	},
	cancelClose: function() {
		Timer.clear(this.timerId);
	},
	close: function() {
		this.content.hide();
		this.isOpen = false;
		this.hasHover = false;
		this.hasFocus = false;
	}
}

Sarissa.updateContentFromURIMultiRoot = function(sFromUrl, oTargetElement, callback, append) {
	var tmpContainer = document.createElement('div');

	Sarissa.updateContentFromURI(sFromUrl, tmpContainer, null, function() {
		var children = [];
		var container = tmpContainer.removeChild(tmpContainer.firstChild);

		if(!append)
			while(oTargetElement.firstChild)
				oTargetElement.removeChild(oTargetElement.firstChild);

		for(var child; child = container.firstChild;) {
			if(child.nodeType == 1) // container.normalize() not effective
				children.push(child);
			oTargetElement.appendChild(child);
		}

		if(callback)
			callback(sFromUrl, children);
	});
}

