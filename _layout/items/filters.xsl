<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="subtype.xsl" />

<xsl:variable name="dungeonsXml" select="document('../../_data/dungeons.xml')" />
<xsl:variable name="locDungeons" select="document(concat('../../data/dungeonStrings-', $lang, '.xml'))" />

<xsl:variable name="factionsXml" select="document('../../_data/factions.xml')/root" />
<xsl:variable name="locFactions" select="document(concat('../../data/factionStrings-', $lang, '.xml'))" />

<xsl:variable name="advOptionsXml" select="document('../../_data/items/advoptions.xml')" />

<xsl:variable name="releasesXml" select="$factionsXml" />

<xsl:template name="advOptions">
	<xsl:variable name="textSelectFilter" select="$loc/strs/items/str[@id='armory.item-search.selectfilter']" />

  <xsl:for-each select="$advOptionsXml/advFilters/advFilter">
    <xsl:variable name="theKey" select="@key" />
	

	
    <div id="childAdvOptions{$theKey}">
      <div id="wrapperOptions{$theKey}"></div>
    </div>

        <div id="optionAdvOptions{$theKey}" name="optionAdvOptions{$theKey}" style=" height: 25px; ">
		
<!--node [1]-->
          <select onChange="changeAdvOptions(this.parentNode, this.value)" name="advOptName" id="selectAdvOptions{$theKey}" style="float: left; ">
	        <option id="advOptions{$theKey}none" class="key" label="{$textSelectFilter}" value="none"><xsl:value-of select="$textSelectFilter"/></option>
            <xsl:for-each select="category">
			  <xsl:variable name="catKey" select="@key" />			
	  	      <optgroup label="{$loc/strs/itemsSearch/str[@id=concat('armory.search.', $catKey)]}">
		      <xsl:for-each select="option">
			    <xsl:variable name="stringKey" select="@key" />
	            <option id="advOptions{$theKey}{$stringKey}" class="{@oper}" value="{$stringKey}" name="advOptions{$theKey}{$stringKey}"><xsl:value-of select="$loc/strs/itemsSearch/str[@id=concat('armory.search.', $stringKey)]" /></option>
              </xsl:for-each>
	  	      </optgroup>			  
            </xsl:for-each>
	      </select>
		  
<!--node [2] (x)-->
          <div id="advOptWrapper{$theKey}" name="advOptWrapper{$theKey}"></div>
		  
<!--node [3]-->
          <div style="float: left; height: 20px;" onClick="javascript: removeAdvOpt(this, '{$theKey}');" id="advOptions{$theKey}Remove" name="advOptions{$theKey}Remove"><a class="remove"><span></span></a></div>
		  
        </div>

		  <!--node [x, 1] (y)-->		  
		    <div id="wrappercompare{$theKey}" name="wrappercompare{$theKey}" style="float: left;">
		      <!--node [x, y, 1] -->
              <select id="advOptOper" name="advOptOper"><option value="gt">&gt;</option><option value="gteq">&gt;=</option><option value="eq">=</option><option value="lt">&lt;</option><option value="lteq">&lt;=</option></select>
		      <!--node [x, y, 2] -->			
              <input type="text" class="irange" name="advOptValue" value="0"></input>
			</div>
		  <!--end node [x, 1] (y)-->

		  <!--node [x, 1] (y)-->		  
		    <div id="wrapperspelleffect{$theKey}" name="wrapperspelleffect{$theKey}" style="float: left;">
		      <!--node [x, y, 1] -->
              <select name="advOptOper" id="advOptOper">
			  <option name="advOptOperresist" id="advOptOperresist" value="resist"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.resist']"/></option>
			  <option name="advOptOperinterrupt" id="advOptOperinterrupt" value="interrupt"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.interrupt']"/></option>
			  <option name="advOptOperproc" id="advOptOperproc" value="proc"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.proc']"/></option>			  
			  <option name="advOptOperdispel" id="advOptOperdispel" value="dispel"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.dispel']"/></option>			  
			  <option name="advOptOpercooldown" id="advOptOpercooldown" value="cooldown"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.cooldown']"/></option>
			  <option name="advOptOpercasttime" id="advOptOpercasttime" value="casttime"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.casttime']"/></option>
			  <option name="advOptOperspellcost" id="advOptOperspellcost" value="spellcost"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.spellcost']"/></option>
			  <option name="advOptOperduration" id="advOptOperduration" value="duration"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.duration']"/></option>
			  <option name="advOptOperrange" id="advOptOperrange" value="range"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.range']"/></option>			  
			  <option name="advOptOperthreat" id="advOptOperthreat" value="threat"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.threat']"/></option>
			  <option name="advOptOpergroup" id="advOptOpergroup" value="group"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.group']"/></option>			    
			  <option name="advOptOpersummon" id="advOptOpersummon" value="summon"><xsl:value-of select="$loc/strs/itemsSpellEffect/str[@id='armory.item-search.spelleffect.summon']"/></option>		  
			  </select>
			</div>
		  <!--end node [x, 1] (y)-->

		  <!--node [x, 1] (y)-->		  
		    <div id="wrapperprofession{$theKey}" name="wrapperprofession{$theKey}" style="float: left;">
		      <!--node [x, y, 1] -->
              <select name="advOptOper">
			  <option value="leatherworking"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.leatherworking']"/></option>
			  <option value="tailoring"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.tailoring']"/></option>	  
			  <option value="engineering"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.engineering']"/></option>
			  <option value="blacksmithing"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.blacksmithing']"/></option>
			  <option value="cooking"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.cooking']"/></option>
			  <option value="alchemy"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.alchemy']"/></option>
			  <option value="firstaid"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.firstaid']"/></option>
			  <option value="enchanting"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.enchanting']"/></option>
			  <option value="fishing"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.fishing']"/></option>
			  <option value="jewelcrafting"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.jewelcrafting']"/></option>
			  </select>
			</div>
		  <!--end node [x, 1] (y)-->


<script type="text/javascript">

	theClone=document.getElementsByName('optionAdvOptions<xsl:value-of select="$theKey" />')[0].cloneNode(true);
	document.getElementById('wrapperOptions<xsl:value-of select="$theKey" />').appendChild(theClone);	

</script>
	
  </xsl:for-each>
</xsl:template>



<xsl:template name="optionsPvPRewards">
  <xsl:param name="factionUpper" />
  <xsl:param name="factionLower" />
  <xsl:param name="factionLetter" />  
    <div class="filter-container" id="childPvP{$factionLower}">
  <div name="divErrorPvP" id="divErrorPvP">  	
	<div class="option-cont"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.pvpsource']"/></div>
      <div class="input-cont"><select id="pvp" name="pvp">
        <option name="pvpall" id="pvpall" value="all"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.allpvpsources']"/></option>
		<xsl:variable name="locpvpxml" select="document(concat('../../_data/items/pvp', $factionLetter, '.xml'))" />
        <xsl:for-each select="$locpvpxml/pvpVendors/pvpVendor">
		  <xsl:variable name="typeKey" select="@key" />
          <option name="pvp{$typeKey}" id="pvp{$typeKey}" value="{$typeKey}"><xsl:value-of select="$loc/strs/pvpSource/str[@id=concat('armory.pvprewards.', $typeKey)]" /></option>
        </xsl:for-each>
	  </select></div>
	</div>
    </div>
