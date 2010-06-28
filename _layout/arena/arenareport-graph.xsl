<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<!-- global vars -->

<xsl:variable name="docHeader" select="document(concat('../../team-info.xml?', /page/gameListingChart/arenaTeam/@teamUrl))/page/teamInfo/arenaTeam" />
<xsl:variable name="season" select="/page/season/@id" />
<xsl:variable name="teamUrl" select="/page/gameListingChart/arenaTeam/@teamUrl" />

<xsl:include href="../includes.xsl"/>
<xsl:include href="header.xsl"/>

<xsl:variable name="teamUrlFlash">
	<xsl:call-template name="search-and-replace">
        <xsl:with-param name="input" select="$teamUrl" />
        <xsl:with-param name="search-string" select="'&amp;'" />
        <xsl:with-param name="replace-string" select="'%26'" />
	</xsl:call-template>
</xsl:variable>

<!-- layout call -->
<xsl:template match="page/gameListingChart"><link rel="stylesheet" href="_css/arena-report.css" /><link rel="stylesheet" href="_css/datepicker.css" />
	
    <div id="dataElement">
        <div class="parchment-top">
            <xsl:call-template name="arenaReportGraphHolder" />
        </div>
    </div>
</xsl:template>

<xsl:template name="arenaReportGraphHolder">
	<xsl:choose>
    	<xsl:when test="not(/page/gameListingChart/arenaTeam)">
        	<div class="parchment-content">
                <div class="list">
                    <div class="full-list notab">
                        <div class="info-pane" style="height: 300px;">
                        	<div style="height: 200px; padding: 10px; text-align:center;">
	                            <xsl:value-of select="$loc/strs/arena/str[@id='error.nodata']"/>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </xsl:when>
        <xsl:otherwise>            
            <div class="parchment-content">
                <div class="list">
					<xsl:call-template name="tabs">
						<xsl:with-param name="tabGroup" select="'arenaTeam'" />
						<xsl:with-param name="currTab" select="'matchHistory'" />
						<xsl:with-param name="subTab" select="''" />
						<xsl:with-param name="tabUrlAppend" select="/page/gameListingChart/arenaTeam/@teamUrl" />
						<xsl:with-param name="subtabUrlAppend" select="''" />
					</xsl:call-template>					
                    <div class="full-list">
                        <div class="info-pane">
                            <xsl:call-template name="arenaReportGraphContent" />
                        </div>
                    </div>
                </div>
            </div>        
        </xsl:otherwise>    
    </xsl:choose>
</xsl:template>


<xsl:template name="arenaReportGraphContent">

	<!-- call team header -->
	<xsl:call-template name="arenareport-header">
        <xsl:with-param name="parchtitle" select="'Match History'"/>
        <xsl:with-param name="teamSize" select="/page/gameListingChart/arenaTeam/@teamSize"/>
		<xsl:with-param name="whichPage" select="'team'"/>
		<xsl:with-param name="docHeader" select="/page/gameListingChart/arenaTeam" />
    </xsl:call-template>
    
    <!-- match history graph title -->
    <div class="filterTitle">
        <xsl:value-of select="$loc/strs/arenaReport/str[@id='matchhistorygraphfor']"/>
        <span class="detailsBlueItalicDates">
			(<span id="blueStartDate" /> - <span id="blueEndDate" />)
		</span>
	</div>	
	<xsl:choose>
		<xsl:when test="not(/page/gameListingChart/games/game)">
			<div id="graphNone">
				<xsl:value-of select="$loc/strs/arenaReport/str[@id='nogames']"/>
			</div>
		</xsl:when>
		<xsl:otherwise>
			<xsl:call-template name="gameGraph" />		
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>




