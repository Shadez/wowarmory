<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="../items/filters.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="page/armorySearch">
	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">					
					<xsl:choose>
						<xsl:when test="tabs/@count = '0'">
							<xsl:call-template name="noSearchResults" />
						</xsl:when>
						<xsl:otherwise>
							<xsl:call-template name="searchTabs" />
								<div class="full-list">
									<div class="info-pane">
										<xsl:call-template name="searchTable" />	
									</div>
								</div>
						</xsl:otherwise>					
					</xsl:choose>
				</div>
			</div>
		</div>
	</div>
</xsl:template>

<!-- when there are no search results -->
<xsl:template name="noSearchResults">
	<div class="full-list notab" style="margin-top: 30px;">
		<div class="info-pane">
			<div class="generic-content">
				<div class="nrcontent">
					<div class="noresult-header"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.noSearchResults']"/></div>
					<div class="noresults">
						<h5><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.noSearchResultsText']"/></h5>
						<div class="default-list">
							<ul>
								<li><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.search.categories']"/></li>
								<li><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.search.name']"/></li>
							</ul>
						</div>
					</div>
					<div class="noresult-footer"><a href="index.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.search.return']"/></a></div>
				</div>
			</div>
		</div>
	</div>
    <script>
		$(document).ready(function(){ $("#armorySearch").val(armory_query.searchQuery); });
    </script>
</xsl:template>

<xsl:template name="searchTabs">

	<xsl:variable name="relColIndex">
		<xsl:choose>
			<xsl:when test="tabs/@selected = 'characters'">8</xsl:when>
			<xsl:when test="tabs/@selected = 'guilds'">4</xsl:when>
			<xsl:when test="tabs/@selected = 'items'">3</xsl:when>
			<xsl:when test="tabs/@selected = 'arenateams'">6</xsl:when>
		</xsl:choose>
	</xsl:variable>


	<script type="text/javascript" src="_js/items/functions.js"></script>
	<script type="text/javascript" src="_js/search/search.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){	
			changetype('all');
			
			var filterValues = [];
			
			//store filters
			<xsl:for-each select="searchResults/filters/filter">
					filterValues["<xsl:value-of select="@name" />"] = "<xsl:value-of select="@value" />";
			
			</xsl:for-each>			
			
			function initSearchr(){ initSearchResults("<xsl:value-of select="tabs/@selected" />", "<xsl:value-of select="searchResults/@searchText" />", "<xsl:value-of select="searchResults/items/@pn" />", filterValues, "<xsl:value-of select="$relColIndex" />");  }
			<xsl:comment>"</xsl:comment>		
		
			//Gecko timeout. Doc.ready() gets called too soon
			if( Browser.safari || Browser.chrome ) setTimeout(function() { initSearchr() }, 0); 
			else initSearchr()
			});	
	</script>

	<xsl:variable name="searchType" select="searchResults/@searchType" />
	<xsl:variable name="searchText" select="searchResults/@searchText" />

	<div class="tabs"> 
		<!-- print top-level tabs -->
		<xsl:for-each select="tabs/tab">
			<xsl:if test="@count &gt; 0">
				<div class="tab">
					<xsl:if test="@type = ../@selected">
						<xsl:attribute name="class">selected-tab</xsl:attribute>
					</xsl:if>
					<a href="search.xml?searchType={$searchType}&amp;searchQuery={$searchText}&amp;selectedTab={@type}">
						<xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@label]" /> <span class="tab-count" style="display: inline;">(<xsl:choose><xsl:when test="@count &gt; 200">200</xsl:when><xsl:otherwise><xsl:value-of select="@count" /></xsl:otherwise></xsl:choose>)</span>
					</a>
				</div>
			</xsl:if>
		</xsl:for-each>
		<div class="clear"></div>
	</div>
	
	<div class="subTabs" style="height: 1px;">
		<div class="upperLeftCorner" style="height: 5px;"></div>
		<div class="upperRightCorner" style="height: 5px;"></div>			
	</div>