</xsl:template>

<xsl:template name="optionsReputationRewards">
  <div class="filter-container" id="childReputationRewards">
  <div id="divErrorFaction">
  <div class="option-cont"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.faction']"/></div>
    <div class="input-cont"><select id="faction" name="faction">
      <option name="faction-1" id="faction-1" value="-1"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.allfactions']"/></option>
      <xsl:for-each select="$releasesXml/releases/release">
        <xsl:variable name="releaseKey" select="@key" />
        <xsl:variable name="releaseId" select="@id" />		
        <optgroup label="{$loc/strs/releases/str[@id=concat('armory.releases.', $releaseKey)]}">  
          <xsl:for-each select="$locFactions/page/factions/faction[@release=$releaseId]">
            <option name="faction{@id}" id="faction{@id}" value="{@id}"><xsl:value-of select="@name" /></option>
         </xsl:for-each>
	   </optgroup>
      </xsl:for-each>
	</select></div>
   </div>	
  </div>
</xsl:template>

<xsl:template name="optionsDungeons">
  <div class="filter-container" id="childDungeon">
  <div id="divErrorDungeon">
  <div class="option-cont"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.dropsfrom']"/></div>
    <div class="input-cont"><select id="dungeon" onChange="changedungeon(this.value)" onKeyUp="changedungeon(this.value)" name="dungeon">
      <option name="dungeonall" id="dungeonall" value="all"><xsl:value-of select="$loc/strs/items/sources/dungeons/str[@id='armory.item-search.alldungeonraid']"/></option>
      <option name="dungeondungeons" id="dungeondungeons" value="dungeons"><xsl:value-of select="$loc/strs/items/sources/dungeons/str[@id='armory.item-search.dungeononly']"/></option>	  
      <option name="dungeonraids" id="dungeonraids" value="raids"><xsl:value-of select="$loc/strs/items/sources/dungeons/str[@id='armory.item-search.raidonly']"/></option>	  	  
      <xsl:for-each select="$releasesXml/releases/release">
        <xsl:variable name="releaseKey" select="@key" />
        <xsl:variable name="releaseId" select="@id" />
        <optgroup label="{$loc/strs/releases/str[@id=concat('armory.releases.', $releaseKey)]}">  
		<xsl:choose>
		  <xsl:when test="$releaseId=1"><option id="dungeonbadgeofjustice" name="dungeonbadgeofjustice" value="badgeofjustice"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.bojr']"/></option></xsl:when>
          <xsl:when test="$releaseId=2">
          	<option id="dungeonemblemofheroism" name="dungeonemblemofheroism" value="emblemofheroism"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eohr']"/></option>
          	<option id="dungeonemblemofvalor" name="dungeonemblemofvalor" value="emblemofvalor"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eovr']"/></option>
          	<option id="dungeonemblemofconquest" name="dungeonemblemofconquest" value="emblemofconquest"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eocr']"/></option>
          	<option id="dungeonemblemoftriumph" name="dungeonemblemoftriumph" value="emblemoftriumph"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eotr']"/></option>
          	<option id="dungeonemblemoffrost" name="dungeonemblemoftriumph" value="emblemoffrost"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eofr']"/></option></xsl:when>
		</xsl:choose>		
          <xsl:for-each select="$locDungeons/page/dungeons/dungeon[@release=$releaseId]">
		    <xsl:variable name="dungeonId" select="@id" />
		    <xsl:variable name="dungeonKey" select="@key" />
            <xsl:variable name="dungeonName" select="@name" />
            <xsl:variable name="dungeonPath" select="$dungeonsXml/config/dungeons/dungeon[@key=$dungeonKey]" />			
            <option class="fake{$dungeonPath/@hasHeroic}" id="dungeon{$dungeonKey}" name="dungeon{$dungeonKey}" value="{$dungeonKey}"><xsl:value-of select="$dungeonName" /> </option>
         </xsl:for-each>
	   </optgroup>
      </xsl:for-each>
	</select></div></div>
	<div class="drop-source"></div><div class="drop-source2" id="dungeonParentBosses"></div>
	<div class="drop-source"></div><div class="drop-source2" id="dungeonParentHeroic"></div>	
  </div>
</xsl:template>

<xsl:template name="optionsBosses">
    <xsl:variable name="textBoss" select="$loc/strs/items/str[@id='armory.item-search.boss']" />	
    <xsl:variable name="textBossOne" select="$loc/strs/items/str[@id='armory.item-search.bossesone']" />	
    <xsl:variable name="textBossTwo" select="$loc/strs/items/str[@id='armory.item-search.bossestwo']" />

  <xsl:for-each select="$locDungeons/page/dungeons/dungeon">
    <xsl:variable name="dungeonId" select="@id" />
    <xsl:variable name="dungeonName" select="@name" />
	
  <div class="filter-container" id="child{@key}">
   <div class="option-cont"><xsl:value-of select="$textBoss"/></div>	
    <div class="input-cont"><select id="boss" name="boss">
      <option id="bossall" name="bossall" value="all"><xsl:value-of select="$textBossOne"/><xsl:value-of select="$dungeonName" /><xsl:value-of select="$textBossTwo"/></option>
	  <xsl:for-each select="boss">
        <option id="boss{@id}" name="boss{@id}" value="{@id}"><xsl:value-of select="@name" /></option>
      </xsl:for-each>		
    </select></div>
	</div>
  </xsl:for-each>
</xsl:template>


<xsl:template name="templateFormItem">
  <xsl:param name="templateClass">detail-search</xsl:param>
<xsl:variable name="theLang" select="/page/@lang" />

<xsl:variable name="textPvE" select="$loc/strs/general/str[@id='playervsenvironment']" />
<xsl:variable name="textPvP" select="$loc/strs/general/str[@id='playervsplayer']" />

<xsl:variable name="textAnyType" select="$loc/strs/classes/str[@id='item-filter.anytype']" />
<xsl:variable name="textTank" select="$loc/strs/classes/str[@id='item-filter.tank']" />
<xsl:variable name="textMelee" select="$loc/strs/classes/str[@id='item-filter.meleedps']" />
<xsl:variable name="textCaster" select="$loc/strs/classes/str[@id='item-filter.casterdps']" />
<xsl:variable name="textHealer" select="$loc/strs/classes/str[@id='item-filter.healer']" />

<xsl:variable name="textAllSlots" select="$loc/strs/items/slots/str[@id='allslots']" />
<xsl:variable name="textHead" select="$loc/strs/items/slots/str[@id='head']" />
<xsl:variable name="textNeck" select="$loc/strs/items/slots/str[@id='neck']" />
<xsl:variable name="textShoulders" select="$loc/strs/items/slots/str[@id='shoulders']" />
<xsl:variable name="textBack" select="$loc/strs/items/slots/str[@id='back']" />
<xsl:variable name="textChest" select="$loc/strs/items/slots/str[@id='chest']" />
<xsl:variable name="textShirt" select="$loc/strs/items/slots/str[@id='shirt']" />
<xsl:variable name="textWrists" select="$loc/strs/items/slots/str[@id='wrists']" />
<xsl:variable name="textHands" select="$loc/strs/items/slots/str[@id='hands']" />
<xsl:variable name="textWaist" select="$loc/strs/items/slots/str[@id='waist']" />
<xsl:variable name="textLegs" select="$loc/strs/items/slots/str[@id='legs']" />
<xsl:variable name="textFeet" select="$loc/strs/items/slots/str[@id='feet']" />

