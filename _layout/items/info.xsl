<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="../includes.xsl"/>
<xsl:include href="tooltip.xsl"/>

<xsl:template match="page/itemInfo">

	<span style="display:none;">start</span><!--needed to fix IE bug that ignores script includes-->
	
	<div id="dataElement">
		<div class="parchment-top">
			<div class="parchment-content">
				<div class="results-side-expanded" id="results-side-switch">
					<div class="list">
						<div class="team-side notab" style="width: 100%;">
							<div class="info-pane">
								<div class="profile-wrapper">
									<xsl:apply-templates mode="itemInfoContent" select="item" />
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</xsl:template>

<xsl:template match="item" mode="itemInfoContent2">	

	<blockquote>
		<b class="iitems">
			<h4><a href="item-search.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.items']"/></a></h4>
			<h3><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.item-results']"/></h3>
		</b>
	</blockquote>
	
	<div style="background: url(wow-icons/_images/51x51/{@icon}.jpg) 0 0 no-repeat; height: 51px; width: 51px; float: left;  margin: 10px;"></div>

	<div style="background-color:#330000; padding: 8px 12px; width: 290px; float: left; margin: 10px 0;">
		<xsl:variable name="itemTooltipNode" select="document(concat('../../item-tooltip.xml?i=',@id))/page/itemTooltips/itemTooltip" />
		<xsl:apply-templates select="$itemTooltipNode">
			<xsl:with-param name="isItemInfoPage" select = "'1'" />
		</xsl:apply-templates>
	</div>
	
	<div class="alt-stats">
		<em><xsl:value-of select="$loc/strs/itemInfo/str[@id='item.fact']"/></em>
	
	
	</div>

	<div class="clear"></div>

</xsl:template>

