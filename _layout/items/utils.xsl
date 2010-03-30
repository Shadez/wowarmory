<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template name="printInventoryType">
    <xsl:param name="type" />
    <xsl:param name="thesubtype" />
    <span class='tooltipRight' style="display: inline;"><xsl:value-of select='$thesubtype' /></span>
    <xsl:choose>
        <xsl:when test="$type = 0"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.non-equip']"/></xsl:when>
        <xsl:when test="$type = 1"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.head']"/></xsl:when>
        <xsl:when test="$type = 2"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.neck']"/></xsl:when>
        <xsl:when test="$type = 3"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.shoulders']"/></xsl:when>
        <xsl:when test="$type = 4"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.shirt']"/></xsl:when>
        <xsl:when test="$type = 5"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.chest']"/></xsl:when>
        <xsl:when test="$type = 6"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.waist']"/></xsl:when>
        <xsl:when test="$type = 7"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.legs']"/></xsl:when>
        <xsl:when test="$type = 8"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.feet']"/></xsl:when>
        <xsl:when test="$type = 9"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.wrist']"/></xsl:when>
        <xsl:when test="$type = 10"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.hand']"/></xsl:when>
        <xsl:when test="$type = 11"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.finger']"/></xsl:when>
        <xsl:when test="$type = 12"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.trinket']"/></xsl:when>
        <xsl:when test="$type = 13"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.one-hand']"/></xsl:when>
        <xsl:when test="$type = 14"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.offHand']"/></xsl:when>
        <xsl:when test="$type = 15"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.ranged']"/></xsl:when>
        <xsl:when test="$type = 16"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.back']"/></xsl:when>
        <xsl:when test="$type = 17"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.two-hand']"/></xsl:when>
        <xsl:when test="$type = 18"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.bag-type']"/></xsl:when>
        <xsl:when test="$type = 19"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.tabard']"/></xsl:when>
        <xsl:when test="$type = 20"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.chest']"/></xsl:when>
        <xsl:when test="$type = 21"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.mainHand']"/></xsl:when>
        <xsl:when test="$type = 22"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.offHand']"/></xsl:when>
        <xsl:when test="$type = 23"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.held-off-hand']"/></xsl:when>
        <xsl:when test="$type = 24"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.projectile']"/></xsl:when>
        <xsl:when test="$type = 25"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.thrown']"/></xsl:when>
        <xsl:when test="$type = 26"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.ranged']"/></xsl:when>
        <xsl:when test="$type = 27"><xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.quiver-type']"/></xsl:when>
        <xsl:when test="$type = 28"><xsl:value-of select="$loc/strs/itemSlot/str[@id='armory.itemslot.slot.relic']"/></xsl:when>
    </xsl:choose>
    
</xsl:template>
</xsl:stylesheet>