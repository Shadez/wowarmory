// Calendar
// constructor
function Calendar(container, detail, detailSimple, dayEvents, dayEventsSelect, yearTitle, monthTitle, filter, confirmDialog, times,
			loadingTarget, blackout,
		classIds, classOrder, types, userTypes, statuses, typeOrder, typeFilter,
		dataURIMonth, dataURIDetail, dataURIDetailAction, dataURIIcon,
		firstDayOfWeek, formatDate, formatTime24, formatTime12, timeFormat24,
		dayStrings, monthStrings, eventOwnerStr, invitedByStr, announcementOwnerStr, createdByStr, classTotalString,
			startStr, endStr, resetStr, resetDescStr, unlockStr, unlockDescStr, errorStr, errorDescStr,
			classStrings, typeStrings, userTypeStrings, statusStrings,
		character,
		changeTitle, renderCallback, eventOverflowStr) {
	this.blackout = $blizz(blackout);
	this.loadingTarget = $blizz(loadingTarget);
	addEvent(this.blackout, 'click', bind(this.hideAll, this));
	this.character = character;
	this.l10n = {
		strings: {
			start: startStr,
			end: endStr,
			reset: resetStr,
			resetDescription: resetDescStr,
			unlock: unlockStr,
			unlockDescription: unlockDescStr,
			days: dayStrings,
			months: monthStrings,
			classTotal: classTotalString,
			eventUserTypes: {},
			eventStatuses: {},
			classes: {},
			owner: {
				announcement: announcementOwnerStr,
				event: eventOwnerStr
			},
			invitedBy: invitedByStr,
			createdBy: createdByStr,
			error: errorStr,
			errorDescription: errorDescStr,
			eventOverflow: eventOverflowStr
		},
		startDay: firstDayOfWeek || 0,
		date: formatDate,
		time24: formatTime24,
		time12: formatTime12,
		time: (timeFormat24 ? formatTime24 : formatTime12)
	}
	this.classes = {
		ids: classIds,
		order: classOrder
	}

	for(var type, i = 0; type = userTypes[i]; i++)
		this.l10n.strings.eventUserTypes[type] = userTypeStrings[i];
	for(var cls, i = 0; cls = statuses[i]; i++){
		this.l10n.strings.eventStatuses[cls] = statusStrings[i];
	}
	for(var cls, i = 0; cls = this.classes.order[i]; i++)
		this.l10n.strings.classes[cls] = classStrings[i];

	this.renderCallback = renderCallback;
	this.changeTitle = changeTitle;
	this.dataURI = {
		month: dataURIMonth,
		detail: dataURIDetail,
		action: dataURIDetailAction,
		icon: dataURIIcon
	}
	this.titles = {
		year: $blizz(yearTitle),
		month: $blizz(monthTitle)
	}
	this.container = $blizz(container);
	this.containerDetail = $blizz(detail);
	this.containerDetailSimple = $blizz(detailSimple);
	this.containerDayEvents = $blizz(dayEvents);
	this.containerDayEventsSelect = $blizz(dayEventsSelect);
	this.containerConfirmDialog = $blizz(confirmDialog);
	this.containerDialogs = this.containerDetail.parentNode; // TODO inconsistent
	this.containerFilter = $blizz(filter);
	this.containerTimes = $blizz(times);
	this.daySummary = {
		date: getElementsByClassName('date', this.containerDayEvents)[0],
		events: getElementsByClassName('events', this.containerDayEvents)[0]
	}
	this.dayEventsSelect = {
		events: getElementsByClassName('events', this.containerDayEventsSelect)[0]
	}
	this.detailSimple = {
		title: getElementsByClassName('title', this.containerDetailSimple)[0],
		description: getElementsByClassName('description', this.containerDetailSimple)[0],
		more: getElementsByClassName('more-info', this.containerDetailSimple)[0]
	}
	var moreInfoTmp = getElementsByClassName('more-info', this.containerDetailSimple);
	if(moreInfoTmp.length)
		this.detailSimple.more = moreInfoTmp[0];
	this.detail = {
		icon: getElementsByClassName('icon', this.containerDetail)[0],
		summary: getElementsByClassName('summary', this.containerDetail)[0],
		description: getElementsByClassName('description', this.containerDetail)[0],
		type: getElementsByClassName('type', this.containerDetail)[0],
		creator: getElementsByClassName('creator', this.containerDetail)[0],
		date: getElementsByClassName('date', this.containerDetail)[0],
		time: getElementsByClassName('time', this.containerDetail)[0],
		participants: getElementsByClassName('participants', this.containerDetail)[0],
		counts: getElementsByClassName('class-icons', this.containerDetail)[0],
		actionGroup: getElementsByClassName('actions', this.containerDetail)[0],
		noactionGroup: getElementsByClassName('noactions', this.containerDetail)[0],		
		actions: {},
		classes: {}
	}
	var tmpActionAnchors = this.detail.actionGroup.getElementsByTagName('a');
	for(var action, i = 0; action = ['accept', 'decline', 'tentative', 'remove', 'signup', 'unsignup'][i]; i++)
		this.detail.actions[action] = tmpActionAnchors[i];
	this.detail.countTotal = getElementsByClassName('total', this.detail.counts)[0];

	for(var cls, i = 0; cls = this.classes.order[i]; i++) {

		var clsicon = createElement('div', {'class':cls});
		var label = createElement('span', {style:'display: none;'});

		clsicon.className = cls; //manually add class cause ie7 sux
		clsicon.appendChild(label);
		this.detail.classes[cls] = clsicon;
		addEvent(clsicon, 'mouseover', bindEventListener(function(e, label) {
			// only show tooltip if it has participants
			if(hasClassName(label.parentNode, 'active')){
				show(label);
			}
		}, this, [label]));
		addEvent(clsicon, 'mouseout', bindEventListener(function(e, label) {
			hide(label);
		}, this, [label]));
		this.detail.counts.insertBefore(clsicon, this.detail.countTotal);
	}

	this.filter = {};

	removeChildren(this.containerFilter);
	for(var type, i = 0; type = typeOrder[i]; i++) {
		this.filter[type] = typeFilter[i];
		var li = createElement('li');
		appendText(li, typeStrings[i]);
		addEvent(li, 'click', bind(this.toggleFilter, this, [li, type]));
		if(typeFilter[i])
			li.className = Calendar.CLASSES.selected;
		this.containerFilter.appendChild(li);
	}
	this.eventTypes = types;
	var tmpTimeOptions = this.containerTimes.getElementsByTagName('li');
	this.times = {
		game: getElementsByClassName('game', this.containerTimes)[0],
		local: getElementsByClassName('local', this.containerTimes)[0],
		options: {
			hour24: tmpTimeOptions[0],
			useLocal: tmpTimeOptions[1]
		}
	}
	if(timeFormat24)
		addClassName(tmpTimeOptions[0], Calendar.CLASSES.selected);

	this.now = new Date();
	this.realmTimezoneCorrection = null;
	this.currentTimezoneCorrection = null;
	this.errorShown = false;
	this.loadingScripts = [];
	this.loadedEvent = null;
	this.loadingEvent = null;
	this.selectedDate = null; // only used when viewing emtpy days
	this.openDialogs = {
		dayEventsSelect: false,
		details: false
	}
	this.useLocalTime = false;
	this.curMonth = new Date();
	this.curMonth.setDate(1);
	this.table = getElementsByClassName('month', this.container)[0];
	this.tbody = this.table.tBodies[0];
	this.titleBase = document.getElementsByTagName('title')[0].innerHTML;
	// object keyed with event id string (user events only)
	this.eventDetailCache = {};
	// object keyed with string YYYYMM with each entry containing a 31 element array
	this.eventCache = {};
	this.eventSpanCache = {};
	// object keyed with string YYYYMM with each entry containing an object corresponding to each event type
	// records time data was loaded, for use with cache expiration if needed
	this.eventDataLoaded = {};

	this.cellTemplate = this.tbody.rows[0].getElementsByTagName('td')[0];

	this._buildHeader();
	this._render();
	show(this.container);
	// defer execution to encourage non-blocking data download
	window.setTimeout(bind(this._loadEventsHelper, this), 100);
}

