<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../language.xsl"/>
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>
<xsl:include href="utils.xsl"/>
<xsl:variable name="XssId" select="page/itemTooltips/itemTooltip/id"/>
<xsl:variable name="XssName" select="page/itemTooltips/itemTooltip/name"/>
<xsl:variable name="XssIcon" select="page/itemTooltips/itemTooltip/icon"/>

<xsl:template name="printItemDropChance">
    <xsl:param name="dropRate"/>
    <xsl:choose>
        <xsl:when test="$dropRate = 0"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.0']"/></xsl:when>
        <xsl:when test="$dropRate = 1"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.1']"/></xsl:when>
        <xsl:when test="$dropRate = 2"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.2']"/></xsl:when>
        <xsl:when test="$dropRate = 3"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.3']"/></xsl:when>
        <xsl:when test="$dropRate = 4"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.4']"/></xsl:when>
        <xsl:when test="$dropRate = 5"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.5']"/></xsl:when>
        <xsl:when test="$dropRate = 6"><xsl:value-of select="$loc/strs/itemInfo/str[@id='armory.item-info.drop-rate.6']"/></xsl:when>		
    </xsl:choose>
</xsl:template>

<xsl:template match="itemTooltips">
<xsl:param name = "isItemInfoPage" />
  <xsl:choose>
    <xsl:when test="comparisonTooltips">
      <table cellspacing='0' cellpadding='0' border="1"><tr>
        <td valign="top">
        <div class="myTable">        
          <xsl:apply-templates select="itemTooltip" mode="plain">
			<xsl:with-param name = "isItemInfoPage"/>
		  </xsl:apply-templates>		  
        </div>
        </td>

        <xsl:for-each select="comparisonTooltips/itemTooltip">
        <td valign="top" class="tooltipDivider">
        <div class="myTable">
			<div style="border-bottom:1px dotted #444; margin: 0 5px 3px 0; color: #999;"><xsl:value-of select="$loc/strs/itemInfo/str[@id='currentlyEquipped']"/></div>
          <xsl:apply-templates select="current()" mode="plain">
			<xsl:with-param name = "isItemInfoPage" />
		  </xsl:apply-templates>		  		  
        </div>
        </td>
        </xsl:for-each>
      </tr></table>
    </xsl:when>
    <xsl:otherwise>
      <xsl:apply-templates select="itemTooltip">
			<xsl:with-param name = "isItemInfoPage" />
		  </xsl:apply-templates>		  	  
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>

<xsl:template match="itemTooltip">
<xsl:param name = "isItemInfoPage" />
<table cellspacing='0' cellpadding='0' border='0'><tbody><tr><td valign="top">

<div class='myTable'>
<xsl:call-template name="itemTooltipTemplate">
<xsl:with-param name = "isItemInfoPage" select= "$isItemInfoPage" />
</xsl:call-template>
</div>
</td></tr></tbody></table>
</xsl:template>

<xsl:template match="itemTooltip" mode="plain">
	<xsl:param name = "isItemInfoPage" />
	<xsl:call-template name="itemTooltipTemplate">
		<xsl:with-param name = "isItemInfoPage" select= "$isItemInfoPage" />
	</xsl:call-template>
</xsl:template>

