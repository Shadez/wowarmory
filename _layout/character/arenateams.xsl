<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="../arena/team-statistics.xsl"/>
<xsl:include href="../arena/header.xsl"/>

<xsl:template match="characterInfo"><link rel="stylesheet" href="_css/arena-report.css" />
	<span style="display:none;">start</span><!--needed to fix IE bug that ignores script includes-->

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
											<xsl:call-template name="charArenaTeamsContent" />
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

<xsl:template name="charArenaTeamsContent">
					
	<!-- character header -->
	<xsl:call-template name="newCharHeader" />
								
	<xsl:for-each select="character/arenaTeams/arenaTeam">								
		<blockquote style="clear:both">
			<b class="iarenateams">
				<h2>
					<xsl:choose>
						<xsl:when test="@size = 2">
							<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character-info.label.2v2team']"/>
						</xsl:when>
						<xsl:when test="@size = 3">
							<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character-info.label.3v3team']"/>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character-info.label.5v5team']"/>
						</xsl:otherwise>
					</xsl:choose>
				</h2>
			</b>
		</blockquote>
		
		<xsl:call-template name="arenareport-header">
			<xsl:with-param name="parchtitle" select="'Match History'"/>
			<xsl:with-param name="teamSize" select="@size"/>
			<xsl:with-param name="docHeader" select="current()" />
		</xsl:call-template>
		
		
		<xsl:call-template name="teamStatistics">
			<xsl:with-param name="whichPage" select="'char'"/>
			<xsl:with-param name="characterName" select="/page/characterInfo/character/@name"/>
			<xsl:with-param name="theSize" select="@size"/>
		</xsl:call-template>
		
	</xsl:for-each>
								

</xsl:template>

</xsl:stylesheet>
