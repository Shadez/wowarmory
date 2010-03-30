<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>
<!-- -->
<xsl:template match="characterInfo">
	
	<xsl:choose>
		<xsl:when test="@errCode">
			<div id="dataElement">
				<div class="parchment-top">
					<div class="parchment-content">
						<div class="list">
							<div class="player-side notab">
								<div class="info-pane">									
									<xsl:call-template name="errorSection" />									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</xsl:when>
		<xsl:otherwise>
			<div id="dataElement">
				<div class="parchment-top">
					<div class="parchment-content">
						<div class="list">
							<xsl:call-template name="newCharTabs" />
							<div class="full-list">
								<div class="info-pane">
									<div class="profile-wrapper">
										<div class="profile">
											<xsl:call-template name="charContent" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="head-content">
	<xsl:variable name="ctx-style">calendar/css/</xsl:variable>
	<script type="text/javascript" src="calendar/js/calendar.js"></script>
	<link rel="stylesheet" type="text/css" href="{$ctx-style}master.css" />
	<script type="text/javascript">
		if(Browser.ie6)
			addStylesheet('<xsl:value-of select="$ctx-style"/>ie6.css');
		else if(Browser.ie7)
			addStylesheet('<xsl:value-of select="$ctx-style"/>ie7.css');
		else if(Browser.opera)
			addStylesheet('<xsl:value-of select="$ctx-style"/>opera.css');
	</script>
</xsl:template>



<xsl:template name="charContent">

	<!-- character header -->
	<xsl:call-template name="newCharHeader" />
	
	<xsl:call-template name="calendar-content"/>
	
</xsl:template>

