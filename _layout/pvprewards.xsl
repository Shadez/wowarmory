<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:include href="includes.xsl"/>

<xsl:template match="pvprewards">

<div id="dataElement">
 <div class="parchment-top">
  <div class="parchment-content">
			
<div class="list">
<div class="full-list notab">
<div class="info-pane">
	<div class="profile-wrapper">
<div class="generic-wrapper"><div class="generic-right"><div class="genericHeader">
<div class="pvprewards-header"></div>
</div>
<div class="dungeon-container">
<div class="dungeon-header">
<table>
 <tr>
  <td width="280"><span><xsl:value-of select="$loc/strs/semicommon/str[@id='alliancerewards']"/></span></td>
  <td width = "5"></td>
  <td width="280"><span><xsl:value-of select="$loc/strs/semicommon/str[@id='horderewards']"/></span></td>
 </tr>
</table>
</div>
<div class="dungeon-content">
	<div class="pvprewards">
		<table>
		<xsl:for-each select="document('../_data/items/pvpa.xml')/pvpVendors/pvpVendor">
			<xsl:variable name="altId">
				<xsl:choose>
					<xsl:when test="position() mod 2 != 1">rc1</xsl:when>
					<xsl:otherwise>rc0</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>
			<xsl:variable name = "typeKey" select = "@key" />
			<tr class="expand-list">
				<td valign="top" class="{$altId}">	 
					<a href = "search.xml?source=pvpAlliance&amp;pvp={$typeKey}&amp;type=all&amp;searchType=items"><xsl:value-of select = "$loc/strs/pvpSource/str[@id=concat('armory.pvprewards.', $typeKey)]" /></a>
				</td> 
			</tr>
    </xsl:for-each>
		</table>

		<table>
		 <xsl:for-each select="document('../_data/items/pvph.xml')/pvpVendors/pvpVendor">
			<xsl:variable name="altId">
				<xsl:choose>
					<xsl:when test="position() mod 2 != 1">rc1</xsl:when>
					<xsl:otherwise>rc0</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>
			<xsl:variable name = "typeKey" select = "@key" />
			<tr class="expand-list">
				<td valign = "top" class="{$altId}">	 
					<a href = "search.xml?source=pvpHorde&amp;pvp={$typeKey}&amp;type=all&amp;searchType=items"><xsl:value-of select = "$loc/strs/pvpSource/str[@id=concat('armory.pvprewards.', $typeKey)]" /></a>
				</td> 
			</tr>
     </xsl:for-each>
		</table>
</div>
<div class="clear"><xsl:comment/></div>
</div>
</div>
  </div></div> <!--/generic Wrapper-->
</div><!--/end profile-wrapper/-->
</div>
</div><!--/end player-side/-->

</div><!--/end list/-->
 </div>
</div>

</div>


</xsl:template>

</xsl:stylesheet>
