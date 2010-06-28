<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="../includes.xsl"/>

<xsl:variable name="pathWinner" select="/page/game/team[@result = 'win']" />
<xsl:variable name="pathLoser" select="/page/game/team[@result = 'loss']" />

<xsl:variable name="urlTeamSelected" select="concat('../../arena-team-game-chart.xml?r=', 
												document('../../team-info-last.xml')/page/arenaTeamCommand/@realm, 
                                                '&amp;t=', 
                                                document('../../team-info-last.xml')/page/arenaTeamCommand/@teamName, 
                                                '&amp;ts=', document('../../team-info-last.xml')/page/arenaTeamCommand/@teamSize)" />
<xsl:variable name="isTeamSelected" select="document('../../team-info-last.xml')/page/arenaTeam/@teamSize" />

<xsl:template match="page/game">
	<xsl:choose>
    	<!-- show message for blank data -->
		<xsl:when test="not(/page/game/team)">
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
			<!--<script type="text/javascript" src="shared/global/third-party/jquery/jquery.uitablefilter.js"></script>-->
			<script type="text/javascript" src="_js/arena-report/arena-game.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){			
                    initializeArenaGame(
						"<xsl:value-of select="/page/game/@matchStartTime" />",
						"<xsl:value-of select="/page/game/@matchLength" />",
						"<xsl:value-of select="/page/game/@realmOffset" />"
					);
                });			
            </script>
            
            <div id="dataElement">
                <div class="parchment-top">
                    <xsl:call-template name="arenaGameHolder" />
                </div>
            </div>
        </xsl:otherwise>        
	</xsl:choose>
</xsl:template>


<xsl:template name="arenaGameHolder">
	<div class="parchment-content">
        <div class="list">
			<div class="full-list notab">
				<div class="info-pane">
            		<xsl:call-template name="arenaGameContent" />
				</div>
			</div>        
        </div>
    </div>
</xsl:template>