<xsl:template name="itemTooltipTemplate">
    <xsl:param name = "isItemInfoPage" />
    <xsl:apply-templates select="name" />
    <xsl:apply-templates select="glyphType" />
    <xsl:apply-templates select="zoneBound" />
    <xsl:apply-templates select="heroic" />
    <xsl:apply-templates select="instanceBound" />
    <xsl:apply-templates select="conjured" />
    <xsl:apply-templates select="bonding" />
    <xsl:apply-templates select="maxCount" />
    <xsl:apply-templates select="startQuestId" />
    <xsl:apply-templates select="equipData" />
    <xsl:apply-templates select="damageData" />
    <xsl:apply-templates select="armor" />
    <xsl:apply-templates select="blockValue" />
    <xsl:apply-templates select="bonusStrength" />
    <xsl:apply-templates select="bonusAgility" />
    <xsl:apply-templates select="bonusStamina" />
    <xsl:apply-templates select="bonusIntellect" />
    <xsl:apply-templates select="bonusSpirit" />
    
    <xsl:apply-templates select="heirloomInfo" />
    
    <xsl:apply-templates select="fireResist" />
    <xsl:apply-templates select="natureResist" />
    <xsl:apply-templates select="frostResist" />
    <xsl:apply-templates select="shadowResist" />
    <xsl:apply-templates select="arcaneResist" />
    <xsl:apply-templates select="enchant" />
    <xsl:apply-templates select="randomEnchantData"/>
    
    <xsl:apply-templates select="socketData" />
    <xsl:apply-templates select="gemProperties" />
    <xsl:apply-templates select="durability" />
    <xsl:apply-templates select="allowableRaces" />
    <xsl:apply-templates select="allowableClasses" />
    <xsl:apply-templates select="requiredLevel" />
    
    <xsl:apply-templates select="requiredLevelMin" />
    <xsl:apply-templates select="requiredLevelMax" />
    <xsl:apply-templates select="requiredLevelCurr" />
    
    <xsl:apply-templates select="requiredSkill" />
    <xsl:apply-templates select="requiredAbility" />
    <xsl:apply-templates select="itemLevel" />
    <!-- pvp rank required -->
    <!-- pvp medal required -->
    <xsl:apply-templates select="requiredFaction" />
    <xsl:apply-templates select="requiredPersonalArenaRating" />
    <xsl:apply-templates select="bonusDefenseSkillRating" />
    <xsl:apply-templates select="bonusDodgeRating" />
    <xsl:apply-templates select="bonusParryRating" />
    <xsl:apply-templates select="bonusBlockRating" />
    <xsl:apply-templates select="bonusHitMeleeRating" />
    <xsl:apply-templates select="bonusHitRangedRating" />
    <xsl:apply-templates select="bonusHitSpellRating" />
    <xsl:apply-templates select="bonusCritMeleeRating" />
    <xsl:apply-templates select="bonusCritRangedRating" />
    <xsl:apply-templates select="bonusCritSpellRating" />
    <xsl:apply-templates select="bonusHitTakenMeleeRating" />
    <xsl:apply-templates select="bonusHitTakenRangedRating" />
    <xsl:apply-templates select="bonusHitTakenSpellRating" />
    <xsl:apply-templates select="bonusCritTakenMeleeRating" />
    <xsl:apply-templates select="bonusCritTakenRangedRating" />
    <xsl:apply-templates select="bonusCritTakenSpellRating" />
    <xsl:apply-templates select="bonusHasteMeleeRating" />
    <xsl:apply-templates select="bonusHasteRangedRating" />
    <xsl:apply-templates select="bonusHasteSpellRating" />
    <xsl:apply-templates select="bonusHitRating" />
    <xsl:apply-templates select="bonusCritRating" />
    <xsl:apply-templates select="bonusHitTakenRating" />
    <xsl:apply-templates select="bonusCritTakenRating" />
    <xsl:apply-templates select="bonusResilienceRating" />
    <xsl:apply-templates select="bonusHasteRating" />

    
    
    
    <xsl:apply-templates select="bonusSpellPower" />
    <xsl:apply-templates select="bonusAttackPower" />
    <xsl:apply-templates select="bonusFeralAttackPower" />
    <xsl:apply-templates select="bonusFeralAttackPower" />
    <xsl:apply-templates select="bonusManaRegen" />
    <xsl:apply-templates select="bonusArmorPenetration" />
    <xsl:apply-templates select="bonusBlockValue" />
    <xsl:apply-templates select="bonusHealthRegen" />
    <xsl:apply-templates select="bonusSpellPenetration" />
    
    <xsl:apply-templates select="bonusExpertiseRating" />
    <xsl:apply-templates select="spellData" />
    <xsl:apply-templates select="setData" />
    <!-- cooldown -->
    <xsl:apply-templates select="desc" />
    
    <xsl:choose>
      <xsl:when test = "not($isItemInfoPage)" ><xsl:apply-templates select="itemSource" /></xsl:when>
      <xsl:otherwise></xsl:otherwise>
    </xsl:choose>
		<div id="XssName{$XssId}" style="display:none"><xsl:value-of select="$XssName"/></div>
		<div id="XssIcon{$XssId}" style="display:none"><xsl:value-of select="$XssIcon"/></div>
</xsl:template>

