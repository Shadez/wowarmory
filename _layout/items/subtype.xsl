<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">


<xsl:template name="itemTypeGuildBank">
  <xsl:param name="showmethemoney" select="0"/>
	<option value="all"><xsl:value-of select="$loc/strs/guildBank/str[@id='alltypes']" /></option>
	<option value="weapons"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.weapons']" /></option>
	<option value="armor"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.armor']" /></option>
	<option value="gems"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.gems']" /></option>
	<option value="containers"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.containers']" /></option>
	<option value="consumables"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.consumables']" /></option>
	<option value="tradegoods"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.tradegoods']" /></option>
	<option value="projectiles"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.projectiles']" /></option>
	<option value="quivers"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.quivers']" /></option>
	<option value="recipes"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.recipes']" /></option>
	<option value="reagents"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.reagents']" /></option>
	<option value="misc"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.miscellaneous']" /></option>
	<option value="enchantments"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.enchantments']" /></option>
	<option value="smallpets"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.smallpets']" /></option>
	
	<xsl:if test="$showmethemoney=1">
	  <option value="money">Money</option>
	</xsl:if>
</xsl:template>


<xsl:template name="itemSubtypeWeapons">
	    <option id="subTpall" name="subTpall" value="all"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.allweapontypes']"/></option>
        <option id="subTp1haxe" name="subTp1haxe" value="1haxe"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.oneaxes']"/></option>
        <option id="subTp2haxe" name="subTp2haxe" value="2haxe"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.twoaxes']"/></option>
        <option id="subTpbow" name="subTpbow" value="bow"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.bows']"/></option>
        <option id="subTpgun" name="subTpgun" value="gun"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.guns']"/></option>
        <option id="subTp1hmce" name="subTp1hmce" value="1hmce"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.onemaces']"/></option>
        <option id="subTp2hmce" name="subTp2hmce" value="2hmce"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.twomaces']"/></option>
        <option id="subTpplarm" name="subTpplarm" value="plarm"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.polearms']"/></option>
        <option id="subTp1hswd" name="subTp1hswd" value="1hswd"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.oneswords']"/></option>
        <option id="subTp2hswd" name="subTp2hswd" value="2hswd"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.twoswords']"/></option>
        <option id="subTpstv" name="subTpstv" value="stv"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.staves']"/></option>
        <option id="subTpfwpn" name="subTpfwpn" value="fwpn"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.fist']"/></option>
        <option id="subTpmisc" name="subTpmisc" value="misc"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.misc']"/></option>
        <option id="subTpdggr" name="subTpdggr" value="dggr"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.daggers']"/></option>
        <option id="subTpthrwn" name="subTpthrwn" value="thrwn"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.thrown']"/></option>
        <option id="subTpxbow" name="subTpxbow" value="xbow"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.crossbows']"/></option>
        <option id="subTpwnd" name="subTpwnd" value="wnd"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.wands']"/></option>
        <option id="subTpfshpl" name="subTpfshpl" value="fshpl"><xsl:value-of select="$loc/strs/items/weaponTypes/str[@id='armory.item-search.fishingpole']"/></option>
</xsl:template>


<xsl:template name="itemSubtypeArmor">
	    <option id="subTpall" name="subTpall" value="all"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.allarmortypes']"/></option>
	    <option id="subTpcloth" name="subTpcloth" value="cloth"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.cloth']"/></option>
	    <option id="subTpleather" name="subTpleather" value="leather"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.leather']"/></option>
	    <option id="subTpmail" name="subTpmail" value="mail"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.mail']"/></option>
	    <option id="subTpplate" name="subTpplate" value="plate"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.plate']"/></option>
	    <option id="subTpshield" name="subTpshield" value="shield"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.shield']"/></option>		
	    <option id="subTpidol" name="subTpidol" value="idol"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.idol']"/></option>		
	    <option id="subTplibram" name="subTplibram" value="libram"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.libram']"/></option>
	    <option id="subTptotem" name="subTptotem" value="totem"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.totem']"/></option>
        <option id="subTpsigil" name="subTpsigil" value="sigil"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.sigil']"/></option>				
	    <option id="subTpmiscellaneous" name="subTpmiscellaneous" value="miscellaneous"><xsl:value-of select="$loc/strs/items/armorType/str[@id='armory.item-search.armor.misc']"/></option>
</xsl:template>


<xsl:template name="itemSubtypeGems">
	  <option id="subTpall" name="subTpall" value="all"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.allgemtypes']"/></option>
	  <option id="subTpblue" name="subTpblue" value="blue"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.blue']"/></option>
	  <option id="subTpred" name="subTpred" value="red"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.red']"/></option>
	  <option id="subTpyellow" name="subTpyellow" value="yellow"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.yellow']"/></option>
	  <option id="subTpmeta" name="subTpmeta" value="meta"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.meta']"/></option>
	  <option id="subTpgreen" name="subTpgreen" value="green"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.green']"/></option>
	  <option id="subTporange" name="subTporange" value="orange"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.orange']"/></option>
	  <option id="subTppurple" name="subTppurple" value="purple"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.purple']"/></option>
	  <option id="subTpprismatic" name="subTpprismatic" value="prismatic"><xsl:value-of select="$loc/strs/items/gems/str[@id='armory.item-search.prismatic']"/></option>
</xsl:template>

<xsl:template name="itemSubtypeRecipes">
	  <option id="subTpall" name="subTpall" value="all"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.allrecipes']"/></option>
	  <option id="subTpbooks" name="subTpbooks" value="books"><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.books']"/></option>
	  <option id="subTpleatherworking" name="subTpleatherworking" value="leatherworking"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.leatherworking']"/></option>
	  <option id="subTptailoring" name="subTptailoring" value="tailoring"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.tailoring']"/></option>	  
	  <option id="subTpengineering" name="subTpengineering" value="engineering"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.engineering']"/></option>
	  <option id="subTpblacksmithing" name="subTpblacksmithing" value="blacksmithing"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.blacksmithing']"/></option>
	  <option id="subTpcooking" name="subTpcooking" value="cooking"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.cooking']"/></option>
	  <option id="subTpalchemy" name="subTpalchemy" value="alchemy"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.alchemy']"/></option>
	  <option id="subTpfirstaid" name="subTpfirstaid" value="firstaid"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.firstaid']"/></option>
	  <option id="subTpenchanting" name="subTpenchanting" value="enchanting"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.enchanting']"/></option>
	  <option id="subTpfishing" name="subTpfishing" value="fishing"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.fishing']"/></option>
	  <option id="subTpjewelcrafting" name="subTpjewelcrafting" value="jewelcrafting"><xsl:value-of select="$loc/strs/professions/str[@id='armory.item-search.jewelcrafting']"/></option>
</xsl:template>


</xsl:stylesheet>