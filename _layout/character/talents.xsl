<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:import href="../tools/talent-page.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="characterInfo">

	<link rel="stylesheet" type="text/css" href="_css/tools/talent-calc.css" />

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
											<xsl:call-template name="charContent" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<script type="text/javascript">
				$(document).ready(function(){
					initCharTalents();			
				});
			</script>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="charContent">

	<!-- character header -->
	<xsl:call-template name="newCharHeader" />
	
	<script type="text/javascript" src="_js/character/talents.js"></script>

	<xsl:variable name="hasPet" select="boolean(talents/pet)" />
    

	<div class="talentGlyphBg">
		<xsl:if test="$hasPet">
			<xsl:attribute name="class">talentGlyphBgPet</xsl:attribute>
		</xsl:if>
		<div class="talentGlyphFooter">
			<xsl:if test="$hasPet">
				<xsl:attribute name="class">talentGlyphFooterPet</xsl:attribute>
			</xsl:if>
			<div class="talentGlyphHeader">
                <div id="glyphHolder">
                            <xsl:for-each select="talents/talentGroup">
                                <div id="glyphSet_{@group}">
                                    <xsl:if test="not(@active = '1')"><xsl:attribute name="style">display: none</xsl:attribute></xsl:if>
                                    <xsl:for-each select="glyphs/glyph[@type='major']">
                                        <div class="staticTip glyph major">
                                            <xsl:attribute name="onmouseover">makeGlyphTooltip("<xsl:value-of select="@name" />","<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.majorglyph']" />","<xsl:value-of select="@effect" />")</xsl:attribute>
                                            <span>
                                                <img class="majorGlyphIcon" src="images/talents/glyph-small-major-{position()}.gif"/>
                                                <xsl:value-of select="@name" />										
                                            </span>
                                        </div>
                                    </xsl:for-each>
                                    
                                    <!-- print empty major glyphs -->
                                    <xsl:if test="count(glyphs/glyph[@type='major']) &lt; 3">
                                        <xsl:call-template name="emptyGlyph">
                                            <xsl:with-param name="ctr" select="'1'"/>
                                            <xsl:with-param name="max" select="3 - count(glyphs/glyph[@type='major'])"/>
                                            <xsl:with-param name="glyphType" select="'major'"/>
                                        </xsl:call-template>
                                    </xsl:if>
                                    
                                    <xsl:for-each select="glyphs/glyph[@type='minor']">
                                        <div class="staticTip glyph minor">
                                            <xsl:attribute name="onmouseover">makeGlyphTooltip("<xsl:value-of select="@name" />","<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.minorglyph']" />","<xsl:value-of select="@effect" />")</xsl:attribute>					
                                            <span>
                                                <img class="minorGlyphIcon" src="images/talents/glyph-small-minor-{position()}.gif"/>
                                                <xsl:value-of select="@name" />
                                            </span>
                                        </div>
                                    </xsl:for-each>
                                    
                                    <!-- print empty minor glyphs -->
                                    <xsl:if test="count(glyphs/glyph[@type='minor']) &lt; 3">
                                        <xsl:call-template name="emptyGlyph">
                                            <xsl:with-param name="ctr" select="'1'" />
                                            <xsl:with-param name="max" select="3 - count(glyphs/glyph[@type='minor'])" />
                                            <xsl:with-param name="glyphType" select="'minor'" />
                                        </xsl:call-template>
                                    </xsl:if>
                                    
                                </div>
                            </xsl:for-each>
                        </div>

                        <xsl:if test="$hasPet">
                            <div id="petTalContainer" class="petTalContainer">
                                <div id="petName">
                        
                                    <xsl:choose>
                                        <xsl:when test="count(talents/pet) &gt; 1">
                                            <select onchange="switchPetTalentSpec(this)">
                                                <xsl:for-each select="talents/pet">
                                                    <option value="{@familyId}-{talentGroup/talentSpec/@value}"><xsl:call-template name="petName"><xsl:with-param name="pet" select="current()" /></xsl:call-template></option>
                                                </xsl:for-each>
                                            </select>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <span class="onlyPetName"><xsl:call-template name="petName"><xsl:with-param name="pet" select="talents/pet" /></xsl:call-template></span>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </div>
                                <!-- Print pet talents -->
                                <xsl:call-template name="talentCalc">
                                    <xsl:with-param name="tcVarName" select="'petTalentCalc'" />
                                    <xsl:with-param name="uniqueId" select="'dsgjkb43'" />
                                    <xsl:with-param name="pageMode" select="'charPage'" />
                                    <xsl:with-param name="whichFamilyId" select="talents/pet[1]/@familyId" />
                                    <xsl:with-param name="talStr" select="talents/pet[1]/talentGroup/talentSpec/@value" />
                                </xsl:call-template>
                    
                            </div>
                        </xsl:if>
                        
				<!-- spec switcher -->
				<xsl:if test="count(talents/talentGroup) = '2'">
					<xsl:attribute name="class">talentGlyphHeaderMultiSpec</xsl:attribute>
					<div class="talentSpecSwitchHolder">
						<table class="talentSpecSwitch">
							<tr>
								<xsl:for-each select="talents/talentGroup">
									<xsl:sort select="@group" />
									<td id="group_{position()}">
										<xsl:if test="@active = 1"><xsl:attribute name="class">selectedSet</xsl:attribute></xsl:if>
										<a class="inActiveTalents" href="javascript:void(0)" id="group_{position()}_link" onclick="switchTalentSpec('{@active}','{@group}', '{talentSpec/@value}')">
											<xsl:if test="@active = 1">
												<xsl:attribute name="class">activeTalents</xsl:attribute>
											</xsl:if>
											<div>
												<img src="/wow-icons/_images/21x21/{@icon}.png" />
												<xsl:value-of select="@prim" />
											</div>
										</a>
										<div class="buildPointer"><xsl:comment /></div>
									</td>
								</xsl:for-each>
							</tr>
						</table>
					</div>
				</xsl:if>
				
			
				<!-- Print character talents -->	
				<xsl:call-template name="talentCalc">
					<xsl:with-param name="tcVarName" select="'talentCalc'" />
					<xsl:with-param name="uniqueId" select="'sdfkte75'" />
					<xsl:with-param name="pageMode" select="'charPage'" />
					<xsl:with-param name="whichClassId" select="character/@classId" />
					<xsl:with-param name="talStr" select="talents/talentGroup[@active='1']/talentSpec/@value" />
				</xsl:call-template>
	
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
</xsl:template>

<xsl:template name="emptyGlyph">

	<xsl:param name="ctr" />
	<xsl:param name="max" />
	<xsl:param name="glyphType" />
	
	<xsl:if test="$ctr &lt;= $max">
		<div class="glyph staticTip emptyGlyph{$glyphType}" onmouseover="makeGlyphTooltip('{$loc/strs/unsorted/str[@id='emptyGlyph']}','{$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.', $glyphType, 'glyph')]}',' ')">
			<span><xsl:value-of select="$loc/strs/unsorted/str[@id='emptyGlyph']" /></span>
		</div>	
		<xsl:call-template name="emptyGlyph">
			<xsl:with-param name="ctr" select="$ctr + 1" />
			<xsl:with-param name="max" select="$max" />
			<xsl:with-param name="glyphType" select="$glyphType" />
		</xsl:call-template>
	</xsl:if>
</xsl:template>

<xsl:template name="petName">

	<xsl:param name="pet" />

	'<xsl:value-of select="$pet/@name" />' - 
	<xsl:apply-templates mode="printf" select="$loc/strs/character/str[@id='charLevelStr']">
		<xsl:with-param name="param1" select="$pet/@lvl" />
		<xsl:with-param name="param2" select="$pet/@family" />
		<xsl:with-param name="param3" select="''" />
	</xsl:apply-templates>

</xsl:template>

</xsl:stylesheet>