<!-- name -->
<xsl:template match="itemSource">
  <xsl:variable name = "theSource" select = "../itemSource/@value" />
		  
			  <xsl:choose>
			    <xsl:when test = "$theSource != 'sourceType.none'" >
				<br /><br /><span class="tooltipContentSpecial" style="float: left;"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.source']"/>&#160;</span>
			  
			    <xsl:variable name = "formBoss" select = "/page/armorySearch/searchResults/filters/filter[@name='boss']/@value" />			  
			  <xsl:choose>
				
			    <xsl:when test = "$theSource = 'sourceType.creatureDrop'" >				
				  <xsl:choose>
				    <xsl:when test = "string-length(../itemSource/@areaName) = 0"><xsl:value-of select = "$loc/strs/itemsSearchColumns/str[@id='armory.hover.bossdrop']" /></xsl:when>
					<xsl:otherwise>
					
			      <xsl:variable name = "theDropRate">
				    <xsl:call-template name = "printItemDropChance"><xsl:with-param name = "dropRate" select = "../itemSource/@dropRate" /></xsl:call-template>
				  </xsl:variable>

			      <xsl:variable name = "urlDifficulty">
				    <xsl:choose>
					  <xsl:when test = "../itemSource/@difficulty = 'h'">heroic</xsl:when>
					  <xsl:otherwise>all</xsl:otherwise>
					</xsl:choose>
				  </xsl:variable>
					<xsl:value-of select="../itemSource/@areaName" /><xsl:choose><xsl:when test = "../itemSource/@difficulty = 'h'">&#160;<xsl:value-of select = "$loc/strs/itemsSearchColumns/str[@id='armory.hover.heroic']" /></xsl:when></xsl:choose><br />
					<xsl:choose><xsl:when test = "string-length(@creatureName) &gt; 0"><span class="tooltipContentSpecial" style="float: left;"><xsl:value-of select = "$loc/strs/itemsSearchColumns/str[@id='armory.hover.boss']" />&#160;</span><xsl:value-of select="../itemSource/@creatureName" /><br /></xsl:when></xsl:choose>
					<span class="tooltipContentSpecial" style="float: left;"><xsl:value-of select = "$loc/strs/itemsSearchColumns/str[@id='armory.hover.droprate']" />&#160;</span>
					<xsl:value-of select="$theDropRate" />
					</xsl:otherwise>
				  </xsl:choose>
				</xsl:when>
				<xsl:otherwise>
	              <xsl:value-of select="$loc/strs/itemsSearchColumns/str[@id=concat('armory.searchColumn.', $theSource)]"/>
				</xsl:otherwise>
			  </xsl:choose>
			    </xsl:when>
			  </xsl:choose>
</xsl:template>

<!-- name -->
<xsl:template match="name">
    <xsl:variable name="randomSuffix" select="concat(' ',../randomEnchantData/suffix)" />
    <xsl:choose>
        <xsl:when test="string-length($randomSuffix) &gt; 0">
            <xsl:choose>
            	<xsl:when test="../overallQualityId = 7"><span class="myGold myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>
				  </span></xsl:when>
            	<xsl:when test="../overallQualityId = 6"><span class="myOrange myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>
				  </span></xsl:when>
                <xsl:when test="../overallQualityId = 5"><span class="myOrange myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>
				  </span></xsl:when>
                <xsl:when test="../overallQualityId = 4"><span class="myPurple myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>
				</span></xsl:when>
                <xsl:when test="../overallQualityId = 3"><span class="myBlue myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>				
				</span></xsl:when>
                <xsl:when test="../overallQualityId = 2"><span class="myGreen myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>				
				</span></xsl:when>
                <xsl:when test="../overallQualityId = 1"><span class="myWhite myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>				
				</span></xsl:when>
                <xsl:when test="../overallQualityId = 0"><span class="myGray myBold myItemName">
					<xsl:call-template name="tooltip-stringorder">
						<xsl:with-param name="orderid" select="'armory.order.item-tooltip-random-suffix'"/>
						<xsl:with-param name="datainsert1" select="current()"/>
						<xsl:with-param name="datainsert2" select="$randomSuffix"/>
					</xsl:call-template>				
				</span></xsl:when>
            </xsl:choose>
        </xsl:when>
        <xsl:otherwise>
            <xsl:choose>
            	<xsl:when test="../overallQualityId = 7"><span class="myOrange myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
            	<xsl:when test="../overallQualityId = 6"><span class="myOrange myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
                <xsl:when test="../overallQualityId = 5"><span class="myOrange myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
                <xsl:when test="../overallQualityId = 4"><span class="myPurple myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
                <xsl:when test="../overallQualityId = 3"><span class="myBlue myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
                <xsl:when test="../overallQualityId = 2"><span class="myGreen myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
                <xsl:when test="../overallQualityId = 1"><span class="myWhite myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
                <xsl:when test="../overallQualityId = 0"><span class="myGray myBold myItemName"><xsl:value-of select="current()" /></span></xsl:when>
            </xsl:choose>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>


<xsl:template match="glyphType">
	<br />
    <span style="color: #5ea6e1">
        <xsl:choose>
        <xsl:when test="current() = 'MAJOR'">
            <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.majorglyph']"/>
        </xsl:when>    
        <xsl:when test="current() = 'MINOR'">
            <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.minorglyph']"/>
        </xsl:when>
    </xsl:choose>
    </span>
</xsl:template>
                
<!-- zone bound -->
<xsl:template match="zoneBound">
    <br /><xsl:value-of select="current()" />
</xsl:template>

<!-- quest item -->
<xsl:template match="heroic">
    <br /><span class="bonusGreen"><xsl:value-of select="$loc/strs/dungeons/str[@id='difficulty.heroic']"/></span>
</xsl:template>


<!-- instance bound -->
<xsl:template match="instanceBound">
    <br /><xsl:value-of select="current()" />
</xsl:template>

<!-- conjured -->
<xsl:template match="conjured"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.conjured']"/></xsl:template>