<xsl:variable name="textFinger" select="$loc/strs/items/slots/str[@id='finger']" />
<xsl:variable name="textTrinket" select="$loc/strs/items/slots/str[@id='trinket']" />
<xsl:variable name="textShield" select="$loc/strs/items/slots/str[@id='shield']" />
<xsl:variable name="textOffHand" select="$loc/strs/items/slots/str[@id='offhandfrill']" />

<xsl:variable name="textRarity" select="$loc/strs/items/rarity/str[@id='armory.item-search.rarity']" />
<xsl:variable name="textAll" select="$loc/strs/items/rarity/str[@id='armory.item-search.all']" />
<xsl:variable name="textCommon" select="$loc/strs/items/rarity/str[@id='armory.item-search.common']" />
<xsl:variable name="textUncommon" select="$loc/strs/items/rarity/str[@id='armory.item-search.uncommon']" />
<xsl:variable name="textRare" select="$loc/strs/items/rarity/str[@id='armory.item-search.rare']" />
<xsl:variable name="textEpic" select="$loc/strs/items/rarity/str[@id='armory.item-search.epic']" />
<xsl:variable name="textLegendary" select="$loc/strs/items/rarity/str[@id='armory.item-search.legendary']" />
<xsl:variable name="textHeirloom" select="$loc/strs/items/rarity/str[@id='armory.item-search.heirloom']" />

<xsl:variable name="textPhysicalDps" select="$loc/strs/classes/role/str[@id='armory.item-search.physicaldps']" />
<xsl:variable name="textCasterDps" select="$loc/strs/classes/role/str[@id='armory.item-search.casterdps']" />
<xsl:variable name="textRoleHealer" select="$loc/strs/classes/role/str[@id='armory.item-search.healer']" />

<xsl:variable name="textPredefinedFilters" select="$loc/strs/itemsOptions/str[@id='armory.item-search.predefinedfilters']" />




<form id="formItem" name="formItem" action="search.xml" method="get" onSubmit="javascript: return menuCheckLength(document.formItem);">

<div class="{$templateClass}">
 <div class="{$templateClass}-top">

  <div id="parentItemName"></div>
  <div class="filter-left">
  <div id="parentSource"></div>  
  <div id="parentSourceSub1"></div>
  </div>
  <div class="filter-right">
  <div id="parentItemType"></div>
  <div id="parentSingle"></div>
  </div>
  <div class="multi-filter"><div id="parentMultiple"></div><div id="parentComplex"></div></div> 
 </div>
	<div class="clear"><xsl:comment/></div>
</div>
<div class="{$templateClass}-bot">

</div>

<div class="button-row">
 <a class="button-red" style="line-height: 17px;" href="javascript: submitForm();"><p><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.newsearch']"/></p><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.newsearch']"/></a>
 <a class="button-red" style="line-height: 17px;" href="javascript: resetForms();"><p><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.resetform']"/></p><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.resetform']"/></a>
  <span class="shrb"></span>   
</div> 
			

<div class="item-errors" id="showHideError" style="display:none; "><div class="insert-error"><em></em><span id="replaceError"></span></div></div>
<div class="item-errors" id="showHideError2" style="display:none; "><div class="insert-error"><em></em><span id="replaceError2"></span></div></div>

<input type="hidden" name="searchType" value="items" />
</form>