<xsl:template match="item" mode="itemInfoContent">		
	<blockquote>
		<b class="iitems">
			<h4><a href="item-search.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.items']"/></a></h4>
			<h3><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.item-results']"/></h3>
		</b>
	</blockquote>
	
	<div class="generic-wrapper">
		<div class="generic-right">
			<div class="genericHeader">
				<div class="item-padding">
					<div class="item-background">
						<div class="item-bottom">
							<div class="item-top">
								<xsl:if test="translationFor">
									<xsl:choose>
										<xsl:when test="translationFor/@factionEquiv = 0">
											<div class="transition-logo-horde">
												<xsl:comment></xsl:comment>
											</div>
										</xsl:when>
										<xsl:when test="translationFor/@factionEquiv = 1">
											<div class="transition-logo-alliance">
												<xsl:comment></xsl:comment>
											</div>
										</xsl:when>
									</xsl:choose>
								</xsl:if>
								<img src="images/pixel.gif" height="250" width="1" style="float: left;" />
								<xsl:variable name="itemTooltipNode" select="document(concat('../../item-tooltip.xml?i=',@id))/page/itemTooltips/itemTooltip" />
								<div class="icon-container">
									<p></p>
									<img src="wow-icons/_images/64x64/{$itemTooltipNode/icon}.jpg" class="p"/>
								</div>
								
								<div class="alt-stats">
									<div class="as-top">
										<div class="as-bot">
											<em><xsl:value-of select="$loc/strs/itemInfo/str[@id='item.fact']"/></em>
											<xsl:if test="dropCreatures and count(dropCreatures/creature) = 1">
												<p><span><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.dropsfrom']"/></span><br />
												<strong>
													<xsl:choose>
														<xsl:when test="dropCreatures/creature[1]/@url">
															<a href="search.xml?searchType=items&amp;{dropCreatures/creature[1]/@url}"><xsl:value-of select="dropCreatures/creature[1]/@name" /></a>
														</xsl:when>
														<xsl:otherwise>
															<xsl:value-of select="dropCreatures/creature[1]/@name" />
														</xsl:otherwise>
													</xsl:choose>
												</strong>
												</p>
											</xsl:if>
											<xsl:if test="dropCreatures and count(containerObjects/object) = 1">
												<p><span><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.contained']"/></span><br />
													<strong>
														<xsl:choose>
															<xsl:when test="containerObjects/object[1]/@url">
																<a href="search.xml?searchType=items&amp;{containerObjects/object[1]/@url}"><xsl:value-of select="containerObjects/object[1]/@name" /></a>
															</xsl:when>
															<xsl:otherwise>
																<xsl:value-of select="containerObjects/object[1]/@name" />
															</xsl:otherwise>
														</xsl:choose>
													</strong>
												</p>
											</xsl:if>
											<p>
												<span><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.itemlevel']"/></span><br />
												<strong><xsl:value-of select="@level" /></strong>
											</p>
											
											<xsl:if test="cost">
												<xsl:if test="cost/@buyPrice or cost/@honor or cost/@arena or cost/token">
													<p>
														<span><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.bought']"/></span><br />
														<strong>
															<xsl:if test="cost/@buyPrice &gt;= 10000"><xsl:value-of select="floor(cost/@buyPrice div 10000)" /><img src="images/icons/money-gold.gif" class="pMoney" /></xsl:if>
															<xsl:if test="(cost/@buyPrice &gt;= 100) and floor((cost/@buyPrice div 100) mod 100) != 0"><xsl:value-of select="floor((cost/@buyPrice div 100) mod 100)" /><img src="images/icons/money-silver.gif" class="pMoney" /></xsl:if>
															<xsl:if test="(cost/@buyPrice &gt;= 0) and (cost/@buyPrice mod 100 != 0)"><xsl:value-of select="cost/@buyPrice mod 100" /><img src="images/icons/money-copper.gif" class="pMoney" />&#160;</xsl:if>
														</strong>
														<xsl:if test="cost/@honor"><p class="token"><span><xsl:value-of select="cost/@honor"/></span><img src="images/icons/honor{cost/@factionId}.gif" onMouseOver="setTipText('{$loc/strs/unsorted/str[@id='armory.labels.honorpoints']}')" class="staticTip" /></p></xsl:if>
														<xsl:if test="cost/@arena"><p class="token"><span><xsl:value-of select="cost/@arena"/></span><img src="images/icons/arena.gif" onMouseOver="setTipText('{$loc/strs/unsorted/str[@id='armory.labels.arenapoints']}')" class="staticTip" /></p></xsl:if>
														<strong>
															<xsl:for-each select="cost/token">
																<a class="item-count staticTip itemToolTip" id="i={@id}" href="item-info.xml?i={@id}"><span><b><xsl:value-of select="@count" /></b><xsl:value-of select="@count" /></span> <img src="wow-icons/_images/21x21/{@icon}.png" class="p21" /></a>
															</xsl:for-each>
														</strong>
													</p>
												</xsl:if>											
												<xsl:if test="cost/@sellPrice">
													<p>
														<span><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.sells']"/></span><br />
														<strong>
															<xsl:if test="cost/@sellPrice &gt;= 10000"><xsl:value-of select="floor(cost/@sellPrice div 10000)" /><img src="images/icons/money-gold.gif" class="pMoney" /></xsl:if>
															<xsl:if test="(cost/@sellPrice &gt;= 100) and floor((cost/@sellPrice div 100) mod 100) != 0"><xsl:value-of select="floor((cost/@sellPrice div 100) mod 100)" /><img src="images/icons/money-silver.gif" class="pMoney" /></xsl:if>
															<xsl:if test="(cost/@sellPrice &gt;= 0) and (cost/@sellPrice mod 100 != 0)"><xsl:value-of select="cost/@sellPrice mod 100" /><img src="images/icons/money-copper.gif" class="pMoney" />&#160;</xsl:if>
														</strong>
													</p>
												</xsl:if>
											</xsl:if>
											
											<xsl:if test="disenchantLoot">
												<xsl:variable name="requiredSkill" select="disenchantLoot/@requiredSkillRank"/>
												<p>
													<span><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.disenchantable']"/></span><br />
													<div class="skill-bar">
														<b style="width:{number(($requiredSkill div 375)*100)}%"></b>
														<img src="images/icons/icon-disenchant-sm.gif" class="staticTip" onMouseOver="javascript: setTipText('{$loc/strs/itemInfo/str[@id='armory.item-info.disenchant.tooltip.before']}{disenchantLoot/@requiredSkillRank}{$loc/strs/itemInfo/str[@id='armory.item-info.disenchant.tooltip.after']}');" />
														<strong class="staticTip" onMouseOver="javascript: setTipText('{$loc/strs/itemInfo/str[@id='armory.item-info.disenchant.tooltip.before']}{disenchantLoot/@requiredSkillRank}{$loc/strs/itemInfo/str[@id='armory.item-info.disenchant.tooltip.after']}');">
															<xsl:value-of select="$requiredSkill"/>
														</strong>
													</div>
												</p>
											</xsl:if>
											
											<xsl:if test="translationFor">
												<p style="margin-top:5px">
													<span>
														<xsl:choose>
															<xsl:when test="translationFor/@factionEquiv = 0">
																<xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.transinto.alliance']"/>
															</xsl:when>
															<xsl:when test="translationFor/@factionEquiv = 1">
																<xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.transinto.horde']"/>
															</xsl:when>
															<xsl:otherwise>
																<xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.transinto']"/>
															</xsl:otherwise>
														</xsl:choose>
													</span>
												</p>
												<xsl:for-each select="translationFor/item">
													<div style="position:relative">
														<table cellpadding="0" cellspacing="0" border="0" style="position:relative">
															<tr>
																<td	style="vertical-align:middle;line-height:1em"><xsl:choose>
																		<xsl:when test="../@factionEquiv = 0">
																			<div class="transition-logo-alliance-small"><xsl:comment></xsl:comment></div>
																		</xsl:when>
																		<xsl:when test="../@factionEquiv = 1">
																			<div class="transition-logo-horde-small"><xsl:comment></xsl:comment></div>
																		</xsl:when>
																	</xsl:choose><img src="wow-icons/_images/21x21/{@icon}.png" class="p21s staticTip itemToolTip" id="i={@id}" /></td>
																<td	style="vertical-align:middle; padding-left:7px"><a class="rarity{@quality} staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><xsl:value-of select="@name" /></a></td>
															</tr>
														</table>
													</div>
												</xsl:for-each>
											</xsl:if>
											
										</div>
									</div>
								</div>
								<div class="item-info">
									<div class="item-bound">
										<div class="id">
											<xsl:apply-templates select="$itemTooltipNode">
												<xsl:with-param name="isItemInfoPage" select = "'1'" />
											</xsl:apply-templates>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- related information -->
	<div class="item-related">

		<xsl:if test="randomProperties">
			<div class="scroll-padding"></div>
			<div class="rel-tab">
				<p class="rel-randomchant"></p>
				<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.randomenchants']"/></h3>
			</div>
			<div class="data" style="clear: both;">
				<table class="data-table">
					<tr class="masthead">
						<td width="25%"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.enchantment']"/></a></td>
						<td width="75%"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.effects']"/></a></td>			
					</tr>
					<xsl:for-each select="randomProperties/randomProperty">
						<tr>
							<td valign="top">
								<q>
									<div class="enchantName">
										...<xsl:value-of select = "@suffix" />
										<div class="enchantNameClone">			
											...<xsl:value-of select = "@suffix" />
										</div>			
									</div>
								</q>
							</td>
							<td valign="top">
								<q>
									<xsl:for-each select="randomPropertyEnchant">
										<xsl:value-of select = "@name" />
										<xsl:if test = "position() != last()">, </xsl:if>
									</xsl:for-each>
								</q>
							</td>
						</tr>
					</xsl:for-each>
				</table>
			</div>
		</xsl:if>
		
		<xsl:if test="dropCreatures and ../item/@id != 29434">
			<xsl:call-template name="creatureDropTemplate">
				<xsl:with-param name="dropTypeNode" select="dropCreatures"/>
				<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.dropped']"/>
			</xsl:call-template>
		</xsl:if>
		
		<xsl:if test="pickPocketCreatures">
			<xsl:call-template name="creatureDropTemplate">
				<xsl:with-param name="dropTypeNode" select="pickPocketCreatures"/>
				<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.pickpocketed']"/>
			</xsl:call-template>
		</xsl:if>
		
		<xsl:if test="skinCreatures">
			<xsl:call-template name="creatureDropTemplate">
				<xsl:with-param name="dropTypeNode" select="skinCreatures"/>
				<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.skinned']"/>
			</xsl:call-template>
		</xsl:if>
		
		<xsl:if test="herbCreatures">
			<xsl:call-template name="creatureDropTemplate">
				<xsl:with-param name="dropTypeNode" select="herbCreatures"/>
				<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.gathered']"/>
			</xsl:call-template>
		</xsl:if>
		
		<xsl:if test="mineCreatures">
			<xsl:call-template name="creatureDropTemplate">
				<xsl:with-param name="dropTypeNode" select="mineCreatures"/>
				<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.mined']"/>
			</xsl:call-template>
		</xsl:if>
		
		<xsl:if test="containerObjects/object">
			<div class="scroll-padding"></div>
			<div class="rel-tab">
				<p class="rel-drop"></p>
				<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.contained']"/></h3>
			</div>
			<div class="data" style="clear: both;">
			<table class="data-table">
				<tr class="masthead">			
					<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
					<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.location']"/></a></td>
					<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.drop']"/></a></td>			
				</tr>
					<xsl:for-each select="containerObjects/object">
						<xsl:sort select="@dropRate" data-type="number" order="descending" />
						<tr>
							<td>
								<q><span><i>
									<xsl:choose>
										<xsl:when test="@url"><a href="search.xml?searchType=items&amp;{@url}"><xsl:value-of select="@name" /></a></xsl:when>
										<xsl:otherwise><xsl:value-of select="@name" /></xsl:otherwise>
									</xsl:choose>
								</i></span></q>
							</td>
							<td>
								<q>
								<xsl:choose>
									<xsl:when test="@areaUrl"><a href="search.xml?searchType=items&amp;{@areaUrl}"><xsl:value-of select="@area" /><xsl:if test="@heroic"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.heroic']"/></xsl:if></a></xsl:when>
									<xsl:otherwise><xsl:value-of select="@area" /></xsl:otherwise>
								</xsl:choose>
								</q>
							</td>
							<td align="center">
								<q><xsl:call-template name="printItemDropChance"><xsl:with-param name="dropRate" select="@dropRate" /></xsl:call-template></q>
							</td>			
						</tr>
					</xsl:for-each>
				</table>
			</div>
		</xsl:if>
	</div>

	<xsl:if test="startsQuest">
		<xsl:call-template name="questTemplate">
			<xsl:with-param name="dropTypeNode" select="startsQuest"/>
			<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.starts']"/>
		<xsl:with-param name="iconClass" select="'rel-queststart'" />
		</xsl:call-template>
	</xsl:if>
	
	<xsl:if test="providedForQuests">
		<xsl:call-template name="questTemplate">
			<xsl:with-param name="dropTypeNode" select="providedForQuests"/>
			<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.provided']"/>
			<xsl:with-param name="iconClass" select="'rel-provided'" />
		</xsl:call-template>
	</xsl:if>
	
	<xsl:if test="objectiveOfQuests">
		<xsl:call-template name="questTemplate">
			<xsl:with-param name="dropTypeNode" select="objectiveOfQuests"/>
			<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.objective']"/>
			<xsl:with-param name="iconClass" select="'rel-objective'" />
		</xsl:call-template>
	</xsl:if>
	
	<xsl:if test="rewardFromQuests and ../item/@id != 29434">
		<xsl:call-template name="questTemplate">
			<xsl:with-param name="dropTypeNode" select="rewardFromQuests"/>
			<xsl:with-param name="title" select="$loc/strs/itemInfo/str[@id='armory.item-info.title.reward']"/>
			<xsl:with-param name="iconClass" select="'rel-reward'" />
		</xsl:call-template>
	</xsl:if>


	<xsl:if test="vendors">
		<div class="scroll-padding"></div><div class="rel-tab"><p class="rel-drop"></p>
		<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.soldby']"/></h3>
		</div>
		<div class="data" style="clear: both;">
		<table class="data-table"><tr class="masthead">
		
		<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
		<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.level']"/></a></td>
		<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.location']"/></a></td>
		
		</tr>
		<xsl:for-each select="vendors/creature">
		<xsl:sort select="@dropRate" data-type="number" order="descending" />
		<tr>
		<td><q><span><i><xsl:value-of select="@name" /></i></span></q></td>
		<td align="center"><q><xsl:value-of select="@minLevel"/><xsl:if test="@maxLevel &gt; @minLevel">-<xsl:value-of select="@maxLevel"/></xsl:if>
		<xsl:if test="@classification &gt; 0">&#160;<xsl:call-template name="printCreatureClassification"><xsl:with-param name="classification" select="@classification"/></xsl:call-template></xsl:if></q></td>
		<td><q><xsl:value-of select="@area" /></q></td>
		</tr>
		</xsl:for-each>
		</table>
		</div>
	</xsl:if>

	<xsl:if test="createdBy and count(createdBy/spell/reagent) &gt; 0">
		<div class="scroll-padding"></div>
		<div class="rel-tab"><p class="rel-reagentreq"></p>
			<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.reqregeants']"/></h3></div>
			<div id="big-results" style="clear: both;">
			<div class="data">
			<table class="data-table"><tr class="masthead">
			
			<td colspan="2"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
			<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.reagents']"/></a></td>
			
			</tr>
			<tr>
			<td width="55">
			<xsl:choose>
			<xsl:when test="createdBy/spell/item">
			<img src="wow-icons/_images/43x43/{createdBy/spell/item/@icon}.png" class="p43" />
			</xsl:when>
			<xsl:otherwise>
			<img src="wow-icons/_images/43x43/{@icon}.png" class="p43" />
			</xsl:otherwise>
			</xsl:choose>
			</td>
			<td><q>
			<xsl:choose>
			<xsl:when test="createdBy/spell/item">
			<a class="rarity{createdBy/spell/item/@quality} staticTip itemToolTip" href="item-info.xml?i={createdBy/spell/item/@id}" id="i={createdBy/spell/item/@id}"><xsl:value-of select="createdBy/spell/item/@name" /></a>
			
			</xsl:when>
			<xsl:otherwise>
			<a class="rarity{@quality} staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><xsl:value-of select="@name" /></a>
			
			</xsl:otherwise>
			</xsl:choose>
			</q></td>
			<td style="white-space: nowrap;"><q>
			<xsl:for-each select="createdBy/spell/reagent">
			<a class="item-add staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><img src="wow-icons/_images/21x21/{@icon}.png" class="p21" /><xsl:if test="@count &gt; 1"><b><xsl:value-of select="@count" /></b></xsl:if>
			</a>
			</xsl:for-each>
			</q></td></tr></table>
			</div>
		</div>
	</xsl:if>

	<xsl:if test="plansFor">
		<div class="scroll-padding"></div>
		<div class="rel-tab">
			<p class="rel-plans"></p>
			<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.plans']"/></h3></div>
			<div id="big-results" style="clear: both;">
			<div class="data">
			<table class="data-table"><tr class="masthead">
			
			<td colspan="2"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
			<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.reagents']"/></a></td>
			
			</tr>
			<tr>
			<td width="55"><img id="{plansFor/spell/item/@id}" src="wow-icons/_images/43x43/{plansFor/spell/item/@icon}.png" class="p43 staticTip itemToolTip" /></td>
			<td class="item-icon" width="50%"><q><a class="rarity{plansFor/spell/item/@quality} staticTip itemToolTip" href="item-info.xml?i={plansFor/spell/item/@id}" id="i={plansFor/spell/item/@id}"><xsl:value-of select="plansFor/spell/item/@name" /></a>
			</q>
			</td>
			<td style="white-space:nowrap;"><q>
			<xsl:for-each select="plansFor/spell/reagent">
			<a class="item-add staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><img src="wow-icons/_images/21x21/{@icon}.png" class="p21" /><xsl:if test="@count &gt; 1"><b><xsl:value-of select="@count" /></b></xsl:if>
			</a>
			</xsl:for-each>
			</q></td></tr></table>
		</div>
	</div>
	</xsl:if>

	<xsl:if test="reagentFor">
	<div class="scroll-padding"></div><div class="rel-tab"><p class="rel-reagentfor"></p>
		<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.regeantsfor']"/></h3></div>
		<div id="big-results" style="clear: both;">
		<div class="reagentTable">
		<div class="data">
		<table class="data-table">
		<tr class="masthead">
		<td colspan="2"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
		<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.reagents']"/></a></td>
		
		</tr>
		<xsl:for-each select="reagentFor/spell">
		<xsl:sort select="item/@level" order="descending" />
		<tr>
		<td width="55"><img id="{item/@id}" src="wow-icons/_images/43x43/{item/@icon}.png" class="p43 staticTip itemToolTip" /></td>
		<td class="item-icon" width="50%"><q><a class="rarity{item/@quality} staticTip itemToolTip" href="item-info.xml?i={item/@id}" id="i={item/@id}"><xsl:value-of select="item/@name" /></a></q>
		</td>
		<td style="white-space:nowrap;"><q>
		<xsl:for-each select="reagent">
		<a class="item-add staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><img src="wow-icons/_images/21x21/{@icon}.png" class="p21" /><b><xsl:if test="@count &gt; 1"><xsl:value-of select="@count" /></xsl:if></b>
		</a>
		</xsl:for-each>
		</q></td></tr>
		</xsl:for-each>
		</table>
		</div>
		</div>
	</div>
	</xsl:if>

	<xsl:if test="currencyFor">
		<div class="scroll-padding"></div><div class="rel-tab">
			<p class="rel-currency"></p>
			<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.currency']"/></h3></div>
			<div id="big-results" style="clear:both;">
			<div class="data">
			<table class="data-table"><tr class="masthead">
			
			<td colspan="2"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
			<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.cost']"/></a></td>
			
			</tr>
			<xsl:for-each select="currencyFor/item">
			<xsl:sort select="@dropRate" data-type="number" order="descending" />
			<tr>
			<td width="55"><img id="{@id}" src="wow-icons/_images/43x43/{@icon}.png" class="p43 staticTip itemToolTip" /></td>
			<td class="item-icon"><q><a class="rarity{@quality} staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><xsl:value-of select="@name" /></a></q>
			</td>
			<td align="center" style="white-space:nowrap;"><q>
			<xsl:if test="cost/@buyPrice &gt;= 10000"><xsl:value-of select="floor(cost/@buyPrice div 10000)" /><img src="images/icons/money-gold.png" class="pMoney" /></xsl:if>
			<xsl:if test="(cost/@buyPrice &gt;= 100) and floor((cost/@buyPrice div 100) mod 100) != 0"><xsl:value-of select="floor((cost/@buyPrice div 100) mod 100)" /><img src="images/icons/money-silver.png" class="pMoney" /></xsl:if>
			<xsl:if test="(cost/@buyPrice &gt;= 0) and (cost/@buyPrice mod 100 != 0)"><xsl:value-of select="cost/@buyPrice mod 100" /><img src="images/icons/money-copper.png" class="pMoney" />&#160;</xsl:if>
			<xsl:if test="cost/@arena"><span><xsl:value-of select="cost/@arena"/></span>&#160;<img src="images/icons/arena.gif" onMouseOver="setTipText('{$loc/strs/unsorted/str[@id='armory.labels.arenapoints']}')" class="staticTip" /></xsl:if>
			<xsl:for-each select="cost/token">
			<xsl:if test="position() &gt; 1">&#160;</xsl:if>
			<xsl:choose>
			<xsl:when test="@id = 29434">
			<a class="item-count staticTip" href="item-info.xml?i={@id}" id="{@id}"><span><b><xsl:value-of select="@count" /></b><xsl:value-of select="@count" /></span> <img src="wow-icons/_images/21x21/{@icon}.png" class="p21" /></a>
			</xsl:when>
			<xsl:otherwise>
			<a class="item-add staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}">
			<img src="wow-icons/_images/21x21/{@icon}.png" class="p21" /><xsl:if test="@count &gt; 1"><b><xsl:value-of select="@count" /></b></xsl:if>
			</a>
			</xsl:otherwise>
			</xsl:choose>
			</xsl:for-each>
			<xsl:if test="cost/@honor"><span style="margin-left:10px;"><xsl:value-of select="cost/@honor"/></span>&#160;<img src="_images/icons/honor{cost/@factionId}.gif" onMouseOver="setTipText('{$loc/strs/unsorted/str[@id='armory.labels.honorpoints']}')" class="staticTip" /></xsl:if>
			</q></td></tr>
			</xsl:for-each>
			</table>
			</div>
		</div>
	</xsl:if>

	<xsl:if test="disenchantLoot">
		<div class="scroll-padding"></div><div class="rel-tab"><p class="rel-de"></p>
			<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.disinto']"/></h3></div>
			<div id="big-results" style="clear: both;">
			<div class="data">
			<table class="data-table">
			<tr class="masthead">
			<td colspan="2" style="width: 50%;"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
			<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.drop']"/></a></td>
			<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.count']"/></a></td>			
			</tr>
			<xsl:for-each select="disenchantLoot/item">
			<xsl:sort select="@dropRate" data-type="number" order="descending" />
			<tr>
			<td width="55"><img src="wow-icons/_images/43x43/{@icon}.png" class="p43 staticTip itemToolTip" id="{@id}" /></td>
			<td class="item-icon" width="50%"><q><a class="rarity{@quality} staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><xsl:value-of select="@name" /></a></q></td>
			<td align="center"><q><xsl:call-template name="printItemDropChance"><xsl:with-param name="dropRate" select="@dropRate" /></xsl:call-template></q></td>
			<td align="center"><q><xsl:value-of select="@minCount" /><xsl:if test="@maxCount &gt; @minCount"> - <xsl:value-of select="@maxCount" /></xsl:if></q></td></tr>
			</xsl:for-each>
			</table>
			</div>
		</div>
	</xsl:if>