<!-- bonding -->
<xsl:template match="bonding">
    <xsl:choose>
        <xsl:when test="current() = 1"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.binds-pickup']"/></xsl:when>
        <xsl:when test="current() = 2"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.binds-equipped']"/></xsl:when>
        <xsl:when test="current() = 3"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.binds-used']"/></xsl:when>
        <xsl:when test="current() = 4 or current() = 5"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.quest-item']"/></xsl:when>
    </xsl:choose>
</xsl:template>

<!-- unique (max count) -->
<xsl:template match="maxCount">
	<xsl:choose>
		<xsl:when test="@uniqueEquippable"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.unique-equipped']"/></xsl:when>
	    <xsl:when test="current() &gt; 0">
		    <br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.unique']"/><xsl:if test="current() &gt; 1">&#160;(<xsl:value-of select="current()" />)</xsl:if>
	    </xsl:when>
	</xsl:choose>
</xsl:template>

<!-- quest item -->
<xsl:template match="startQuestId">
    <xsl:if test="current() &gt; 0"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.begins-quest']"/></xsl:if>
</xsl:template>

<!-- equip slot -->
<xsl:template match="equipData">
    <xsl:choose>
        <!-- inventoryType 18 = Bag -->
        <xsl:when test="inventoryType = 18"><br />
            <xsl:value-of select="containerSlots" />&#160;<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.slot']"/>&#160;<xsl:value-of select="subclassName" />
        </xsl:when>
        <!-- inventoryType 0 = non equip type -->
        <xsl:when test="inventoryType != 0">
        	<br />
            <xsl:choose>
                <!-- classId 6 = Projectile -->
                <xsl:when test="../classId = 6">
                    <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.projectile']"/><br />
                </xsl:when>
                <xsl:otherwise>
                	
                	<xsl:choose>
                    	<xsl:when test="subclassName">
                             <xsl:call-template name="printInventoryType">
                                <xsl:with-param name="type" select="inventoryType" />
                                <xsl:with-param name="thesubtype" select="subclassName" />
                            </xsl:call-template>                   
	                    </xsl:when>
                        <xsl:otherwise>
                            <xsl:call-template name="printInventoryType">
                                <xsl:with-param name="type" select="inventoryType" />
                            </xsl:call-template>                           
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:when>
    </xsl:choose>
</xsl:template>

<!-- weapon damage/speed/dps -->
<!-- WoW rounds total dps up, and truncates attack speed -->
<xsl:template match="damageData">
    <xsl:choose>
        <!-- classId 6 = Projectile -->
        <!-- we're assuming here that projectiles don't have more than one damage type -->
        <xsl:when test="../classId = 6">
            <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.adds']"/>&#160;<xsl:value-of select="(damage[1]/min + damage[1]/max) * 0.5" />&#160;<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.dps']"/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:for-each select="damage">
                <xsl:choose>
                    <xsl:when test="position() = 1"><br />
                        <xsl:call-template name="printDamageType">
                            <xsl:with-param name="min" select="min" />
                            <xsl:with-param name="max" select="max" />
                            <xsl:with-param name="type" select="type" />
                        </xsl:call-template>
                        <xsl:if test="../speed">
                            <span class='tooltipRight'><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.speed']"/>&#160;<xsl:value-of select="format-number(floor(../speed * 10) div 10, '#.00')" /></span>
                        </xsl:if>
                    </xsl:when>
                    <xsl:otherwise><br /><span>+ 
					    <xsl:call-template name="printDamageType">
                            <xsl:with-param name="min" select="min" />
                            <xsl:with-param name="max" select="max" />
                            <xsl:with-param name="type" select="type" />
                        </xsl:call-template></span>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:for-each>
            <xsl:if test="dps"><br/>	
			<!-- Loc - item-tooltip-dps-string -->
			(<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-dps-string'"/>
				<xsl:with-param name="datainsert1" select="format-number(dps, '#.0')"/>
			</xsl:call-template>)
			</xsl:if>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template name="printDamageType">
    <xsl:param name="min" />
    <xsl:param name="max" />
    <xsl:param name="type" />
    
		<xsl:choose>
		<!-- Loc - item-tooltip-damage-string -->
     <xsl:when test="$type = 0">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>	
		</xsl:when>
     <xsl:when test="$type = 1">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.holy-damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>	
		</xsl:when>
    <xsl:when test="$type = 2">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.fire-damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>	
		</xsl:when>
    <xsl:when test="$type = 3">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.nature-damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>
		</xsl:when>
    <xsl:when test="$type = 4">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.frost-damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>	
		</xsl:when>
    <xsl:when test="$type = 5">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.shadow-damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>	
		</xsl:when>
    <xsl:when test="$type = 6">
			<xsl:call-template name="tooltip-stringorder">
				<xsl:with-param name="orderid" select="'armory.order.item-tooltip-damage-string'"/>
				<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.arcane-damage']"/>
				<xsl:with-param name="itemTooltipMinMax"/>
				<xsl:with-param name="datainsert2" select="$min"/>
				<xsl:with-param name="datainsert3" select="$max"/>
			</xsl:call-template>	
		</xsl:when>
    </xsl:choose>