<xsl:template name="arenaGameContent">
	<xsl:variable name="battleGroup" select="/page/game/@battleGroup" />
	<div class="profile-wrapper">
        <blockquote>
        	<b class="iarenateams">        
                <xsl:choose>
                    <xsl:when test="string-length($isTeamSelected) &gt; 0">
						<h4><a href="{$urlTeamSelected}"><xsl:value-of select="$loc/strs/arena/str[@id='match-history']"/></a></h4>
                    </xsl:when>
                    <xsl:otherwise>
						<h4><xsl:value-of select="$loc/strs/arena/str[@id='match-history']"/></h4>
                    </xsl:otherwise>
                </xsl:choose>        
                <h3>
					<xsl:apply-templates mode="printf" select="$loc/strs/arenaReport/str[@id='reportHeader']">
						<xsl:with-param name="param1" select="@teamSize" />					
					</xsl:apply-templates>
                </h3>
        	</b>
        </blockquote>
    </div>

	<div class="arenareport-header-double">
		<div class="arenareport-header-double-moldingleft">
            <div class="arenareport-header-double-flash-l">
                <xsl:attribute name="id">teamiconWinner</xsl:attribute>
                <xsl:call-template name="flash">
                    <xsl:with-param name="id" select="'teamiconWinner'"/>
                    <xsl:with-param name="src" select="'images/icons/team/pvpemblems.swf'"/>
                    <xsl:with-param name="bgcolor" select="concat('#',$pathWinner/@emblemBackground)"/>
                    <xsl:with-param name="wmode" select="'transparent'"/>
                    <xsl:with-param name="width" select="'78'"/>
                    <xsl:with-param name="height" select="'78'"/>
                    <xsl:with-param name="quality" select="'high'"/>
                    <xsl:with-param name="noflash" select="concat('&lt;div class=teamicon-noflash&gt;&lt;a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&gt;&lt;img src=images/',$lang,'/getflash.png class=p/&gt;&lt;/a&gt;&lt;/div&gt;')"/>
                    <xsl:with-param name="flashvars" select="concat('totalIcons=1&#38;totalIcons=1&#38;startPointX=4&#38;initScale=100&#38;overScale=100&#38;largeIcon=1&#38;iconColor1=',$pathWinner/@emblemIconColor,'&#38;iconName1=images/icons/team/pvp-banner-emblem-',$pathWinner/@emblemIconStyle,'.png&#38;bgColor1=',$pathWinner/@emblemBackground,'&#38;borderColor1=',$pathWinner/@emblemBorderColor,'&#38;teamUrl1=')"/>
                </xsl:call-template>
            </div>
            <div class="arenareport-header-double-rating-l">+<xsl:value-of select="$pathWinner/@ratingDelta" /></div>
            <div class="arenareport-header-double-ratingnew-l"><xsl:value-of select="$pathWinner/@ratingNew" /></div>
            <div class="arenareport-header-double-txt-l">
                <div class="reldiv">
                    <div class="arenareport-winner1-l"><xsl:value-of select="$pathWinner/@name" /></div>
                    <div class="arenareport-winner2-l"><xsl:value-of select="$pathWinner/@name" /></div>
                </div>
            </div>
            <div style="position: absolute; color: white; margin: 125px 0 0 25px;">
                <div class="reldiv">
                    <div class="arenareport-pathwinner1"><xsl:value-of select="$pathWinner/@realm" /></div>
                    <div class="arenareport-pathwinner2"><xsl:value-of select="$pathWinner/@realm" /></div>
                </div>
            </div>
		</div>
		<div class="arenareport-header-double-moldingright">
			<div class="reldiv">
				<div class="arenareport-header-double-flash-r">
					<xsl:attribute name="id">teamiconLoser</xsl:attribute>
					<xsl:call-template name="flash">
						<xsl:with-param name="id" select="'teamiconLoser'"/>
						<xsl:with-param name="src" select="'images/icons/team/pvpemblems.swf'"/>
						<xsl:with-param name="bgcolor" select="concat('#',$pathLoser/@emblemBackground)"/>
						<xsl:with-param name="wmode" select="'transparent'"/>
						<xsl:with-param name="width" select="'78'"/>
						<xsl:with-param name="height" select="'78'"/>
						<xsl:with-param name="quality" select="'high'"/>
						<xsl:with-param name="noflash" select="concat('&lt;div class=teamicon-noflash&gt;&lt;a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&gt;&lt;img src=images/',$lang,'/getflash.png class=p/&gt;&lt;/a&gt;&lt;/div&gt;')"/>
						<xsl:with-param name="flashvars" select="concat('totalIcons=1&#38;totalIcons=1&#38;startPointX=4&#38;initScale=100&#38;overScale=100&#38;largeIcon=1&#38;iconColor1=',$pathLoser/@emblemIconColor,'&#38;iconName1=images/icons/team/pvp-banner-emblem-',$pathLoser/@emblemIconStyle,'.png&#38;bgColor1=',$pathLoser/@emblemBackground,'&#38;borderColor1=',$pathLoser/@emblemBorderColor,'&#38;teamUrl1=')"/>
					</xsl:call-template>
				</div>
				<div class="arenareport-header-double-rating-r"><xsl:value-of select = "$pathLoser/@ratingDelta" /></div>
				<div class="arenareport-header-double-ratingnew-r"><xsl:value-of select = "$pathLoser/@ratingNew" /></div>
				<div class="arenareport-header-double-txt-r">
					<div class="reldiv">
						<div class="arenareport-loser1-r"><xsl:value-of select="$pathLoser/@name" /></div>
						<div class="arenareport-loser2-r"><xsl:value-of select="$pathLoser/@name" /></div>
					</div>
				</div>
				<div style="position: absolute;color: white; margin: 125px 0 0 -170px;">
					<div class="reldiv">
						<div class="arenareport-pathloser1"><xsl:value-of select="$pathLoser/@realm" /></div>
						<div class="arenareport-pathloser2"><xsl:value-of select="$pathLoser/@realm" /></div>
					</div>
				</div>
			</div>
		</div>
		<div style="width: 100%; clear: both; height: 1px;">
			<div class="reldiv">
				<div style="margin-top: -60px; width: 100%; position: absolute;">
					<table>
						<tr>
							<td class="halfwidth"></td>
							<td class="buttonside" valign="top"><div class="buttonleft"/></td>
							<td class="buttonmid">
								<div class="buttonmidbg">
									<div class="reldiv">
										<div class="arenareport-defeats1"><xsl:value-of select="$loc/strs/arenaReport/str[@id='defeats']"/></div>
									</div>
									<div class="arenareport-defeats2"><xsl:value-of select="$loc/strs/arenaReport/str[@id='defeats']"/></div>
								</div>
							</td>
							<td class="buttonside" valign="top">
								<div class="buttonright"/>
							</td>
							<td class="halfwidth"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="matchstats">	
		<xsl:value-of select="$loc/strs/arenaReport/str[@id='gameInfo.map']"/>&#160;
		<span><xsl:value-of select="/page/game/@map" /></span>
					
		<xsl:value-of select="$loc/strs/arenaReport/str[@id='gameInfo.startTime']"/>&#160;
		<span id="matchStartTime"><xsl:value-of select="/page/game/@matchStartTime" /></span>
		
		<xsl:value-of select="$loc/strs/arenaReport/str[@id='gameInfo.matchLength']"/>&#160;
		<span id="matchLength"><xsl:value-of select="/page/game/@matchLength" /></span>	
	</div>

    
	<div class="data">
        <table id="arenaGameTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
            <thead>
                <tr class="masthead">
                    <th style="text-align:left; width: 120px; min-width:120px;">
						<a><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/><span class='sortArw'> </span></a>
					</th>
                    <th style="text-align:left; width: 250px; white-space:nowrap">
						<a><xsl:value-of select="$loc/strs/arena/str[@id='team-name']"/><span class='sortArw'> </span></a>
					</th>
                    <th style="text-align:left; width: 120px;">
						<a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.race-class']"/><span class='sortArw'> </span></a>
					</th>
                    <th class="numericSort" style="text-align:left;">
                    	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='killingblows']}')">
                    	<xsl:value-of select="$loc/strs/arena/str[@id='killingblows.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th class="numericSort" style="text-align:left;">
                    	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='dmgout']}')">
                    	<xsl:value-of select="$loc/strs/arena/str[@id='dmgout.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th class="numericSort" style="text-align:left;">
                    	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='dmgin']}')">
                    	<xsl:value-of select="$loc/strs/arena/str[@id='dmgin.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th class="numericSort" style="text-align:left;">
                    	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='healout']}')">
                    	<xsl:value-of select="$loc/strs/arena/str[@id='healout.short']"/><span class='sortArw'> </span></a>
                    </th>
                    <th class="numericSort" style="text-align:left;">
                    	<a class="staticTip" onmouseover="setTipText('{$loc/strs/arena/str[@id='healin']}')">
                    	<xsl:value-of select="$loc/strs/arena/str[@id='healin.short']"/><span class='sortArw'> </span></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="/page/game/team">                	
                    <xsl:variable name="teamName" select="@name" />
					<xsl:variable name="isDeleted" select="@deleted" />
                    <xsl:variable name="teamUrl" select="@teamUrl" />
                	<xsl:for-each select="current()/member">                    
                    	<xsl:variable name="classTxt"	select="$loc/strs/classes/str[@id=concat('armory.classes.class.',current()/@classId,'.',current()/@genderId)]" />
                        <xsl:variable name="raceTxt"	select="$loc/strs/races/str[@id=concat('armory.races.race.',current()/@raceId,'.',current()/@genderId)]" />
                        <xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />                    
                        <tr>
                            <td><a href="character-sheet.xml?{@url}"><xsl:value-of select="@characterName"/></a></td>
                            <td style="overflow:hidden;">
								<xsl:choose>
									<xsl:when test="$isDeleted = 'true'">
										<a href="javascript:void(0)" class="graphLink delGraphLink staticTip" 
											onmouseover="setTipText('{$loc/strs/arena/str[@id='deletedTeam']}');" />
										<a href="javascript:void(0)" class="truncateMe graphTxt staticTip deletedTeam" 
		                                	onmouseover="setTipText('{$loc/strs/arena/str[@id='deletedTeam']}');"><xsl:value-of select="$teamName" /></a>									
									</xsl:when>
									<xsl:otherwise>
										<a href="arena-team-game-chart.xml?{$teamUrl}" class="graphLink staticTip" 
											onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='viewTeamHistory']}');" />
										<a class="truncateMe graphTxt staticTip" onmouseover="setTipText('{$loc/strs/arenaReport/str[@id='viewTeamProfile']}');" 
											href="team-info.xml?{$teamUrl}"><xsl:value-of select="$teamName"/></a>									
									</xsl:otherwise>								
								</xsl:choose>
							</td>
                            <td class="centNum">
                                <img class="staticTip" onmouseover="setTipText('{$raceTxt}');" src="images/icons/race/{@raceId}-{@genderId}.gif" />&#160;
                                <img class="staticTip" onmouseover="setTipText('{$classTxt}');" src="images/icons/class/{@classId}.gif" />
                            </td>
                            <td class="rightNum"><xsl:value-of select="@killingBlows" /></td>
                            <td class="rightNum"><xsl:value-of select="@damageDone" /></td>
                            <td class="rightNum"><xsl:value-of select="@damageTaken" /></td>
                            <td class="rightNum"><span style="display:none"><xsl:value-of select="@healingDone" /></span><xsl:value-of select="@healingDone" /></td>
                            <td class="rightNum"><xsl:value-of select="@healingTaken" /></td>
                        </tr>
                    </xsl:for-each>
                </xsl:for-each>
            </tbody>
        </table>
    </div>
</xsl:template>


</xsl:stylesheet>