<form id="formPhantom" style="display: none; ">

  <div id="divDelete"></div>
  <div class="showFilter" id="divMultiple"><span class="shr"></span></div>  

  <div class="filter-container" id="childItemName"><div class="option-cont"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.itemname']"/></div>
  <div class="input-cont" id="divSearchQuery"><input id="searchQuery" type="text" name="searchQuery" /></div>
     <div class="see-also" id="divSeeAlso" style="display: none;"><em class="a"></em><em class="b"></em><em class="c"></em><em class="d"></em><h2><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.seealso']"/></h2><div id="replaceSeeAlso"></div></div>
  </div>

  <xsl:call-template name="optionsBosses" />
  <xsl:call-template name="optionsDungeons" />
  <xsl:call-template name="optionsReputationRewards" />
  <xsl:call-template name="optionsPvPRewards">
	<xsl:with-param name="factionUpper" select="'Alliance'" />
	<xsl:with-param name="factionLower" select="'alliance'" />	
	<xsl:with-param name="factionLetter" select="'a'" />		
  </xsl:call-template>
  <xsl:call-template name="optionsPvPRewards">
	<xsl:with-param name="factionUpper" select="'Horde'" />
	<xsl:with-param name="factionLower" select="'horde'" />	
	<xsl:with-param name="factionLetter" select="'h'" />		
  </xsl:call-template>

  <xsl:call-template name="advOptions" />

  <div class="filter-container" id="childItemType"><div class="option-cont"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.itemtype']"/></div>
    <div class="input-cont"><select id="type" onChange="changetype(this.value)" onKeyUp="changetype(this.value)" name="type">
	  <option id="typeall" name="typeall" value="all"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.allitems']"/></option>
	  <option id="typeweapons" name="typeweapons" value="weapons"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.weapons']"/></option>
	  <option id="typearmor" name="typearmor" value="armor"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.armor']"/></option>
	  <option id="typegems" name="typegems" value="gems"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.gems']"/></option>
	  <option id="typecontainers" name="typecontainers" value="containers"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.containers']"/></option>
	  <option id="typeconsumables" name="typeconsumables" value="consumables"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.consumables']"/></option>
	  <option id="typetradegoods" name="typetradegoods" value="tradegoods"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.tradegoods']"/></option>
	  <option id="typeprojectiles" name="typeprojectiles" value="projectiles"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.projectiles']"/></option>
	  <option id="typequivers" name="typequivers" value="quivers"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.quivers']"/></option>
	  <option id="typerecipes" name="typerecipes" value="recipes"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.recipes']"/></option>
	  <option id="typereagents" name="typereagents" value="reagents"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.reagents']"/></option>
	  <option id="typemisc" name="typemisc" value="misc"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.miscellaneous']"/></option>
	  <option id="typeenchP" name="typeenchP" value="enchP"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.enchp']"/></option>
	  <option id="typeenchT" name="typeenchT" value="enchT"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.encht']"/></option>	  
	  <option id="typemounts" name="typemounts" value="mounts"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.mounts']"/></option>
	  <option id="typesmallpets" name="typesmallpets" value="smallpets"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.smallpets']"/></option>
	  <option id="typekeys" name="typekeys" value="keys"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.keys']"/></option>
      <option id="typeglyphs" name="typeglyphs" value="glyphs"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.glyphs']"/></option>
      
	</select></div>
  </div>

  <div class="filter-container" id="childSource"><div class="option-cont"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.source']"/></div>
    <div class="input-cont"><select id="source" onChange="changesource(this.value)" onKeyUp="changesource(this.value)" name="source">
	  <option id="sourceall" name="sourceall" value="all" selected="selected"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.allsources']"/></option>
	  <option id="sourcedungeon" name="sourcedungeon" value="dungeon"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.dungeonraiddrops']"/></option>
	  <option id="sourcereputation" name="sourcereputation" value="reputation"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.reputationrewards']"/></option>
	  <option id="sourcequest" name="sourcequest" value="quest"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.questrewards']"/></option>
	  <option id="sourcepvpAlliance" name="sourcepvpAlliance" value="pvpAlliance"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.pvprewardsa']"/></option>
	  <option id="sourcepvpHorde" name="sourcepvpHorde" value="pvpHorde"><xsl:value-of select="$loc/strs/items/sources/general/str[@id='armory.item-search.pvprewardsh']"/></option>	  	</select></div>
  </div>
  
  <div id="childUsableByDruid">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypetank" id="classTypetank" value="tank"><xsl:value-of select="$textTank"/></option>
  <option name="classTypemelee" id="classTypemelee" value="melee"><xsl:value-of select="$textMelee"/></option>
  <option name="classTypecaster" id="classTypecaster" value="caster"><xsl:value-of select="$textCaster"/></option>
  <option name="classTypehealer" id="classTypehealer" value="healer"><xsl:value-of select="$textHealer"/></option>
  </select>
  </div>  

  <div id="childUsableByPaladin">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypetank" id="classTypetank" value="tank"><xsl:value-of select="$textTank"/></option>
  <option name="classTypemelee" id="classTypemelee" value="melee"><xsl:value-of select="$textMelee"/></option>
  <option name="classTypecaster" id="classTypecaster" value="caster"><xsl:value-of select="$textCaster"/></option>
  <option name="classTypehealer" id="classTypehealer" value="healer"><xsl:value-of select="$textHealer"/></option>      
  </select>
  </div>  

  <div id="childUsableByShaman">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypemelee" id="classTypemelee" value="melee"><xsl:value-of select="$textMelee"/></option>
  <option name="classTypecaster" id="classTypecaster" value="caster"><xsl:value-of select="$textCaster"/></option>
  <option name="classTypehealer" id="classTypehealer" value="healer"><xsl:value-of select="$textHealer"/></option>      
  </select>
  </div>  

  <div id="childUsableByPriest">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypecaster" id="classTypecaster" value="caster"><xsl:value-of select="$textCaster"/></option>
  <option name="classTypehealer" id="classTypehealer" value="healer"><xsl:value-of select="$textHealer"/></option>      
  </select>
  </div>  

  <div id="childUsableByWarlock">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypedot" id="classTypedot" value="dot"><xsl:value-of select="$loc/strs/classes/str[@id='items.warlocks.damage']"/></option>
  <option name="classTypedd" id="classTypedd" value="dd"><xsl:value-of select="$loc/strs/classes/str[@id='items.warlocks.damagecrit']"/></option>      
  </select>
  </div>  

  <div id="childUsableByWarrior">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypetank" id="classTypetank" value="tank"><xsl:value-of select="$textTank"/></option>
  <option name="classTypemelee" id="classTypemelee" value="melee"><xsl:value-of select="$textMelee"/></option>  
  </select>
  </div> 
  
  <div id="childUsableByDeathKnight">
  <select name="classType" id="classType" >
  <option name="classTypeall" id="classTypeall" value="all"><xsl:value-of select="$textAnyType"/></option>  
  <option name="classTypetank" id="classTypetank" value="tank"><xsl:value-of select="$textTank"/></option>
  <option name="classTypemelee" id="classTypemelee" value="melee"><xsl:value-of select="$textMelee"/></option>  
  </select>
  </div> 
  
  <div id="childAllComplex">
 <div class="ao-cont" id="showHideAllComplexButton"><a class="ao-pop" href="javascript: toggleAllComplex();"><div id="replaceAllComplex"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.showadvanced']"/></div><em></em></a></div>  
	<div id="showHideAllComplex" style="display: none; ">
	  <div class="filter-left">
	    <div class="sub-filters" id="allComplexParentUsableBy"></div>	  
	    <div class="sub-filters" id="allComplexParentSlot"></div>						
	    <div class="sub-filters" id="allComplexParentRequiredLevel"></div>
	    <div class="sub-filters" id="allComplexParentRarity"></div>			
	  </div>
	  <div id="allComplexParentAdvancedOptions"></div>	
	</div>
  </div>
  
  <div id="childWeapons"><!-- begin Weapons -->
	<div class="filter-left">


	<div class="sub-filters" id="weaponParentUsableBy"></div>	
	<div class="sub-filters">	

	  <div class="sub-label"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.slot']"/> </div>	
	  <select id="slot" name="slot">
	    <option id="slotall" name="slotall" value="all"><xsl:value-of select="$textAllSlots"/></option>
        <option id="slotmain" name="slotmain" value="main"><xsl:value-of select="$loc/strs/items/weaponSlots/str[@id='armory.item-search.weapons.main']"/></option>
        <option id="slotoff" name="slotoff" value="off"><xsl:value-of select="$loc/strs/items/weaponSlots/str[@id='armory.item-search.weapons.off']"/></option>
        <option id="slotone" name="slotone" value="one"><xsl:value-of select="$loc/strs/items/weaponSlots/str[@id='armory.item-search.weapons.both']"/></option>	
        <option id="slottwo" name="slottwo" value="two"><xsl:value-of select="$loc/strs/items/weaponSlots/str[@id='armory.item-search.weapons.two']"/></option>		
        <option id="slotranged" name="slotranged" value="ranged"><xsl:value-of select="$loc/strs/items/weaponSlots/str[@id='armory.item-search.weapons.ranged']"/></option>
	  </select>	
	</div>	

	<div class="sub-filters">
	
	  <div class="sub-label"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.weapontype']"/></div>
	  <select id="subTp" name="subTp">
		<xsl:call-template name="itemSubtypeWeapons" />
	  </select>
	</div>

	<div class="sub-filters" id="weaponParentRequiredLevel"></div>

	<div class="sub-filters" id="weaponParentRarity"></div>

</div>	
	<div class="sub-filters" id="weaponParentAdvancedOptions"></div>

  </div><!-- end Weapons -->
  
  
  <div id="childGems">
	<div class="filter-left">
  <div class="sub-filters" id="gemParentUsableBy"></div>  	
	<div class="sub-filters">
	<div class="sub-label"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.gemtype']"/></div>
	<select id="subTp" name="subTp">
		<xsl:call-template name="itemSubtypeGems" />
	</select>
	</div>
	
  <div class="sub-filters">
	<div class="sub-label"><xsl:value-of select="$textRarity"/></div>
	<select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>	  
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	</select>
  </div>	
  

	