</xsl:template>


<!-- armor -->
<xsl:template match="armor">
    <xsl:if test="current() &gt; 0"><br /><span><xsl:attribute name = "class"><xsl:if test = "@armorBonus = '1'">myGreen</xsl:if></xsl:attribute>
		<xsl:call-template name="tooltip-stringorder">
			<xsl:with-param name="orderid" select="'armory.order.item-tooltip-armor-string'"/>
			<xsl:with-param name="datainsert1" select="current()"/>
		</xsl:call-template>
	  </span>		
	</xsl:if>
</xsl:template>

<!-- block value -->
<xsl:template match="blockValue">
    <xsl:if test="current() &gt; 0"><br />
		<xsl:call-template name="tooltip-stringorder">
			<xsl:with-param name="orderid" select="'armory.order.item-tooltip-blockvalue-string'"/>
			<xsl:with-param name="datainsert1" select="current()"/>
		</xsl:call-template>
	</xsl:if>
</xsl:template>

<!-- stat modifiers --><!-- Loc - item-tooltip-StatModifiers-string -->
<xsl:template match="bonusStrength"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-statmodifiers-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.strength']"/>
		<xsl:with-param name="itemTooltipStatModifiers"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>	
</xsl:template>
<xsl:template match="bonusAgility"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-statmodifiers-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.agility']"/>
		<xsl:with-param name="itemTooltipStatModifiers"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>
</xsl:template>
<xsl:template match="bonusStamina"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-statmodifiers-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.stamina']"/>
		<xsl:with-param name="itemTooltipStatModifiers"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>
</xsl:template>
<xsl:template match="bonusIntellect"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-statmodifiers-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.intellect']"/>
		<xsl:with-param name="itemTooltipStatModifiers"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>
</xsl:template>
<xsl:template match="bonusSpirit"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-statmodifiers-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.spirit']"/>
		<xsl:with-param name="itemTooltipStatModifiers"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>
</xsl:template>
    
<!-- resistances --><!-- Loc - item-tooltip-resistances-string -->
<xsl:template match="fireResist"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-resistances-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.fire-resistance']"/>
		<xsl:with-param name="itemTooltipResistancesValue"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>	
</xsl:template>
<xsl:template match="natureResist"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-resistances-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.nature-resistance']"/>
		<xsl:with-param name="itemTooltipResistancesValue"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>	
</xsl:template>
<xsl:template match="frostResist"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-resistances-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.frost-resistance']"/>
		<xsl:with-param name="itemTooltipResistancesValue"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>	
</xsl:template>
<xsl:template match="shadowResist"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-resistances-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.shadow-resistance']"/>
		<xsl:with-param name="itemTooltipResistancesValue"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>	
</xsl:template>
<xsl:template match="arcaneResist"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-resistances-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.arcane-resistance']"/>
		<xsl:with-param name="itemTooltipResistancesValue"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template>	
</xsl:template>
    
<!-- enchantments -->
<xsl:template match="enchant"><br /><span class="bonusGreen"><xsl:value-of select="current()" /></span>
</xsl:template>

<xsl:template match="socketData">
	<xsl:variable name="numGemsMatched" select="count(socket/@match)" />

    <xsl:for-each select="socket">
        <xsl:call-template name="printGemSocket">
            <xsl:with-param name="color"><xsl:value-of select="@color" /></xsl:with-param>
            <xsl:with-param name="enchant"><xsl:value-of select="@enchant" /></xsl:with-param>
            <xsl:with-param name="icon"><xsl:value-of select="@icon" /></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>
    <xsl:if test="socketMatchEnchant">
        <br /><span><xsl:attribute name="class">
                <xsl:choose>
                    <xsl:when test="$numGemsMatched = count(socket)">bonusGreen</xsl:when>
                    <xsl:otherwise>setItemGray</xsl:otherwise>
                </xsl:choose>
            </xsl:attribute><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.socket-bonus']"/>&#160;<xsl:value-of select="socketMatchEnchant" />
	    </span>
    </xsl:if>
</xsl:template>

