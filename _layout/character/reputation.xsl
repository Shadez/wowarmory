<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="characterInfo"><link rel="stylesheet" href="_css/character/reputation.css" type="text/css" />
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
		</xsl:otherwise>
	</xsl:choose>

</xsl:template>


<xsl:template name="charContent">

<script type="text/javascript">
	$(document).ready(function(){
		$('#repTableUngrouped').tablesorter({sortList: [[0,0]]});
	});
</script>

	<!-- character header -->
	<xsl:call-template name="newCharHeader" />
	
	<xsl:choose>
		<xsl:when test="reputationTab/faction">
		<!--<xsl:when test="1=0">-->
			
			<!-- print reputations -->
			<div class="reputation-cont">
				<div class="groupSwitches">
					<a class="selectedGroup" href="javascript:void(0)" onclick="$('#reputation-grouped').css('display','block');$('#reputation-ungrouped').css('display','none');$(this).parent().children().removeClass('selectedGroup');$(this).addClass('selectedGroup')">
						<span><xsl:value-of select="$loc/strs/factions/str[@id='armory.character-reputation.group.grouped']"/></span>
					</a>
					<a href="javascript:void(0)" onclick="$('#reputation-grouped').css('display','none');$('#reputation-ungrouped').css('display','block');$(this).parent().children().removeClass('selectedGroup');$(this).addClass('selectedGroup')">
						<span><xsl:value-of select="$loc/strs/factions/str[@id='armory.character-reputation.group.ungrouped']"/></span>
					</a>
				</div>
				
				<div id="reputation-grouped">
					<xsl:apply-templates select="reputationTab/faction" mode="tier1" />
				</div>
				<div id="reputation-ungrouped" style="display:none">
					<div class="tier_1_a">
						<div class="tier_1_b">
							<div class="tier_1_c">
								<div class="tier_1_d">
									<div class="tier_2_a">
										<div class="tier_2_b">
											<table id="repTableUngrouped" class="rep-table" cellpadding="0" cellspacing="0" border="0">
												<thead>
													<tr>
														<th>
															<a class="selectedSorting" onclick="$(this).parent().parent().children().children().removeClass('selectedSorting');$(this).addClass('selectedSorting')"><xsl:value-of select="$loc/strs/factions/str[@id='armory.character-reputation.sort.faction']"/></a>
														</th>
														<th>
															<a onclick="$(this).parent().parent().children().children().removeClass('selectedSorting');$(this).addClass('selectedSorting')"><xsl:value-of select="$loc/strs/factions/str[@id='armory.character-reputation.sort.reputation']"/></a>
														</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<xsl:apply-templates select="reputationTab//faction[@reputation]" mode="tier3">
														<xsl:sort data-type="text" select="@name" />
													</xsl:apply-templates>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"><xsl:comment/></div>
			<br />
		
		</xsl:when>
		<xsl:otherwise>
			<div class="reputationNote">
				<h1><xsl:value-of select="$loc/strs/factions/str[@id='armory.character-reputation.noreputation']"/></h1>
			</div>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template match="faction" mode="tier1">
	<div class="tier_1">
		<div class="tier_1_a">
			<div class="tier_1_b">
				<div class="tier_1_c">
					<div class="tier_1_d">
						<a href="javascript:void(0)" class="tier_1_title" onclick="$(this).parents('.tier_1').toggleClass('repCollapse')" onmouseover="$(this).parents('.tier_1_a').addClass('repSelect1')" onmouseout="$(this).parents('.tier_1_a').removeClass('repSelect1')">
							<xsl:value-of select="@name" />
						</a>
						<div class="tier_2">
							<xsl:if test="faction[not(@header)]">
								<div class="tier_2_a">
									<div class="tier_2_b">
										<table class="rep-table" cellpadding="0" cellspacing="0" border="0">
											<tbody>
												<xsl:apply-templates select="faction[not(@header)]" mode="tier3" />
											</tbody>
										</table>
									</div>
								</div>
								<xsl:if test="following-sibling::faction">
									<div class="tier_2_shadow"><xsl:comment></xsl:comment></div>
								</xsl:if>
							</xsl:if>
							<xsl:for-each select="faction[child::faction]">
								<xsl:apply-templates select="." mode="tier2" />
							</xsl:for-each>
						</div>
					</div>
				</div>
			</div>
		</div>
		<xsl:choose>
			<xsl:when test="following-sibling::faction">
				<div class="tier_1_shadow"><xsl:comment></xsl:comment></div>
			</xsl:when>
			<xsl:otherwise>
				<div class="tier_1_shadow_end"><xsl:comment></xsl:comment></div>
			</xsl:otherwise>
		</xsl:choose>
	</div>
