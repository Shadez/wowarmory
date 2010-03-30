<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="page/arenaLadderPagedResult">

	<xsl:variable name="defaultNormalBattlegroup" select="$bgXML/battlegroup[not(@tournamentBattleGroup=1)][1]/@display" />
	<xsl:variable name="defaultTournamentBattlegroup" select="$bgXML/battlegroup[@tournamentBattleGroup=1][1]/@display" />
	<xsl:variable name="arenaTournamentMode" select="boolean(@teamSize = 3 and @battleGroup = $defaultTournamentBattlegroup)" />

	<xsl:variable name="currTab">
		<xsl:choose>
			<xsl:when test="$arenaTournamentMode">arenaTournament</xsl:when>
			<xsl:otherwise><xsl:value-of select="@teamSize" />v<xsl:value-of select="@teamSize" /></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">

					<xsl:call-template name="tabs">
						<xsl:with-param name="tabGroup" select="'arenaLadder'" />
						<xsl:with-param name="currTab" select="$currTab" />
						<xsl:with-param name="subTab" select="''" />
						<xsl:with-param name="tabUrlAppend" select="''" />
						<xsl:with-param name="subtabUrlAppend" select="''" />
					</xsl:call-template>

					<div class="full-list">
						<div class="info-pane">
							 <blockquote>							 												
							 	<b class="iarenateams">
									<h4 style="width: 300px;"><a href="/battlegroups.xml"><xsl:value-of select="$loc/strs/arena/str[@id='arena-ladders']"/></a></h4>
									<h3 style="width: 300px;">
										<xsl:choose>
											<xsl:when test="$arenaTournamentMode"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.arenaTournament']" /></xsl:when>
											<xsl:when test="@teamSize = 2"><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.header.2v2']"/></xsl:when>
											<xsl:when test="@teamSize = 3"><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.header.3v3']"/></xsl:when>
											<xsl:when test="@teamSize = 5"><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.header.5v5']"/></xsl:when>
										</xsl:choose>
									</h3>
								</b>
							</blockquote>							
							<xsl:call-template name="ladderTable">
								<xsl:with-param name="defaultNormalBattlegroup" select="$defaultNormalBattlegroup" />
								<xsl:with-param name="defaultTournamentBattlegroup" select="$defaultTournamentBattlegroup" />
								<xsl:with-param name="arenaTournamentMode" select="$arenaTournamentMode" />
							</xsl:call-template>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
</xsl:template>