<!--
	<xsl:if test="translationFor">
		<div class="scroll-padding"></div><div class="rel-tab"><p class="rel-de"></p>
			<h3><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.transinto']"/></h3></div>
			<div id="big-results" style="clear: both;">
			<div class="data">
			<table class="data-table">
			<tr class="masthead">
			<td colspan="2" style="width: 50%;"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
			</tr>
			<xsl:for-each select="translationFor/item">
			<tr>
			<td width="55"><img src="wow-icons/_images/43x43/{@icon}.png" class="p43 staticTip itemToolTip" id="i={@id}" /></td>
			<td class="item-icon" width="50%"><q><a class="rarity{@quality} staticTip itemToolTip" href="item-info.xml?i={@id}" id="i={@id}"><xsl:value-of select="@name" /></a></q></td>
			</tr>
			</xsl:for-each>
			</table>
			</div>
		</div>
	</xsl:if>
-->
	<div class="clear"><xsl:comment/></div>			
</xsl:template>



<xsl:template name="printCreatureClassification">
	<xsl:param name="classification"/>

	<xsl:choose>
		<xsl:when test="$classification = 1"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.creature.classification.1']"/></xsl:when>
		<xsl:when test="$classification = 2"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.creature.classification.2']"/></xsl:when>
		<xsl:when test="$classification = 3"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.creature.classification.3']"/></xsl:when>
		<xsl:when test="$classification = 4"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.creature.classification.4']"/></xsl:when>
	</xsl:choose>