</div>
	<div id="gemParentAdvancedOptions"></div>
  </div>

  <div class="filter-container" id="childRecipes">
	<div class="option-cont"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.recipes']"/></div>
	<div class="input-cont"><select id="subTp" name="subTp">
		<xsl:call-template name="itemSubtypeRecipes" />
	</select> </div>

	<div class="option-cont"><xsl:value-of select="$textRarity"/></div>
	<div class="input-cont"><select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	</select> </div>   

  <div name="divErrorLevel" id="divErrorLevel"> 
	<div class="option-cont"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.requiredskilllevel']"/></div>
	<div class="input-cont"><input type="text" name="minSkill" id="minSkill" class="irange"/> - <input type="text" name="maxSkill" id="maxSkill" class="irange"/></div>   
  </div>
	
  </div>

  <div class="filter-container" id="childConsumablesNoPoor">
	<div class="option-cont"><xsl:value-of select="$textRarity"/></div>
	<div class="input-cont"><select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	</select> </div>   	
  </div>  
  
  <div class="filter-container" id="childMiscRarity">
	<div class="option-cont"><xsl:value-of select="$textRarity"/></div>
	<div class="input-cont"><select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	  <option id="rrtec" name="rrtec" value="lg"><xsl:value-of select="$textLegendary"/></option>
      <option id="rrthm" name="rrthm" value="hm"><xsl:value-of select="$textHeirloom"/></option>	  
	</select> </div>   	
  </div>    
  
  
  <div id="childRarity">
	<div id="childRarityClass" class="sub-label-top"><xsl:value-of select="$textRarity"/></div>
	<select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtpr" name="rrtpr" value="pr"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.poor']"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	  <option id="rrtlg" name="rrtlg" value="lg"><xsl:value-of select="$textLegendary"/></option>
      <option id="rrthm" name="rrthm" value="hm"><xsl:value-of select="$textHeirloom"/></option>
	</select>
  </div>


  <div id="childRequiredLevel">
  <div name="divErrorLevel" id="divErrorLevel">   
	<div class="sub-label" id="textLevelRange"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.requiredlevel']"/></div>
	<input class="irange" name="rqrMin" id="rqrMin" type="text" value="" maxlength="2" size="10"/> - <input name="rqrMax" class="irange" id="rqrMax" type="text" size="2" value="" maxlength="2"/>
  </div>
  </div>

  <div id="childUsableBy">
	<div class="sub-label" style="font-size: 12px; color:#003333;"> <img src="images/icons/icon-question.gif" border="0" onMouseOver="setTipText('{$loc/strs/items/str[@id='armory.items.hover.desiredby']}');" class="desiredHelp staticTip" /> <xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.usableby']"/></div>
	<select id="usbleBy" name="usbleBy" onChange="javascript: changeusbleBy(this.value)" onKeyUp="javascript: changeusbleBy(this.value)">
	  <option id="usbleByall" name="usbleByall" value="all"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.allclasses']"/></option>
	  <option id="usbleBy1" name="usbleBy1" value="1"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.1']" /></option>
	  <option id="usbleBy2" name="usbleBy2" value="2"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.2']" /></option>
	  <option id="usbleBy3" name="usbleBy3" value="3"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.3']" /></option>
	  <option id="usbleBy4" name="usbleBy4" value="4"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.4']" /></option>
	  <option id="usbleBy5" name="usbleBy5" value="5"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.5']" /></option>
	  <option id="usbleBy6" name="usbleBy6" value="6"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.6']" /></option>
	  <option id="usbleBy7" name="usbleBy7" value="7"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.7']" /></option>
	  <option id="usbleBy8" name="usbleBy8" value="8"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.8']" /></option>
	  <option id="usbleBy9" name="usbleBy9" value="9"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.9']" /></option>
	  <option id="usbleBy11" name="usbleBy11" value="11"><xsl:value-of select="$loc/strs/classes/str[@id='armory.classes.class.11']" /></option>
	</select>
	<div id="parentUsableBySpecific"></div>
  </div>
  
  <div id="childAdvancedOptions">
    <div class="filter-right">
	  <div class="a-option"><div id="replaceAdvancedOptions"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.advancedfilters']"/></div></div>
      <div class="advanced-cont">	
	    <div id="parentAdvancedFilters"></div>
      <div id="idAndOr" style="display: none;"><input class="irange" type="radio" id="andor" name="andor" value="and" checked="checked" style="float: left" /><div style="float: left " onMouseOver="setTipText('{$loc/strs/itemsOptions/str[@id='armory.item-search.matchalltip']}')" class="staticTip"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.matchall']"/></div><input class="irange" type="radio" id="andor" name="andor" value="or" style="float: left; margin-left: 20px;" /><div style="float: left;" class="staticTip" onMouseOver="setTipText('{$loc/strs/itemsOptions/str[@id='armory.item-search.matchonetip']}')"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.matchone']"/></div><br /></div>		
      </div>
      <div id="parentAdvancedButtons">
      <div id="idAddFilterWeapon"><a class="add-filter" href="javascript: addAdvOpt();"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.addfilter']"/></a></div>
  
	    <div id="parentPredefinedFilter">
<!--		<div id="childPredefinedGeneric" onMouseOver="document.getElementById('hiddenPredefinedGeneric').style.display='block';  document.getElementById('allClassArrow').style.visibility='visible'; document.getElementById('allClassMessage').style.display='block'; document.getElementById('usbleBy').className='usableByWhite';" onMouseOut="document.getElementById('hiddenPredefinedGeneric').style.display='none'; document.getElementById('allClassArrow').style.visibility='hidden'; document.getElementById('allClassMessage').style.display='none'; document.getElementById('usbleBy').className='';">-->
		<div id="childPredefinedGeneric" onMouseOver="document.getElementById('hiddenPredefinedGeneric').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedGeneric').style.display='none';">
          <a class="button-lite" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
		  <div class="drop-lang" id="hiddenPredefinedGeneric" style="display: none; ">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>
                      <li><u><xsl:value-of select="$textPvE"/></u></li>
                      <li><a href="javascript: roleTank();"><xsl:value-of select="$loc/strs/classes/role/str[@id='armory.item-search.tank']"/></a></li>
	                  <li><a href="javascript: roleMeleeDps();"><xsl:value-of select="$textPhysicalDps"/></a></li>
	                  <li><a href="javascript: roleCasterDps();"><xsl:value-of select="$textCasterDps"/></a></li>
	                  <li><a href="javascript: roleHealer();"><xsl:value-of select="$textRoleHealer"/></a></li>
		            </ul>
		            <ul>
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
	                  <li><a href="javascript: roleMeleeDpsPvP();"><xsl:value-of select="$textPhysicalDps"/></a></li>
	                  <li><a href="javascript: roleCasterDpsPvP();"><xsl:value-of select="$textCasterDps"/></a></li>
	                  <li><a href="javascript: roleHealerPvP();"><xsl:value-of select="$textRoleHealer"/></a></li>
		            </ul>					
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  
          </div><!-- end childPredefinedGeneric-->
		  </div>
	    </div><!-- end parentPredefinedFilter-->
      </div><!-- end parentAdvancedButtons -->
    </div>
  </div><!-- end childAdvancedOptions -->


  <div id="childSlotEnchT">
	<div class="filter-left">

  <div class="sub-filters">
	<div class="sub-label"><xsl:value-of select="$textRarity"/></div>
	<select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>	  
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	</select>
  </div>	
	
  </div>