</xsl:template>

<xsl:template name="searchTable">
	<xsl:variable name="selTab" select="tabs/@selected" />
	<xsl:variable name="selTabLabel" select="tabs/tab[@type=$selTab]/@label" />
	
	<blockquote>
		<b class="i{tabs/@selected}">
			<h4><a href="index.xml"><xsl:value-of select="$loc/strs/common/str[@id='search-armory']" /></a></h4>
			<h3 id="replaceHeaderTitle"><xsl:value-of select="$loc/strs/unsorted/str[@id=$selTabLabel]" /></h3>
		</b>
	</blockquote>
	
	<!-- show item filters -->
	<xsl:if test="tabs/@selected = 'items' and not(searchResults/items/@pn)">
		<div class="filter-containter" style="display: block; margin-bottom: 25px;">
			<p>
				<div class="filter-loc">
					<div class="open-filter">
						<em class="copy-link-left">		
							<a href="javascript: toggleItemFilter();triggerRender();" class="filter-red">
								<xsl:variable name="textShowFilters" select="$loc/strs/items/str[@id='armory.item-search.showitemfilters']" />		
								<strong id="replaceShowFilters1"><xsl:value-of select="$textShowFilters" /></strong>
								<b id="replaceShowFilters2"><xsl:value-of select="$textShowFilters" /></b>
							</a>
						</em>
					</div>
				</div>
			</p>
		</div>
		<div class="clear"></div>
		<!--filterBox-->
		<div id="showHideItemFilters" class="searchPageIeFix">
			<xsl:if test="tabs/@selected = 'items'" >
				<xsl:call-template name="templateFormItem">
					<xsl:with-param name="templateClass" select="'detail-search-results'" />
				</xsl:call-template>
			</xsl:if>
			<div class="clear"></div>
		</div>
	</xsl:if>
	
	<div class="clear" style="border:1px solid transparent"><!-- border ensures ie doesn't ignore the element --></div>
	
	<!-- pager -->	
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
						<span id="currResults" class="bold"></span>
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalResults" class="bold"><xsl:value-of select="tabs/tab[@type=$selTab]/@count" /></span>
					</xsl:with-param>
				</xsl:apply-templates>
				
				
						<!-- <span id="currResults" class="bold"></span>
					<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.showingTotal']">
						<xsl:with-param name="param1">
							<span id="totalResults" class="bold"><xsl:value-of select="tabs/tab[@type=$selTab]/@count" /></span>
						</xsl:with-param>
					</xsl:apply-templates> -->
				
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
                <option value="10">10</option>
                <option selected="selected" value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
            </select>
        </form>
    </div>

	<!-- choose template based on result type -->
	<div class="data">
        <table id="searchResultsTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
			<xsl:choose>
				<xsl:when test="tabs/@selected = 'characters'">
					<xsl:call-template name="characterResults" />	
				</xsl:when>
				<xsl:when test="tabs/@selected = 'guilds'">
					<xsl:call-template name="guildResults" />	
				</xsl:when>
				<xsl:when test="tabs/@selected = 'items'">
					<xsl:call-template name="itemResults" />	
				</xsl:when>
				<xsl:when test="tabs/@selected = 'arenateams'">
					<xsl:call-template name="arenaResults" />	
				</xsl:when>
			</xsl:choose>
		</table>
	</div>
</xsl:template>

