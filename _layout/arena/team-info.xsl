<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<!-- global vars -->
<xsl:variable name="season" select="/page/season/@id" />
<xsl:variable name="teamUrl" select="/page/teamInfo/arenaTeam/@urlEscape" />

<xsl:include href="../includes.xsl"/>
<xsl:include href="header.xsl"/>
<xsl:include href="team-statistics.xsl"/>

<xsl:variable name="teamUrlFlash">
	<xsl:call-template name="search-and-replace">
        <xsl:with-param name="input" select="$teamUrl" />
        <xsl:with-param name="search-string" select="'&amp;'" />
        <xsl:with-param name="replace-string" select="'%26'" />
	</xsl:call-template>
</xsl:variable>

<!-- layout call -->
<xsl:template match="page/teamInfo/arenaTeam">

	<xsl:choose>
    	<xsl:when test="not(/page/teamInfo/arenaTeam/@url)">
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
        
			<script type="text/javascript" src="_js/arena-report/team-info.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){			
                    initializeTeamInfo();
                });	
            </script>
            
            <div id="dataElement">
                <div class="parchment-top">
                    <xsl:call-template name="teamInfoHolder" />
                </div>
            </div>
    	</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="teamInfoHolder">
	<!-- tabs -->
    <div class="parchment-content">
        <div class="list">			
			<xsl:call-template name="tabs">
				<xsl:with-param name="tabGroup" select="'arenaTeam'" />
				<xsl:with-param name="currTab" select="'teamInfo'" />
				<xsl:with-param name="subTab" select="''" />
				<xsl:with-param name="tabUrlAppend" select="/page/teamInfo/arenaTeam/@teamUrl" />
				<xsl:with-param name="subtabUrlAppend" select="''" />
			</xsl:call-template>
			<div class="full-list">
				<div class="info-pane">
            		<xsl:call-template name="teamInfoContent" />
				</div>
			</div>        
        </div>
    </div>
</xsl:template>

<xsl:template name="teamInfoContent">
	<xsl:call-template name="arenareport-header">
        <xsl:with-param name="parchtitle" select="'Match History'"/>
        <xsl:with-param name="teamSize" select="/page/teamInfo/arenaTeam/@teamSize"/>
		<xsl:with-param name="whichPage" select="'team'"/>
		<xsl:with-param name="docHeader" select="/page/teamInfo/arenaTeam" />
    </xsl:call-template>

	<xsl:variable name="isPropass">
		<xsl:choose>
			<xsl:when test="character/@tournamentRealm">true</xsl:when>
		<xsl:otherwise>false</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<xsl:variable name="teamUrl" select="@urlEscape" />
	<xsl:variable name="size">
		<xsl:choose>
			<xsl:when test="@size = 2"> 
				<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.team-info.2v2']"/>
			</xsl:when>  
			<xsl:when test="@size = 3"> 
				<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.team-info.3v3']"/>
			</xsl:when>                 
			<xsl:otherwise>
				<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.team-info.5v5']"/>
			</xsl:otherwise>            
		</xsl:choose>   
	</xsl:variable>
	<xsl:variable name="whichLadderType">
  	<xsl:choose>
    	<xsl:when test="@size = 2"> 
      	<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.2v2-arena-ladder']"/>
      </xsl:when>  
      <xsl:when test="@size = 3"> 
        <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.3v3-arena-ladder']"/>
      </xsl:when>                 
      <xsl:otherwise>
        <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.5v5-arena-ladder']"/>
    	</xsl:otherwise>            
  	</xsl:choose>   
	</xsl:variable>

	<xsl:call-template name="teamStatistics">
         <xsl:with-param name="whichPage" select="'team'"/>
         <xsl:with-param name="characterName" select="''"/>   
         <xsl:with-param name="theSize" select="@size"/>
         <xsl:with-param name="isPropass" select="$isPropass"/>
    </xsl:call-template>

	<div class="data">
        <table id="teamsTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
            <thead>
                <tr class="masthead">
                    <th style="text-align:left; width: 150px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='teammembers']"/><span class='sortArw'> </span></a></th>
                    <th style="text-align:left; width: 240px;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.guild']"/><span class='sortArw'> </span></a></th>
                    <th style="text-align:left; width: 130px;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.race-class']"/><span class='sortArw'> </span></a></th>
                    <th>
                        <a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='totalgames']}')">
                        <xsl:value-of select="$loc/strs/arena/str[@id='totalgames.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th>
                        <a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='wins']}')">
                        <xsl:value-of select="$loc/strs/arena/str[@id='wins.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th>
                        <a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='losses']}')">
                        <xsl:value-of select="$loc/strs/arena/str[@id='losses.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th><a><xsl:value-of select="$loc/strs/arena/str[@id='winp']"/><span class='sortArw'> </span></a></th>
                    <th>
                        <a class="staticTip" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.labels.personalrating']}')">
                        <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.personalrating.short']"/><span class='sortArw'> </span></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="/page/teamInfo/arenaTeam/members/character">
                	<xsl:variable name="classTxt"	select="$loc/strs/classes/str[@id=concat('armory.classes.class.',current()/@classId,'.',current()/@genderId)]" />
                    <xsl:variable name="raceTxt"	select="$loc/strs/races/str[@id=concat('armory.races.race.',current()/@raceId,'.',current()/@genderId)]" />
                    <xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />               
 					               
                    <tr>
                    	<xsl:if test="current()/@teamRank = '0'">
                        	<xsl:attribute name="class">data3</xsl:attribute>
                        </xsl:if>
                        <td><a href="character-sheet.xml?{@charUrl}"><xsl:value-of select="@name" /></a></td>
                        <td><a href="guild-info.xml?{@guildUrl}"><xsl:value-of select="@guild" /></a></td>
                        <td>
                        	<img class="staticTip" onmouseover="setTipText('{$raceTxt}');" src="images/icons/race/{@raceId}-{@genderId}.gif" />&#160;
                            <img class="staticTip" onmouseover="setTipText('{$classTxt}');" src="images/icons/class/{@classId}.gif" />
						</td>
                        <td class="rightNum"><xsl:value-of select="@seasonGamesPlayed" /></td>
                        <td class="rightNum" style="color: #678705;"><xsl:value-of select="@seasonGamesWon" /> </td>
                        <td class="rightNum" style="color: #9A1401;"><xsl:value-of select="@seasonGamesPlayed - @seasonGamesWon" /> </td>
                        <td class="rightNum">
							<xsl:choose>
								<xsl:when test="@seasonGamesPlayed = 0">
									0%
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="round((@seasonGamesWon div @seasonGamesPlayed) * 100)" />%		
								</xsl:otherwise>
							</xsl:choose>						
						</td>
                        <td class="rightNum"><xsl:value-of select="@contribution" /></td>                    	
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
    </div>
</xsl:template>



</xsl:stylesheet>