</div>

  <div id="childSlotEnchP">
	<div class="filter-left">
	
	<div class="sub-filters">
	<div class="sub-label"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.slot']"/></div>
	<select id="slot" name="slot">
	  <option id="slotall" name="slotall" value="all"><xsl:value-of select="$textAllSlots"/></option>
	  <option id="slothead" name="slothead" value="head"><xsl:value-of select="$textHead"/></option>
	  <option id="slotshoulders" name="slotshoulders" value="shoulders"><xsl:value-of select="$textShoulders"/></option>
	  <option id="slotchest" name="slotchest" value="chest"><xsl:value-of select="$textChest"/></option>
	  <option id="slothands" name="slothands" value="hands"><xsl:value-of select="$textHands"/></option>
	  <option id="slotlegs" name="slotlegs" value="legs"><xsl:value-of select="$textLegs"/></option>
	  <option id="slotfeet" name="slotfeet" value="feet"><xsl:value-of select="$textFeet"/></option>
	  <option id="slotweapon" name="slotweapon" value="weapon"><xsl:value-of select="$loc/strs/items/slots/str[@id='weapon']"/></option>	  
	  <option id="slotshield" name="slotshield" value="shield"><xsl:value-of select="$textShield"/></option>
    </select>
	
  <div class="sub-filters">
	<div class="sub-label"><xsl:value-of select="$textRarity"/></div>
	<select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>	  
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	</select>
  </div>	
	
  </div>
  </div>
</div>

  <div id="childSlotAll">
	<div class="sub-label"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.slot']"/></div>
	<select id="slot" name="slot">
	  <option id="slotall" name="slotall" value="all"><xsl:value-of select="$textAllSlots"/></option>
	  <optgroup label="{$loc/strs/items/slots/str[@id='armor']}">		  
	  <option id="slothead" name="slothead" value="head"><xsl:value-of select="$textHead"/></option>
	  <option id="slotneck" name="slotneck" value="neck"><xsl:value-of select="$textNeck"/></option>
	  <option id="slotshoulders" name="slotshoulders" value="shoulders"><xsl:value-of select="$textShoulders"/></option>
  	  <option id="slotback" name="slotback" value="back"><xsl:value-of select="$textBack"/></option>
	  <option id="slotchest" name="slotchest" value="chest"><xsl:value-of select="$textChest"/></option>
	  <option id="slotshirt" name="slotshirt" value="shirt"><xsl:value-of select="$textShirt"/></option>
	  <option id="slotwrists" name="slotwrists" value="wrists"><xsl:value-of select="$textWrists"/></option>
	  <option id="slothands" name="slothands" value="hands"><xsl:value-of select="$textHands"/></option>
	  <option id="slotwaist" name="slotwaist" value="waist"><xsl:value-of select="$textWaist"/></option>
	  <option id="slotlegs" name="slotlegs" value="legs"><xsl:value-of select="$textLegs"/></option>
	  <option id="slotfeet" name="slotfeet" value="feet"><xsl:value-of select="$textFeet"/></option>
	  <option id="slotfinger" name="slotfinger" value="finger"><xsl:value-of select="$textFinger"/></option>
	  <option id="slottrinket" name="slottrinket" value="trinket"><xsl:value-of select="$textTrinket"/></option>
      <option id="slotoffhand" name="slotoffhand" value="offhand"><xsl:value-of select="$textOffHand"/></option>
	  </optgroup> 
	  <optgroup label="{$loc/strs/itemsOptions/str[@id='armory.item-search.complex.weapons']}">
      <option id="slotmain" name="slotmain" value="main"><xsl:value-of select="$loc/strs/items/slots/str[@id='main']"/></option>
      <option id="slotoff" name="slotoff" value="off"><xsl:value-of select="$loc/strs/items/slots/str[@id='off']"/></option>
      <option id="slotone" name="slotone" value="one"><xsl:value-of select="$loc/strs/items/slots/str[@id='both']"/></option>	
      <option id="slottwo" name="slottwo" value="two"><xsl:value-of select="$loc/strs/items/slots/str[@id='two']"/></option>		
      <option id="slotranged" name="slotranged" value="ranged"><xsl:value-of select="$loc/strs/items/slots/str[@id='ranged']"/></option>
	  </optgroup>
	  
    </select>
  </div>

  <div id="childSlot">
	<div class="sub-label"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.slot']"/></div>
	<select id="slot" name="slot">
	  <option id="slotall" name="slotall" value="all"><xsl:value-of select="$textAllSlots"/></option>
	  <option id="slothead" name="slothead" value="head"><xsl:value-of select="$textHead"/></option>
	  <option id="slotneck" name="slotneck" value="neck"><xsl:value-of select="$textNeck"/></option>
	  <option id="slotshoulders" name="slotshoulders" value="shoulders"><xsl:value-of select="$textShoulders"/></option>
  	  <option id="slotback" name="slotback" value="back"><xsl:value-of select="$textBack"/></option>
	  <option id="slotchest" name="slotchest" value="chest"><xsl:value-of select="$textChest"/></option>
	  <option id="slotshirt" name="slotshirt" value="shirt"><xsl:value-of select="$textShirt"/></option>
	  <option id="slotwrists" name="slotwrists" value="wrists"><xsl:value-of select="$textWrists"/></option>
	  <option id="slothands" name="slothands" value="hands"><xsl:value-of select="$textHands"/></option>
	  <option id="slotwaist" name="slotwaist" value="waist"><xsl:value-of select="$textWaist"/></option>
	  <option id="slotlegs" name="slotlegs" value="legs"><xsl:value-of select="$textLegs"/></option>
	  <option id="slotfeet" name="slotfeet" value="feet"><xsl:value-of select="$textFeet"/></option>
	  <option id="slotfinger" name="slotfinger" value="finger"><xsl:value-of select="$textFinger"/></option>
	  <option id="slottrinket" name="slottrinket" value="trinket"><xsl:value-of select="$textTrinket"/></option>
      <option id="slotoffhand" name="slotoffhand" value="offhand"><xsl:value-of select="$textOffHand"/></option>
    </select>
  </div>

  <div id="childEnchP">
    <div id="childEnchP">
	  <div id="enchPParentSlot"></div>
	  <div id="enchPParentAdvancedOptions"></div>	  
	</div>
  </div>

  <div id="childEnchT">
    <div id="childEnchT">
	  <div id="enchTParentSlot"></div>
	  <div id="enchTParentAdvancedOptions"></div>	  
	</div>
  </div>

  <div id="childArmor"><!-- begin Armor -->
    
	<div class="filter-left">


	<div class="sub-filters" id="armorParentUsableBy"></div>
	<div class="sub-filters" id="armorParentSlot"></div>
<!--	<div id="armorParentRelics"></div>-->

<!--	<div class="sub-filters" id="armorParentItemLevel"></div>-->
	<div class="sub-filters">
	  <div class="sub-label"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.armortype']"/></div>
	  <select id="subTp" name="subTp">
		<xsl:call-template name="itemSubtypeArmor" />
	  </select>
	</div>	

	<div class="sub-filters" id="armorParentRequiredLevel"></div>

	<div class="sub-filters" id="armorParentRarity"></div>
	
</div>
	<div class="sub-filters" id="armorParentAdvancedOptions"></div>
	
  </div><!-- end Armor -->

