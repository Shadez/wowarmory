<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template name="arenareport-header">

	<xsl:param name="teamSize">2</xsl:param>
	<xsl:param name="docHeader" />
	<xsl:param name="whichPage" />

	<div class="arenareport-header-single">
		<div class="arenareport-moldingleft-s">
			<div class="reldiv">
				<div class="arenareport-moldingleft-s-flash">
					<xsl:call-template name="flash">
						<xsl:with-param name="id" select="concat('teamicon', $docHeader/@size)"/>
						<xsl:with-param name="src" select="'images/icons/team/pvpemblems.swf'"/>
						<xsl:with-param name="bgcolor" select="concat('#',$docHeader/emblem/@background)"/>
						<xsl:with-param name="wmode" select="'transparent'"/>
						<xsl:with-param name="width" select="'78'"/>
						<xsl:with-param name="height" select="'78'"/>
						<xsl:with-param name="quality" select="'high'"/>
						<xsl:with-param name="noflash" select="concat('&lt;div class=teamicon-noflash&gt;&lt;a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&gt;&lt;img src=images/',$lang,'/getflash.png class=p/&gt;&lt;/a&gt;&lt;/div&gt;')"/>
						<xsl:with-param name="flashvars" select="concat('totalIcons=1&#38;totalIcons=1&#38;startPointX=4&#38;initScale=100&#38;overScale=100&#38;largeIcon=1&#38;iconColor1=',$docHeader/emblem/@iconColor,'&#38;iconName1=images/icons/team/pvp-banner-emblem-',$docHeader/emblem/@iconStyle,'.png&#38;bgColor1=',$docHeader/emblem/@background,'&#38;borderColor1=',$docHeader/emblem/@borderColor,'&#38;teamUrl1=')"/>
					</xsl:call-template>
				</div>
				<div class="arenareport-moldingleft-name">
					<div class="reldiv">
						<div class="teamnameshadow"><xsl:value-of select="$docHeader/@name"/>
                        <span style="font-family:Arial, Helvetica, sans-serif;"><xsl:choose>
                        	<xsl:when test="$teamSize = '5'">
                            &lt;5v5&gt;
                            </xsl:when>
                            <xsl:when test="$teamSize = '3'">
                            &lt;3v3&gt;
                            </xsl:when>
                            <xsl:otherwise>
                            &lt;2v2&gt;
                            </xsl:otherwise>
                        </xsl:choose></span>
                        
                        </div>
						<div class="teamnamehighlight"><a class="teamnamehighlight" href="team-info.xml?{$docHeader/@url}"><xsl:value-of select="$docHeader/@name"/>
                        <span style="font-family:Arial, Helvetica, sans-serif; display: inline;"><xsl:choose>
                        	<xsl:when test="$teamSize = '5'">
                            &lt;5v5&gt;
                            </xsl:when>
                            <xsl:when test="$teamSize = '3'">
                            &lt;3v3&gt;
                            </xsl:when>
                            <xsl:otherwise>
                            &lt;2v2&gt;
                            </xsl:otherwise>
                        </xsl:choose></span>
                        
                        </a></div>		
					</div>
				</div>
				
				<xsl:call-template name="teamSubInfo">
					<xsl:with-param name="docHeader" select="$docHeader" />	
					<xsl:with-param name="whichPage" select="$whichPage" />	
				</xsl:call-template>
				
			</div> 
		</div>		
	</div>  
</xsl:template>


<xsl:template name="teamSubInfo">

	<xsl:param name="docHeader" />
	<xsl:param name="whichPage" />
		
	<div class="arenareport-moldingleft-info">	
		<xsl:choose>
			<xsl:when test="$whichPage = 'team'">		
				<div style="float: left; margin: 10px 0 0 -25px">
					<!-- ahref around the whole block so the entire thing is clickable -->			
					<a class="smFrame staticTip" href="{$regionForumsURL}board.html?sid=1&amp;forumName={$docHeader/@realm}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.realm']}');" onclick="window.open(this.href);return false;">
						<xsl:if test="not($region = 'US' or $region = 'EU')">
							<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
							<xsl:attribute name="class">smFrame</xsl:attribute>
							<xsl:attribute name="onmouseover"></xsl:attribute>						
						</xsl:if>
						<div><xsl:value-of select="$docHeader/@realm" /></div>
						<img src="images/icon-header-realm.gif" />
					</a>
					<a class="smFrame staticTip" style="margin-left: -20px;" href="{$regionForumsURL}board.html?sid=1&amp;forumName={$docHeader/@battleGroup}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.battleGroup']}');" onclick="window.open(this.href);return false;">
						<xsl:if test="not($region = 'US' or $region = 'EU')">
							<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
							<xsl:attribute name="class">smFrame</xsl:attribute>
							<xsl:attribute name="onmouseover"></xsl:attribute>						
						</xsl:if>
						<div><xsl:value-of select="$docHeader/@battleGroup" /></div>
						<img src="images/icon-header-battlegroup.gif" />
					</a>	
				</div>
			</xsl:when>
			<xsl:otherwise>
				<div style="float: left;">
					<div class="reldiv">
						<div style="position: absolute; top:-1px;">						
							<div class="team-members"><xsl:value-of select="$loc/strs/arena/str[@id='team-members']"/>
								<xsl:for-each select="members/character">
									<a href="character-sheet.xml?{@charUrl}"><xsl:value-of select="@name"/></a><xsl:if test="position() != last()">, </xsl:if>
								</xsl:for-each>
							</div>	
						</div>
					</div>
				</div>
			</xsl:otherwise>	
		</xsl:choose>	
	</div>
</xsl:template>


</xsl:stylesheet>