<xsl:template name="ladderTable">

	<xsl:param name="defaultNormalBattlegroup" />
	<xsl:param name="defaultTournamentBattlegroup" />
	<xsl:param name="arenaTournamentMode" />

	<xsl:variable name="currBattlegroup" select="@battleGroup" />
	<xsl:variable name="filterValue" select="@filterValue" />
	<xsl:variable name="numArenaTeams" select="count(arenaTeams/arenaTeam)" />
	
	<script type="text/javascript">//<![CDATA[
		var ArenaLadder = function() {

			var
				page,
				maxPage,
				battlegroup,
				filterField,
				filterValue,
				sortDir,
				sortField,
				teamSize;

				validTeamSizes = {
					2: true,
					3: true,
					5: true
				};

			this.initialize = function(Page, MaxPage, Battlegroup, FilterField, FilterValue, SortDir, SortField, TeamSize) {

				page        = Page;
				maxPage     = MaxPage;
				battlegroup = Battlegroup;
				filterField = FilterField;
				filterValue = FilterValue;
				sortField   = SortField;
				sortDir     = SortDir;
				teamSize    = TeamSize;

				var arenaTournamentMode = (teamSize == 3 && battlegroup == defaultTournamentBattlegroup);

				// Arena Tournament Tab Selected
				if(arenaTournamentMode) {

					var cook = getcookie2('default-arena-battlegroup');
					if(cook && cook.length)
						defaultNormalBattlegroup = cook;

					for(var size in validTeamSizes) {					
						size = parseInt(size);

						var link = $('#tab_' + size + 'v' + size + ' a:first');
						link.attr('href', getUrl({ teamSize: size, battlegroup: defaultNormalBattlegroup }));
					}

				// 2v2, 3v3, or 5v5 Tab Selected
				} else {

					setcookie('default-arena-battlegroup', battlegroup);

					for(var size in validTeamSizes) {					
						size = parseInt(size);
						if(size != teamSize) {
							var link = $('#tab_' + size + 'v' + size + ' a:first');
							link.attr('href', getUrl({ teamSize: size }));
						}
					}

					var link = $('#tab_arenaTournament a:first');
					link.attr('href', getUrl({ teamSize: 3, battlegroup: defaultTournamentBattlegroup }));
				}
			};

			this.setPage = function(pageNum) {
				pageNum = parseInt(pageNum);
				if(!isNaN(pageNum) && pageNum >= 1 && pageNum <= maxPage && pageNum != page) {
					page = pageNum;
					updateUrl();
				}
			};

			this.setBattlegroup = function(battlegroupName) {
				if(battlegroupName)	{
					resetAll();
					battlegroup = battlegroupName;
					updateUrl();
				}
			};

			this.setFilter = function(field, value) {
				if(field && value) {
					resetAll();
					if(parseInt(value) != -1) {
						filterField = field;
						filterValue = value;
					}
					updateUrl();
				}
			};

			this.setSort = function(field, dir) {
				if(field && dir) {
					sortField = field;
					sortDir   = dir;
					updateUrl();
				}
			};

			this.setTeamSize = function(size) {
				if(validTeamSizes[size]) {
					teamSize = size;
					updateUrl();
				}
			};

			this.toggleSort = function(field) {
				if(field) {
					if(sortField == field && sortDir == 'a') {
						sortDir = 'd';
					} else {
						sortDir = 'a';
					}
					sortField = field;
					updateUrl();
				}
			};

			function resetAll() {
				page        = 1;
				filterField = null;
				filterValue = null;
				sortField   = null;
				sortDir     = null;
			}

			function getDataObject() {

				var data = {
					page:        page,
					maxPage:     maxPage,
					battlegroup: battlegroup,
					filterField: filterField,
					filterValue: filterValue,
					sortField:   sortField,
					sortDir:     sortDir,
					teamSize:    teamSize
				};

				return data;
			}

			function getUrl(overrides) {

				var data = getDataObject();

				if(overrides != null) {
					for(var i in overrides) {
						data[i] = overrides[i];
					}
				}

				var
					url    = 'arena-ladder.xml',
					params = [];

				if(data.page > 1)
					params.push('p=' + data.page);

				params.push('ts=' + data.teamSize);
				params.push('b=' + urlEncode(data.battlegroup));

				if(data.filterField && data.filterValue)
				{
					params.push('ff=' + data.filterField);
					params.push('fv=' + urlEncode(data.filterValue));
				}

				if(
					data.sortField &&
					data.sortDir &&
					!(data.sortField == 'rank' && data.sortDir == 'a') // Default sorting
				) {
					params.push('sf=' + data.sortField);
					params.push('sd=' + data.sortDir);
				}

				for(var i = 0, len = params.length; i < len; ++i) {
					url += (i > 0 ? '&' : '?');
					url += params[i];
				}
				
				return url;			
			}

			function updateUrl() {

				var url = getUrl();

				location.href = url;
			}
		};
	//]]></script>

	<script type="text/javascript">
		var defaultNormalBattlegroup = "<xsl:value-of select="$defaultNormalBattlegroup" />";
		var defaultTournamentBattlegroup = "<xsl:value-of select="$defaultTournamentBattlegroup" />";

		var arenaLadder = new ArenaLadder();
		arenaLadder.initialize(
			 <xsl:value-of select="@page" />,
			 <xsl:value-of select="@maxPage" />,
			"<xsl:value-of select="@battleGroup" />",
			"<xsl:value-of select="@filterField" />",
			"<xsl:value-of select="@filterValue" />",
			"<xsl:value-of select="@sortDir" />",
			"<xsl:value-of select="@sortField" />",
			 <xsl:value-of select="@teamSize" />
		);

		$(document).ready(function(){
			$("#realmSelect").bgiframe();
			$("#battlegroupSelect").bgiframe();
		});
	</script>
	
	<div id="ladderContent">
		<div id="pager" class="pager page-body" style="text-align:right;">
			<form id="pagingForm" style="margin: 0; padding: 0; display: inline;" onsubmit="return false;">
				<div id="searchTypeHolder"></div>
				<div style="float: left; margin-left: 5px;">
					<!-- Page X of X -->
					<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.paging']">
						<xsl:with-param name="param1">
							<input id="pagingInput" onkeyup="if(event.which == 13) arenaLadder.setPage(this.value)" type="text" value="{@page}" />
						</xsl:with-param>
						<xsl:with-param name="param2">
							<span id="totalPages"><xsl:value-of select="@maxPage" /></span>
						</xsl:with-param>				
					</xsl:apply-templates>
				</div>
				<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px; display: none;">			
					<!-- showing X of X results -->				
					<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.showing']">
						<xsl:with-param name="param1">
							<span id="currResults" class="bold"></span>
						</xsl:with-param>
						<xsl:with-param name="param2">
							<span id="totalResults" class="bold"></span>
						</xsl:with-param>
					</xsl:apply-templates>
				</div>
				
				<!-- hide pages 2 and/or 3 if needed -->
				<xsl:variable name="page2Style"><xsl:if test="@maxPage &lt;= 1">display: none</xsl:if></xsl:variable>
				<xsl:variable name="page3Style"><xsl:if test="@maxPage &lt;= 2">display: none</xsl:if></xsl:variable>
				
				<div id="pageSelector" style="float: right">
					<a class="firstPg firstPg-on" href="javascript:;" onclick="arenaLadder.setPage(1)">
						<xsl:if test="@page = 1">
							<xsl:attribute name="class">firstPg firstPg-off</xsl:attribute>
						</xsl:if>
					</a>
					<a class="prevPg prevPg-on" href="javascript:;" onclick="arenaLadder.setPage({@page - 1})">
						<xsl:if test="@page = 1">
							<xsl:attribute name="class">prevPg prevPg-off</xsl:attribute>
						</xsl:if>
					</a>
					<xsl:choose>
						<xsl:when test="(@page + 1) = @maxPage">
							<a id="pageSelect1" class="p" href="javascript:;" onclick="arenaLadder.setPage({@page - 1})"><xsl:value-of select="@page - 1" /></a>
							<a id="pageSelect2" style="{$page2Style}" class="sel" href="javascript:;"><xsl:value-of select="@page" /></a>
							<a id="pageSelect3" style="{$page3Style}" class="p" href="javascript:;" onclick="arenaLadder.setPage({@page + 1})"><xsl:value-of select="@page + 1" /></a>							
						</xsl:when>
						<xsl:when test="@page = @maxPage">
							<a id="pageSelect1" class="p" href="javascript:;" onclick="arenaLadder.setPage({@page - 2})"><xsl:value-of select="@page - 2" /></a>
							<a id="pageSelect2" style="{$page2Style}" class="p" href="javascript:;" onclick="arenaLadder.setPage({@page - 1})"><xsl:value-of select="@page - 1" /></a>
							<a id="pageSelect3" style="{$page3Style}" class="sel" href="javascript:;"><xsl:value-of select="@page" /></a>							
						</xsl:when>
						<xsl:otherwise>
							<a id="pageSelect1" class="sel" href="javascript:;"><xsl:value-of select="@page" /></a>
							<a id="pageSelect2" style="{$page2Style}" class="p" href="javascript:;" onclick="arenaLadder.setPage({@page + 1})"><xsl:value-of select="@page + 1" /></a>
							<a id="pageSelect3" style="{$page3Style}" class="p" href="javascript:;" onclick="arenaLadder.setPage({@page + 2})"><xsl:value-of select="@page + 2" /></a>
						</xsl:otherwise>
					</xsl:choose>
					<a class="nextPg nextPg-on" href="javascript:;" onclick="arenaLadder.setPage({@page + 1})">
						<xsl:if test="@page = @maxPage">
							<xsl:attribute name="class">nextPg nextPg-off</xsl:attribute>
							<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
						</xsl:if>
					</a>
					<a class="lastPg lastPg-on" href="javascript:;" onclick="arenaLadder.setPage({@maxPage})">
						<xsl:if test="@page = @maxPage">
							<xsl:attribute name="class">lastPg lastPg-off</xsl:attribute>
							<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
						</xsl:if>
					</a>
				</div>
	
				<select id="pageSize" style="display:none;">
					<option value="10">10</option>
					<option selected="selected" value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
				</select>
				
				<!-- realm drop down-->
				
				<div style="background:url(images/icons/icon-realm.gif) 0 0 no-repeat; padding-left: 22px; float: right;  margin: 3px 20px 0 15px;">
					<select id="realmSelect" style="float: left;" onchange="arenaLadder.setFilter('realm', this.value)">
						<option value="-1"><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id = 'armory.arena-ladder-data.all-realms']" /></option>
						<xsl:for-each select="$bgXML/battlegroup[@display = $currBattlegroup]/realms/realm">
							<xsl:sort select="@name" />
							<option value="{@name}">
								<xsl:if test="$filterValue = current()/@name">
									<xsl:attribute name="selected">selected</xsl:attribute>
								</xsl:if>
								<xsl:value-of select="@name" />
							</option>
						</xsl:for-each>	
					</select>
				</div>
			
				<!-- battlegroup drop down -->
				<div style="background:url(images/icons/icon-bg.gif) 0 0 no-repeat; padding-left: 22px; float: right; margin: 3px 0 0 0;">
					<select id="battlegroupSelect" style="float: left;" onchange="arenaLadder.setBattlegroup(this.value)">
						<xsl:choose>
							<xsl:when test="$arenaTournamentMode">
								<xsl:for-each select="$bgXML/battlegroup[@tournamentBattleGroup=1]">
									<xsl:sort select="@display" />
									<option value="{@display}">
										<xsl:if test="$currBattlegroup = current()/@display">
											<xsl:attribute name="selected">selected</xsl:attribute>
										</xsl:if>
										<xsl:value-of select="@display" />
									</option>
								</xsl:for-each>
							</xsl:when>
							<xsl:otherwise>
								<xsl:for-each select="$bgXML/battlegroup[not(@tournamentBattleGroup=1)]">
									<xsl:sort select="@display" />
									<option value="{@display}">
										<xsl:if test="$currBattlegroup = current()/@display">
											<xsl:attribute name="selected">selected</xsl:attribute>
										</xsl:if>
										<xsl:value-of select="@display" />
									</option>
								</xsl:for-each>
							</xsl:otherwise>
						</xsl:choose>
					</select>
				</div>
			</form>
		</div>
		
		<xsl:variable name="headerSortStyle">
			<xsl:choose>
				<xsl:when test="@sortDir = 'd'">header headerSortDown</xsl:when>
				<xsl:otherwise>header headerSortUp</xsl:otherwise>			
			</xsl:choose>
		</xsl:variable>
		
		<div class="data">
			<table id="ladderTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
				<thead>
					<tr class="masthead">
						<th>
							<xsl:if test="@sortField = 'rank' or @sortField = ''">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('rank')">
								<xsl:value-of select="$loc/strs/general/str[@id = 'rank']" /><span class='sortArw' />
							</a>
						</th>
						<th style="width: 100%;">
							<xsl:if test="@sortField = 'name'">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('name')">
								<xsl:value-of select="$loc/strs/arena/str[@id='team-name']" /><span class='sortArw' />
							</a>
							<div id="teamIconBoxContainer">
								<div id="teamIconBox" style="position:absolute; z-index: 2000; zoom: 1;" />
							</div>
						</th>
						<th style="width: 250px;">
							<xsl:if test="@sortField = 'realm'">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('realm')">
								<xsl:value-of select="$loc/strs/semicommon/str[@id='realm']" /><span class='sortArw' />
							</a>
						</th>
						<th>
							<xsl:if test="@sortField = 'faction'">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('faction')">
								<xsl:value-of select="$loc/strs/semicommon/str[@id='faction']" /><span class='sortArw'> </span>
							</a>
						</th>
						<th>
							<xsl:if test="@sortField = 'sgw'">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('sgw')">
								<xsl:value-of select="$loc/strs/arena/str[@id = 'wins']" /><span class='sortArw' />
							</a>
						</th>
						<th>
							<xsl:if test="@sortField = 'sgl'">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('sgl')">
								<xsl:value-of select="$loc/strs/arena/str[@id = 'losses']" /><span class='sortArw' />
							</a>
						</th>
						<th>
							<xsl:if test="@sortField = 'rating'">
								<xsl:attribute name="class"><xsl:value-of select="$headerSortStyle" /></xsl:attribute>
							</xsl:if>
							<a href="javascript:;" onclick="arenaLadder.toggleSort('rating')">
								<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.rating']" /><span class='sortArw' />
							</a>
						</th>
					</tr>
				</thead>
				<tbody>
					<xsl:for-each select="arenaTeams/arenaTeam">
						<xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />
						<tr onmouseover="popIconLarge('teamIconBoxFlash','iconObject{position()}')" onmouseout="popIconSmall('teamIconBoxFlash','iconObject{position()}')">
							<td class="rightNum" style="font-weight: bold;"><xsl:value-of select="@ranking" /></td>
							<td style="padding-left: 40px;"><a href="/team-info.xml?{@realmUrl}"><xsl:value-of select="@name" /></a></td>
							<td style="white-space: nowrap"><xsl:value-of select="@realm" /></td>
							<td class="centNum"><img class="staticTip" onmouseover="setTipText('{$factionTxt}');" src="images/icons/faction/icon-{@factionId}.gif" /></td>
							<td class="rightNum" style="font-weight: bold; color: #678705;"><xsl:value-of select="@seasonGamesWon" /></td>
							<td class="rightNum" style="font-weight: bold; color: #9A1401;"><xsl:value-of select="@seasonGamesPlayed - @seasonGamesWon" /></td>
							<td class="rightNum" style="font-weight: bold;"><xsl:value-of select="@rating" /></td>
						</tr>
					</xsl:for-each>
				</tbody>
			</table>
		</div>
	</div>
	
	<xsl:if test="$numArenaTeams &gt; 0">
		<script type="text/javascript">
			var flashVarsString="totalIcons=<xsl:value-of select="$numArenaTeams" />&#38;initScale=35&#38;overScale=100&#38;overModifierX=0&#38;overModifierY=0&#38;startPointX=43&#38;";
	
			<xsl:for-each select="arenaTeams/arenaTeam">
				<xsl:variable name="positionNum" select="position()" />			
				var encodedRealm=encodeURI("<xsl:value-of select="@realm"/>");
				flashVarsString+="iconName<xsl:value-of select="$positionNum"/>=images/icons/team/pvp-banner-emblem-<xsl:value-of select="emblem/@iconStyle"/>.png&#38;iconColor<xsl:value-of select="$positionNum"/>=<xsl:value-of select="emblem/@iconColor"/>&#38;bgColor<xsl:value-of select="$positionNum"/>=<xsl:value-of select="emblem/@background"/>&#38;borderColor<xsl:value-of select="$positionNum"/>=<xsl:value-of select="emblem/@borderColor"/>&#38;teamUrl<xsl:value-of select="$positionNum"/>=team-info.xml?r="+encodedRealm+"%26ts=<xsl:value-of select="@size"/>%26t=<xsl:value-of select="@name"/>&#38;";
			</xsl:for-each>
			
			var heightCalc=(<xsl:value-of select="$numArenaTeams" />*28)+10;
			if(heightCalc &lt; 100) heightCalc = 100;		
			
			printFlash('teamIconBox', 'images/icons/team/pvpemblems.swf', 'transparent', '', '#000000', '76', heightCalc, 'high', '', flashVarsString, '');	
		</script>
	</xsl:if>	
	
</xsl:template>

</xsl:stylesheet>