<!-- class Roles Begin -->

  
  <!--Druid-->
  <div id="childPredefinedDruid">
  <div onMouseOver="document.getElementById('hiddenPredefinedDruid').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedDruid').style.display='none';">
    <a class="button-lite" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class11"></div>-->
	  <div id="hiddenPredefinedDruid" style="display: none; " class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>
	                  <li><u><xsl:value-of select="$textPvE"/></u></li>
	                  <li><a href="javascript: roleTankDruid();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.tank']"/></a></li>
	                  <li><a href="javascript: roleMeleeDpsDruid();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.melee']"/></a></li>
	                  <li><a href="javascript: roleCasterDpsDruid();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.caster']"/></a></li>
	                  <li><a href="javascript: roleHealerDruid();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.healer']"/></a></li>
                    </ul>
	                <ul>
		              <li><u><xsl:value-of select="$textPvP"/></u></li>
	                  <li><a href="javascript: roleMeleeDpsDruidPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.melee']"/></a></li>
	                  <li><a href="javascript: roleCasterDpsDruidPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.caster']"/></a></li>
	                  <li><a href="javascript: roleHealerDruidPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.druid.healer']"/></a></li>
                    </ul>	   
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
		 </div>
       </div>
    </div>
  </div><!-- end childPredefinedDruid-->

  <!--Hunter-->
  <div id="childPredefinedHunter" onMouseOver="document.getElementById('hiddenPredefinedHunter').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedHunter').style.display='none';">
    <a class="button-lite" id="childPredefinedHunter" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class3"></div>-->
	<div id="hiddenPredefinedHunter" style="display: none; " class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>
                      <li><a href="javascript: roleRangedDpsHunter();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.hunter.ranged']"/></a></li>
                    </ul>
					<ul>
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleRangedDpsHunterPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.hunter.ranged']"/></a></li>
                    </ul>	   
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
        </div>
     </div>
  </div><!-- end childPredefinedHunter-->

  <!--Mage-->
  <div id="childPredefinedMage" onMouseOver="document.getElementById('hiddenPredefinedMage').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedMage').style.display='none';">
    <a class="button-lite" id="childPredefinedMage" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class8"></div>-->
	<div id="hiddenPredefinedMage" style="display: none;" class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>
                      <li><a href="javascript: roleCasterDpsMage();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.mage.caster']"/></a></li>
					</ul>
					<ul>
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleCasterDpsMagePvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.mage.caster']"/></a></li>
                    </ul>	   
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  
     </div>
  </div><!-- end childPredefinedMage-->

  <!--Paladin-->
  <div id="childPredefinedPaladin" onMouseOver="document.getElementById('hiddenPredefinedPaladin').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedPaladin').style.display='none';">
    <a class="button-lite" id="childPredefinedPaladin" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class2"></div>-->
	<div id="hiddenPredefinedPaladin" style="display: none; " class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>	
                      <li><a href="javascript: roleTankPaladin();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.tank']"/></a></li>
                      <li><a href="javascript: roleMeleeDpsPaladin();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.melee']"/></a></li>
                      <li><a href="javascript: roleCasterDpsPaladin();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.caster']"/></a></li>
                      <li><a href="javascript: roleHealerPaladin();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.healer']"/></a></li>
					</ul>
					<ul>
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleMeleeDpsPaladinPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.melee']"/></a></li>
                      <li><a href="javascript: roleCasterDpsPaladinPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.caster']"/></a></li>
                      <li><a href="javascript: roleHealerPaladinPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.paladin.healer']"/></a></li>
                    </ul>	   
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  
     </div>
  </div><!-- end childPredefinedPaladin-->

  <!--Priest-->
  <div id="childPredefinedPriest" onMouseOver="document.getElementById('hiddenPredefinedPriest').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedPriest').style.display='none';">
    <a class="button-lite" id="childPredefinedPriest" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class5"></div>-->
	<div id="hiddenPredefinedPriest" style="display: none;" class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>
                      <li><u><xsl:value-of select="$textPvE"/></u></li>
                      <li><a href="javascript: roleCasterDpsPriest();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.priest.caster']"/></a></li>
                      <li><a href="javascript: roleHealerPriest();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.priest.healer']"/></a></li>
                    </ul>
                    <ul>
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleCasterDpsPriestPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.priest.caster']"/></a></li>
                      <li><a href="javascript: roleHealerPriestPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.priest.healer']"/></a></li>
                    </ul>					
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  	  
     </div>
  </div><!-- end childPredefinedPriest-->
  
  <!--Rogue-->
  <div id="childPredefinedRogue" onMouseOver="document.getElementById('hiddenPredefinedRogue').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedRogue').style.display='none';">
    <a class="button-lite" id="childPredefinedRogue" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class4"></div>-->
	<div id="hiddenPredefinedRogue" style="display: none;" class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>
                      <li><a href="javascript: roleMeleeDpsRogue();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.rogue.melee']"/></a></li>
                    </ul>
                    <ul>					
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleMeleeDpsRoguePvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.rogue.melee']"/></a></li>
                    </ul>					
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>		  					  
     </div>
  </div><!-- end childPredefinedRogue-->
  
  <!--Shaman-->
  <div id="childPredefinedShaman" onMouseOver="document.getElementById('hiddenPredefinedShaman').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedShaman').style.display='none';">
    <a class="button-lite" id="childPredefinedShaman" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class7"></div>-->
	<div id="hiddenPredefinedShaman" style="display: none;" class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>
                      <li><a href="javascript: roleMeleeDpsShaman();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.shaman.melee']"/></a></li>
                      <li><a href="javascript: roleCasterDpsShaman();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.shaman.caster']"/></a></li>
                      <li><a href="javascript: roleHealerShaman();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.shaman.healer']"/></a></li>
					</ul>
                    <ul>
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleMeleeDpsShamanPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.shaman.melee']"/></a></li>
                      <li><a href="javascript: roleCasterDpsShamanPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.shaman.caster']"/></a></li>
                      <li><a href="javascript: roleHealerShamanPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.shaman.healer']"/></a></li>
                    </ul>					
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  		
     </div>
  </div><!-- end childPredefinedShaman-->


  <!--Warlock-->
  <div id="childPredefinedWarlock" onMouseOver="document.getElementById('hiddenPredefinedWarlock').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedWarlock').style.display='none';">
    <a class="button-lite" id="childPredefinedWarlock" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class9"></div>-->
	<div id="hiddenPredefinedWarlock" style="display: none;" class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>	
                      <li><a href="javascript: roleCasterDpsWarlock();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.warlock.caster']"/></a></li>
                    </ul>
                    <ul>					
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleCasterDpsWarlockPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.warlock.caster']"/></a></li>
                    </ul>					  
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  						  					  												
     </div>
  </div><!-- end childPredefinedWarlock-->      

  <!--Warrior-->
  <div id="childPredefinedWarrior" onMouseOver="document.getElementById('hiddenPredefinedWarrior').style.display='block';" onMouseOut="document.getElementById('hiddenPredefinedWarrior').style.display='none';">
    <a class="button-lite" id="childPredefinedWarrior" href="javascript: ;"><xsl:value-of select="$textPredefinedFilters"/></a>
	<!--<div class="item-class-icon class1"></div>-->
	<div id="hiddenPredefinedWarrior" style="display: none;" class="drop-lang">
            <div class="light-tip">
              <table>
	            <tr>
		          <td class="tl"></td><td class="t"></td><td class="tr"></td>
	            </tr>
	            <tr>
		          <td class="l"><q></q></td><td class="bg">
		            <ul>	
                      <li><u><xsl:value-of select="$textPvE"/></u></li>	
                      <li><a href="javascript: roleTankWarrior();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.warrior.tank']"/></a></li>
                      <li><a href="javascript: roleMeleeDpsWarrior();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.warrior.melee']"/></a></li>
                    </ul>
                    <ul>					
                      <li><u><xsl:value-of select="$textPvP"/></u></li>
                      <li><a href="javascript: roleMeleeDpsWarriorPvP();"><xsl:value-of select="$loc/strs/itemsPredefined/str[@id='armory.predefined.warrior.melee']"/></a></li>		
                    </ul>					  
                  </td><td class="r"><q></q></td>
	            </tr>
	            <tr>
		          <td class="bl"></td><td class="b"></td><td class="br"></td>
	            </tr> 
              </table>
            </div>  											  
     </div>
  </div><!-- end childPredefinedWarrior-->

  <!-- end class Roles -->


  <!-- Containers -->
  <div class="filter-container" id="childContainers">
    <div class="option-cont"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.bagtype']"/></div>
	<div class="input-cont"><select id="subTp" name="subTp">
    <option id="subTpall" name="subTpall" value="all"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.allbags']"/></option>
    <option id="subTpbag" name="subTpbag" value="bag"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.bag']"/></option>
    <option id="subTpsoul" name="subTpsoul" value="soul"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.soul']"/></option>
    <option id="subTpherb" name="subTpherb" value="herb"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.herb']"/></option>
    <option id="subTpenchanting" name="subTpenchanting" value="enchanting"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.enchanting']"/></option>
    <option id="subTpengineering" name="subTpengineering" value="engineering"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.engineering']"/></option>
    <option id="subTpgem" name="subTpgem" value="gem"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.gem']"/></option>
    <option id="subTpinscription" name="subTpinscription" value="inscription"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.inscription']"/></option>
    <option id="subTpleatherworking" name="subTpleatherworking" value="leatherworking"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.leatherworking']"/></option>
    <option id="subTpmining" name="subTpmining" value="mining"><xsl:value-of select="$loc/strs/items/bags/str[@id='armory.item-search.bags.mining']"/></option>
    </select></div>
  </div>
  <!-- End Containers -->

  <!-- Projectiles -->
  <div class="filter-container" id="childProjectiles">
    <div class="option-cont"><xsl:value-of select="$loc/strs/items/projectileTypes/str[@id='armory.item-search.projectiles.type']"/></div>
	<div class="input-cont"><select id="projectiles" name="subTp">
    <option name="subTpall" id="subTpall" value="all"><xsl:value-of select="$loc/strs/items/projectileTypes/str[@id='armory.item-search.projectiles.all']"/></option>
    <option id="subTparrow" name="subTparrow" value="arrow"><xsl:value-of select="$loc/strs/items/projectileTypes/str[@id='armory.item-search.projectiles.arrow']"/></option>
    <option name="subTpbullet" id="subTpbullet" value="bullet"><xsl:value-of select="$loc/strs/items/projectileTypes/str[@id='armory.item-search.projectiles.bullet']"/></option>
    </select></div>

	<div class="option-cont"><xsl:value-of select="$textRarity"/></div>
	<div class="input-cont"><select id="rrt" name="rrt">
	  <option id="rrtall" name="rrtall" value="all"><xsl:value-of select="$textAll"/></option>
	  <option id="rrtcn" name="rrtcn" value="cn"><xsl:value-of select="$textCommon"/></option>
	  <option id="rrtun" name="rrtun" value="un"><xsl:value-of select="$textUncommon"/></option>
	  <option id="rrtre" name="rrtre" value="re"><xsl:value-of select="$textRare"/></option>
	  <option id="rrtec" name="rrtec" value="ec"><xsl:value-of select="$textEpic"/></option>
	  <option id="rrtec" name="rrtec" value="lg"><xsl:value-of select="$textLegendary"/></option>
	</select></div>
	
  </div>
  <!-- Projectiles End -->

  <!-- Quivers -->
  <div class="filter-container" id="childQuivers">
   <div class="option-cont"><xsl:value-of select="$loc/strs/items/quiverTypes/str[@id='armory.item-search.quiver.type']"/></div>
	<div class="input-cont"><select id="quivers" name="subTp">
    <option id="subTall" name="subTall" value="all"><xsl:value-of select="$loc/strs/items/quiverTypes/str[@id='armory.item-search.quiver.all']"/></option>
    <option id="subTquiver" name="subTquiver" value="quiver"><xsl:value-of select="$loc/strs/items/quiverTypes/str[@id='armory.item-search.quiver.quiver']"/></option>
    <option id="subTammopouch" name="subTammopouch" value="ammopouch"><xsl:value-of select="$loc/strs/items/quiverTypes/str[@id='armory.item-search.quiver.ammo']"/></option>
    </select></div>
  </div>

  <!-- Difficulty -->
  <div class="filter-container" id="childHeroic">
   <div class="option-cont"><xsl:value-of select="$loc/strs/dungeons/str[@id='difficulty.title']"/></div>
	<div class="input-cont"><select id="difficulty" name="difficulty">
    <option id="difficultyall" name="difficultyall" value="all"><xsl:value-of select="$loc/strs/dungeons/str[@id='difficulty.all']"/></option>	
    <option id="difficultynormal" name="difficultynormal" value="normal"><xsl:value-of select="$loc/strs/dungeons/str[@id='difficulty.normalonly']"/></option>
    <option id="difficultyheroic" name="difficultyheroic" value="heroic"><xsl:value-of select="$loc/strs/dungeons/str[@id='difficulty.heroiconly']"/></option>
    </select></div>
  </div>
  <!-- Difficulty -->