<xsl:template name="calendar-content">
	<xsl:variable name="loc-cal" select="$loc/strs/calendar"/>
	<noscript><xsl:value-of select="$loc-cal/str[@id='noscript']"/></noscript>

	<!-- empty div that holds top part of calendar bg -->
	<div style="width:895px; height: 100px; position: absolute; z-index: 0;">
	</div>
    <!-- drop down tabs -->
    <div id="calendar-loading-target">
			<!-- **************************************************************** -->
			<a class="staticTip" id="calendar-feed-container" style="text-decoration:none;" onmouseover="setTipText('{$loc-cal/feed/str[@id='subscribeMessage']}');">
				<xsl:attribute name="href">calendar-feed.xml?cn=<xsl:value-of select="character/@name"/>&amp;r=<xsl:value-of select="character/@realm"/></xsl:attribute>
				<div class="calendar-button"><div>
					<!--<xsl:value-of select="$loc-cal/feed/str[@id='subscribe']"/>-->
				</div></div>
			</a>
			<div class="calendar-time-container">
            <div class="calendar-drop" id="calendarTimeSetHandle"><div><xsl:value-of select="$loc-cal/str[@id='timesettings']"/></div></div>
            <div id="calendarTimeSetOptions" class="light-tip select-custom" style="z-index: 9999999; position: absolute;">
                <div class="calendar-time-contents">
                    <table class="calendar-tiptable">
                        <tr>
                            <td class="tl"></td><td class="t"></td><td class="tr"></td>
                        </tr>
                        <tr>
                            <td class="l"><q></q></td>
                            <td class="bg">
                                <div id="calendar-timezone" class="calendar-timezone">
                                    <div><xsl:value-of select="$loc-cal/time/str[@id='realm']"/><xsl:text> </xsl:text><span class="game"></span></div>
                                    <div><xsl:value-of select="$loc-cal/time/str[@id='local']"/><xsl:text> </xsl:text><span class="local"></span></div>
                                    <ul style="padding: 0; margin: 10px 0 0 0;position:relative;z-index:5">
                                        <li onclick="calendar.toggleTimeFormat()"><xsl:value-of select="$loc-cal/time/str[@id='hour24']"/></li>
                                        <li onclick="calendar.toggleUseLocalTime()"><xsl:value-of select="$loc-cal/time/str[@id='useLocal']"/></li>
                                    </ul>
                                </div>
                           </td><td class="r"><q></q></td>
                        </tr>
                        <tr>
                            <td class="bl"></td><td class="b"></td><td class="br"></td>
                        </tr>
                    </table>
                </div>
            </div>
			</div>
			<div class="calendar-filter-container">
            <div class="calendar-drop" id="calendarFilterHandle"><div><xsl:value-of select="$loc-cal/str[@id='filters']"/></div></div>
            <div id="calendarFilterOptions" class="light-tip select-custom" style="z-index:12345;">
                <div class="calendar-filter-contents">
                    <table class="calendar-tiptable">
                        <tr>
                            <td class="tl"></td><td class="t"></td><td class="tr"></td>
                        </tr>
                        <tr>
                            <td class="l"><q></q></td><td class="bg">
                            <div class="calendar-inner-filters">
                                <ul id="calendar-filter" style="padding: 0; margin: 10px 0 0 0;position:relative;z-index:5">
                                    <li></li>
                                </ul>
                            </div>
                        </td><td class="r"><q></q></td>
                        </tr>
                        <tr>
                            <td class="bl"></td><td class="b"></td><td class="br"></td>
                        </tr>
                    </table>
                </div>
            </div>
			</div>
			
			<!-- **************************************************************** -->
		
		<div class="loading-msg" style="float:right;">
			<img src="images/hourglass.gif" class="hourglass" alt="{$loc-cal/str[@id='loading']}" style="display:none;"/>
		</div>
        
		<a class="calendar-prev-month" href="javascript:void(0);" onclick="calendar.changeMonth(-1, true);"></a>
		<a class="calendar-next-month" href="javascript:void(0);" onclick="calendar.changeMonth(1, true);"></a>
		<span class="calendar-titleholder">
			<span id="calendar-title-month" class="calendar-monthtitle"></span>
			<span id="calendar-title-year" class="calendar-yeartitle"></span>
		</span>
		<!--
		<span class="calendar-switchmonth">
            <div class="calendar-nextmonth">
                <a class="bluebutton" href="javascript:void(0)" onclick="calendar.changeMonth(1, true)"><div class="bluebutton-a"></div><div class="bluebutton-next-lg"/><div class="bluebutton-c"/></a>
            </div>
			<div class="calendar-prevmonth">
                <a class="bluebutton" id="buttonright" href="javascript:void(0)" onclick="calendar.changeMonth(-1, true)"><div class="bluebutton-a"></div><div class="bluebutton-prev-lg"/><div class="bluebutton-c"/></a>
            </div>
        </span>
		-->
    </div>
	<!-- end drop down tabs -->
    <!-- calendar portion -->
	<div class="calendar-holder" >
		<div class="calendar-container">
			<div id="calendar" class="calendar" style="display:none">
				<div id="blackout" style="display:none"></div>
				<div id="calendar-day-events" class="calendar-day-events" style="display:none">
					<div class="tooltip">
						<table class="calendar-tiptable">
							<tr>
								<td class="tl"></td><td class="t"></td><td class="tr"></td>
							</tr>
							<tr>
								<td class="l"><q></q></td><td class="bg">
									<div class="date"></div>
									<ol class="events">
									<li></li>
									</ol>
								</td><td class="r"><q></q></td>
							</tr>
							<tr>
								<td class="bl"></td><td class="b"></td><td class="br"></td>
							</tr>
						</table>
					</div>
				</div>
				<div>
					<div id="calendar-detail" class="calendar-detail" style="display:none">
						<div class="reldiv">
							<div class="calendar-detail-bg"/>
							<div class="calendar-detail-head">
								<a class="calendar-report" href="javascript:void(0)" onclick="calendar.eventAction('spam')"><xsl:attribute name="title"><xsl:value-of select="$loc-cal/str[@id='spam']"/></xsl:attribute></a>
								<div class="close">
									<table>
										<tr>
											<td>
												<a class="bluebutton" href="javascript:void(0)" onclick="calendar.hideDetail()"><div class="bluebutton-a"></div><div class="bluebutton-x"/><div class="bluebutton-c"/></a>
											</td>
										</tr>
									</table>
								</div>
								<div class="title-container">
									<span class="title event"><xsl:value-of select="$loc-cal/str[@id='viewEvent']"/></span>
									<span class="title announcement"><xsl:value-of select="$loc-cal/str[@id='viewAnnouncement']"/></span>
								</div>
							</div>
							<div class="loading-msg">
								<xsl:value-of select="$loc-cal/str[@id='loading']"/>
							</div>
							<div class="detail-content-container">
								<div class="calendar-detail-contents">
									<div class="reldiv">


										<div class="header">
											<div class="icon"></div>
											<div class="header-contents">
												<div class="summary"></div>
												<div class="lockedmsg"><xsl:value-of select="$loc-cal/str[@id='locked']"/></div>
												<div class="type"></div>
												<div class="creator"></div>
												<div class="date"></div>
												<div class="time"></div>
											</div>
											<div class="linebreak"><xsl:comment/></div>
										</div>

										<div class="description"></div>

										<div class="actions" style="text-align: center; display: block;">
											<table class="actionButtonsHolder" style="margin: 10px auto 0;">
											  <tr id="actionRow1">
												<td align="center">
												<div class="button-1">
													<a class="actionButton" href="javascript:void(0)" onclick="calendar.eventAction('accept')">
														<xsl:value-of select="$loc-cal/str[@id='accept']"/>
													</a>
												</div>
												</td>
												<td align="center">
												<div class="button-2">
													<a class="actionButton" href="javascript:void(0)" onclick="calendar.eventAction('decline')">
														<xsl:value-of select="$loc-cal/str[@id='decline']"/>
													</a>
												</div>
												</td>
											   </tr>
											   <tr id="actionRow2">
												<td align="center" style="padding-top: 5px;">
												<div class="button-3">
													<a class="actionButton" href="javascript:void(0)" onclick="calendar.eventAction('tentative')">
														<xsl:value-of select="$loc-cal/str[@id='tentative']"/>
													</a>
												</div>
												</td>
												<td align="center" style="padding-top: 5px;">
												<div class="button-4">
													<a class="actionButton" href="javascript:void(0)" onclick="calendar.eventAction('remove')">
														<xsl:value-of select="$loc-cal/str[@id='remove']"/>
													</a>
												</div>												
												</td>
											   </tr>
											   <tr id="actionRow3">
											    <td>
												<div class="button-5">
													<a class="actionButton" href="javascript:void(0)" onclick="calendar.eventAction('signup')">
														<xsl:value-of select="$loc-cal/str[@id='signup']"/>
													</a>
												</div>												
												</td>
												<td>
													<div class="button-6">
														<a class="actionButton" href="javascript:void(0)" onclick="calendar.eventAction('unsignup')">
															<xsl:value-of select="$loc-cal/str[@id='remove']"/>
														</a>
													</div>
												</td>
											   </tr>
											  </table>
											<div style="clear: both; height: 1px; width: 100px"></div>
										</div>		
										
										<div class="noactions" style="display: block;">
											<div class="noactionsmsg"><xsl:copy-of select="$loc-cal/str[@id='creator']/node()"/></div>
										</div>

										<div class="participant-container">
											<table>
												<thead>
													<tr>
														<th style="text-align: left;"><xsl:value-of select="$loc-cal/str[@id='player']"/></th>
														<th style="text-align: left;"><xsl:value-of select="$loc-cal/str[@id='class']"/></th>
														<th style="text-align: right;"><xsl:value-of select="$loc-cal/str[@id='status']"/></th>
													</tr>
												</thead>
												<tbody class="participants">
													<tr><td></td></tr>
												</tbody>
											</table>
										</div>
										<div class="class-icon-container">
											<div class="class-icons">
												<div class="total"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="calendar-detail-simple" class="calendar-detail-simple" style="display:none">
						<div class="reldiv">
							<div class="calendar-detail-simple-bg"></div>
							<div class="calendar-detail-simple-head">
								<div class="close">
									<table><tr><td><a class="bluebutton" href="javascript:void(0)" onclick="calendar.hideDetail()"><div class="bluebutton-a"></div><div class="bluebutton-x"/><div class="bluebutton-c"/></a></td></tr></table>
								</div>
								<div class="title-container">
									<span class="title"></span>
								</div>
							</div>
							<div class="calendar-detail-simple-contents">
								<span class="description"></span>
								<xsl:if test="$loc-cal/str/@id = 'moreinfo'">
									<div class="more-info" style="display:none">
										<xsl:copy-of select="$loc-cal/str[@id='moreinfo']/node()"/>
									</div>
								</xsl:if>
							</div>
						</div>
					</div>
					<div id="calendar-confirmation-dialog" class="calendar-confirmation-dialog" style="display:none">
						<div class="reldiv">
							<div class="calendar-detail-mini-bg"></div>
							<div class="calendar-detail-simple-head">
								<div class="close">
									<table><tr><td><a class="bluebutton" href="javascript:void(0)" onclick="calendar.hideConfirmation()"><div class="bluebutton-a"></div><div class="bluebutton-x"/><div class="bluebutton-c"/></a></td></tr></table>
								</div>
								<div class="title-container">
									<span class="title"><xsl:value-of select="$loc-cal/str[@id='spam']"/></span>
								</div>
							</div>
							<div class="calendar-confirmation-contents">
							<br />
								<xsl:value-of select="$loc-cal/str[@id='complaint']"/>
							<br />
								<div>
									<a class="actionButton" href="javascript:void(0)" onclick="calendar.hideConfirmation()">
										<xsl:value-of select="$loc-cal/str[@id='close']"/>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div id="calendar-day-events-select" class="calendar-day-events-select" style="display:none;">
						<div class="reldiv">
							<div class="calendar-day-events-select-bg"></div>
							<div class="calendar-day-events-select-head">
								<div class="close">
									<a class="bluebutton" href="javascript:void(0)" onclick="calendar.hideDayEventsSelect()"><div class="bluebutton-a"></div><div class="bluebutton-x"/><div class="bluebutton-c"/></a>
								</div>
								<div class="title-container">
									<span class="title"><xsl:value-of select="$loc-cal/str[@id='eventList']"/></span>
								</div>
							</div>
							<div class="calendar-day-events-data">
								<div class="calendar-day-events-contents">
									<ol class="events" style="padding: 0; margin: 0">
										<li></li>
									</ol>
								</div>
							</div>
						</div>
					</div>
				</div>
				<table class="month" style="border-spacing: 0;" cellpadding="0" cellspacing="0">
					<thead style="margin: 0; padding: 0;">
						<tr><th></th></tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="reldiv">
									<div class="day-background"></div>
									<div class="calendar-box-gradient"></div>
									<div class="day-hasinvite"></div>
									<div class="day-deco-event"></div>
									<div class="calendar-box-today"/>
									<div class="calendar-box-hover"></div>
									<div class="calendar-box-selected"></div>
									<div class="day-date hasshadow"></div>
									<div class="calendar-box-othermonth"></div>
									<div class="day-content"></div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var CHARACTER = "<xsl:value-of select="character/@name"/>";
		var REALM = "<xsl:value-of select="character/@realm"/>";
		var ADDITIONALERROR = "<xsl:value-of select="$loc-cal/dynamic/str[@id='characterErrorDescription']"/>"; //additional error for calendar
		
		
		var CALENDAR_STRINGS = {
			<xsl:for-each select="$loc-cal/dynamic/str">
				<xsl:value-of select="@id"/>: '<xsl:value-of select="."/>',
			</xsl:for-each>
			days: [<xsl:for-each select="$loc/strs/weekdays/str">'<xsl:value-of select="."/>',</xsl:for-each>],
			months: [<xsl:for-each select="$loc/strs/months/str">'<xsl:value-of select="."/>',</xsl:for-each>],
			classes: [
				<!-- TODO refactor into iteration -->
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.1']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.6']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.2']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.5']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.7']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.11']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.4']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.8']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.9']"/>',
				'<xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.3']"/>'
				],
			eventTypes: [<xsl:for-each select="$loc-cal/event-type/str">'<xsl:value-of select="."/>',</xsl:for-each>],
			eventUserTypes: [<xsl:for-each select="$loc-cal/player-event-type/str">'<xsl:value-of select="."/>',</xsl:for-each>],
			eventStatuses: [<xsl:for-each select="$loc-cal/event-status/str">'<xsl:value-of select="."/>',</xsl:for-each>]
		}

		var CALENDAR_L10N = {
			locale: '<xsl:value-of select="$lang"/>',
			firstDayOfWeek: <xsl:value-of select="$loc-cal/format/str[@id='firstDayOfWeek']"/>,
			dateFunc: function(date) {
				<xsl:value-of select="$loc-cal/format/str[@id='dateFormat']"/>
			},
			timeFormat24: <xsl:value-of select="$loc-cal/format/str[@id='use24HourFormat']"/>,
			time24Func: function(date) {
				return padLeft(date.getHours().toString(), 2, '0') + ':' + padLeft(date.getMinutes().toString(), 2, '0');
			},
			time12Func: function(date) {
				var hours = date.getHours();
				var displayHour = hours % 12;
				if(displayHour == 0)
					displayHour = 12;
				<xsl:value-of select="$loc-cal/format/str[@id='time12HourFormat']"/>
			}
		}

		Calendar.eventLinksBase = '<xsl:value-of select="concat($loc/strs/common/str[@id='url.wow'], $loc-cal/links/@base)"/>';
		Calendar.eventLinks = {
			<xsl:for-each select="$loc-cal/links/event">
				Calendar_<xsl:value-of select="@id"/>: '<xsl:value-of select="."/>'
				<xsl:if test="position() != last()">,</xsl:if>
			</xsl:for-each>
		}
		
		var eventOverflowString = "<xsl:value-of select="$loc-cal/str[@id='eventoverflow']"/>";

		<![CDATA[

		var CALENDAR_CONFIG = {
			events: {
				types: ['player','holiday','bg','darkmoon','raidLockout','raidReset','holidayWeekly'], // 'guild' included with player data
				userTypes: ['raid','dungeon','pvp','meeting','other'],
				statuses: ['invited', 'tentative', 'available','declined','confirmed','out','standby', 'signedUp'],
				filter: {
					order: ['bg','darkmoon','raidLockout','raidReset','holidayWeekly'],
					state: [false, true, false, false, true]
				}
			},
			classes: {
				ids: {
					1: 'warrior',
					2: 'paladin',
					3: 'hunter',
					4: 'rogue',
					5: 'priest',
					6: 'deathknight',
					7: 'shaman',
					8: 'mage',
					9: 'warlock',
					11: 'druid'
				},
				order: ['warrior','deathknight','paladin','priest','shaman','druid','rogue','mage','warlock','hunter']
			}
		}




		var CTX = '/vault/calendar/';
		var CALENDAR_DATA = {
			common: function(callback) { return '?callback=calendar.' + callback + '&r=' +encodeURIComponent(REALM) + '&n=' + encodeURIComponent(CHARACTER); },
			monthURIFunc: function(callback, year, month, type) {
				// loc currently used only to prevent cross-language caching
				var common = CALENDAR_DATA.common(callback) + '&year=' + year + '&month=' + (month+1) + '&loc=' + CALENDAR_L10N.locale;
				switch(type) {
					case 'player':
						return CTX + 'month-user.json' + common;
					default:
						return CTX + 'month-world.json' + common + '&type=' + type;
						
				}
			},
			detailURIFunc: function(callback, id) {
				return CTX + 'detail.json' + CALENDAR_DATA.common(callback) + '&e=' + id;
			},
			actionURIFunc: function(callback, id, action) {
				return CTX + 'action.json' + CALENDAR_DATA.common(callback) + '&e=' + id + '&a=' + action;
			}
		}

		CALENDAR_DATA.iconURIFunc = function(event, ongoing, detail) {
			var size = detail ? 75 : 121;
			if(event.icon.length == 0) {
				if(ongoing || event.calendarType != 'bg')
					return null;
				return 'wow-icons/_images/calendar/' + size + '/calendar_defaultholiday.png';
			}
			if(ongoing)
			<!-- todo: retrieve lower-cased icon names for holidays and remove explicit lower-casing -->
				return 'wow-icons/_images/calendar/' + size + '/' + event.icon.toLowerCase() + 'ongoing.png';
			if(!event.isEnd && !calendar._showEndDate(event))
				return 'wow-icons/_images/calendar/' + size + '/' + event.icon.toLowerCase() + '.png';

			return 'wow-icons/_images/calendar/' + size + '/' + event.icon.toLowerCase() + (event.isEnd ? 'end' : 'start') + '.png';
		}

		Calendar.addDropShadows = function(parent) {
			duplicateNodes(parent, 'hasshadow', 'shadow');
		}

		var calendar = new Calendar('calendar', 'calendar-detail', 'calendar-detail-simple', 'calendar-day-events',
				'calendar-day-events-select', 'calendar-title-year', 'calendar-title-month', 'calendar-filter',
				'calendar-confirmation-dialog', 'calendar-timezone', 'calendar-loading-target', 'blackout',
				CALENDAR_CONFIG.classes.ids,
				CALENDAR_CONFIG.classes.order,
				CALENDAR_CONFIG.events.types,
				CALENDAR_CONFIG.events.userTypes,
				CALENDAR_CONFIG.events.statuses,
				CALENDAR_CONFIG.events.filter.order,
				CALENDAR_CONFIG.events.filter.state,
				CALENDAR_DATA.monthURIFunc,
				CALENDAR_DATA.detailURIFunc,
				CALENDAR_DATA.actionURIFunc,
				CALENDAR_DATA.iconURIFunc,
				CALENDAR_L10N.firstDayOfWeek,
				CALENDAR_L10N.dateFunc,
				CALENDAR_L10N.time24Func,
				CALENDAR_L10N.time12Func,
				CALENDAR_L10N.timeFormat24,
				CALENDAR_STRINGS.days,
				CALENDAR_STRINGS.months,
				CALENDAR_STRINGS.eventOwner,
				CALENDAR_STRINGS.invitedBy,
				CALENDAR_STRINGS.announcementOwner,
				CALENDAR_STRINGS.createdBy,
				CALENDAR_STRINGS.attendees,
				CALENDAR_STRINGS.eventStarts,
				CALENDAR_STRINGS.eventEnds,
				CALENDAR_STRINGS.eventResets,
				CALENDAR_STRINGS.eventResetsDescription,
				CALENDAR_STRINGS.eventUnlocks,
				CALENDAR_STRINGS.eventUnlocksDescription,
				CALENDAR_STRINGS.error,
				CALENDAR_STRINGS.errorDescription,
				CALENDAR_STRINGS.classes,
				CALENDAR_STRINGS.eventTypes,
				CALENDAR_STRINGS.eventUserTypes,
				CALENDAR_STRINGS.eventStatuses,
				CHARACTER,
				false,
				Calendar.addDropShadows,

				eventOverflowString);

			CustomSelect.init([
				['calendarFilterHandle','calendarFilterOptions','active','active',true],
				['calendarTimeSetHandle','calendarTimeSetOptions','active','active',true]
			]);

			//hide blackout when they click on the filters
			$("#calendarFilterHandle").click(function(){
				calendar.hideAll();
			});

			//hide blackout when they click on the filters
			$("#calendarTimeSetHandle").click(function(){
				calendar.hideAll();
			});

		]]>
	</script>
</xsl:template>

</xsl:stylesheet>