<xsl:template name="characterResults">
	<thead>
		<tr class="masthead">
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.character-name']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.level']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.race']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.class']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/semicommon/str[@id='faction']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.guild']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/semicommon/str[@id='realm']" /><span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/arena/str[@id='battlegroup']" /><span class='sortArw'> </span></a></th>
			<th style="width: 90px;"><a><xsl:value-of select="$loc/strs/common/str[@id='search.relevance']" /><span class='sortArw'> </span></a></th>
		</tr>
	</thead>
	<tbody>
		<xsl:for-each select="searchResults/characters/character">
			<xsl:sort select="@relevance" />
			<xsl:variable name="classTxt"	select="$loc/strs/classes/str[@id=concat('armory.classes.class.',current()/@classId,'.',current()/@genderId)]" />
			<xsl:variable name="raceTxt"	select="$loc/strs/races/str[@id=concat('armory.races.race.',current()/@raceId,'.',current()/@genderId)]" />
			<xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />
		
			<tr>
				<td><a href="character-sheet.xml?{@url}"><xsl:value-of select="@name" /></a></td>
				<td class="rightNum"><xsl:value-of select="@level" /></td>
				<td style="text-align:right;">
					<span style="display: none;"><xsl:value-of select="$raceTxt" /></span>
					<img class="staticTip" onmouseover="setTipText('{$raceTxt}');" src="images/icons/race/{@raceId}-{@genderId}.gif" /></td>
				<td>
					<span style="display: none;"><xsl:value-of select="$classTxt"/></span>
					<img class="staticTip" onmouseover="setTipText('{$classTxt}');" src="images/icons/class/{@classId}.gif" /></td>
				
				<td class="centNum"><img class="staticTip" onmouseover="setTipText('{$factionTxt}');" src="images/icons/faction/icon-{@factionId}.gif" /></td>
				<td><a href="guild-info.xml?{@guildUrl}"><xsl:value-of select="@guild" /></a></td>
				<td><xsl:value-of select="@realm" /></td>
				<td><xsl:value-of select="@battleGroup" /></td>
				<td><span style="display: none;"><xsl:value-of select="@relevance" />%</span>
					<q class="staticTip" onmouseover="setTipText('{@relevance}%');">
						<del class="rel-container"><a><em style="width:{@relevance}%"></em></a></del>
					</q></td>					
			</tr>
		</xsl:for-each>
	</tbody>

</xsl:template>

<xsl:template name="guildResults">
	<thead>
		<tr class="masthead">
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.guild']" /><span class='sortArw'> </span></a></th>
			<th style="width: 200px;"><a><xsl:value-of select="$loc/strs/semicommon/str[@id='realm']" /><span class='sortArw'> </span></a></th>
			<th style="width: 200px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='battlegroup']" /><span class='sortArw'> </span></a></th>
			<th style="width: 100px;"><a><xsl:value-of select="$loc/strs/semicommon/str[@id='faction']" /><span class='sortArw'> </span></a></th>
			<th style="width: 120px;"><a><xsl:value-of select="$loc/strs/common/str[@id='search.relevance']" /><span class='sortArw'> </span></a></th>
		</tr>
	</thead>
	<tbody>
		<xsl:for-each select="searchResults/guilds/guild">
			<xsl:sort select="@relevance" />
			<xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />		
			<tr>
				<td><a href="guild-info.xml?{@url}"><xsl:value-of select="@name" /></a></td>
				<td><xsl:value-of select="@realm" /></td>
				<td><xsl:value-of select="@battleGroup" /></td>
				<td class="centNum"><img class="staticTip" onmouseover="setTipText('{$factionTxt}');" src="images/icons/faction/icon-{@factionId}.gif" /></td>
				<td><span style="display: none;"><xsl:value-of select="@relevance" />%</span>
					<q class="staticTip" onmouseover="setTipText('{@relevance}%');">
						<del class="rel-container"><a><em style="width:{@relevance}%"></em></a></del>
					</q></td>					
			</tr>
		</xsl:for-each>
	</tbody>
</xsl:template>