</xsl:template>

<xsl:template match="faction" mode="tier2">
	<div class="tier_2_a">
		<div class="tier_2_b">
			<table class="rep-table repGroup" cellpadding="0" cellspacing="0" border="0">
			<xsl:if test="@reputation"><xsl:attribute name="class">rep-table repHeader</xsl:attribute></xsl:if>
				<tbody>
					<tr>
						<xsl:call-template name="eachFaction">
							<xsl:with-param name="factionNode" select="current()" />
							<xsl:with-param name="header" select="@name" />
						</xsl:call-template>
					</tr>
				</tbody>
			</table>
			<table class="rep-table repContent" cellpadding="0" cellspacing="0" border="0">
				<tbody>
					<xsl:apply-templates select="faction" mode="tier3" />
				</tbody>
			</table>
		</div>
	</div>
	<xsl:if test="following-sibling::faction">
		<div class="tier_2_shadow"><xsl:comment></xsl:comment></div>
	</xsl:if>
</xsl:template>

<xsl:template match="faction" mode="tier3">
	<tr>
		<xsl:call-template name="eachFaction">
			<xsl:with-param name="factionNode" select="current()" />
		</xsl:call-template>
	</tr> 
</xsl:template>

<xsl:template name="eachFaction">

	<xsl:param name="factionNode" />
	<xsl:param name="header" />
	<xsl:variable name="factionRep" select="$factionNode/@reputation" />
	<xsl:variable name="theGenderId" select="/page/characterInfo/character/@genderId" />
	
	<xsl:variable name="repClass">		  	
		<xsl:choose>
			<xsl:when test="$factionRep &lt; -6000">rep0</xsl:when>
			<xsl:when test="$factionRep &lt; -3000">rep1</xsl:when>
			<xsl:when test="$factionRep &lt; 0">rep2</xsl:when>	
			<xsl:when test="$factionRep &lt; 3000">rep3</xsl:when>	
			<xsl:when test="$factionRep &lt; 9000">rep4</xsl:when>
			<xsl:when test="$factionRep &lt; 21000">rep5</xsl:when>
			<xsl:when test="$factionRep &lt; 42000">rep6</xsl:when>
			<xsl:otherwise>rep7</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:variable name="repText">
		<xsl:choose>
			<xsl:when test="$factionRep &lt; -6000"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.hated.', $theGenderId)]"/></xsl:when>
			<xsl:when test="$factionRep &lt; -3000"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.hostile.', $theGenderId)]"/></xsl:when>
			<xsl:when test="$factionRep &lt; 0"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.unfriendly.', $theGenderId)]"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 3000"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.neutral.', $theGenderId)]"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 9000"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.friendly.', $theGenderId)]"/></xsl:when>
			<xsl:when test="$factionRep &lt; 21000"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.honored.', $theGenderId)]"/></xsl:when>
			<xsl:when test="$factionRep &lt; 42000"><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.revered.', $theGenderId)]"/></xsl:when>
			<xsl:otherwise><xsl:value-of select="$loc/strs/itemTooltip/str[@id=concat('armory.item-tooltip.exalted.', $theGenderId)]"/></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:variable name="repCap">
		<xsl:choose>
			<xsl:when test="$factionRep &lt; -6000">36000</xsl:when>
			<xsl:when test="$factionRep &lt; -3000">3000</xsl:when>
			<xsl:when test="$factionRep &lt; 0">3000</xsl:when>	
			<xsl:when test="$factionRep &lt; 3000">3000</xsl:when>	
			<xsl:when test="$factionRep &lt; 9000">6000</xsl:when>
			<xsl:when test="$factionRep &lt; 21000">12000</xsl:when>
			<xsl:when test="$factionRep &lt; 42000">21000</xsl:when>
			<xsl:otherwise>1000</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:variable name="repAdjusted">
		<xsl:choose>
			<xsl:when test="$factionRep &lt; -6000"><xsl:value-of select="number(42000 + $factionRep)"/></xsl:when>
			<xsl:when test="$factionRep &lt; -3000"><xsl:value-of select="number(6000 + $factionRep)"/></xsl:when>
			<xsl:when test="$factionRep &lt; 0"><xsl:value-of select="number(3000 + $factionRep)"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 3000"><xsl:value-of select="number($factionRep)"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 9000"><xsl:value-of select="number($factionRep - 3000)"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 21000"><xsl:value-of select="number($factionRep - 9000)"/></xsl:when>
			<xsl:when test="$factionRep &lt; 42000"><xsl:value-of select="number($factionRep - 21000)"/></xsl:when>
			<xsl:otherwise><xsl:value-of select="number($factionRep - 42000)"/></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:variable name="repBar">
		<xsl:choose>
			<xsl:when test="$factionRep &lt; -6000"><xsl:value-of select="number($repAdjusted * 100 div $repCap)"/></xsl:when>
			<xsl:when test="$factionRep &lt; -3000"><xsl:value-of select="number( $repAdjusted * 100 div $repCap)"/></xsl:when>
			<xsl:when test="$factionRep &lt; 0"><xsl:value-of select="number( $repAdjusted * 100 div $repCap)"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 3000"><xsl:value-of select="number($repAdjusted * 100 div $repCap)"/></xsl:when>	
			<xsl:when test="$factionRep &lt; 6000"><xsl:value-of select="number($repAdjusted * 100 div $repCap)"/></xsl:when>
			<xsl:when test="$factionRep &lt; 9000"><xsl:value-of select="number($repAdjusted * 100 div $repCap)"/></xsl:when>
			<xsl:when test="$factionRep &lt; 21000"><xsl:value-of select="number($repAdjusted * 100 div $repCap)"/></xsl:when>
			<xsl:otherwise><xsl:value-of select="number($repAdjusted * 100 div $repCap)"/></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>


	<xsl:variable name="factionName" select="$factionNode/@key" />
	<xsl:variable name="factionURLKey" select="concat('armory.character-reputation.url.', $factionName)"/>
	<xsl:variable name="factionURL" select="$loc/strs/factions/str[@id=$factionURLKey]" />

	<td class="faction-name">
		<span style="display:none"><xsl:value-of select="@name" /></span>
		<xsl:choose>
			<xsl:when test="$header != ''">
				<span>
					<a href="javascript:void(0)" class="tier_2_title" onclick="$(this).parents('.tier_2_a').toggleClass('repCollapse')" onmouseover="$(this).parents('.tier_2_a').addClass('repSelect2')" onmouseout="$(this).parents('.tier_2_a').removeClass('repSelect2')">
						<xsl:value-of select="@name" />
					</a>
				</span>
			</xsl:when>
			<xsl:when test="string-length($factionURL) != 0">
				<span>
					<a class="staticTip" target="_blank" href="{$factionURL}" onmouseover="setTipText('{$loc/strs/factions/str[@id='factions.learnmore']}')">
						<xsl:value-of select="@name"/>
					</a>
				</span>
			</xsl:when>
			<xsl:otherwise>
				<span><xsl:value-of select="@name"/></span>
			</xsl:otherwise>		  
		</xsl:choose>
	</td>
	<xsl:if test="@reputation">
		<td class="{$repClass} repBar">
			<span style="display:none"><xsl:value-of select="@reputation" /></span>
			<div class="faction-bar">
				<a class="rep-data"><xsl:value-of select="$repAdjusted" />/<xsl:value-of select="$repCap" /></a>
				<div class="bar-color" style="width: {$repBar}%"></div>
			</div>
		</td>
		<td class="faction-level">
			<div>
				<span><xsl:value-of select="$repText" /></span>
			</div>
		</td>
	</xsl:if>
	
</xsl:template>
</xsl:stylesheet>