</form>

<script type="text/javascript" src="_js/items/functions.js"></script>

<script type="text/javascript">
	
	var theCounter = 0;
	var currentAdvOpt = "";  

	$(document).ready(function(){

		theCurrentForm="default";
	
		cloneDelete('childItemName', 'parentItemName');
		cloneDelete('childItemType', 'parentItemType');
		cloneDelete('childSource', 'parentSource');  
	  
		document.getElementById('parentAdvancedFilters').appendChild(document.getElementById('childAdvOptionsWeapon'));		
	
		var advOptArray = new Array;
	
		<xsl:for-each select="searchResults/filters/filter">
			<xsl:choose>
				<xsl:when test="string-length(@count)=0">
			
					var filterName="<xsl:value-of select="@name" />";
					var filterValue="<xsl:value-of select="@value" />";
	
	
					if(!(filterName == "selSubTp") &amp;&amp; !(filterName == "selSlot") &amp;&amp; !(filterName == "selType")){
					
						var formElement=document.getElementsByName( filterName )[0];
						
						if (formElement.nodeName == "INPUT" &amp;&amp; filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.change<xsl:value-of select="@name" />)
								change<xsl:value-of select="@name" />(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
				</xsl:when>
				<xsl:otherwise>	
					advOptArray[<xsl:value-of select="@count" /> - 1]="<xsl:value-of select="@value" />";	
				</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
	
	
		for (y=0; y &lt; advOptArray.length; y++) {
			theString = advOptArray[y];
			theString = theString.split("_");
			addPredefinedAdvOpt(theString[0], theString);
		}
	
		
		theCounter = 0;
		searchText = "black"
		document.getElementById('searchQuery').value="<xsl:value-of select="searchResults/@searchString" />";
	
	
		//on enter make it submit the form
		$("#formItem").keypress(function(e){
			//submit form
			if(e.which == 13){
				$("#formItem")[0].submit();
			}
		});

	});

</script>



</xsl:template>

</xsl:stylesheet>