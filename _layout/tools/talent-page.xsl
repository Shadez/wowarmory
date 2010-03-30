<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="talentCalc">

	<xsl:param name="tcVarName" />
	<xsl:param name="uniqueId" />
	<xsl:param name="pageMode" />
	<xsl:param name="whichClassId" />
	<xsl:param name="whichFamilyId" />
	<xsl:param name="talStr" />

	<xsl:variable name="petMode" select="boolean($whichFamilyId)" />
	<xsl:variable name="importId">
		<xsl:choose>
			<xsl:when test="$petMode">0</xsl:when>
			<xsl:otherwise><xsl:value-of select="$whichClassId" /></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<xsl:variable name="talentList" select="document(concat('../../data/talent-tree-', $importId, '-', $lang, '.xml'))" />

	<xsl-template name="head-content">
		<script type="text/javascript" src="_js/tools/talent-calc.js"></script>
	</xsl-template>

	<!-- JS Data -->
	<script type="text/javascript">
		var talentData_<xsl:value-of select="$uniqueId" /> = [
		<xsl:for-each select="$talentList/page/talentTrees/tree">
			<xsl:sort select="@order" />
			{
				id:   "<xsl:value-of select="@key" />",
				name: "<xsl:value-of select="@name" />",
				talents: [
				<xsl:for-each select="talent">
					{
						id:     <xsl:value-of select="@key" />,
						tier:   <xsl:value-of select="@tier" />,
						column: <xsl:value-of select="@column" />,
						name:  "<xsl:value-of select="@name" />",
						icon:  "<xsl:value-of select="@icon" />",
						<xsl:if test="@requires">
							requires: <xsl:value-of select="@requires" />,
						</xsl:if>
						<xsl:if test="@categoryMask0">
							categoryMask0: <xsl:value-of select="@categoryMask0" />,
						</xsl:if>
						<xsl:if test="@categoryMask1">
							categoryMask1: <xsl:value-of select="@categoryMask1" />,
						</xsl:if>
						ranks: [
						<xsl:for-each select="rank">
							<xsl:sort select="@lvl" />
							"<xsl:call-template name="search-and-replace">
								<xsl:with-param name="input" select="@description" />
								<xsl:with-param name="search-string" select="'&quot;'" />
								<xsl:with-param name="replace-string" select="'\&quot;'" />
							</xsl:call-template>"
							<xsl:if test="position() &lt; last()">,</xsl:if>					
						</xsl:for-each>
						]
					}
					<xsl:if test="position() &lt; last()">,</xsl:if>
				</xsl:for-each>
				]
			}
			<xsl:if test="position() &lt; last()">,</xsl:if>
		</xsl:for-each>
		];

		var petData_<xsl:value-of select="$uniqueId" /> = null;
		<xsl:if test="$petMode">
			<xsl:choose>
				<xsl:when test="$pageMode = 'calc'">
					petData_<xsl:value-of select="$uniqueId" /> = {
					<xsl:for-each select="../petTalentTabs/petTalentTab/family">
						<xsl:value-of select="@id" />: {
							name:  "<xsl:value-of select="@name" />",
							tree:  "<xsl:value-of select="../@order" />",
							catId:  <xsl:value-of select="@catId" />,
							icon:  "<xsl:value-of select="@icon" />"
						}
						<xsl:if test="position() &lt; last()">,</xsl:if>
					</xsl:for-each>
					};
				</xsl:when>
				<xsl:otherwise>
					petData_<xsl:value-of select="$uniqueId" /> = {
					<xsl:for-each select="../characterInfo/talents/pet">
						<xsl:value-of select="@familyId" />: {
							name:  "<xsl:value-of select="@family" />",
							tree:  "<xsl:value-of select="talentGroup/@order" />",
							catId: <xsl:value-of select="@catId" />
						}
						<xsl:if test="position() &lt; last()">,</xsl:if>
					</xsl:for-each>
					};
				</xsl:otherwise>
			</xsl:choose>
			var textTalentBeastMasteryName = "<xsl:value-of select="../spells/spell[@id=53270]/@name" />";
			var textTalentBeastMasteryDesc = "<xsl:value-of select="../spells/spell[@id=53270]/@description" />";
		</xsl:if>
	
		var textTalentStrSingle = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqTalents.single']" />";
		var textTalentStrPlural = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqTalents.plural']" />";
		var textTalentRank = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.rankStrOrder']" />";
		var textTalentNextRank = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.nextRank']" />";
		var textTalentReqTreeTalents = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqTalentTree']" />";
		var textPrintableClassTalents = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.printable.classTalents']" />";
		var textPrintableMinReqLevel = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.printable.minReqLevel']" />";
		var textPrintableReqTalentPts = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.printable.reqTalentPts']" />";
		var textPrintableTreeTalents = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.printable.treeTalents']" />";
		var textPrintablePtsPerTree = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.printable.ptsPerTree']" />";
		var textPrintableDontWastePaper = "<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.printable.dontWastePaper']" />";

		var <xsl:value-of select="$tcVarName" /> = new TalentCalculator();

		$(document).ready(function() {

			<xsl:value-of select="$tcVarName" />.initTalentCalc(
				"<xsl:choose><xsl:when test="$petMode"><xsl:value-of select="$whichFamilyId" /></xsl:when><xsl:otherwise><xsl:value-of select="$whichClassId" /></xsl:otherwise></xsl:choose>", 
				"<xsl:value-of select="$talStr" />", 
				"<xsl:value-of select="$pageMode" />",
				"<xsl:value-of select="$petMode" />",
				"<xsl:value-of select="$uniqueId" />",
				talentData_<xsl:value-of select="$uniqueId" />,
				petData_<xsl:value-of select="$uniqueId" />
			);
		});
	</script>

	<!-- Top status bar (calculator only) -->
	<xsl:if test="$pageMode = 'calc'">
		<div class="calcInfo">
			<a id="linkToBuild_{$uniqueId}" class="awesomeButton awesomeButton-exportBuild" href="#">
				<span>
					<div class="staticTip" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='talents.linkToBuild.tooltip']}')">
						<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.linkToBuild']" />
					</div>
				</span>
			</a>
			<a class="awesomeButton awesomeButton-printableVersion" href="javascript:;" onclick="{$tcVarName}.showPrintableVersion()"><span><div><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.print']" /></div></span></a>
			<span class="calcInfoLeft">
				<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqLevel']" /></b>&#160;<span class="ptsHolder" id="requiredLevel">10</span>
				<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.pointsSpent']" /></b>&#160;<span class="ptsHolder" id="pointsSpent">0</span>
				<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.pointsLeft']" /></b>&#160;<span class="ptsHolder" id="pointsLeft">0</span> 
			</span>
			<xsl:if test="$petMode">
				<a href="javascript:;" onclick="{$tcVarName}.toggleBeastMastery()" id="beastMasteryToggler" class="petBeastMastery staticTip" onmouseover="{$tcVarName}.displayBeastMasteryTooltip()">+4</a>
			</xsl:if>
		</div>
	</xsl:if>

	<xsl:choose>
		<!-- Pet Talent Calculator -->
		<xsl:when test="$petMode">
			<div id="talContainer_{$uniqueId}" class="talContainer petContainer" >
				<xsl:if test="$pageMode = 'calc'">
					<xsl:attribute name="class">talContainer petTalCalcContainer</xsl:attribute>
				</xsl:if>

				<div class="talentFrame">
					<xsl:for-each select="$talentList/page/talentTrees/tree"> <!-- Loop through trees -->
						<xsl:sort select="@order" />
						<div id="{@key}_treeContainer_{$uniqueId}" class="talentTreeContainer" style="display: none">
							<div id="{@key}_tree_{$uniqueId}" class="talentTree" style="margin-right: 3px; background-image: url('images/talents/bg/small/{@bgImage}.jpg')">

								<xsl:call-template name="oneTier">
									<xsl:with-param name="tcVarName" select="$tcVarName" />
									<xsl:with-param name="uniqueId" select="$uniqueId" />
									<xsl:with-param name="pageMode" select="$pageMode" />
									<xsl:with-param name="currTier" select="'0'" />
									<xsl:with-param name="maxTier" select="'5'" />
									<xsl:with-param name="currTree" select="current()" />
								</xsl:call-template>
								
								<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/{@icon}.png) 0 0 no-repeat;">
									<!-- Individual reset button (calculator only) -->
									<xsl:if test="$pageMode = 'calc'">
										<a class="subtleResetButton" href="javascript:;" onclick="{$tcVarName}.resetTalents({@order}, true);">
											<span><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reset']" /></span>
										</a>
									</xsl:if>
									<span id="treeName_{@order}_{$uniqueId}" style="font-weight: bold;"><xsl:value-of select="current()/@name" /></span> &#160;<span id="treeSpent_{@order}_{$uniqueId}">0</span>
								</div>					
							</div>
						</div>
					</xsl:for-each>

					<!-- Export button (character sheet) -->
					<xsl:if test="$pageMode != 'calc'">
						<table cellpadding="0" cellspacing="0" border="0" class="resetExportPetHolder">
							<tr>
								<td>
									<a id="linkToBuild_{$uniqueId}" class="awesomeButton awesomeButton-exportBuild" href="#" target="_blank">
										<span>
											<div class="staticTip" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.talents.export.click']}')">						
												<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.talents.export.exportbuild']" />					
											</div>
										</span>
									</a>
								</td>
							</tr>
						</table>
					</xsl:if>

				</div>
			</div>

			<!-- Pet family selector (calculator only) -->
			<xsl:if test="$pageMode = 'calc'">
				<div id="petFamilies" class="petFamilies">
					<xsl:for-each select="../petTalentTabs/petTalentTab">
						<xsl:sort select="@order" />
						<div class="petGroup" id="{@order}_group">
							<div class="petGroup_b" onmouseover="$(this).parent().addClass('hoverPetGroup')" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onclick="{$tcVarName}.changePetTree({@order})">
								<h4><xsl:value-of select="@name" /></h4>
								<xsl:for-each select="family">
									<div id="{@id}_family" class="petFamily staticTip" style="background-image: url(wow-icons/_images/43x43/{@icon}.png)" onmouseover="{$tcVarName}.displayPetFamilyTooltip({@id})" onclick="{$tcVarName}.changePetTree({../@order}, {@id}, event)">
										<div class="petFrame">

										</div>
									</div>
								</xsl:for-each>
								<div style="clear: both; overflow: hidden; height:1px"></div>
							</div>
							<div class="petListArrow"></div>
						</div>
					</xsl:for-each>
				</div>
			</xsl:if>
		</xsl:when>

		<!-- Talent Calculator -->
		<xsl:otherwise>
			<div id="talContainer_{$uniqueId}" class="talContainer">
				<xsl:if test="$pageMode = 'calc'">
					<xsl:attribute name="class">talContainer talCalcContainer</xsl:attribute>
				</xsl:if>
				
				<div class="talentFrame">			
					<xsl:for-each select="$talentList/page/talentTrees/tree"> <!-- Loop through trees -->
						<xsl:sort select="@order" />
		
						<div id="{@key}_tree_{$uniqueId}" class="talentTree" style="margin-right: 3px; background-image: url('images/talents/bg/small/{@bgImage}.jpg')">
							<xsl:if test="position() = last()">
								<xsl:attribute name="style">background-image: url('images/talents/bg/small/<xsl:value-of select="@bgImage" />.jpg');</xsl:attribute>
							</xsl:if>
							<xsl:call-template name="oneTier">
								<xsl:with-param name="tcVarName" select="$tcVarName" />
								<xsl:with-param name="uniqueId" select="$uniqueId" />
								<xsl:with-param name="pageMode" select="$pageMode" />
								<xsl:with-param name="currTier" select="'0'" />
								<xsl:with-param name="maxTier" select="'10'" />
								<xsl:with-param name="currTree" select="current()" />
							</xsl:call-template>

							<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/{@icon}.png) 0 0 no-repeat;">
								<!-- Individual reset button (calculator only) -->
								<xsl:if test="$pageMode = 'calc'">
									<a class="subtleResetButton" href="javascript:;" onclick="{$tcVarName}.resetTalents({@order}, true);">
										<span><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reset']" /></span>
									</a>
								</xsl:if>
								<span id="treeName_{@order}_{$uniqueId}" style="font-weight: bold;"><xsl:value-of select="current()/@name" /></span> &#160;<span id="treeSpent_{@order}_{$uniqueId}">0</span>
							</div>			
						</div>	
					</xsl:for-each>
					
					<!-- Bottom button -->
					<table cellpadding="0" cellspacing="0" border="0" class="resetExportHolder">
						<tr>
							<td>
								<xsl:choose>
									<!-- Reset (calculator) -->
									<xsl:when test="$pageMode = 'calc'">
										<a class="awesomeButton awesomeButton-resetTalents" href="javascript:;" onclick="{$tcVarName}.resetAllTalents()">				
											<span>
												<div class="reload">
													<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.resetAll']" />
												</div>
											</span>
										</a>
									</xsl:when>
									<!-- Export (character sheet) -->
									<xsl:otherwise>
										<a id="linkToBuild_{$uniqueId}" class="awesomeButton awesomeButton-exportBuild" href="#" target="_blank">
											<span>
												<div class="staticTip" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.talents.export.click']}')">						
													<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.talents.export.exportbuild']" />					
												</div>
											</span>
										</a>
									</xsl:otherwise>
								</xsl:choose>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</xsl:otherwise>
	</xsl:choose>

