<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:include href="includes.xsl"/>

<xsl:template match="factions">

	<xsl:variable name="factionsXml" select="document('../_data/factions.xml')/root" />
	<xsl:variable name="locFactions" select="document('../data/factionStrings.xml')" />

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">				
                <div class="list">				
					<xsl:call-template name="tabs">
						<xsl:with-param name="tabGroup" select="/page/tabInfo/@tabGroup" />
						<xsl:with-param name="currTab" select="/page/tabInfo/@tab" />
						<xsl:with-param name="subTab" select="/page/tabInfo/@subTab" />
						<xsl:with-param name="tabUrlAppend" select="''" />
						<xsl:with-param name="subtabUrlAppend" select="''" />
					</xsl:call-template>
                    <div class="full-list">
                        <div class="info-pane dungeon-container">
							<div class="info-header dhbg{@release}">
								<h1><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.factions']"/></h1>
								<h2><xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@release]"/></h2>
							</div>
							<div class="dungeon-header">
								<table>
									<tr>
										<td style="width: 90%;"><span><xsl:value-of select="$loc/strs/factions/str[@id='faction']"/></span></td>
										<td><span><xsl:value-of select="$loc/strs/factions/str[@id='side']"/></span></td>
									</tr>
								</table>								
							</div>
							<div class="dungeon-content">
								<table>
									<xsl:for-each select="$locFactions/page/factions/faction[@release=current()/@releaseid]">
										<xsl:variable name="factionId" select="@id" />
										<xsl:variable name="factionName" select="@name" />
										<xsl:variable name="factionPath" select="$factionsXml/factions/faction[@id=$factionId]" />		
										<xsl:variable name="altId">
											<xsl:choose>
												<xsl:when test="position() mod 2 != 1">rc1</xsl:when>
												<xsl:otherwise>rc0</xsl:otherwise>
											</xsl:choose>
										</xsl:variable>	
										<tr class="expand-list">
											 <td width="90%" class="{$altId}">
											 	<a href="search.xml?source=reputation&amp;faction={$factionId}&amp;searchType=items">
													<xsl:value-of select="$factionName" />
												</a>
											</td>
											 <td class="{$altId}">
											 	<q class="side-col">
													<xsl:if test="$factionPath/@friendlyTo = 'a'">
														<img class="staticTip" onmouseover="setTipText('{$loc/strs/semicommon/str[@id='alliance']}');" src="images/icon-alliance.gif" />
													</xsl:if>
													<xsl:if test="$factionPath/@friendlyTo = 'h'">
														<img class="staticTip" onmouseover="setTipText('{$loc/strs/semicommon/str[@id='horde']}');" src="images/icon-horde.gif" style="margin-left: 25px" />
													</xsl:if>
													<xsl:if test="$factionPath/@friendlyTo = 'both'">
														<img class="staticTip" onmouseover="setTipText('{$loc/strs/semicommon/str[@id='alliance']}');" src="images/icon-alliance.gif" /> 
														<img class="staticTip" onmouseover="setTipText('{$loc/strs/semicommon/str[@id='horde']}');" src="images/icon-horde.gif" style="margin-left: 5px;" />
													</xsl:if>
												</q>
											</td>
										 </tr>									
									</xsl:for-each>								
								</table>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>


</xsl:stylesheet>
