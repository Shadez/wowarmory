<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:include href="achievements-async.xsl"/>

<xsl:template match="statistic|c" mode="statistic-quantity">
	<xsl:choose>
	    <xsl:when test="@quantityGold|@quantitySilver|@quantityCopper">
		    <xsl:if test="@quantityGold">
		    	<xsl:value-of select="@quantityGold"/><img class="p" src="images/icons/money-gold-small.png" alt=""/>
		    	<xsl:text> </xsl:text>
		    </xsl:if>
	    	<xsl:if test="@quantitySilver">
	    		<xsl:value-of select="@quantitySilver"/><img class="p" src="images/icons/money-silver-small.png" alt=""/>
	    		<xsl:text> </xsl:text>
	    	</xsl:if>
	    	<xsl:if test="@quantityCopper">
	    		<xsl:value-of select="@quantityCopper"/><img class="p" src="images/icons/money-copper-small.png" alt=""/>
	    	</xsl:if>
		</xsl:when>
   		<xsl:when test="@highest">
   			<xsl:value-of select="concat(@highest, ' (', @quantity, ')')"/>
   		</xsl:when>
   		<xsl:otherwise>
   			<xsl:text> </xsl:text><xsl:value-of select="@quantity"/>
   		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template match="/category">
	<table> <!-- root placeholder node -->
		<xsl:apply-templates select="." mode="compare"/>
	</table>
</xsl:template>


<xsl:template match="statistic" mode="ach">
    	<div>
        <xsl:attribute name="class">stat_row <xsl:if test="not(position() mod 2)">zebra</xsl:if></xsl:attribute>
        <div style="float:right">
			<xsl:apply-templates select="." mode="statistic-quantity"/>
		</div>
            <xsl:value-of select="@name"/>
        </div>
</xsl:template>


<xsl:template match="/category[count(descendant-or-self::category/statistic/c) = 0]">
	<div> <!-- root placeholder node -->
		<xsl:apply-templates select="." mode="root"/>
	</div>
</xsl:template>

<xsl:template match="statistic" mode="compare-ach">
	<tr>
    <xsl:attribute name="class">stat_row <xsl:if test="not(position() mod 2)">zebra</xsl:if></xsl:attribute>
		<td width="100%">
			<xsl:value-of select="@name"/>
		</td>
		<xsl:for-each select="c">
			<td>
            <xsl:if test="position() != last()"><xsl:attribute name="class">row_b</xsl:attribute></xsl:if>
            <div>
                <xsl:attribute name="class">c_stat stat_val</xsl:attribute>
                <xsl:apply-templates select="." mode="statistic-quantity"/>
            </div>
			</td>
		</xsl:for-each>
	</tr>
</xsl:template>

<xsl:template match="category" mode="root">
	<div>
		<div class="cat_header">
			<xsl:value-of select="@name"/>
		</div>
		<xsl:apply-templates select="statistic" mode="ach"/>
	</div>
	<xsl:apply-templates select="category" mode="root"/>
</xsl:template>

<xsl:template match="category" mode="compare">
	<tbody class="summary">
		<tr>
			<td class="cat_header" colspan="{count(statistic[1]/c) + 1}">
				<xsl:value-of select="@name"/>
			</td>
		</tr>
		<xsl:apply-templates select="statistic" mode="compare-ach"/>
	</tbody>
	<xsl:apply-templates select="category" mode="compare"/>
</xsl:template>

</xsl:stylesheet>