<xsl:template name="gameGraph">

	<script type="text/javascript" src="_js/arena-report/graph.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			//"no search results" text, season start date, season end date
			initializeArenaReportGraph(
				"<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.noSearchResults']" />",
				"<xsl:value-of select="/page/season/@start" />",
				"<xsl:value-of select="/page/season/@end" />",
				"<xsl:value-of select="/page/gameListingChart/games/game/@realmOffset" />",
				"<xsl:value-of select="/page/gameListingChart/arenaTeam/@highestRating" />",
				"<xsl:value-of select="/page/gameListingChart/arenaTeam/@lowestRating" />",
				"<xsl:value-of select="/page/gameListingChart/arenaTeam/@battleGroup" />",
				"<xsl:value-of select="$loc/strs/arena/str[@id='current']"/>"
			);
		});			
	</script>
	<span id="gameStartVal" style="display:none; width: 0; height: 0;"><xsl:value-of select="/page/season/@start" /></span>
	<span id="serverOffset" style="display:none; width: 0; height: 0;"><xsl:value-of select="/page/gameListingChart/games/game/@realmOffset" /></span>


	<!-- flash graph -->
    <div id="graphContainer">
		<div id="infoBubbleHolder">		
		
			<div id="rightBubble" style="white-space:nowrap">
				<div id="textEndDate" style="white-space:nowrap"></div>
				<span class="detailsBrownItalic" style="white-space:nowrap"><xsl:value-of select="$loc/strs/arenaReport/str[@id='ratingcolon']"/></span>
                <span id="textRatingRight" class="detailsBrownItalicLarge" style="white-space:nowrap"/>
			</div>
			
			<div style="width: 340px; height: 39px; left: 279px; position: absolute;">
				<div id="containerDetails">
					<div style="position: absolute; margin: 9px 0 0 8px;">
						<span class="detailsBrownItalic" style="padding-right: 5px; white-space:nowrap;">
							<xsl:value-of select="$loc/strs/arenaReport/str[@id='datecolon']"/>
						</span>
						<span id="textDate" class="bold detailsBlueItalic" style="white-space:nowrap;"/>
					</div>
					<div style="position: absolute; margin: 27px 0 0 8px;">
						<span class="detailsBrownItalic" style="padding-right: 5px; white-space:nowrap;">
							<xsl:value-of select="$loc/strs/arenaReport/str[@id='opponentcolon']"/>
						</span>
						<span id="textOpponent" class="bold detailsBlueItalic"/>
					</div>
					<div style="position: absolute; margin: 15px 0 0 165px; width: 150px; text-align: right; height: 30px; line-height: 22px;">
						<span id="textRatingNew" style="white-space:nowrap"/>
					</div>
					<div style="position: absolute; margin: 11px 0 0 290px; width: 50px; text-align: right; height: 30px;line-height: 22px;;">
						<span id="textRatingChange" class="detailsRatingChangeGreen" style="white-space:nowrap"/>
					</div>
				</div>
				<div id="containerDelta" style="white-space:nowrap">
					<div style="position: absolute; margin: 9px 0 0 8px;">
						<span class="detailsBlueItalic" style="white-space:nowrap;"><xsl:value-of select="$loc/strs/arenaReport/str[@id='gamesdisplayed']"/></span> 
						<span id="textGamesPlayed" class="bold detailsBrown" style="white-space:nowrap;"/>&#xa0;
						<span class="bold detailsBrown" style="white-space:nowrap;"><xsl:value-of select="$loc/strs/arenaReport/str[@id='of']"/></span>&#xa0;
						<span id="textTotalGames" class="bold detailsBrown" style="white-space:nowrap;"/>
					</div>
					<div style="position: absolute; margin: 26px 0 0 8px; white-space:nowrap;">
						<span class="detailsBlueItalic staticTip" onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='netchange.selection']}')" 
							style="white-space:nowrap;"><xsl:value-of select="$loc/strs/arenaReport/str[@id='netchange.selection.short']"/></span> 
						<span id="textRatingChangeInterval" class="bold" style="white-space:nowrap;"/>
						<span class="limitAverageBrown" style="padding-left: 10px;">
						(						
							<xsl:apply-templates mode="printf" select="$loc/strs/arenaReport/str[@id='averagechange']">
								<xsl:with-param name="param1">
									<span id="textRatingChangeAverage" style="white-space:nowrap;"/>
								</xsl:with-param>	
							</xsl:apply-templates>
						)
						</span>
					</div>
				</div>			
			</div>
			
			<div id="leftBubble"  style="white-space:nowrap">
				<div id="textStartDate" style="white-space:nowrap;"></div>
				<span class="detailsBrownItalic" style="white-space:nowrap;"><xsl:value-of select="$loc/strs/arenaReport/str[@id='ratingcolon']"/></span>
                <span id="textRatingLeft" style="white-space:nowrap;" class="detailsBrownItalicLarge"/>
			</div>
		</div>
		

        <div id="arenaFlashOuter">	
            <xsl:call-template name="flash">
                <xsl:with-param name="id" select="'arenaflash'"/>
                <xsl:with-param name="src" select="'_flash/graph.swf'"/>
                <xsl:with-param name="base" select="''"/>
                <xsl:with-param name="wmode" select="'transparent'"/>
                <xsl:with-param name="width" select="'875'"/>
                <xsl:with-param name="height" select="'470'"/>
                <xsl:with-param name="quality" select="'autohigh'"/>
                <xsl:with-param name="flashvars" select="concat('arenaSeason=', $season, '&amp;teamSize=', 
					/page/gameListingChart/arenaTeam/@teamSize, '&amp;teamRealm=', 
					/page/gameListingChart/arenaTeam/@realm,'&amp;teamName=',/page/gameListingChart/arenaTeam/@name)"/>
                <xsl:with-param name="noflash" select="concat('&lt;div class=teamicon-noflash&gt;&lt;a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&gt;&lt;img src=images/',$lang,'/getflash.png class=p/&gt;&lt;/a&gt;&lt;/div&gt;')"/>
            </xsl:call-template>
        </div>

    
        <div id="graphBottom">
            <a id="matchHighlight" class="detailsBlueItalic" style="margin: 0 25px 0 0; display: none;" href="javascript:FnClearHighlightInFlash();">
                <xsl:value-of select="$loc/strs/arenaReport/str[@id='clearmatchhighlight']"/>
            </a>
            <a class="detailsBlueItalic" style="margin: 0 15px 0 0;" href="javascript:FnViewRecentInFlash();">
                <xsl:value-of select="$loc/strs/arenaReport/str[@id='viewrecentgames']"/>
            </a>
            <a class="detailsBlueItalic" style="margin: 0 15px 0 0;" href="javascript:FnViewSeasonInFlash();">
                <xsl:value-of select="$loc/strs/arenaReport/str[@id='viewcompleteseason']"/>
            </a>
        </div>
	</div>

    <div id="matchHolder">
		<!-- show sortable table -->
		<xsl:call-template name="matchTable" />
	</div>
	
	<div id="errorLoadingArenaData" style="display: none;">
		<xsl:value-of select="$loc/strs/guildBank/str[@id='errorcontent']"/>
	</div>