<xsl:template name="printGemSocket">
    <xsl:param name="color" />
    <xsl:param name="enchant" />
    <xsl:param name="icon" />
    <xsl:choose>
        <xsl:when test="string-length($enchant) &gt; 0">
            <br /><xsl:if test="string-length($icon) &gt; 0"><img src="{concat('wow-icons/_images/21x21/',$icon,'.png')}" class="socketImg p"/></xsl:if><xsl:value-of select="$enchant" />
        </xsl:when>
        <xsl:otherwise>
            <xsl:choose>
                <xsl:when test="$color = 'Meta'"><br /><span class="setItemGray"><img src="shared/global/tooltip/images/icons/Socket_Meta.png" class="socketImg"/><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.meta-socket']"/></span></xsl:when>
                <xsl:when test="$color = 'Red'"><br /><span class="setItemGray"><img src="shared/global/tooltip/images/icons/Socket_Red.png" class="socketImg"/><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.red-socket']"/></span></xsl:when>
                <xsl:when test="$color = 'Yellow'"><br /><span class="setItemGray"><img src="shared/global/tooltip/images/icons/Socket_Yellow.png" class="socketImg"/><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.yellow-socket']"/></span></xsl:when>
                <xsl:when test="$color = 'Blue'"><br /><span class="setItemGray"><img src="shared/global/tooltip/images/icons/Socket_Blue.png" class="socketImg"/><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.blue-socket']"/></span></xsl:when>
            </xsl:choose>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template match="randomEnchantData">
    <xsl:choose>
        <xsl:when test="suffix"><xsl:for-each select="enchant"><br /><xsl:value-of select="current()" /></xsl:for-each>
        </xsl:when>
        <xsl:otherwise><br /><span class="bonusGreen">&lt;<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.random-enchant']"/>&gt;</span>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<!-- gem properties -->
<xsl:template match="gemProperties"><br /><xsl:value-of select="current()" /></xsl:template>

<!-- durability -->
<xsl:template match="durability">
    <br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.durability']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;<xsl:value-of select="@current" /> / <xsl:value-of select="@max" />
</xsl:template>

<!-- allowable races -->
<xsl:template match="allowableRaces"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.races']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;<xsl:for-each select="race"><xsl:if test="position() &gt; 1">, </xsl:if><xsl:value-of select="current()" /></xsl:for-each>
</xsl:template>

<!-- allowable classes -->
<xsl:template match="allowableClasses">
	<br />
    <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.classes']"/>
    	<xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;<xsl:for-each select="class">
        <xsl:if test="position() &gt; 1">, </xsl:if><xsl:value-of select="current()" />
		</xsl:for-each>
</xsl:template>

<!-- required level -->
<xsl:template match="requiredLevel">
	<xsl:if test="current() &gt; 1"><br />
    	<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.requires-level']"/>&#160;<xsl:value-of select="current()" />
	</xsl:if>
</xsl:template>

<!-- heirloom info -->
<xsl:template match="requiredLevelMin">
	<br />
    <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.requiredLevelMin']"/>
	&#160;<xsl:value-of select="current()" />&#160;
</xsl:template>

<xsl:template match="requiredLevelMax">	
	<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.requiredLevelMax']"/>
	&#160;<xsl:value-of select="current()" />
</xsl:template>

<xsl:template match="requiredLevelCurr">
	(<xsl:value-of select="current()" />)
</xsl:template>

<!-- minimum skill required --><!-- Loc - item-tooltip-miniSkillRequired-string -->
<xsl:template match="requiredSkill"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-miniSkillRequired-string'"/>
		<xsl:with-param name="datainsert1" select="@name"/>
		<xsl:with-param name="datainsert2" select="@rank"/>
	</xsl:call-template>	
</xsl:template>

<!-- ability required --><!-- Loc - item-tooltip-miniSkillRequired-string -->	
<xsl:template match="requiredAbility"><br/>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-requiredAbility-string'"/>
		<xsl:with-param name="datainsert1" select="current()"/>
	</xsl:call-template>
</xsl:template>

<!-- Item Level -->
<xsl:template match="itemLevel">
	<br />
    <xsl:value-of select="$loc/strs/itemsSearch/str[@id='armory.search.itemLevel']"/>&#160;<xsl:value-of select="current()" />&#160;
</xsl:template>

<!-- pvp rank required -->

<!-- pvp medal required -->

<!-- reputation required -->
<xsl:template match="requiredFaction"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.requires']"/>&#160;<xsl:value-of select="@name" /> - <xsl:call-template name="printFactionStanding">
    <xsl:with-param name="standing" select="@rep" /></xsl:call-template>
</xsl:template>

<xsl:template match="requiredPersonalArenaRating"><br />
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-requiredPersonalArenaRating'"/>
		<xsl:with-param name="datainsert1" select="@personalArenaRating" />
	</xsl:call-template>
</xsl:template>

