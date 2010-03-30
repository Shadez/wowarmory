<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="achievements.xsl"/>
<xsl:import href="statistics-async.xsl"/>

<xsl:variable name="achievementPageType">statistics</xsl:variable>

<xsl:template match="summary" mode="ach">
	<div class="summary">
		<div class="cat_header">
			<xsl:value-of select="$loc/strs/achievements/str[@id='stats.latest']"/>
       </div>
		<xsl:apply-templates select="statistic" mode="ach"/>
	</div>
	<div class="loading" style="display:none">
		<xsl:value-of select="$loc/strs/common/str[@id='loading']"/>
	</div>
</xsl:template>

<xsl:template match="statistics" mode="compare-summary">
	<tr class="summary_row1">
		<td class="cat_header" colspan="{count(summary/statistic[1]/c) + 1}">
			<xsl:apply-templates select="$loc/strs/achievements/str[@id='stats.latest.compare']" mode="printf">
				<xsl:with-param name="param1" select="../characterInfo/character/@name"/>
			</xsl:apply-templates>
		</td>
	</tr>
	<xsl:apply-templates select="summary/statistic" mode="compare-ach"/>
</xsl:template>

</xsl:stylesheet>