</xsl:template>

<xsl:template name="matchTable">	
    <div class="filterTitle">
		<xsl:value-of select="$loc/strs/arenaReport/str[@id='matchhistoryfilters']"/>            
    </div>
    
    <div class="filtercontainer">    
        <div id="opponentFilter" class="filterBox">
			<xsl:value-of select="$loc/strs/arena/str[@id='opponent']" /><br />
			<input id="opponentVal" type="text" size="30" maxlength="30" value="" class="filterInput" style="width: 200px;"/>
        </div>
        <div id="dateRange" class="filterBox">
			<xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.dateRange']" /><br />
			<span id="dateStart" class="filterInput"></span>
			<a id="dateStartLink" class="calIcon" href="javascript:void(0)"> </a>            
			<span class="inlineTxt"> - </span>            
			<span id="dateEnd" class="filterInput"></span>    
			<a id="dateEndLink" class="calIcon"  href="javascript:void(0)"> </a>
        </div>
    
    	<div id="rating" class="filterBox">
			<xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.ratingBetween']" /><br />            
			<input id="ratingMin" type="text" maxlength="4" value="{/page/gameListingChart/arenaTeam/@lowestRating}" class="filterInput" />
			<span class="inlineTxt"> - </span>            
			<input id="ratingMax" type="text" maxlength="4" value="{/page/gameListingChart/arenaTeam/@highestRating}" class="filterInput" />
        </div>
        
        <div id="ratingChangeBox" class="filterBox">
			<xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.ratingChange']" /><br />				
			<select id="ratingLogic" style="width: 60px; margin-right: 5px; float: left;">
				<option value="all"><xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.all']" /></option>
				<option value="eq">=</option>
				<option value="gt">&gt;</option>
				<option value="gte">&gt;=</option>
				<option value="lt">&lt;</option>
				<option value="lte">&lt;=</option>
			</select>
			<input id="ratingChange" type="text" maxlength="4" value="" class="filterInput" />
        </div>
		<div class="clear"></div>		
		
		<div id="filterButtonHolder">
			<a id="runFilterButton" href="javascript:void(0)" onclick="runFilters();">
				<span class="btnRight"><xsl:value-of select="$loc/strs/guildBank/str[@id='runfilters']"/></span>
			</a>            
			<a id="resetFilterButton" href="javascript:void(0)" onclick="resetFilters();">
				<xsl:value-of select="$loc/strs/guildBank/str[@id='resetfilters']"/>
			</a>
		</div>
		
		<div class="clear"></div>		
    </div>

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
						<span id="currResults" class="bold"><xsl:value-of select="count(/page/gameListingChart/games/game)" /></span>
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalResults" class="bold"><xsl:value-of select="count(/page/gameListingChart/games/game)" /></span>
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
        <table id="matchTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
            <thead>
                <tr class="masthead">
                    <th style="text-align:left; width: 400px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='opponent']"/><span class='sortArw'> </span></a></th>
                    <th style="text-align:left; width: 120px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='newrating']"/><span class='sortArw'> </span></a></th>
                    <th style="text-align:left;">
						<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='overallchange.tooltip']}')">
                        <xsl:value-of select="$loc/strs/arena/str[@id='overallchange']"/><span class='sortArw'> </span></a>
					</th>
                    <th style="text-align: left; width: 270px;">
						<a style="padding-left: 10px;"><xsl:value-of select="$loc/strs/arena/str[@id='date']"/><span class='sortArw'> </span></a>
					</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="/page/gameListingChart/games/game">
					<tr>
						<td>
							<span style="display: none;"><xsl:value-of select="@ot" /></span>
							<xsl:choose>
								<xsl:when test="@deleted = 'true'">
									<a href="javascript:void(0)" class="graphLink delGraphLink staticTip" 
										onmouseover="setTipText('{$loc/strs/arena/str[@id='deletedTeam']}');" />
									<a href="javascript:void(0)" class="graphTxt staticTip deletedTeam" 
										onmouseover="setTipText('{$loc/strs/arena/str[@id='deletedTeam']}');"><xsl:value-of select="@ot" /></a>
								</xsl:when>
								<xsl:otherwise>
									<a href="arena-team-game-chart.xml?{@teamUrl}" class="graphLink staticTip" 
										onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='viewTeamHistory']}');" />
									<a class="graphTxt staticTip" onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='viewTeamProfile']}');" 
										href="team-info.xml?{@teamUrl}"><xsl:value-of select="@ot" /></a>
								</xsl:otherwise>
							</xsl:choose>
						</td>                    
						<td class="rightNum"><xsl:value-of select="@r" /></td>
						<td class="rightNum">
							<!-- calc change -->
							<xsl:choose>
								<xsl:when test="position() = 1">
									<xsl:call-template name="ratingChange">
										<xsl:with-param name="ratingNum" select="current()/@r - 0" />
									</xsl:call-template>
								</xsl:when>
								<xsl:otherwise>
									<xsl:variable name="lastPos" select="position() - 1" />
									<xsl:call-template name="ratingChange">
										<xsl:with-param name="ratingNum" select="current()/@r - /page/gameListingChart/games/game[$lastPos]/@r" />
									</xsl:call-template>
								</xsl:otherwise>
							</xsl:choose>
						</td>
						<td style="font-weight: normal;">
							<span style="display: none;"><xsl:value-of select="@st" /></span>
							<span class="timeFormat"><xsl:value-of select="@st" /></span>
							<a class="staticTip goToMatchReport" onmouseover="setTipText('{$loc/strs/arena/str[@id='goToMatchReport']}')" 
								href="arena-game.xml?gid={@id}&amp;r={/page/gameListingChart/arenaTeam/@realmName}"> </a>
							<a class="staticTip findMatch" onmouseover="setTipText('{$loc/strs/arena/str[@id='findMatch']}')" 
								href="javascript:void(0)" onclick="FnHighlightInFlash('{@id}')"></a>
						</td>
					</tr>
                </xsl:for-each>
            </tbody>
        </table>
    </div>

</xsl:template>


<!-- shows +/- and color for rating change -->
<xsl:template name="ratingChange">
	<xsl:param name="ratingNum" />    
	<span style="font-weight: bold; color: #336600; text-align:right">
        <xsl:if test="$ratingNum &lt; 0">
            <xsl:attribute name="style">font-weight: bold; color: #CC0000;</xsl:attribute>
        </xsl:if>
        <xsl:if test="$ratingNum &gt; 0">+</xsl:if>
        <xsl:value-of select="$ratingNum" />
    </span>
</xsl:template>

</xsl:stylesheet>