</xsl:template>

<!-- Print out one talent tree tier -->
<xsl:template name="oneTier">

	<xsl:param name="tcVarName" />
	<xsl:param name="uniqueId" />
	<xsl:param name="pageMode" />
	<xsl:param name="currTier" ></xsl:param>
	<xsl:param name="maxTier" />
	<xsl:param name="currTree" />
	
	<div class="tier">	
		<xsl:for-each select="$currTree/talent[@tier = $currTier]">
			<div id="{@key}_iconHolder_{$uniqueId}" class="talent staticTip col{@column}" style="background-image:url('wow-icons/_images/_talents31x31/{@icon}.jpg');">
				<xsl:if test="not($currTier = 0)">
					<xsl:attribute name="style">background-image:url('wow-icons/_images/_talents31x31/grey/<xsl:value-of select="@icon"/>.jpg');</xsl:attribute>
				</xsl:if>
				<div id="{@key}_talentHolder_{$uniqueId}" class="talentHolder" onmouseover="{$tcVarName}.makeTalentTooltip({@key});" onclick="return false">
					<xsl:if test="$pageMode = 'calc'">
						<xsl:attribute name="onmousedown">
							<xsl:value-of select="$tcVarName" />.addTalent(<xsl:value-of select="@key" />, event); return false;
						</xsl:attribute>
					</xsl:if>
					<xsl:attribute name="class">talentHolder
						<xsl:if test="not($currTier = 0)"> disabled</xsl:if>
					</xsl:attribute>
					
					<xsl:if test="spell">
						<span id="spellInfo_{@key}" style="display: none;">

							<!-- Range -->							
							<xsl:if test="spell/@maxRange">
								<span style="float: right;">
									<xsl:if test="not(spell/power)">
										<xsl:attribute name="style">float: left;</xsl:attribute>
									</xsl:if>
									<!-- Yes I know, it doesn't make any sense to me either -Lee -->
									<xsl:if test="spell/@minRange"><xsl:value-of select="spell/@minRange" />&#160;-</xsl:if>
									<xsl:choose>
										<!-- Melee -->
										<xsl:when test="spell/@maxRange = '5'">
											<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.meleeRange']" />
										</xsl:when>
										<xsl:otherwise>
											<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.rangedSpell']">
												<xsl:with-param name="param1" select="spell/@maxRange" />
											</xsl:apply-templates>
										</xsl:otherwise>										
									</xsl:choose>
								</span>
								<xsl:if test="not(spell/power)"><br /></xsl:if>			
							</xsl:if>
							
							<!-- Cost -->
							<xsl:if test="spell/power">
								<span style="float: left;">
									<xsl:for-each select="spell/power">
										<xsl:if test="position() &gt; 1">,</xsl:if>
										<xsl:choose>
											<xsl:when test="@type = 'mana'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.mana-percent']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'rage'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.rage']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'energy'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.energy']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'runic'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.runic']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'unholy'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.unholy']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'frost'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.frost']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'blood'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.blood']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'unknown'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.mana']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
										</xsl:choose>
					
									</xsl:for-each>

								</span><br />
							</xsl:if>

							<!-- Cooldown -->
							<xsl:if test="spell/@cooldown">
								<span style="float: right;">									
								<xsl:choose>
									<xsl:when test="spell/@cooldown &lt; '60000'">
										<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.cooldown.sec']">
											<xsl:with-param name="param1" select="spell/@cooldown div 1000" />
										</xsl:apply-templates>
						
									</xsl:when>
									<xsl:otherwise>
										<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.cooldown.min']">
											<xsl:with-param name="param1" select="spell/@cooldown div 60000" />
										</xsl:apply-templates>
									</xsl:otherwise>
								</xsl:choose>
								</span>														
							</xsl:if>
							
							<!-- Cast time -->		
							<xsl:if test="spell/@castTime">
								<span style="float: left;">			
									<xsl:choose>
										<xsl:when test="spell/@castTime = '0'">
											<xsl:choose>
												<xsl:when test="spell/@channeled = '1'">
													<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.casttime.channeled']" />
												</xsl:when>
												<xsl:otherwise>
													<xsl:choose>
														<xsl:when test="spell/power/@type ='mana'">
															<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.casttime.instant-cast']" />
														</xsl:when>
														<xsl:otherwise>
															<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.casttime.instant']" />
														</xsl:otherwise>
													</xsl:choose>									
												</xsl:otherwise>
											</xsl:choose>
										</xsl:when>
										<xsl:otherwise>
											<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.casttime.non-instant']">
												<xsl:with-param name="param1" select="spell/@castTime div 1000" />
											</xsl:apply-templates>
										</xsl:otherwise>
									</xsl:choose>
								</span>
							</xsl:if>
							
						</span>
					</xsl:if>

					<div class="talentHover"></div>
					
					<div class="rankCtr">
						<span id="{@key}_numPoints_{$uniqueId}">0</span>
						<span>/</span>
						<span><xsl:value-of select="count(rank)" /></span>
					</div>
				</div>
			</div>
		</xsl:for-each>
	</div>
	
	<!-- Print next tier -->
	<xsl:if test="$currTier &lt; $maxTier">
		<xsl:call-template name="oneTier">
			<xsl:with-param name="tcVarName" select="$tcVarName" />
			<xsl:with-param name="uniqueId" select="$uniqueId" />
			<xsl:with-param name="pageMode" select="$pageMode" />
			<xsl:with-param name="currTier" select="$currTier + 1" />
			<xsl:with-param name="maxTier" select="$maxTier" />
			<xsl:with-param name="currTree" select="current()" />
		</xsl:call-template>
	</xsl:if>

</xsl:template>

</xsl:stylesheet>