<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template name="teamStatistics">
    <xsl:param name="whichPage" />
    <xsl:param name="characterName" />
    <xsl:param name="theSize" />
    <xsl:param name="isPropass" select="'false'" />

	<!--Creation of the rank-->	
    <xsl:variable name="standingPrint">
        <xsl:choose>
            <xsl:when test="@ranking != 0 and @ranking &lt;= 1000">
                <xsl:value-of select="@ranking" /><xsl:call-template name="positionSuffix"><xsl:with-param name="pos" select="@ranking"/></xsl:call-template>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$loc/strs/common/str[@id='armory.none']"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <!--Arena Team Badge-->
	<xsl:call-template name="printBadge">
		<xsl:with-param name="standingPrint" select="$standingPrint" />	
	</xsl:call-template>


	<div class="filterTitle">
		<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.tabs.statistics']"/>
	</div>			
    <div class="stats-container" style="margin-bottom: 10px;">
        <div class="arenaTeam-data">
            <div class="innerData">
                <xsl:choose>
                    <xsl:when test="$whichPage='team'">
                        <xsl:variable name="gamesLostWeek" select="@gamesPlayed - @gamesWon" />
                        <xsl:variable name="gamesLostSeason" select="@seasonGamesPlayed - @seasonGamesWon" />
                        <table>
                            <tr class="team-header">
                                <td></td><td align="center"><strong><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.games']"/></strong></td>
                                <td align="center"><strong><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.win-loss']"/></strong></td>
                                <td align="center"><strong><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.winpercentage']"/></strong></td>
                                <td align="center"><strong><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.teamrating']"/></strong></td>
                            </tr>
                            <tr class="hl">
                                <td><p><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.thisweek']"/></p></td>
                                <td align="center"><p><xsl:value-of select="@gamesPlayed"/></p></td>
                                <td align="center"><p><xsl:value-of select="@gamesWon"/> - <xsl:value-of select="$gamesLostWeek"/></p></td>
                                <td align="center"><p>
                                <xsl:choose>
                                    <xsl:when test="@gamesPlayed=0">0%</xsl:when>
                                    <xsl:otherwise><xsl:value-of select="round((@gamesWon div @gamesPlayed) * 100)" />%</xsl:otherwise>
                                </xsl:choose>
                                </p></td>
                                <td align="center"><p class="rating"><xsl:value-of select="@rating"/></p></td>
                            </tr>
                            <tr>
                                <td><p><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.season']"/></p></td>
                                <td align="center"><p><xsl:value-of select="@seasonGamesPlayed"/></p></td>
                                <td align="center"><p><xsl:value-of select="@seasonGamesWon"/> - <xsl:value-of select="$gamesLostSeason"/></p></td>
                                <td align="center"><p>
                                <xsl:choose>
                                    <xsl:when test="@seasonGamesPlayed=0">0%</xsl:when>
                                    <xsl:otherwise><xsl:value-of select="round((@seasonGamesWon div @seasonGamesPlayed) * 100)" />%</xsl:otherwise>
                                </xsl:choose>
                                </p></td>
                                <td align="center"><p class="rating"><xsl:value-of select="@rating"/></p></td>
                            </tr>
                        </table>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:variable name="gamesLostTeam" select="@seasonGamesPlayed - @seasonGamesWon" />
                        <xsl:variable name="gamesPlayedChar" select="members/character[@name=$characterName]/@seasonGamesPlayed" />
                        <xsl:variable name="gamesWonChar" select="members/character[@name=$characterName]/@seasonGamesWon" />
                        <xsl:variable name="gamesLostChar" select="$gamesPlayedChar - $gamesWonChar" />
                        <table>
                            <tr class="team-header">
                                <td></td><td width="25%" align="center"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.games']"/></span></td>
                                <td width="25%" align="center"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.win-loss']"/></span></td>
                                <td width="25%" align="center"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.winpercentage']"/></span></td>
                                <td width="25%" align="center"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.rating']"/></span></td>
                            </tr>
                            <tr class="hl">
                                <td><p>
                                <xsl:choose>
									<xsl:when test="@size=2"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.twoteamstats']"/></xsl:when>
									<xsl:when test="@size=3"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.threeteamstats']"/></xsl:when>
									<xsl:otherwise><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.fiveteamstats']"/></xsl:otherwise>
                                </xsl:choose>	  
                                </p></td>
                                <td align="center"><p><xsl:value-of select="@seasonGamesPlayed"/></p></td>
                                <td align="center"><p><xsl:value-of select="@seasonGamesWon"/> - <xsl:value-of select="$gamesLostTeam"/></p></td>
                                <td align="center">
                                    <p>
                                    <xsl:choose>
                                        <xsl:when test="@seasonGamesPlayed=0">0%</xsl:when>
                                        <xsl:otherwise><xsl:value-of select="round((@seasonGamesWon div @seasonGamesPlayed) * 100)" />%</xsl:otherwise>
                                    </xsl:choose>	  	  
                                    </p>
                                </td>
                                <td align="center"><p class="rating"><xsl:value-of select="@rating"/></p></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character-info.statsBefore']"/>
                                    <xsl:value-of select="$characterName" />
                                    <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character-info.characterPossessive']"/> 
                                    <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character-info.statsAfter']"/></p>
                                </td>
                                <td align="center"><p><xsl:value-of select="$gamesPlayedChar"/></p></td>
                                <td align="center"><p><xsl:value-of select="$gamesWonChar"/> - <xsl:value-of select="$gamesLostChar"/></p></td>
                                <td align="center">
                                    <p>
                                    <xsl:choose>
                                        <xsl:when test="$gamesPlayedChar=0">0%</xsl:when>
                                        <xsl:otherwise><xsl:value-of select="round(($gamesWonChar div $gamesPlayedChar) * 100)" />%</xsl:otherwise>
                                    </xsl:choose>	  	  	  
                                    </p>
                                </td>
                                <td align="center"><p class="rating"><xsl:value-of select="@rating"/></p></td>
                            </tr>
                        </table>	
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
	</div>
