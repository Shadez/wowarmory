<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!-- tabs -->
<xsl:template name="newGuildTabs"><link rel="stylesheet" type="text/css" href="_css/guild/global.css" />	
	<xsl:call-template name="tabs">
		<xsl:with-param name="tabGroup" select="/page/tabInfo/@tabGroup" />
		<xsl:with-param name="currTab" select="/page/tabInfo/@tab" />
		<xsl:with-param name="subTab" select="/page/tabInfo/@subTab" />
		<xsl:with-param name="tabUrlAppend" select="/page/tabInfo/@tabUrl" />
		<xsl:with-param name="subtabUrlAppend" select="/page/tabInfo/@tabUrl" />	
	</xsl:call-template>	
</xsl:template>

<!-- guild header -->
<xsl:template name="newGuildHeader">

	<xsl:variable name="stringMembers">
		<xsl:choose>
			<xsl:when test="guildHeader/@members = 1">
				<xsl:call-template name="stringorder">
					<xsl:with-param name="orderid" select="'armory.order.guild.members'"/>				
					<xsl:with-param name="datainsert1" select="guildHeader/@members"/>
					<xsl:with-param name="datainsert2" select="$loc/strs/guild/str[@id='member']"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="stringorder">
					<xsl:with-param name="orderid" select="'armory.order.guild.members'"/>				
					<xsl:with-param name="datainsert1" select="guildHeader/@members"/>
					<xsl:with-param name="datainsert2" select="$loc/strs/guild/str[@id='members']"/>
				</xsl:call-template>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>	

	<div class="guildbanks-faction-horde" style="margin-bottom: 40px;">
		<xsl:if test="guildHeader/@factionId = '0'">
			<xsl:attribute name="class">guildbanks-faction-alliance</xsl:attribute>
		</xsl:if>
		<div class="profile-left">
			<div class="profile-right">	
				<div style="height: 140px; width: 100%;">				
					<div class="reldiv">	
						<div class="guildheadertext">
							<div class="guild-details">
							
								<div class="guild-shadow">
									<table><tr><td>
										<h1><xsl:value-of select="guildHeader/@name"/></h1>
										<h2><xsl:value-of select="$stringMembers" /></h2>
									</td></tr></table>
								</div>
								<div class="guild-white">
									<table><tr><td>
										<h1><xsl:value-of select="guildHeader/@name"/></h1>
										<h2><xsl:value-of select="$stringMembers" /></h2>
									</td></tr></table>
								</div>
							</div>
						</div>
						<!-- emblem -->
						<div style="position: absolute; margin: -10px 0 0 -10px; z-index: 10000;">
							<xsl:call-template name="flash">
									<xsl:with-param name="id" select="'guild_emblem'"/>
									<xsl:with-param name="src" select="'images/emblem_ex.swf'"/>
									<xsl:with-param name="wmode" select="'transparent'"/>
									<xsl:with-param name="width" select="'230'"/>
									<xsl:with-param name="height" select="'200'"/>
									<xsl:with-param name="border" select="'1'"/>
									<xsl:with-param name="quality" select="'best'"/>
									<xsl:with-param name="flashvars" select="concat('emblemstyle=', guildHeader/emblem/@emblemIconStyle, '&#38;emblemcolor=', guildHeader/emblem/@emblemIconColor, '&#38;embborderstyle=', guildHeader/emblem/@emblemBorderStyle, '&#38;embbordercolor=', guildHeader/emblem/@emblemBorderColor, '&#38;bgcolor=',guildHeader/emblem/@emblemBackground, '&#38;faction=', guildHeader/@faction, '&#38;imgdir=images/tabard_images/')"/>
							</xsl:call-template>
						</div>			
												
						<div style="position: absolute; margin: 116px 0 0 210px;">
							<!-- ahref around the whole block so the entire thing is clickable -->			
							<a class="smFrame staticTip" href="{$regionForumsURL}board.html?sid=1&amp;forumName={guildHeader/@realm}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.realm']}');">
								<xsl:if test="not($region = 'US' or $region = 'EU')">
									<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
									<xsl:attribute name="class">smFrame</xsl:attribute>
									<xsl:attribute name="onmouseover"></xsl:attribute>						
								</xsl:if>
								<div><xsl:value-of select="guildHeader/@realm" /></div>
								<img src="images/icon-header-realm.gif" />
							</a>
							<a class="smFrame staticTip" href="{$regionForumsURL}board.html?sid=1&amp;forumName={guildHeader/@battleGroup}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.battleGroup']}');">
								<xsl:if test="not($region = 'US' or $region = 'EU')">
									<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
									<xsl:attribute name="class">smFrame</xsl:attribute>
									<xsl:attribute name="onmouseover"></xsl:attribute>						
								</xsl:if>
								<div><xsl:value-of select="guildHeader/@battleGroup" /></div>
								<img src="images/icon-header-battlegroup.gif" />
							</a>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</xsl:template>



<xsl:template name="goldFormat">

	<xsl:param name="totalMoney" />
	<xsl:param name="styleSuffix" />
	
	<xsl:variable name="gold" select="floor($totalMoney div 10000)" />
	<xsl:variable name="silver" select="floor(($totalMoney - ($gold * 10000)) div 100)" />
	
	<xsl:variable name="copper" select="(($totalMoney - ($gold * 10000)) - ($silver * 100))" />
	
	<xsl:if test="$gold &gt; 0">
		<span class="goldCoin{$styleSuffix}"><xsl:value-of select="$gold" /></span>
	</xsl:if> 
	
	<xsl:if test="$silver &gt; 0">
		<span class="silverCoin{$styleSuffix}"><xsl:value-of select="$silver" /></span>
	</xsl:if> 
	
	<xsl:if test="$copper &gt; 0">
		<span class="copperCoin{$styleSuffix}"><xsl:value-of select="$copper" /></span>
	</xsl:if>
	
</xsl:template>

</xsl:stylesheet>