<xsl:template name="printFactionStanding">
    <xsl:param name="standing" />
    <xsl:choose>
        <xsl:when test="$standing = 0"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.hated']"/></xsl:when>
        <xsl:when test="$standing = 1"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.hostile']"/></xsl:when>
        <xsl:when test="$standing = 2"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.unfriendly']"/></xsl:when>
        <xsl:when test="$standing = 3"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.neutral']"/></xsl:when>
        <xsl:when test="$standing = 4"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.friendly']"/></xsl:when>
        <xsl:when test="$standing = 5"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.honored']"/></xsl:when>
        <xsl:when test="$standing = 6"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.revered']"/></xsl:when>
        <xsl:when test="$standing = 7"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.exalted']"/></xsl:when>
    </xsl:choose>
</xsl:template>

<!-- rating stats --><!-- Loc - item-tooltip-ratingStats-string -->	
<xsl:template match="bonusDefenseSkillRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.increase-defense']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusDodgeRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.increase-dodge']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusParryRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusParryRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusBlockRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusBlockRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitMeleeRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHitMeleeRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitRangedRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHitRangedRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitSpellRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.improve-spell']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritMeleeRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusCritMeleeRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritRangedRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusCritRangedRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritSpellRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.improve-spell-crit']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitTakenMeleeRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHitTakenMeleeRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitTakenRangedRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHitTakenRangedRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitTakenSpellRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHitTakenSpellRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritTakenMeleeRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusCritTakenMeleeRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritTakenRangedRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusCritTakenRangedRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritTakenSpellRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusCritTakenSpellRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHasteMeleeRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHasteMeleeRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHasteRangedRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHasteRangedRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHasteSpellRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHasteSpellRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.improve-hit-rating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.improve-crit-strike']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHitTakenRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHitTakenRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusCritTakenRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusCritTakenRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusResilienceRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.improve-resilience']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusHasteRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHasteRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusSpellPower"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusSpellPower']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>
<xsl:template match="bonusAttackPower"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusAttackPower']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusRangedAttackPower"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusRangedAttackPower']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusFeralAttackPower"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusFeralAttackPower']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusManaRegen"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-manaRegen-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusManaRegen']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
		<xsl:with-param name="datainsert3" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusManaRegenPer5']"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusArmorPenetration"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusArmorPenetration']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusExpertiseRating"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusExpertiseRating']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusBlockValue"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusBlockValue']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusHealthRegen"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusHealthRege']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>

<xsl:template match="bonusSpellPenetration"><br/><span class='bonusGreen'>
	<xsl:call-template name="tooltip-stringorder">
		<xsl:with-param name="orderid" select="'armory.order.item-tooltip-ratingStats-string'"/>
		<xsl:with-param name="datainsert1" select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bonusSpellPenetration']"/>
		<xsl:with-param name="datainsert2" select="current()"/>
	</xsl:call-template></span>
</xsl:template>





<!-- spell effect & charges -->
<xsl:template match="spellData">
    <xsl:for-each select="spell"><br />
        <xsl:choose>
            <xsl:when test="itemTooltip">
            	<span class='bonusGreen'>
                	<xsl:call-template name="printSpellTrigger"><xsl:with-param name="trigger" select="trigger" /></xsl:call-template><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;<xsl:value-of select="desc" /></span>
            	<br /><xsl:if test="charges &gt; 1"><xsl:value-of select="charges" />&#160;<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.charges']"/><br /></xsl:if>
            	<br /><xsl:apply-templates select="itemTooltip" mode="plain" /><br />
                <xsl:for-each select="reagent">
                    <xsl:choose>
                        <xsl:when test="position() = 1"><br /><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.requires']"/>&#160;</xsl:when><xsl:otherwise>, </xsl:otherwise>
                    </xsl:choose><xsl:value-of select="@name" /><xsl:if test="@count &gt; 1"> (<xsl:value-of select="@count" />)</xsl:if>
                </xsl:for-each>
            </xsl:when>
            <xsl:otherwise>
                <span class='bonusGreen'>                
                	<xsl:call-template name="printSpellTrigger">
                	<xsl:with-param name="trigger" select="trigger" />
                    </xsl:call-template><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;
                    <xsl:value-of select="desc" />
				</span>
                <xsl:if test="charges &gt; 1"><br />
                	<xsl:value-of select="charges" />&#160;
                    <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.charges']"/>
				</xsl:if>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:for-each>
</xsl:template>

<xsl:template name="printSpellTrigger">
    <xsl:param name="trigger" />
    <xsl:choose>
        <xsl:when test="$trigger = 0"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.use']"/></xsl:when>
        <xsl:when test="$trigger = 1"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.equip']"/></xsl:when>
        <xsl:when test="$trigger = 2"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.chance-on-hit']"/></xsl:when>
        <xsl:when test="$trigger = 6"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.use']"/></xsl:when>
    </xsl:choose>
</xsl:template>