// static properties and methods
Calendar.INC_RENDER_BUFFER_MS = 250;
Calendar.FAST_JS = !Browser.ie;
Calendar.CACHE_DETAILS = true;
Calendar.MAX_DAY_EVENTS = 4;
Calendar.MAX_DATE_DIFF = 31556926000; // 1 year
Calendar.MIN_DATE_DIFF = -31556926000; // 1 year
Calendar.DAY_EVENTS_RESIZE_THRESHOLD = 2;
//Calendar.MAX_DATA_SCRIPT = 6; // concurrent script tags per data source, up to 12
Calendar.mode = {
	FIXED_6_WK: 0,
	FLEX_MIN_5_WK: 1,
	FLEX: 2
}
Calendar.RENDER_MODE = Calendar.mode.FIXED_6_WK;
Calendar.CLASSES = {
	selected: 'selected',
	loading: 'loading'
}

Calendar.getDayCell = function(e) {
	var currentTarget = e.currentTarget;
	if(!currentTarget) // IE does not support currentTarget, manually bubble to expected node
		return Calendar.getParentCell(e.srcElement);
	return currentTarget;
}
Calendar.getParentCell = function(node) {
	while(node.nodeName.toLowerCase() != 'td')
		node = node.parentNode;
	return node;
}
Calendar.dateMonthComparator = function(d1, d2) {
	var ret = d1.getFullYear() - d2.getFullYear();
	if(ret == 0)
		ret = d1.getMonth() - d2.getMonth();
	return ret;
}
Calendar.dateDayComparator = function(d1, d2) {
	var ret = d1.getFullYear() - d2.getFullYear();
	if(ret == 0) {
		ret = d1.getMonth() - d2.getMonth();
		if(ret == 0)
			ret = d1.getDate() - d2.getDate();
	}
	return ret;
}
Calendar.eventComparator = function(e1, e2) {
	/* Sort order:
	 * events with pending invites before events without them
	 * player created events before anything else
	 * holidays before non-holidays
	 * holiday priority descending
	 * battleground holidays before non-battleground holidays
	 * date ascending
	 * name ascending
	 */
	
	if ((e1.calendarTypeId == 6) && (e2.calendarTypeId == 5)) return -1;
	
	if(e1.status == 'invited' && e2.status != 'invited') return -1;
	if(e1.status != 'invited' && e2.status == 'invited') return 1;
	var e1Type = e1.calendarType;
	var e2Type = e2.calendarType;
	var e1IsPlayer = e1Type == 'player' || e1Type == 'guild' || e1Type == 'guildSignup';
	var e2IsPlayer = e2Type == 'player' || e2Type == 'guild' || e1Type == 'guildSignup';
	if(e1IsPlayer && !e2IsPlayer) return -1;
	if(!e1IsPlayer && e2IsPlayer) return 1;
	var e1Holiday = e1Type == 'holiday' || e1Type == 'holidayWeekly';
	var e2Holiday = e2Type == 'holiday' || e2Type == 'holidayWeekly';
	if(e1Holiday && !e2Holiday) return -1;
	if(!e1Holiday && e2Holiday) return 1;
	var pri1 = e1.priority == undefined ? -1 : e1.priority;
	var pri2 = e2.priority == undefined ? 1 : e2.priority;
	var ret = pri2 - pri1;
	if(ret == 0) {
		if(e1Type == 'bg' && e2Type != 'bg') return -1;
		if(e1Type != 'bg' && e2Type == 'bg') return 1;
		ret = e1.start - e2.start;
		if(ret == 0) {
			if(e1.summary < e2.summary) return -1;
			if(e1.summary > e2.summary) return 1;
		}
	}
	return ret;
}
Calendar.sortMonthEvents = function(days) {
	if(days)
		for(var day = 0; day < days.length; day++)
			Calendar.sortDay(days[day]);
}
Calendar.sortDay = function(dayEvents) {
	if(dayEvents)
		dayEvents.sort(Calendar.eventComparator);
}
Calendar.addCacheEvent = function(cache, event, date) {
	// YYYYMMDD
	var monthKey = date.getFullYear().toString() + date.getMonth().toString();
	var monthEntry = cache[monthKey];
	var dayEntry;

	if(monthEntry)
		dayEntry = monthEntry[date.getDate()];
	else {
		monthEntry = cache[monthKey] = new Array(31); // wasted 1-3 indices is negligible
		dayEntry = monthEntry[date.getDate()];
	}
	if(dayEntry)
		dayEntry.push(event);
	else
		monthEntry[date.getDate()] = [event];
}
Calendar.setStatusStyle = function(node, status) {
	switch(status) {
		case 'available':
		case 'confirmed':
		case 'standby':
		case 'tentative':
			addClassName(node, 'accepted');
		break;
		case 'declined':
		case 'out':
			addClassName(node, 'declined');
		break;
		case 'invited':
			addClassName(node, 'invited');
			
	}
}
Calendar.getOwner = function(eventDetail) {
	if(eventDetail.owner) // guild
		return eventDetail.owner;
	if(eventDetail.invites) // player
		for(var part, i = 0; part = eventDetail.invites[i]; i++)
			if(part.owner)
				return part.invitee;
	return null;
}
// candidates for common functions, used by showDayEvents
Calendar.util = {
	getAbsoluteOffset: function(node, container) { // container assumed to be an offsetParent
		var offset = [0,0];
		while(node && node != container) {
			offset[0] += node.offsetLeft;
			offset[1] += node.offsetTop;
			node = node.offsetParent;
		}
		return offset;
	},
	clamp: function(val, min, max) {
		if(val < min)
			return min;
		if(max !== undefined && val > max)
			return max;
		return val;
	},
	// CSS 3 word-wrap: break-word has limited support
	// inserts zero-width space every 25 chars in a long sequence of non-whitespace characters
	breakLongWords: function(text) {
		return text.replace(/([^\s]{25,}?)(?=[^\s])/g, '$1\u200B');
	}
}