</xsl:template>


<!-- prints pretty badge -->
<xsl:template name="printBadge">

	<xsl:param name="standingPrint" />


    <div class="arena-badge-container" style="float: right; margin-top: 20px;">
        <div class="arenaTeam-badge" style="margin: 0 auto; float: none; padding: 1px;">
            <div><xsl:attribute name="class">teamSide<xsl:value-of select="@factionId" /></xsl:attribute></div>
            <div class="teamRank">
            	<span><xsl:value-of select="$loc/strs/arena/str[@id='lastweek']"/></span>
                <p><xsl:value-of select="$loc/strs/general/str[@id='rank']"/></p>
            </div>
            <div class="rank-num" style="padding-top: 5px;">
                <xsl:attribute name="id">arenarank<xsl:value-of select="@size"/></xsl:attribute>
                    <xsl:call-template name="flash">
                    <xsl:with-param name="id" select="concat('arenarank', @size)"/>
                    <xsl:with-param name="src" select="'images/rank.swf'"/>
                    <xsl:with-param name="wmode" select="'transparent'"/>
                    <xsl:with-param name="width" select="'100'"/>
                    <xsl:with-param name="height" select="'50'"/>
                    <xsl:with-param name="quality" select="'best'"/>
                    <xsl:with-param name="noflash" select="concat('&lt;div class=teamstanding-noflash&gt;',$standingPrint,'&lt;/div&gt;')"/>
                    <xsl:with-param name="flashvars" select="concat('rankNum=', $standingPrint)"/>
                </xsl:call-template>
            </div>
            <div class="arenaBadge-icon">
                <xsl:attribute name="style">
                    <xsl:choose>
                         <xsl:when test="@ranking &gt; 1000 or @ranking=0">background-image:url(images/icons/badges/arena/arena-6.jpg);</xsl:when>
                         <xsl:when test="@ranking &gt; 500">background-image:url(images/icons/badges/arena/arena-5.jpg);</xsl:when>
                         <xsl:when test="@ranking &gt; 100">background-image:url(images/icons/badges/arena/arena-4.jpg);</xsl:when>	 
                         <xsl:when test="@ranking &gt; 10">background-image:url(images/icons/badges/arena/arena-3.jpg);</xsl:when>	 
                         <xsl:when test="@ranking = 1">background-image:url(images/icons/badges/arena/arena-2.jpg);</xsl:when>	 
                         <xsl:otherwise>background-image:url(images/icons/badges/arena/arena-6.jpg);</xsl:otherwise>	 
                    </xsl:choose>
                </xsl:attribute>
                <img class="p">
                    <xsl:attribute name="src">
                        <xsl:choose>
                             <xsl:when test="@ranking &gt; 1000 or @ranking=0">images/badge-border-arena-parchment.gif</xsl:when>
                             <xsl:when test="@ranking &gt; 500">images/badge-border-arena-bronze.gif</xsl:when>
                             <xsl:when test="@ranking &gt; 100">images/badge-border-arena-bronze-large.gif</xsl:when>	 
                             <xsl:when test="@ranking &gt; 10">images/badge-border-arena-silver.gif</xsl:when>	 
                             <xsl:when test="@ranking = 1">images/badge-border-arena-gold.gif</xsl:when>	 
                             <xsl:otherwise>/_images/badge-border-arena-parchment.gif</xsl:otherwise>	 
                        </xsl:choose>
                    </xsl:attribute>
                </img>	 
            </div>
        </div>
        <a class="standing-link" href="arena-ladder.xml?{@realmUrl}"><img src="images/pixel.gif" /></a>			
    </div>
</xsl:template>

<!-- prints statistics grid -->
<xsl:template name="printStats">






</xsl:template>


</xsl:stylesheet>