<xsl:template name="itemResults">
	<thead>
		<tr class="masthead">
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.item']" /><span class='sortArw'> </span></a></th>
			<th style="width: 150px;"><a><xsl:value-of select="$loc/strs/itemsSearch/str[@id='armory.search.itemLevel']" /><span class='sortArw'> </span></a></th>
			<th style="width: 250px;"><a><xsl:value-of select="$loc/strs/itemsSearchColumns/str[@id='armory.searchColumn.source']" /><span class='sortArw'> </span></a></th>
			<th style="width: 150px;"><a><xsl:value-of select="$loc/strs/common/str[@id='search.relevance']" /><span class='sortArw'> </span></a></th>
		</tr>
	</thead>
	<tbody>
		<xsl:for-each select="searchResults/items/item">
			<xsl:sort select="@relevance" />
			<tr>
				<td><a id="{@id}" href="item-info.xml?i={@id}" class="rarity{@rarity} staticTip itemToolTip" style="background: url('wow-icons/_images/21x21/{@icon}.png') 0 0 no-repeat; padding: 2px 0 4px 25px;"><xsl:value-of select="@name" /></a></td>
				<td class="leftNum"><xsl:value-of select="filter[@name='itemLevel']/@value" /></td>
				<td>
					<xsl:choose>
						<xsl:when test="current()/filter[@name='source']/@areaName">
							<a href="search.xml?source=dungeon&amp;dungeon={current()/filter[@name='source']/@areaKey}&amp;boss=all&amp;difficulty=all&amp;type=all&amp;searchType=items"><xsl:value-of select="current()/filter[@name='source']/@areaName" /></a>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$loc/strs/itemsSearchColumns/str[@id=concat('armory.searchColumn.', current()/filter[@name='source']/@value)]" />
						</xsl:otherwise>					
					</xsl:choose>
				</td>
				<td style="text-align:left;"><span style="display: none;"><xsl:value-of select="filter[@name='relevance']/@value" />%</span>
					<q class="staticTip" onmouseover="setTipText('{filter[@name='relevance']/@value}%');">
						<del class="rel-container"><a><em style="width:{filter[@name='relevance']/@value}%"></em></a></del>
					</q></td>
			</tr>
		</xsl:for-each>
	</tbody>
</xsl:template>


<xsl:template name="arenaResults">
	<thead>
		<tr class="masthead">
			<th style="width: 100%;"><a><xsl:value-of select="$loc/strs/arena/str[@id='team-name']" /><span class='sortArw'> </span></a></th>			
			<th><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.rating']" /> <span class='sortArw'> </span></a></th>
			<th><a><xsl:value-of select="$loc/strs/arena/str[@id='team-type']" /> <span class='sortArw'> </span></a></th>
			<th style="min-width: 150px;"><a><xsl:value-of select="$loc/strs/semicommon/str[@id='realm']" /><span class='sortArw'> </span></a></th>
			<th style="min-width: 150px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='battlegroup']" /><span class='sortArw'> </span></a></th>
			<th style="min-width: 100px;"><a><xsl:value-of select="$loc/strs/semicommon/str[@id='faction']" /><span class='sortArw'> </span></a></th>
			<th style="width: 120px;"><a><xsl:value-of select="$loc/strs/common/str[@id='search.relevance']" /><span class='sortArw'> </span></a></th>
		</tr>
	</thead>
	<tbody>
		<xsl:for-each select="searchResults/arenaTeams/arenaTeam">
			<xsl:sort select="@relevance" />
			<xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />
			<tr>
				<td><a href="team-info.xml?{@url}"><xsl:value-of select="@name" /></a></td>								
				<td class="rightNum"><span style="font-weight: bold"><xsl:value-of select="@rating" /></span></td>
				<td class="centNum"><xsl:value-of select="@teamSize" /><xsl:value-of select="$loc/strs/arenaReport/str[@id='versus']" /><xsl:value-of select="@teamSize" /></td>
				<td><xsl:value-of select="@realm" /></td>
				<td><xsl:value-of select="@battleGroup" /></td>
				<td class="centNum"><img class="staticTip" onmouseover="setTipText('{$factionTxt}');" src="images/icons/faction/icon-{@factionId}.gif" /></td>
				<td><span style="display: none;"><xsl:value-of select="@relevance" />%</span>
					<q class="staticTip" onmouseover="setTipText('{@relevance}%');">
						<del class="rel-container"><a><em style="width:{@relevance}%"></em></a></del>
					</q></td>
			</tr>
		</xsl:for-each>
	</tbody>
</xsl:template>

</xsl:stylesheet>