Calendar.prototype = {
	// TODO timezone should be provided at calendar construction to allow correct current day/month/year to be rendered initially
	initTimezone: function(realmUTCOffset) {
		if(this.realmTimezoneCorrection) // should never be called more than once
			return;
		// realmUTCOffset = 18 * 60 * 60 * 1000; // debug
		this.realmTimezoneCorrection = realmUTCOffset + (this.now.getTimezoneOffset() * 60000);
		this.currentTimezoneCorrection = this.realmTimezoneCorrection;
		this.updateTime();
		window.setInterval(bind(this.updateTime, this), 60000);
	},
	updateTime: function() {
		this.now = new Date();
		removeText(this.times.game);
		removeText(this.times.local);
		appendText(this.times.game, this.l10n.time(new Date(this.now.getTime() + this.realmTimezoneCorrection)));
		appendText(this.times.local, this.l10n.time(this.now));
	},
	toggleTimeFormat: function() {
		if(this.l10n.time == this.l10n.time24) {
			this.l10n.time = this.l10n.time12;
			removeClassName(this.times.options.hour24, Calendar.CLASSES.selected);
		} else {
			this.l10n.time = this.l10n.time24;
			addClassName(this.times.options.hour24, Calendar.CLASSES.selected);
		}
		this.updateTime();
		this._resetMonthEvents(true); // TODO OPT change only times instead of re-rendering
		// TODO reset open dialogs
	},
	toggleUseLocalTime: function() {
		this.useLocalTime = !this.useLocalTime;
		(this.useLocalTime ? addClassName : removeClassName)(this.times.options.useLocal, Calendar.CLASSES.selected);
		this.currentTimezoneCorrection = this.useLocalTime ? 0 : this.realmTimezoneCorrection;
		this._rebuildCaches();
		this.updateTime();
		this._resetMonthEvents(true, true);
		this.hideAll();
	},
	changeMonth: function(index, relative) {
		this.errorShown = false;
		if(relative)
			this.curMonth.setMonth(this.curMonth.getMonth() + index);
		else
			this.curMonth.setMonth(index);

		var diffFromNow = this.curMonth.getTime() - this.now.getTime();

		if(diffFromNow > Calendar.MAX_DATE_DIFF) {
			this.curMonth.setTime(this.now.getTime() + Calendar.MAX_DATE_DIFF);
			this.curMonth.setDate(1);
			// TODO disable next month navigation
		} else if(diffFromNow < Calendar.MIN_DATE_DIFF) {
			this.curMonth.setTime(this.now.getTime() + Calendar.MIN_DATE_DIFF);
			this.curMonth.setDate(1);
			// TODO disable prev month navigation
		}

		this.hideAll();

		this._deselectDayOfWeek();
		this._render();
		if(!this._loadEventsHelper() || (Calendar.FAST_JS && this.loadingScripts.length))
			this._resetMonthEvents();
			
			
		$("#loading-icon").animate({opacity:1}, 3500, function() { 
			$("#loading-icon").fadeOut("fast");
		});
	},
	toggleFilter: function(node, type) {
		this.filter[type] = !this.filter[type];
		(this.filter[type] ? addClassName : removeClassName)(node, Calendar.CLASSES.selected);
		this._resetMonthEvents(true, true); // TODO OPT only run if scripts loaded
		if(this.filter[type])
			this._loadEventsHelper();

		this.hideAll();
	},
	eventAction: function(action) {
		var event = this.eventDetailCache[this.loadedEvent.id.toString()];
		
		var allowedActions = (event.calendarType != 'guildSignup') ?  
								this._getAllowedActions(event, this._getSelf(event)) :
								this._getAllowedSignupActions(event, this._getSelf(event));
		
		if(allowedActions && allowedActions[action]) {
			if((event.calendarType == 'guildSignup') && (action == "unsignup"))
				action = "remove";
			addClassName(this.loadingTarget, Calendar.CLASSES.loading);			
			XHR.getJSON(this.dataURI.action('eventActionCallback', this.loadedEvent.id, action));
		}
	},
	eventActionCallback: function(data) {
		removeClassName(this.loadingTarget, Calendar.CLASSES.loading); // not accurate if multiple clicks occurred
		if((!data.status) && (data.action != 'spam'))
			return; // ignore failed actions
		var event = this.eventDetailCache[data.eventId.toString()];
		if(!event)
			return; // invalid id, ignore
			
		var selfEntry; 
		
		if(event.calendarType == 'guildSignup'){
			selfEntry = { status: '' };
		}else{
			selfEntry = this._getSelf(event);
		}

		switch(data.action) {
			case 'signup':			
				selfEntry.status = 'available';
				var monthEvent = this._getMonthEvent(event);
				if(monthEvent)
					monthEvent.status = 'available';
			break;
			case 'accept':
				selfEntry.status = 'available';
				var monthEvent = this._getMonthEvent(event);
				if(monthEvent)
					monthEvent.status = 'available';
			break;
			case 'decline':
				selfEntry.status = 'declined';
				var monthEvent = this._getMonthEvent(event);
				if(monthEvent)
					monthEvent.status = 'declined';
			break;
			case 'tentative':
				selfEntry.status = 'tentative';
				var monthEvent = this._getMonthEvent(event);
				if(monthEvent)
					monthEvent.status = 'tentative';
			break;
			case 'spam':
				show(this.containerConfirmDialog);
				this._dialogOpened('confirm');
				// fallthrough
			case 'remove':
				if(event.calendarType != 'guildSignup'){
					this._removeEvent(event);
				}else{
					this.hideDetail();
					selfEntry.status = 'declined';
					var monthEvent = this._getMonthEvent(event);
					if(monthEvent)
						monthEvent.status = '';
					
				}
			break;
		}

		this._resetParticipantList(event);
		this._resetEventActions(event, selfEntry);
		if(this.openDialogs.dayEventsSelect) {
			var eventDate = this._getDate(event.start);
			this._resetDayEventsSelect(eventDate);
		}
		this._resetMonthEvents(true, true); // TODO OPT only need to re-render affected event
	},
	loadEvents: function(cal) {
		var dateKey = cal.year.toString() + (cal.month - 1);
		var scriptKey = dateKey + cal.calendarType;
		var lastUpdated = this.eventDataLoaded[dateKey];
		
		if(this.realmTimezoneCorrection == null)
			this.initTimezone(cal.tz);

		// if script loaded, remove from expected data script list
		for(var key, i = 0; key = this.loadingScripts[i]; i++)
			if(key == scriptKey)
				this.loadingScripts.splice(i--, 1);
		if(!this.loadingScripts.length)
			removeClassName(this.loadingTarget, Calendar.CLASSES.loading);

		if(!lastUpdated)
			lastUpdated = this.eventDataLoaded[dateKey] = {};
		else if(lastUpdated[cal.calendarType]) // duplicate data, ignore
			return;
		lastUpdated[cal.calendarType] = (new Date()).getTime();

		if(cal.events.length) {
			for(var event, i = 0; event = cal.events[i]; i++) {
				var eventDate = this._getDate(event.start);
				
				// create end event
				if(this._showEndDate(event)) {
					var newEvent = {}; // shallow clone, could be optimized to not need clone

					for(field in event)
						if(field != 'end')
							newEvent[field] = event[field];
					newEvent.start = event.end; // hack
					newEvent.isEnd = true;
					newEvent.summary = printf(this.l10n.strings.end, event.summary);
					event.summary = printf(this.l10n.strings.start, event.summary);
					Calendar.addCacheEvent(this.eventCache, newEvent, this._getDate(event.end));

					this._addSpanCache(event);
				}

				Calendar.addCacheEvent(this.eventCache, event, this._getDate(event.start));
			}

			Calendar.sortMonthEvents(this.eventCache[dateKey]);
			Calendar.sortMonthEvents(this.eventSpanCache[dateKey]);
		}

		// TODO timer ids should be unique to this calendar instance
		// TODO OPT only re-render if loaded data is in view
		if(this.loadingScripts.length)
			Timer.set("Calendar.render", bind(this._resetMonthEvents, this, [true]), Calendar.INC_RENDER_BUFFER_MS);
		else {
			Timer.clear("Calendar.render");
			this._resetMonthEvents(true, true); // clear styles - sorting may have occurred
		}
	},
	selectEvent: function(e, event) {
		var currentTarget = e.currentTarget;
		if(!currentTarget) { // IE does not support currentTarget, manually bubble to expected node
			currentTarget = e.srcElement;
			while(currentTarget.nodeName.toLowerCase() != 'div')
				currentTarget = currentTarget.parentNode;
		}

		stopEvent(e);
		this._activateDetail(currentTarget, event);
		this._activateDay(Calendar.getParentCell(currentTarget));
	},
	selectEventIndirect: function(event, node) {
		this._deselectDayEventsSelect();
		addClassName(node, Calendar.CLASSES.selected);
		this._selectEventIndirectHelper(event);
	},
	showDayEvents: function(e, date) {
		var dayEvents = this._getDayEvents(date);

		if(!dayEvents)
			return;

		var items = [];
		
		this._eachFilteredEvent(dayEvents, function(event) {
			var item = this._buildEventListItem(event, "10px");	
			
			switch(event.calendarType) {
				case 'player':
					var info = createElement('div');

					// if inviter is not defined, it's self
					if(event.inviter === undefined)
						appendText(info, this.l10n.strings.owner.event);
					else
						appendText(info, printf(this.l10n.strings.invitedBy, event.inviter));
					item.appendChild(info);
				break;
				case 'guild':
					var info = createElement('div');
					// if owner is not defined, it's self
					if(event.owner === undefined){
						appendText(info, this.l10n.strings.owner.announcement);
					}else{
						appendText(info, printf(this.l10n.strings.createdBy, event.owner));
					}
					item.appendChild(info);
				break;
				case 'guildSignup':
					var info = createElement('div');
					// if owner is not defined, it's self
					if(event.inviter === undefined)
						appendText(info, this.l10n.strings.owner.event);
					else
						appendText(info, printf(this.l10n.strings.invitedBy, event.inviter));
					item.appendChild(info);
				break;
			}
			items.push(item);
		});

		// assumes tooltip positioned absolutely relative to this.container
		if(items.length) {
			var target = Calendar.getDayCell(e);
			var offset = Calendar.util.getAbsoluteOffset(target, this.container);

			removeChildren(this.daySummary.events);
			this.daySummary.date.innerHTML = this.l10n.date(date);

			var itemCtr = 0;
			//limit the number of events shown in the tooltip to 5
			for(var item, i = 0; item = items[i]; i++){				
				if(itemCtr <= 4)
					this.daySummary.events.appendChild(item);				
				
				itemCtr++;
				
				if(itemCtr == 5){
					var explainDiv = document.createElement("div");
					explainDiv.innerHTML = "<span style='color: white'>"+this.l10n.strings.eventOverflow+"</span>";
					this.daySummary.events.appendChild(explainDiv);	
				}
			}

			show(this.containerDayEvents); // must show first to calculate height
			var calTipLeft = findPosX(target) - findPosX(this.container);
			var calTipTop  = findPosY(target) - this.containerDayEvents.offsetHeight - 320;

			var windowWidth = 0, windowHeight = 0;
			if(typeof(window.innerWidth) == 'number'){
				windowWidth = window.innerWidth;
				windowHeight = window.innerHeight;
			}else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
				windowWidth = document.documentElement.clientWidth;
				windowHeight = document.documentElement.clientHeight;
			}else if(document.body && (document.body.clientWidth || document.body.clientHeight)) {
				windowWidth = document.body.clientWidth;
				windowHeight = document.body.clientHeight;
			}

			if((calTipLeft + this.containerDayEvents.offsetWidth + 30) > windowWidth){
				calTipLeft = calTipLeft - 	this.containerDayEvents.offsetWidth;
			}

			this.containerDayEvents.style.left = calTipLeft + 'px';
			this.containerDayEvents.style.top = calTipTop + 'px';

		}
	},
	showDayEventsSelect: function(e, date) {
		stopEvent(e);
		this._resetDayEventsSelect(date);
		this._dialogOpened('dayEventsSelect');
		show(this.containerDayEventsSelect);
	},
	hideAll: function() {
		this.hideDetail();
		this.hideDayEventsSelect();
		this.hideConfirmation();
	},
	hideDayEventsSelect: function() {
		this._dialogClosed('dayEventsSelect');
		hide(this.containerDayEventsSelect);
	},
	hideConfirmation: function() {
		hide(this.containerConfirmDialog);
		this._dialogClosed('confirm');
	},
	hideDayEvents: function(e) {
		hide(this.containerDayEvents);
	},
	hideDetail: function() {
		this._dialogClosed('details');
		this._deselectDayEventsSelect();
		this.loadedEvent = null;
		this.loadingEvent = null;
		this._deselectEvents();
		hide(this.containerDetail);
		hide(this.containerDetailSimple);
	},
	loadEventDetailSimple: function(event) {
		removeChildren(this.detailSimple.description);
		removeText(this.detailSimple.title);
		var description = event.description;
		switch(event.calendarType) {
			case 'raidReset':
				description = printf(this.l10n.strings.resetDescription, description, this.l10n.time(this._getDate(event.start)));
				break;
			case 'raidLockout':
				description = printf(this.l10n.strings.unlockDescription, description, this.l10n.time(this._getDate(event.start)));
				break;
		}
		appendText(this.detailSimple.description, Calendar.util.breakLongWords(description), true);
		
		if (event.summary.length > 36) { 
			event.summary = event.summary.substring(0,36) + "...";
		}
		
		appendText(this.detailSimple.title, event.summary, true);
		if(this.detailSimple.more) {
			var path;
			//if(Calendar.eventLinksBase && Calendar.eventLinks && (path = Calendar.eventLinks[event.icon])) { 
			if (event.key != "undefined") {
				var anchor = this.detailSimple.more.getElementsByTagName('a')[0];
				anchor.href = Calendar.eventLinksBase + Calendar.eventLinks["Calendar_"+event.key];
				show(this.detailSimple.more);
			} else
				hide(this.detailSimple.more);
		}
		hide(this.containerDetail);
		this._dialogOpened('details');
		show(this.containerDetailSimple);
	},
	loadEventDetail: function(event) {
		// another event has already been selected, or dialog has been closed, ignore
		if(!this.loadingEvent || this.loadingEvent.id != event.id)
			return;
		this.loadingEvent = null;
		var eventDate = this._getDate(event.start);

		if(event.id)
			this.eventDetailCache[event.id.toString()] = event;

		//hide buttons
		this.detail.actionGroup.style.display = "none";
		this.detail.noactionGroup.style.display = "none";		

		
		removeChildren(this.detail.summary);
		removeChildren(this.detail.description);
		removeChildren(this.detail.type);
		removeChildren(this.detail.creator);
		removeChildren(this.detail.date);
		removeChildren(this.detail.time);

		this.detail.icon.style.backgroundImage = 'url(' + this.dataURI.icon(event, null, true) + ')';
		appendText(this.detail.summary, event.summary);
		appendText(this.detail.description, Calendar.util.breakLongWords(event.description), true);

		if(event.location)
			if (event.mode)
				appendText(this.detail.type, event.location + " (" + event.mode +")");
			else
			appendText(this.detail.type, event.location);
		else
			appendText(this.detail.type, this.l10n.strings.eventUserTypes[event.type]);


		(event.locked ? addClassName : removeClassName)(this.containerDetail, 'locked');
		appendText(this.detail.creator, printf(this.l10n.strings.createdBy, Calendar.getOwner(event)));
		appendText(this.detail.date, this.l10n.date(eventDate));
		appendText(this.detail.time, this.l10n.time(eventDate));

		(event.calendarType == 'guild' ? addClassName : removeClassName)(this.containerDetail, 'guild');


		

		if(event.invites) {
			var selfEntry = this._resetParticipantList(event);
			this._resetEventActions(event, selfEntry);
		}

		hide(this.containerDetailSimple);

		this._dialogOpened('details');
		show(this.containerDetail);

		removeClassName(this.containerDetail, Calendar.CLASSES.loading);

		if(event.calendarType == 'guild'){
			this.detail.actionGroup.style.display = "none";
			this.detail.noactionGroup.style.display = "none";					
		}

	},
	selectDay: function(e, date) {
		var targetCell = Calendar.getDayCell(e);
		var dayEvents = this._getDayEvents(date);
		var targetEvent;

		this.selectedDate = date;
		this.loadedEvent = null;
		this._deselectEvents();
		this._activateDay(targetCell);

		// select the first event of the day
		if(dayEvents) {
			this._eachFilteredEvent(dayEvents, function(event) {
				targetEvent = event;
				return true;
			});
		}
		if(targetEvent)
			this._activateDetail(getElementsByClassName('event', targetCell)[0], targetEvent);
		else
			this.hideDetail();
	},
	_getAllowedActions: function(event, selfEntry) {
		// no actions allowed if you are not a participant or you are the owner
		if(!selfEntry || this._isSelf(event.owner))
			return null;

		var actions = {remove:true};

		if(event.spam)
			actions.spam = true;
		if(!event.locked && this.now.getTime() < event.start) {
			var status = selfEntry.status;
			actions.accept = status == 'invited' || status == 'declined' || status == 'tentative';
			actions.decline = status == 'invited' || status == 'available' || status == 'tentative';
			actions.tentative = status == 'invited' || status == 'available' || status == 'declined';
		}
		return actions;
	},
	_getAllowedSignupActions: function(event, selfEntry) {
		
		if(this._isSelf(event.owner))
			return null;		
		
		var actions = {remove:false, accept: false, decline: false, tentative:false, signup: true, unsignup: false};
		if(this.now.getTime() > event.start) {
			actions.signup = false;
		}

		if(selfEntry && selfEntry.status != "available"){
			actions.signup = false;
			actions.unsignup = true;
		}
		
		return actions;		
	},
	_getDate: function(epoch) { // hack to emulate support for different timezone in Date - ignore the timezone in this object
		return new Date(epoch + this.currentTimezoneCorrection);
	},
	_activateDay: function(targetCell) {
		this._deselectDays();
		this._deselectDayOfWeek();

		addClassName(targetCell, Calendar.CLASSES.selected);

		var dayOfWeek = 0;
		// no need to normalize for whitespace since created dynamically
		for(; targetCell != targetCell.parentNode.childNodes[dayOfWeek] && dayOfWeek < 7; dayOfWeek++);
		addClassName(this.table.tHead.rows[0].cells[dayOfWeek], Calendar.CLASSES.selected);
	},
	_activateDetail: function(target, event) {
		this._activateDetailHelper(event);
		addClassName(target, Calendar.CLASSES.selected);
	},
	_activateDetailHelper: function(event) {
		if(event == this.loadedEvent) // already loaded and visible
			return;

		this.loadedEvent = event;
		this.selectedDate = null;

		this._deselectEvents();
		this.loadingEvent = event;

		switch(event.calendarType) {
			case 'guildSignup':
			case 'player':
			case 'guild':
				if(Calendar.CACHE_DETAILS) {
					var eventDetailCacheEntry = this.eventDetailCache[event.id.toString()];
					if(eventDetailCacheEntry) {
						this.loadEventDetail(eventDetailCacheEntry);
						return;
					}
				}
				removeChildren(this.detail.description);
				addClassName(this.containerDetail, Calendar.CLASSES.loading);

				hide(this.containerDetailSimple);
				this._dialogOpened('details');
				show(this.containerDetail);

				(event.calendarType == 'guild' ? addClassName : removeClassName)(this.containerDetail, 'guild');


				XHR.getJSON(this.dataURI.detail('loadEventDetail', event.id), false, null, bindWithArgs(this._errorHandler, this, [true, null]));
			break;
			default:
				this.loadEventDetailSimple(event);
		}
	},
	// note browser may complete call to loadEvents before this function returns
	_loadEventsHelper: function() {
		var loadingScripts = false;
		var dates = [
		             this.curMonth,
		             new Date(this.curMonth.getFullYear(), this.curMonth.getMonth() + 1, 1),
		             new Date(this.curMonth.getFullYear(), this.curMonth.getMonth() - 1, 1)
		             ];
		this.loadingScripts = [];

		for(var date, i = 0; date = dates[i]; i++) {
			var year = date.getFullYear();
			var month = date.getMonth();
			var lastUpdated = this.eventDataLoaded[year.toString() + month];

			for(var type, j = 0; type = this.eventTypes[j]; j++) {
				// load only once (timestamp ignored)
				if(this._isFilterActive(type) && (!lastUpdated || !lastUpdated[type])) {
					var scriptKey = year.toString() + month.toString() + type;
					addClassName(this.loadingTarget, Calendar.CLASSES.loading);
					this.loadingScripts.push(scriptKey);
					loadingScripts = true;
					XHR.getJSON(this.dataURI.month('loadEvents', year, month, type), false, null, bindWithArgs(this._errorHandler, this,
							[false, scriptKey]));
				}
			}
		}
		
		if(!this.loadingScripts.length)
			removeClassName(this.container, Calendar.CLASSES.loading);
		return loadingScripts;
	},
	_selectEventIndirectHelper: function(event) {
		var eventDate = this._getDate(event.start);
		var dayEvents = this._getDayEvents(eventDate);
		var cell = this._getCellForDate(eventDate);

		if(cell) {
			this._eachFilteredEvent(dayEvents, function(dayEvent, numDisplayedEvents) {
				if(dayEvent == event) {
					if(numDisplayedEvents > Calendar.MAX_DAY_EVENTS)
						this._activateDetailHelper(event);
					else
						this._activateDetail(getElementsByClassName('event', cell)[numDisplayedEvents - 1], event);
					return true;
				}
			});
			this._activateDay(cell);
			return true;
		}
		return false;
	},
	_buildHeader: function() {
		var row = this.table.tHead.rows[0];
		removeChildren(row);
		for(var i = 0; i < 7; i++) {
			var cell = createElement('th');
			appendText(cell, this.l10n.strings.days[(i + this.l10n.startDay) % 7]);
			row.appendChild(cell);
		}
	},
	_render: function() {
		var daysInMonths = this._getDaysInMonths();
		var dowOffset = this._getDayOfWeekOffset();

		this.titles.month.innerHTML = this.l10n.strings.months[this.curMonth.getMonth()];
		this.titles.year.innerHTML = this.curMonth.getFullYear();

		if(this.changeTitle)
			document.title = this.titleBase + " - " + this.l10n.strings.months[this.curMonth.getMonth()] + " " + this.curMonth.getFullYear();

		removeChildren(this.tbody);

		var numWeeks;
		switch(Calendar.renderMode) {
			case Calendar.mode.FIXED_6_WK:
			default:
				numWeeks = 6;
		}

		for(var week = 0; week < numWeeks; week++) {
			var row = this.tbody.insertRow(-1);
			for(var dow = 0; dow < 7; dow++) {
				var day = week * 7 + dow - dowOffset + 1;
				var cell = this.cellTemplate.cloneNode(true);
				var targetDate;

				if(day <= 0) {
					day = daysInMonths[0] + dow - dowOffset + 1;
					targetDate = new Date(this.curMonth.getFullYear(), this.curMonth.getMonth() - 1, day);
					cell.className = 'previous';
				} else if(day > daysInMonths[1]) {
					day -= daysInMonths[1];
					targetDate = new Date(this.curMonth.getFullYear(), this.curMonth.getMonth() + 1, day);
					cell.className = 'next';
				} else
					targetDate = new Date(this.curMonth.getFullYear(), this.curMonth.getMonth(), day);

				appendText(getElementsByClassName('day-date', cell)[0], day);

				addEvent(cell, 'click', bindEventListener(this.selectDay, this, [targetDate]));
				addEvent(cell, 'mouseover', bindEventListener(this.showDayEvents, this, [targetDate]));
				addEvent(cell, 'mouseout', bindEventListener(this.hideDayEvents, this));
				row.appendChild(cell);
			}
		}

		var tempCell = this._getCellForDate(this.now);
		if(tempCell)
			addClassName(tempCell, 'today');

		if(this.renderCallback)
			this.renderCallback(this.tbody);
	},
	_resetMonthEvents: function(cleanEvents, cleanStyles) {
		var dowOffset = this._getDayOfWeekOffset();
		var cells = this.tbody.getElementsByTagName('td');

		if(cleanStyles) {
			for(var node, i = 0; node = cells[i]; i++)
				removeClassName(node, 'compact invited hasevents');
			var bgNodes = getElementsByClassName('day-background', this.tbody).concat(getElementsByClassName('day-deco-event', this.tbody));
			for(var node, i = 0; node = bgNodes[i]; i++)
				node.style.backgroundImage = '';
		}

		if(cleanEvents)
			this._clearEvents();

		// optimization: include only 1 week before, 2 weeks after
		for(var mo = this.curMonth.getMonth() - 1; mo <= this.curMonth.getMonth() + 1; mo++) {
			// account for year change threshold
			var tempDate = new Date(this.curMonth.getFullYear(), mo, 1);
			var monthKey = tempDate.getFullYear().toString() + tempDate.getMonth().toString();
			var monthEntry = this.eventCache[monthKey];
			var monthSpanEntry = this.eventSpanCache[monthKey];

			if(monthEntry) {
				var daysInMonths = this._getDaysInMonths();
				var cells = this.tbody.getElementsByTagName('td');
				var visibleBackground = new Array(31);

				for(var day = 0; day < monthEntry.length; day++) {
					var dayEntry = monthEntry[day];
					if(dayEntry && dayEntry.length) {
						var targetIndex = day + dowOffset - 1;
						var monthCompare = Calendar.dateMonthComparator(tempDate, this.curMonth);
						if(monthCompare == -1)
							targetIndex -= daysInMonths[0];
						else if(monthCompare == 1)
							targetIndex += daysInMonths[1];

						if(targetIndex >= 0 && targetIndex < cells.length) {
							var targetCell = cells[targetIndex];
							var targetCellContent = getElementsByClassName('day-content', targetCell)[0];
							var firstEvent;
							// _appendEventNode defined externally to avoid closure memory overhead
							var numDisplayedEvents = this._eachFilteredEvent(dayEntry, this._appendEventNode, [targetCell, targetCellContent]);

							if(numDisplayedEvents) {
								addClassName(targetCell, 'hasevents');
								if(numDisplayedEvents > Calendar.DAY_EVENTS_RESIZE_THRESHOLD) {
									addClassName(targetCell, 'compact');
									if(numDisplayedEvents > Calendar.MAX_DAY_EVENTS) {
										var dropIcon = createElement('div');
										dropIcon.className = 'dropicon';
										addEvent(dropIcon, 'click', bindEventListener(this.showDayEventsSelect, this,
												[new Date(tempDate.getFullYear(), tempDate.getMonth(), day)]));
										targetCellContent.insertBefore(dropIcon, targetCellContent.getElementsByTagName('div')[0]);
									}
								}

								this._eachFilteredEvent(dayEntry, function(event) {
									if(event.icon != undefined) {
										var iconPath = this.dataURI.icon(event);
										
										if(iconPath) {
											visibleBackground[day] = event.icon;
											if(Browser.ie6) {
												getElementsByClassName('day-background', targetCell)[0].style.filter =
														"progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='" + iconPath+ "')";
											} else {
												getElementsByClassName('day-background', targetCell)[0].style.backgroundImage =
														'url(' + iconPath + ')';
											}
										}
									}
									return true;
								});
							}
						}
					}
				}

				// span possible iff month entry exists
				if(monthSpanEntry) {
					for(var day = 0; day < monthSpanEntry.length; day++) {
						var dayEntry = monthSpanEntry[day];
						if(dayEntry && dayEntry.length) {
							var targetIndex = day + dowOffset - 1;
							var monthCompare = Calendar.dateMonthComparator(tempDate, this.curMonth);
							if(monthCompare == -1)
								targetIndex -= daysInMonths[0];
							else if(monthCompare == 1)
								targetIndex += daysInMonths[1];

							if(targetIndex >= 0 && targetIndex < cells.length) {
								var targetCell = cells[targetIndex];

								this._eachFilteredEvent(dayEntry, function(event, i) {
									if(event.icon != undefined && event.icon != visibleBackground[day]) {
										var iconPath = this.dataURI.icon(event, true);
										if(iconPath) {
											if(Browser.ie6) {
												getElementsByClassName('day-deco-event', targetCell)[0].style.filter =
														"progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='" + iconPath + "')";
											} else {
												getElementsByClassName('day-deco-event', targetCell)[0].style.backgroundImage = 'url(' + iconPath + ')';
											}
										}
									}

									return true;
								});
							}
						}
					}
				}
			}
		}

		// Carry over selected event or empty day between next/prev month, otherwise deselect
		if(this.loadedEvent && !this._selectEventIndirectHelper(this.loadedEvent)) {
			this.loadedEvent = null;
			this._deselectDays();
			this.hideDetail();
		} else if(this.selectedDate) {
			var cell = this._getCellForDate(this.selectedDate);
			if(cell)
				this._activateDay(cell);
			else
				this.selectedDate = null;
		}
	},
	_resetDayEventsSelect: function(date) {
		var dayEvents = this._getDayEvents(date);

		if(dayEvents && dayEvents.length) {
			removeChildren(this.dayEventsSelect.events);
			this._eachFilteredEvent(dayEvents, function(event) {				
				var item = this._buildEventListItem(event,"0px");
				addEvent(item, 'click', bind(this.selectEventIndirect, this, [event, item]));
				if(this.loadedEvent == event)
					item.className = Calendar.CLASSES.selected;
				this.dayEventsSelect.events.appendChild(item);
			});
		}
	},
	_clearEvents: function() {
		var contents = getElementsByClassName('day-content', this.tbody);
		for(var c, i = 0; c = contents[i]; i++) {
			var divs = c.getElementsByTagName('div');
			while(divs.length)
				divs[0].parentNode.removeChild(divs[0]);
		}
	},
	_appendEventNode: function(event, numDisplayedEvents, targetCell, targetCellContent) {
		if(numDisplayedEvents > Calendar.MAX_DAY_EVENTS)
			return true;
		var entry = createElement('div');
		entry.className = 'event';
		entry.appendChild(this._getSummaryNode(event));
		switch(event.calendarType) {
			case 'guildSignup':
			case 'player':
			case 'guild':
				var eventDate = this._getDate(event.start);
				var time = createElement('span');
				time.className = 'time';
				appendText(time, this.l10n.time(eventDate));
				entry.appendChild(time);
				addClassName(entry, 'player-event');

				if((event.moderator) || (event.calendarType == 'guild')){
					addClassName(entry, 'moderator');
				}
				else if(event.status) {
					Calendar.setStatusStyle(entry, event.status);
					if(event.status == 'invited' && this.now.getTime() < event.start)
						addClassName(targetCell, 'invited');
				}
			break;
		}
		addEvent(entry, 'click', bindEventListener(this.selectEvent, this, [event]));
		targetCellContent.appendChild(entry);
	},
	_deselectDayOfWeek: function() {
		for(var cell, i = 0; cell = this.table.tHead.rows[0].cells[i]; i++)
			removeClassName(cell, Calendar.CLASSES.selected);
	},
	_deselectDays: function() {
		for(var row, i = 0; row = this.tbody.rows[i]; i++)
			for(var cell, j = 0; cell = row.cells[j]; j++)
				removeClassName(cell, Calendar.CLASSES.selected);
	},
	_deselectEvents: function() {
		var events = this.tbody.getElementsByTagName('div');
		for(var event, i = 0; event = events[i]; i++)
			removeClassName(event, Calendar.CLASSES.selected);
	},
	_deselectDayEventsSelect: function() {
		var lis = getElementsByClassName(Calendar.CLASSES.selected, this.dayEventsSelect.events);
		for(var li, i = 0; li = lis[i]; i++)
			removeClassName(li, Calendar.CLASSES.selected);
	},
	_getDayEvents: function(date) {
		var monthEvents = this.eventCache[date.getFullYear().toString() + date.getMonth().toString()];
		if(!monthEvents)
			return null;
		return monthEvents[date.getDate()];
	},
	// index 0: previous month, index 1: current month
	_getDaysInMonths: function(date) {
		var date = date || this.curMonth;
		return [
		        (new Date(date.getFullYear(), date.getMonth(), 0)).getDate(),
		        (new Date(date.getFullYear(), date.getMonth() + 1, 0)).getDate()
		        ];
	},
	_getDayOfWeekOffset: function() {
		function normalizeInt(val, max) {
			return val < 0 ? max + val % max : val % max;
		}
		return normalizeInt(this.curMonth.getDay() - this.l10n.startDay, 7);
	},
	_getCellForDate: function(date) {
		var monthDiff = (date.getFullYear() - this.curMonth.getFullYear()) * 12 + date.getMonth() - this.curMonth.getMonth();
		var targetIndex = date.getDate() + this._getDayOfWeekOffset() - 1;

		if(monthDiff == -1)
			targetIndex -= this._getDaysInMonths()[0];
		else if(monthDiff == 1)
			targetIndex += this._getDaysInMonths()[1];
		else if(monthDiff != 0)
			return null;

		var cells = this.tbody.getElementsByTagName('td');
		if(targetIndex < 0 || targetIndex >= cells.length)
			return null;

		return cells[targetIndex];
	},
	_buildEventListItem: function(event, timePadding) {
		var eventDate = this._getDate(event.start);
		var item = createElement('li');
		var time = createElement('span');
		var summary = this._getSummaryNode(event);
		time.className = 'time';
		time.style.marginLeft = timePadding;
		
		appendText(time, this.l10n.time(eventDate));
		item.appendChild(summary);
		item.appendChild(time);

		if(event.moderator)
			addClassName(summary, 'moderator');
		else if(event.status){
			Calendar.setStatusStyle(summary, event.status);
		}

		return item;
	},
	_getSummaryNode: function(event) {
		var summaryNode = createElement('span');
		summaryNode.className = 'summary';
		var summary = event.summary;
		switch(event.calendarType) {
			case 'raidReset':
				summary = printf(this.l10n.strings.reset, summary);
				break;
			case 'raidLockout':
				summary = printf(this.l10n.strings.unlock, summary);
				break;
		}
		appendText(summaryNode, summary);
		return summaryNode;
	},
	_isFilterActive: function(type) {
		// by default an undefined filter is considered visible
		return this.filter[type] || this.filter[type] === undefined;
	},
	// func preserves "this" scope
	// func can return true to break loop
	// arguments at index 0 and 1 are the event and loop iteration, respectively
	_eachFilteredEvent: function(events, func, extraArgs) {
		var numFilteredEvents = 0;
		for(var event, i = 0; event = events[i]; i++) {
			if(this._isFilterActive(event.calendarType)) {
				numFilteredEvents++;
				var args = [event, numFilteredEvents];
				if(extraArgs)
					args = args.concat(extraArgs);
				if(func.apply(this, args))
					break;
			}
		}
		return numFilteredEvents;
	},
	_isSelf: function(character) {
		return character.toLowerCase() == this.character.toLowerCase();
	},
	_resetParticipantList: function(eventDetail) {
		var total = 0;
		var counts = {};
		var selfEntry;

		removeChildren(this.detail.participants);

		for(var cls in this.detail.classes) {
			var tmp = this.detail.classes[cls];
			counts[cls] = 0;
			removeText(tmp);
			removeClassName(tmp, 'active');
		}

		// TODO implement sorting
		for(var part, i = 0; part = eventDetail.invites[i]; i++) {
			
			var row = this.detail.participants.insertRow(-1);
			var cls = this.classes.ids[part.classId];

			var classItem = this.detail.classes[cls];
			row.className = "textLeft";

			//column for player name
			var nameCol = row.insertCell(-1);
			nameCol.style.paddingRight = "10px"

			if(eventDetail.owner == part.invitee)
				nameCol.innerHTML = "<img src=\"images/calendar/crown.gif\"  /> "+part.invitee;
			else if(part.moderator)
				nameCol.innerHTML = "<img src=\"images/calendar/icon-moderator.gif\"  /> "+part.invitee;
			else
				nameCol.innerHTML = part.invitee;

			appendText(row.insertCell(-1), this.l10n.strings.classes[cls]);
			var statusCell = row.insertCell(-1);
			statusCell.style.paddingLeft = "10px";
			
			statusCell.className = "textRight";
			
			if(part.status){
				appendText(statusCell, this.l10n.strings.eventStatuses[part.status]);
				Calendar.setStatusStyle(statusCell, part.status);
			}
		

			if(part.status == 'available' || part.status == 'confirmed') {
				total++;
				counts[cls]++;
				addClassName(classItem, 'active');
			}
			if(eventDetail.owner == part.invitee)
				addClassName(row, 'owner');
			else if(part.moderator)
				addClassName(row, 'moderator');
			if(this._isSelf(part.invitee))
				selfEntry = part;
		}

		for(var cls in this.detail.classes)
			appendText(this.detail.classes[cls], counts[cls]);

		removeText(this.detail.countTotal);
		appendText(this.detail.countTotal, printf(this.l10n.strings.classTotal, total));

		return selfEntry;
	},
	_resetEventActions: function(event, selfEntry) {

		this.detail.actionGroup.style.display = "block";
		this.detail.noactionGroup.style.display = "none";	
		
		for(var action in this.detail.actions){
			//alert("action: " + action);
			removeClassName(this.detail.actions[action], 'disabled');
			$("#actionRow1").show();
			$("#actionRow2").show();
			$("#actionRow3").show();
		}

		var allowedActions = (event.calendarType != 'guildSignup') ?  
								this._getAllowedActions(event, this._getSelf(event)) :
								this._getAllowedSignupActions(event,selfEntry);
		
		if(allowedActions) {
			for(action in this.detail.actions){		
				if(!allowedActions[action]){
					addClassName(this.detail.actions[action], 'disabled');
					if(event.calendarType == 'guildSignup'){
						$("#actionRow1").hide();
						$("#actionRow2").hide();
					}else{
						$("#actionRow3").hide();
					}
				}
			}
		} else {
			this.detail.actionGroup.style.display = "none";
			this.detail.noactionGroup.style.display = "block";				
		}
	},
	_getSelf: function(eventDetail) {
		for(var part, i = 0; part = eventDetail.invites[i]; i++)
			if(this._isSelf(part.invitee))
				return part;
		return null;
	},
	_getMonthEvent: function(eventDetail) {
		var eventDate = this._getDate(eventDetail.start);
		var dayEvents = this._getDayEvents(eventDate);
		if(!dayEvents)
			return null;

		for(var evt, i = 0; evt = dayEvents[i]; i++)
			if(evt.id == eventDetail.id)
				return evt;
	},
	_removeEvent: function(eventDetail) {
		this.hideDetail();
		var eventDate = this._getDate(eventDetail.start);
		var dayEvents = this._getDayEvents(eventDate);
		if(!dayEvents)
			return;

		for(var evt, i = 0; evt = dayEvents[i]; i++) {
			if(evt.id == eventDetail.id) {
				dayEvents.splice(i, 1);
				break;
			}
		}

		delete this.eventDetailCache[eventDetail.id.toString()];
	},
	_dialogOpened: function(name) {
		if(name == 'dayEventsSelect')
			addClassName(this.containerDialogs, 'dual');
		this.openDialogs[name] = true;
		show(this.blackout);
	},
	_dialogClosed: function(name) {
		this.openDialogs[name] = false;
		for(var dialog in this.openDialogs)
			if(this.openDialogs[dialog])
				return;
		hide(this.blackout);
		removeClassName(this.containerDialogs, 'dual');
	},
	_addSpanCache: function(event) {
		var curDate = this._getDate(event.start);
		var endDate = this._getDate(event.end);
		while(Calendar.dateDayComparator(curDate, endDate) != 1) {
			Calendar.addCacheEvent(this.eventSpanCache, event, curDate);
			curDate.setDate(curDate.getDate() + 1);
		}
	},
	_rebuildCaches: function() {
		var newCache = {};
		this.eventSpanCache = {};
		for(var key in this.eventCache) {
			var entry = this.eventCache[key];
			for(var i = 0; i < entry.length; i++) {
				var eventArray = entry[i];
				if(eventArray) {
					for(var j = 0; j < eventArray.length; j++) {
						var event = eventArray[j];
						Calendar.addCacheEvent(newCache, event, this._getDate(event.start));
						if(this._showEndDate(event))
							this._addSpanCache(event);
					}
				}
			}
			Calendar.sortMonthEvents(newCache[key]);
			Calendar.sortMonthEvents(this.eventSpanCache[key]);
		}
		this.eventCache = newCache;
	},
	_showEndDate: function(event) {
		// use calendar date instead, not 24 hours?
		return event.end && (event.end - event.start > 86400000);
	},
	_errorHandler: function(detail, scriptKey, code) {
		if(code == 302) {// redirects only occur in case of login needed
			// TODO does not work in all browsers
			this.errorShown = true;
			window.location.reload();
		} else {
			if(!detail && this.errorShown)
				return;
			this.errorShown = true;
			removeText(this.detailSimple.title);
			removeChildren(this.detailSimple.description);
			appendText(this.detailSimple.title, this.l10n.strings.error);
			
			var isActive = testActiveAccount(this.character);
			
			if (!isActive) {
				appendText(this.detailSimple.description, ADDITIONALERROR, true); // account not active
			} else {
				appendText(this.detailSimple.description, this.l10n.strings.errorDescription, true);
			}
			
			hide(this.containerDetail);
			this._dialogOpened('details');
			show(this.containerDetailSimple);
		}
	}
}


function findPosX(obj)
  {
    var curleft = 0;
    if(obj.offsetParent)
        while(1)
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
  }

  function findPosY(obj)
  {
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
  }

function testActiveAccount(currentCharacter) {
	
	var reallyActive = false;
	
	$.ajax({
		type: "GET",
		url: 'character-select.xml',
		async: false,
		dataType: "xml",
		success: function(msg){
			$(msg).find("account").each(function() {
				var hasActive = false;
				if ($(this).attr("active")) { hasActive = true; }

				var userName = $(this).attr("username");
				$(msg).find("character").each(function() {
					if ($(this).attr("account") == userName) {
						if ($(this).attr("name") == currentCharacter) { if (hasActive) { reallyActive = true; }}
					}
				});
			});
		},
		error: function(msg){				

		}
	});
	
	return reallyActive;
}