</xsl:template>

<xsl:template name="creatureDropTemplate">
	<xsl:param name="dropTypeNode" />
	<xsl:param name="title" />
	
	<xsl:if test="$dropTypeNode">
		<div class="scroll-padding"></div>
		<div class="rel-tab">
			<p class="rel-drop"></p>
			<h3><xsl:value-of select="$title" /></h3>
		</div>
		<div class="rwd" style="display:none; clear: both;">
			<xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.randomwdrop']"/>
		</div>
		<div class="data" style="clear: both;">
			<table class="data-table">
				<tr class="masthead">		
					<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.name']"/></a></td>
					<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.level']"/></a></td>
					<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.location']"/></a></td>
					<xsl:if test="$dropTypeNode/creature"><td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.drop']"/></a></td></xsl:if>		
				</tr>
				<xsl:for-each select="$dropTypeNode/creature">
					<xsl:sort select="@dropRate" data-type="number" order="descending" />
					<tr>
						<td><q><span><i class="mobName">
							<xsl:choose>
								<xsl:when test="@url"><a href="search.xml?searchType=items&amp;{@url}"><xsl:value-of select="@name" /></a></xsl:when>
								<xsl:otherwise><xsl:value-of select="@name" /></xsl:otherwise>
							</xsl:choose>
						</i></span></q></td>
						<td align="center">
							<q>
								<xsl:value-of select="@minLevel"/>
								<xsl:if test="@maxLevel &gt; @minLevel">-<xsl:value-of select="@maxLevel"/></xsl:if>
								<xsl:if test="@classification &gt; 0">&#160;
									<xsl:call-template name="printCreatureClassification">
										<xsl:with-param name="classification" select="@classification"/>
									</xsl:call-template></xsl:if>
							</q>
						</td>
						<td align="center">
							<q>
								<xsl:choose>
									<xsl:when test="@areaUrl"><a href="search.xml?searchType=items&amp;{@areaUrl}"><xsl:value-of select="@area" /><xsl:if test="@heroic"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.heroic']"/></xsl:if></a></xsl:when>
									<xsl:otherwise><xsl:value-of select="@area" /><xsl:if test="@heroic"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.heroic']"/></xsl:if></xsl:otherwise>
								</xsl:choose>
							</q>
						</td>
						<td align="center">
							<q><xsl:call-template name="printItemDropChance"><xsl:with-param name="dropRate" select="@dropRate" /></xsl:call-template></q>
						</td>
					</tr>
				</xsl:for-each>		
				<xsl:for-each select="$dropTypeNode/info">
					<xsl:sort select="@dropRate" data-type="number" order="descending" />
					<tr class="data1">
						<xsl:if test="position() mod 2 = 0"><xsl:attribute name="class">data0</xsl:attribute></xsl:if>		
						<td><span><i class="mobName"><xsl:value-of select="type/@name" /></i></span></td>
						<td align="center">
							<xsl:value-of select="@minLevel"/>
								<xsl:if test="@maxLevel &gt; @minLevel">-<xsl:value-of select="round(@avgMaxLevel)"/></xsl:if>
								<xsl:if test="@classification &gt; 0">&#160;
									<xsl:call-template name="printCreatureClassification">
										<xsl:with-param name="classification" select="@classification"/>
									</xsl:call-template>
								</xsl:if>
						</td>
						<td align="center"><xsl:value-of select="$loc/strs/str[@id='armory.item-info.world']"/></td>	
					</tr>
				</xsl:for-each>	  
			</table>
		</div>
	</xsl:if>
</xsl:template>



<xsl:template name="questTemplate">
	<xsl:param name="dropTypeNode" />
	<xsl:param name="title" />
	<xsl:param name="iconClass" />
	
	<xsl:if test="$dropTypeNode">
		<div class="scroll-padding"></div><div class="rel-tab"><p><xsl:attribute name="class"><xsl:value-of select="$iconClass" /></xsl:attribute></p><h3><xsl:value-of select="$title" /></h3></div>
		<div class="data" style="clear: both;">
			<table class="data-table">
				<tr class="masthead">
					<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.title']"/></a></td>
					<td align="center"><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.reqlevel']"/></a></td>
					<td><a class="noLink"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.label.location']"/></a></td>
				</tr>
				<xsl:for-each select="$dropTypeNode/quest">
					<xsl:sort select="@reqMinLevel" data-type="number" order="descending" />
					<tr>
						<td><q><span><i><xsl:value-of select="@name" /></i></span></q></td>
						<td align="center"><q><xsl:value-of select="@reqMinLevel"/></q></td>
						<td><q><xsl:value-of select="@area" /></q></td>
					</tr>
				</xsl:for-each>
			</table>
		</div>
	</xsl:if>
</xsl:template>

</xsl:stylesheet>