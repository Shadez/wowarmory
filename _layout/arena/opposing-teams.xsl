<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<!-- global vars -->
<xsl:variable name="season" select="/page/season/@id" />
<xsl:variable name="teamUrl" select="/page/arenaGameOpposingTeamsReport/arenaTeam/@teamUrl" />

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
<xsl:template match="page/arenaGameOpposingTeamsReport">

	<xsl:choose>
    	<xsl:when test="not(/page/arenaGameOpposingTeamsReport/arenaTeam )">
			<div id="dataElement">
                <div class="parchment-top">
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
                </div>
            </div>
        </xsl:when>
        <xsl:otherwise>
        	<link rel="stylesheet" href="_css/arena-report.css" />
            <link rel="stylesheet" href="_css/datepicker.css" /> 
			<script type="text/javascript" src="_js/arena-report/opposing-teams.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){			
                    initializeOpposingTeams();
                });
            </script>
            
            <div id="dataElement">
                <div class="parchment-top">
                    <xsl:call-template name="opponentHistoryHolder" />
                </div>
            </div>
        </xsl:otherwise>
    </xsl:choose>

</xsl:template>

<xsl:template name="opponentHistoryHolder">
    <div class="parchment-content">
        <div class="list">
			<xsl:call-template name="tabs">
				<xsl:with-param name="tabGroup" select="'arenaTeam'" />
				<xsl:with-param name="currTab" select="'opponentHistory'" />
				<xsl:with-param name="subTab" select="''" />
				<xsl:with-param name="tabUrlAppend" select="/page/arenaGameOpposingTeamsReport/arenaTeam/@teamUrl" />
				<xsl:with-param name="subtabUrlAppend" select="''" />
			</xsl:call-template>
			<div class="full-list">
				<div class="info-pane">
            		<xsl:call-template name="opponentHistoryContent" />
				</div>
			</div>        
        </div>
    </div>


</xsl:template>


<xsl:template name="opponentHistoryContent">
	<xsl:call-template name="arenareport-header">
		<xsl:with-param name="docHeader" select="/page/arenaGameOpposingTeamsReport/arenaTeam"/>
        <xsl:with-param name="whichPage" select="'team'"/>
        <xsl:with-param name="teamSize" select="/page/arenaGameOpposingTeamsReport/arenaTeam/@teamSize"/>
    </xsl:call-template>

	<div id="pager" class="pager page-body" style="text-align:right;">
        <form id="pagingForm" style="margin: 0; padding: 0; display: inline;" onsubmit="return false;">
        	<div id="searchTypeHolder"></div>
            <div style="float: left; margin-left: 5px;">
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
						<span id="currResults" class="bold"><xsl:value-of select="count(/page/arenaGameOpposingTeamsReport/opposingTeam )" /></span>
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalResults" class="bold"><xsl:value-of select="count(/page/arenaGameOpposingTeamsReport/opposingTeam )" /></span>
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
	<table id="teamsTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
		<thead>
			<tr class="masthead">
            	<th style="text-align:left; width: 260px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='opponent']"/><span class='sortArw'> </span></a></th>
                <th style="text-align:left; width: 200px;">
					<a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.realm']"/><span class='sortArw'> </span></a>
				</th>
                <th class="numericSort">
                	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='totalgames']}')">
                    	<xsl:value-of select="$loc/strs/arena/str[@id='totalgames.short']"/><span class='sortArw'> </span></a>
                </th>
                <th class="numericSort">
                	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='wins']}')">
						<xsl:value-of select="$loc/strs/arena/str[@id='wins.short']"/><span class='sortArw'> </span></a>
				</th>
                <th class="numericSort">
					<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='losses']}')">
						<xsl:value-of select="$loc/strs/arena/str[@id='losses.short']"/><span class='sortArw'> </span></a>
				</th>
                <th class="numericSort"><a><xsl:value-of select="$loc/strs/arena/str[@id='winp']"/><span class='sortArw'> </span></a></th>
                <th>
					<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='overallchange.tooltip']}')">
						<xsl:value-of select="$loc/strs/arena/str[@id='overallchange']"/><span class='sortArw'> </span></a>
				</th>
            </tr>
		</thead>
        <tbody>
        	<xsl:for-each select="/page/arenaGameOpposingTeamsReport/opposingTeam">
        		<tr>
                	<td valign="middle">
						<span style="display: none;"><xsl:value-of select="@teamName" /></span>
                    	<xsl:choose>
                        	<xsl:when test="@deleted = 'true'">
								<a href="javascript:void(0)" class="graphLink delGraphLink staticTip" 
									onmouseover="setTipText('{$loc/strs/arena/str[@id='deletedTeam']}');" />
                            	<a href="javascript:void(0)" class="graphTxt staticTip deletedTeam" 
                                	onmouseover="setTipText('{$loc/strs/arena/str[@id='deletedTeam']}');"><xsl:value-of select="@teamName" /></a>
                            </xsl:when>
                            <xsl:otherwise>
								<a href="arena-team-game-chart.xml?{@teamUrl}" class="graphLink staticTip" 
									onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='viewTeamHistory']}');" />                            	
								<a class="graphTxt staticTip" onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='viewTeamProfile']}');" 
									href="team-info.xml?{@teamUrl}"><xsl:value-of select="@teamName" /></a>
                            </xsl:otherwise>
                        </xsl:choose>
					</td>
                    <td><xsl:value-of select="@realm" /></td>
                    <td class="rightNum"><span style="display: none;"><xsl:value-of select="@games" /></span><xsl:value-of select="@games" /></td>
                    <td class="rightNum"><xsl:value-of select="@wins" /></td>
                    <td class="rightNum"><xsl:value-of select="@losses" /> </td>
                    <td class="rightNum"><xsl:value-of select="@winPer" />%</td>
                    <td class="rightNum">
						<span style="display: none;"><xsl:value-of select="@rd" /></span>
						<a href="arena-team-game-chart.xml?{/page/arenaGameOpposingTeamsReport/arenaTeam/@teamUrl}&amp;_opp={@teamName}"
							class="matchReportDetails staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='viewmatchhistory']}');" />
						<xsl:call-template name="ratingChange"><xsl:with-param name="ratingNum" select="@rd" /></xsl:call-template>
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
	<span class="graphTxt" style="font-weight: bold; color: #336600; text-align:right;">
        <xsl:if test="$ratingNum &lt; 0">
            <xsl:attribute name="style">font-weight: bold; color: #CC0000;</xsl:attribute>
        </xsl:if>
        <xsl:if test="$ratingNum &gt; 0">+</xsl:if>
        <xsl:value-of select="$ratingNum" />
    </span>
</xsl:template>

</xsl:stylesheet>
