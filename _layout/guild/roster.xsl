<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="guildInfo">

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">
					<xsl:call-template name="newGuildTabs" />
                    <div class="full-list">
                        <div class="info-pane">
							<div class="profile-wrapper">
								<div class="profile">
                           			<xsl:call-template name="guildContent" />
						   		</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>


<xsl:template name="guildContent">

	<!-- character header -->
	<xsl:call-template name="newGuildHeader" />

	<script type="text/javascript" src="_js/guild/roster.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			initGuildRoster("<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.noSearchResults']" />");	//"
		});	
	</script>
	

	<div class="filtercrest"><div class="filterTitle"><xsl:value-of select="$loc/strs/guildBank/str[@id='guildrosterfilters']" /></div></div>
	<div class="filtercontainer">
	
		<div id="nameFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/guildBank/str[@id='charnamec']" /><br />
			<input id="filCharName" type="text" maxlength="20" value="" class="filterInput" style="width: 150px;"/>		
		</div>
		<div id="nameFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/character/str[@id='character-level']" /><br />
			<input id="filMinLevel" type="text" size="2" maxlength="2" value="10" class="filterInput" style="width: 30px;"/>
			<span class="inlineTxt"> - </span>
			<input id="filMaxLevel" type="text" size="2" maxlength="2" value="80" class="filterInput" style="width: 30px;"/>
		</div>
		
		<div id="nameFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/general/str[@id='race']" /><br />
			
			<xsl:choose>
				<!-- alliance -->
				<xsl:when test="guildHeader/@faction = '0'">
					<select id="filRaceSelect" onchange="runGuildRosterFilters();">
						<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
						<option value="3"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.3']"/></option>
						<option value="1"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.1']"/></option>
						<option value="4"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.4']"/></option>
						<option value="7"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.7']"/></option>
						<option value="11"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.11']"/></option>
					</select>
				</xsl:when>
				<xsl:otherwise>
					<select id="filRaceSelect" onchange="runGuildRosterFilters();">
						<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
						<option value="2"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.2']"/></option>
						<option value="5"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.5']"/></option>
						<option value="10"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.10']"/></option>
						<option value="6"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.6']"/></option>
						<option value="8"><xsl:value-of select="$loc/strs/races/str[@id='armory.races.race.8']"/></option>
					</select>				
				</xsl:otherwise>		
			</xsl:choose>
			
		</div>
		
		<div id="nameFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/guildBank/str[@id='gender']"/><br />
			<select id="filGenderSelect" onchange="runGuildRosterFilters();">
				<option value="-1"><xsl:value-of select="$loc/strs/guildBank/str[@id='both']"/></option>
				<option value="0"><xsl:value-of select="$loc/strs/guildBank/str[@id='male']"/></option>
				<option value="1"><xsl:value-of select="$loc/strs/guildBank/str[@id='female']"/></option>			
			</select>
		</div>		
		
		<div id="nameFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/general/str[@id='class']" /><br />
			
			<select id="filClassSelect" onchange="runGuildRosterFilters();">
				<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
				<option value="6"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.6']"/></option>
				<option value="11"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.11']"/></option>				
				<option value="2"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.2']"/></option>
				<option value="3"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.3']"/></option>
				<option value="4"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.4']"/></option>
				<option value="5"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.5']"/></option>				
				<option value="7"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.7']"/></option>
				<option value="8"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.8']"/></option>
				<option value="9"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.9']"/></option>
				<option value="1"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.1']"/></option>
				
			</select>
		</div>
		
		<div id="nameFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/general/str[@id='rank']" /><br />
			<xsl:variable name="unique-ranks" select="guild/members/character[not(@rank=following::character/@rank)]" />
			<select id="filRankSelect" onchange="runGuildRosterFilters();">
				<option value="-1"><xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.all']" /></option>
				<xsl:for-each select="$unique-ranks">
					<xsl:sort select="@rank" />	
					<option value="{@rank}">
						<xsl:choose>
							<xsl:when test="not(@rank = '0')">
								<xsl:apply-templates mode="printf" select="$loc/strs/guild/str[@id='guild-rank-strOrder']">
									<xsl:with-param name="param1" select="@rank" />
								</xsl:apply-templates>
							</xsl:when>
							<xsl:otherwise>
								<xsl:value-of select="$loc/strs/guild/str[@id='guild-leader']" />
							</xsl:otherwise>
						</xsl:choose>					
					</option>			
				</xsl:for-each>
			
			</select>
		</div>
		
		<div class="clear"></div>
		
		<div id="filterButtonHolder">
			<a id="runFilterButton" href="javascript:void(0)" onclick="resetRosterFilters();" style="cursor: pointer;">
				<span class="btnRight"><xsl:value-of select="$loc/strs/guildBank/str[@id='resetfilters']"/></span>
			</a>            
		</div>	
		
	</div>
	<div class="bottomshadow"></div>

	<div class="filterTitle"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.members']" /></div>


	<div id="pager" class="pager page-body" style="text-align:right;">
        <form id="pagingForm" style="margin: 0; padding: 0; display: inline;" onsubmit="return false;">
        	<div id="searchTypeHolder"></div>
            <div style="float: left; margin-left: 5px;">
				<!-- Page X of X -->
				<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.paging']">
					<xsl:with-param name="param1">
						<input id="pagingInput" type="text" />
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalPages"></span>
					</xsl:with-param>				
				</xsl:apply-templates>
            </div>
            <div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">			
				<!-- showing X of X results -->				
				<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.showing']">
					<xsl:with-param name="param1">
						<span id="currResults" class="bold"><xsl:value-of select="count(guild/members/character)" /></span>
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalResults" class="bold"><xsl:value-of select="count(guild/members/character)" /></span>
					</xsl:with-param>				
				</xsl:apply-templates>
            </div>
            <div id="pageSelector" style="float: right">
                <a class="firstPg firstPg-on" href="javascript:void(0)"> </a>
                <a class="prevPg prevPg-on" href="javascript:void(0)"> </a>
                <a id="pageSelect1" class="p" href="javascript:void(0)"> </a>
                <a id="pageSelect2" class="p" href="javascript:void(0)"> </a>
                <a id="pageSelect3" class="p" href="javascript:void(0)"> </a>
                <a class="nextPg nextPg-on" href="javascript:void(0)"> </a>
                <a class="lastPg lastPg-on" href="javascript:void(0)"> </a>
            </div>
			<xsl:value-of select="$loc/strs/arena/str[@id='resultsPerPage']"/>
            <select id="pageSize">
                <option selected="selected" value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
            </select>
        </form>
    </div>
	
	
	<div class="data">
        <table id="rosterTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
            <thead>
                <tr class="masthead">					
                    <th style="width: 100%; text-align:left;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.character-name']" /><span class='sortArw'> </span></a></th>
					<th style="text-align:left;"><a><xsl:value-of select="$loc/strs/login/str[@id='armory.login.achievements']" /><span class='sortArw'> </span></a></th>
                    <th style="text-align:left; width: 80px;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.level']" /><span class='sortArw'> </span></a></th>
                    <th style="text-align:left;"><a><xsl:value-of select="$loc/strs/general/str[@id='race']" /><span class='sortArw'> </span></a></th>
					<th style="text-align:left;"><a><xsl:value-of select="$loc/strs/general/str[@id='class']" /><span class='sortArw'> </span></a></th>
					<th style="text-align:left; width: 200px; min-width: 150px;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.guildrank']" /><span class='sortArw'> </span></a></th>					
                </tr>
            </thead>
            <tbody>
				<xsl:for-each select="guild/members/character">
					<xsl:sort select="@rank" />	
					<xsl:variable name="classTxt"	select="$loc/strs/classes/str[@id=concat('armory.classes.class.',current()/@classId,'.',current()/@genderId)]" />
					<xsl:variable name="raceTxt"	select="$loc/strs/races/str[@id=concat('armory.races.race.',current()/@raceId,'.',current()/@genderId)]" />
					<xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />				
					
					<tr>
						<xsl:if test="@rank = '0'"><xsl:attribute name="class">data3</xsl:attribute></xsl:if>						
						<td style="padding-left: 7px;"><a href="character-sheet.xml?{@url}"><xsl:value-of select="@name" /></a></td>
						<td class="rightNum"><span class="achievPtsSpan"><xsl:value-of select="@achPoints" /></span></td>
						<td class="rightNum"><xsl:value-of select="@level" /></td>
						<td style="text-align:right;">
							<span style="display: none;"><xsl:value-of select="$raceTxt" /></span>
							<span style="display: none;"><xsl:value-of select="@raceId" /></span>
			                <img class="staticTip" onmouseover="setTipText('{$raceTxt}');" src="images/icons/race/{@raceId}-{@genderId}.gif" />		
						</td>
						<td>
							<span style="display: none;"><xsl:value-of select="$classTxt"/></span>
							<span style="display: none;"><xsl:value-of select="@classId" /></span>
							<span style="display: none;"><xsl:value-of select="@genderId" /></span>
			                <img class="staticTip" onmouseover="setTipText('{$classTxt}');" src="images/icons/class/{@classId}.gif" />
						</td>
						<td class="centNum" style="white-space:nowrap">
							<span style="display: none"><xsl:value-of select="@rank" /></span>
							<xsl:choose>
								<xsl:when test="not(@rank = '0')">
									<strong>
									<xsl:apply-templates mode="printf" select="$loc/strs/guild/str[@id='guild-rank-strOrder']">
										<xsl:with-param name="param1" select="@rank" />
									</xsl:apply-templates>
									</strong>
								</xsl:when>
								<xsl:otherwise>
									<q style="line-height:18px;"><img src="images/icons/icon-guildmaster.gif" align="absmiddle" hspace="5"/>
                                       <strong><xsl:value-of select="$loc/strs/guild/str[@id='guild-leader']" /></strong>
                                    </q>
								</xsl:otherwise>
							</xsl:choose>
						</td>						
					</tr>			
				</xsl:for-each>
			</tbody>
		</table>
	</div>

	<div class="page-body">
		<div style="padding: 0 12px 0 0; text-align:right;line-height:22px;"><xsl:value-of select="$loc/strs/guild/str[@id='noteten']"/></div>
	</div>


</xsl:template>





</xsl:stylesheet>