<!-- set description -->
<xsl:template match="setData">
    <xsl:variable name="meetsSkillReq" select="not(requiredSkill) or requiredSkill/@hasSkill" />
    <xsl:variable name="numSetPieces" select="count(item/@equipped)" />

    <br /><br /><span class='setNameYellow'><xsl:value-of select="name" /> (<xsl:value-of select="$numSetPieces"/>/<xsl:value-of select="count(item)" />)</span>
    <xsl:if test="requiredSkill">
    	<br /><span>
    	    <xsl:choose>
                <xsl:when test="requiredSkill/@hasSkill"><xsl:attribute name="class">myWhite</xsl:attribute></xsl:when>
                <xsl:otherwise><xsl:attribute name="class">myRed</xsl:attribute></xsl:otherwise>
            </xsl:choose>
            <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.requires']"/>&#160;<xsl:value-of select="requiredSkill/@name" /> (<xsl:value-of select="requiredSkill/@rank" />)
        </span>
    </xsl:if>
		<div class="setItemIndent">
			<xsl:for-each select="item">
                <br />
                <span>
                	<xsl:choose>
                        <xsl:when test="@equipped">
                                <xsl:attribute name="class">setItemYellow</xsl:attribute>
                        </xsl:when>
                        <xsl:otherwise>
                                <xsl:attribute name="class">setItemGray</xsl:attribute>
                        </xsl:otherwise>
					</xsl:choose>
					<xsl:value-of select="@name" />
                </span>
			</xsl:for-each>
   		</div>
		<br/>
    <xsl:for-each select="setBonus">
        <br />
        <span>
            <xsl:choose>
                <xsl:when test="$numSetPieces &gt;= @threshold and $meetsSkillReq"><xsl:attribute name="class">bonusGreen</xsl:attribute></xsl:when>
                <xsl:otherwise><xsl:attribute name="class">setItemGray</xsl:attribute>(<xsl:value-of select="@threshold" />) </xsl:otherwise>
            </xsl:choose>
            <xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.set']"/>
            <xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;<xsl:value-of select="@desc" />
        </span>
    </xsl:for-each>
</xsl:template>









<!-- item description text -->
<xsl:template match="desc">
    <br /><span class='myYellow'>"<xsl:value-of select="current()" />"</span>
</xsl:template>



<!-- ######## Localization Ordering Template ################################################ -->
<xsl:template name="tooltip-stringorder">
    <xsl:param name="orderid"/>
    <xsl:param name="datainsert1"/>
    <xsl:param name="datainsert2"/>
    <xsl:param name="datainsert3"/>
    <xsl:param name="datainsert4"/>
    <xsl:param name="itemTooltipMin-Max"/>
    <xsl:param name="itemTooltipStatModifiers"/>
    <xsl:param name="itemTooltipResistancesValue"/>
    
    <xsl:for-each select="$loc/strs/order[@id=$orderid]/str">
    <xsl:variable name="nodecount" select="count($loc/strs/order[@id=$orderid]/str)"/>
    <xsl:variable name="positionNum" select="position()"/>    
        <span>
            <xsl:attribute name="class">
            <xsl:choose>
                <xsl:when test="@format = 'italic'">italic</xsl:when>
                <xsl:when test="@format = 'bold'">bold</xsl:when> 
            </xsl:choose>	  
            </xsl:attribute>
    
            <xsl:choose>
                <xsl:when test="@id">
                    <xsl:variable name="comparestring" select="@id"/>	
                    <xsl:value-of select="../../str[@id=$comparestring]"/>
                </xsl:when>
                <xsl:when test="@select='datainsert1'">
                    <xsl:value-of select="$datainsert1"/>
                </xsl:when>
                <xsl:when test="@select='datainsert2'">
                    <xsl:value-of select="$datainsert2"/>
                </xsl:when>
                <xsl:when test="@select='datainsert3'">
                    <xsl:value-of select="$datainsert3"/>
                </xsl:when>
                <xsl:when test="@select='datainsert4'">
                    <xsl:value-of select="$datainsert4"/>
                </xsl:when>
                <xsl:when test="@select='itemTooltipMin-Max'">
                    <xsl:value-of select="$datainsert2" /><xsl:if test="$datainsert3 &gt; $datainsert2">-<xsl:value-of select="$datainsert3" /></xsl:if>
                </xsl:when>	
                <xsl:when test="@select='itemTooltipStatModifiers' or @select='itemTooltipResistancesValue'">
                    <xsl:choose>
                        <xsl:when test="$datainsert2 &lt; 0"><xsl:value-of select="$datainsert2" /></xsl:when>
                        <xsl:when test="$datainsert2 &gt; 0">+<xsl:value-of select="$datainsert2" /></xsl:when>
                    </xsl:choose>
                </xsl:when>
            </xsl:choose>
            <xsl:choose>
                <xsl:when test="$positionNum&lt;$nodecount and @space">&#160;</xsl:when>
            </xsl:choose>
        
        </span>            
    </xsl:for-each>
	
</xsl:template>


</xsl:stylesheet>
