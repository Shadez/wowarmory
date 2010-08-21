<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../language.xsl" />
<xsl:variable name="lang" select="/*/@lang" />
<xsl:variable name="base-icon">wow-icons/_images/</xsl:variable>

<!-- Shared -->

<xsl:template match="achievement" mode="icon">
	<div class="firsts_icon" style='background-image:url("{$base-icon}51x51/{@icon}.jpg")'><img class="p" src="images/achievements/fst_iconframe.png" /></div>
</xsl:template>

<xsl:template name="achievement-progress-bar">
	<xsl:param name="value"/>
	<xsl:param name="max"/>
    <xsl:param name="stype"/>
    <xsl:param name="text"/>
    <xsl:param name="tooltip"/>

	<div class="prog_bar">
    	<xsl:attribute name="class">prog_bar <xsl:if test="$stype"><xsl:value-of select="$stype"/></xsl:if></xsl:attribute>
        <xsl:if test="$tooltip">
            <xsl:attribute name="class">prog_bar staticTip <xsl:if test="$stype"><xsl:value-of select="$stype"/></xsl:if></xsl:attribute>
            <xsl:attribute name="onmouseover">setTipText('<xsl:value-of select="$tooltip"/>');</xsl:attribute>
        </xsl:if>
		<xsl:if test="$stype != 'blue'">
        	<div class="progress_cap">
        		<xsl:if test="$value = '0'">
        			<xsl:attribute name="style">background-position:bottom</xsl:attribute>
        		</xsl:if>
        		<xsl:comment/>
        	</div>
			<div class="progress_cap_r">
        		<xsl:if test="($value div $max * 100 &lt; 100) or (@quantityGold div @maxQuantityGold * 100 &lt; 100)">
        			<xsl:attribute name="style">background-position:bottom</xsl:attribute>
        		</xsl:if>
        		<xsl:comment/>
        	</div>
        </xsl:if>
		<div class="progress_int">
			<xsl:choose>
				<xsl:when test="@maxQuantityGold">
					<xsl:variable name="valueNormalized">
						<xsl:choose>
							<xsl:when test="@quantityGold &gt; @maxQuantityGold"><xsl:value-of select="@maxQuantityGold"/></xsl:when>
							<xsl:otherwise><xsl:value-of select="@quantityGold"/></xsl:otherwise>
						</xsl:choose>
					</xsl:variable>
				    <div style="width:{$valueNormalized div @maxQuantityGold * 100}%" class="progress_fill"><xsl:comment/></div>
				    <div class="prog_int_text">
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
				    		<xsl:otherwise>
				    			0<img class="p" src="images/icons/money-copper-small.png" alt=""/>
				    		</xsl:otherwise>
				    	</xsl:choose>
			    	</div>
				</xsl:when>
				<xsl:otherwise>
					<xsl:variable name="valueNormalized">
						<xsl:choose>
							<xsl:when test="$value &gt; $max"><xsl:value-of select="$max"/></xsl:when>
							<xsl:otherwise><xsl:value-of select="$value"/></xsl:otherwise>
						</xsl:choose>
					</xsl:variable>
					<div style="width:{$valueNormalized div $max * 100}%" class="progress_fill"><xsl:comment/></div>
					<div class="prog_int_text">
						<xsl:if test="$text">
							<xsl:value-of select="$loc/strs/achievements/str[@id=$text]"/><xsl:text> </xsl:text>
						</xsl:if>
		            	<xsl:value-of select="$value"/> / <xsl:value-of select="$max"/>
					</div>
				</xsl:otherwise>
			</xsl:choose>
		</div>
	</div>
</xsl:template>

<!-- Do not show for single character feats of strength -->
<xsl:template match="category[//achievement/@points|//achievement/c]" mode="progress-bar">
	<xsl:param name="index"/>
	<xsl:param name="type"/>

	<xsl:call-template name="achievement-progress-bar">
		<xsl:with-param name="value" select="count(achievement/@dateCompleted|achievement/c[$index]/@dateCompleted)"/>
		<!-- Faction-specific achievements have reciprocals, only marked when both are present -->
		<xsl:with-param name="max" select="count(achievement[not(@factionId) or @factionId = 0])"/>
        <xsl:with-param name="stype" select="$type"/>
	</xsl:call-template>
</xsl:template>

<!-- Single character -->

<xsl:template match="achievements[count(category/achievement/c) = 0]">
	<div> <!-- root placeholder node -->
		<xsl:apply-templates select="category" mode="root"/>
	</div>
</xsl:template>

<xsl:template match="category" mode="root">
	<div>
		<xsl:if test="count(parent::category)">
			<xsl:attribute name="style">display:none</xsl:attribute>
		</xsl:if>
		<div>
			<xsl:apply-templates select="." mode="progress-bar"/>
		</div>
		<xsl:apply-templates select="achievement" mode="ach"/>
	</div>
	<xsl:apply-templates select="category" mode="root"/>
</xsl:template>

<xsl:template match="achievement" mode="s_ach">
	<xsl:variable name="categoryIndex" select="count(../../rootCategories/category[@id = current()/@categoryId]/preceding-sibling::category) + 1"/>

	<div class="s_achievement" onclick="Armory.Achievements.openCategory('{@categoryId}', '{$categoryIndex}', '{@id}')">
	    <div class="s_ach_stat">
	        <xsl:if test="@points">
				<xsl:value-of select="@points"/><img src="images/achievements/tiny_shield.gif"/>
			</xsl:if>
	        <xsl:if test="@dateCompleted">
	        	(<xsl:apply-templates select="@dateCompleted" mode="format-date"/>)
	        </xsl:if>
	    </div>
		<span><xsl:value-of select="@title"/></span><span class="achv_desc"><xsl:value-of select="@desc"/></span>
	</div>
</xsl:template>

<xsl:template match="achievement" mode="ach">
	<div id="ach{@id}" class="achievement" onclick="Armory.Achievements.select(this, true)">
		<xsl:attribute name="class">achievement<xsl:if test="not(@dateCompleted)"> locked</xsl:if></xsl:attribute>
		<xsl:if test="@points">
			<div class="pointshield">
				<div><xsl:value-of select="@points"/></div>
			</div>
		</xsl:if>
		<xsl:apply-templates select="." mode="icon"/>
		<div class="achv_title"><xsl:value-of select="@title"/></div>
		<div class="achv_desc"><xsl:value-of select="@desc"/></div>
        <xsl:if test="@dateCompleted">
        	<div class="achv_date"><xsl:value-of select="@dateCompleted"/></div>
        </xsl:if>

		<xsl:if test="criteria|achievement">
			<ul class="criteria">
	            <xsl:if test="not(criteria/@maxQuantity or criteria/@maxQuantityGold) ">
	            	<xsl:attribute name="class">criteria c_list</xsl:attribute>
	            </xsl:if>
            	<xsl:apply-templates select="criteria|achievement"/>
			</ul>
			<br clear="all"/>
		</xsl:if>
		<xsl:if test="@reward">
			<div class="achv_reward_bg">
				<xsl:value-of select="@reward"/>
			</div>
		</xsl:if>
	</div>
</xsl:template>

<xsl:template match="criteria[@maxQuantity|@maxQuantityGold]">
	<div class="critbar">
		<xsl:call-template name="achievement-progress-bar">
			<xsl:with-param name="value" select="@quantity"/>
			<xsl:with-param name="max" select="@maxQuantity"/>
		</xsl:call-template>
	</div>
</xsl:template>

<xsl:template match="achievement">
	<li id="ach{@id}" class="c_list_col">
		<xsl:if test="@dateCompleted">
			<xsl:attribute name="class">c_list_col criteriamet</xsl:attribute>
		</xsl:if>
		<xsl:if test="position() mod 2">
			<xsl:attribute name="style">float:left</xsl:attribute>
		</xsl:if>
		<xsl:value-of select="@title"/> (<xsl:value-of select="@points"/>)
	</li>
</xsl:template>

<xsl:template match="criteria">
	<li class="c_list_col">
		<xsl:if test="@date">
			<xsl:attribute name="class">c_list_col criteriamet</xsl:attribute>
		</xsl:if>
        <xsl:if test="position() mod 2">
			<xsl:attribute name="style">float:left</xsl:attribute>
		</xsl:if>
		<xsl:value-of select="@name"/> <!-- Have criteria @id, but not category and subcategory to deeeplink. Function is Armory.Achievements.openCategory(Category, SubcategoryOffset, AchievementId)-->
	</li>
</xsl:template>

<!-- Comparison -->

<xsl:template match="achievements">
	<table> <!-- root placeholder node -->
		<xsl:apply-templates select="category[1]" mode="compare"/>
	</table>
</xsl:template>

<xsl:template match="category" mode="compare">
	<tbody class="summary">
		<xsl:apply-templates select="." mode="compare-progress"/>
		<xsl:apply-templates select="achievement" mode="compare-ach"/>
	</tbody>
    <xsl:apply-templates select="category" mode="compare-sub"/>
</xsl:template>

<xsl:template match="category" mode="compare-sub">
	<tbody style="display:none">
		<xsl:apply-templates select="." mode="compare-progress"/>
		<xsl:apply-templates select="achievement" mode="compare-ach"/>
	</tbody>
</xsl:template>

<xsl:template match="category" mode="compare-progress">
	<xsl:param name="catIndex" select="0"/>

	<tr class="comp_progress">
		<td width="100%"></td>
		<xsl:for-each select="achievement[1]/c">
			<td>
				<xsl:apply-templates select="../.." mode="progress-bar">
					<xsl:with-param name="index" select="position()"/>
                    <xsl:with-param name="type" select="'blue'"/>
				</xsl:apply-templates>
			</td>
		</xsl:for-each>
	</tr>
</xsl:template>

<xsl:template match="achievement" mode="compare-ach">
	<tr class="comp_row">
		<td class="desc_td">
			<xsl:apply-templates select="." mode="icon"/>
            <div class="firsts_icon_block"><xsl:comment/></div>
			<div class="compare_desc"><div style="font-weight: bold"><xsl:value-of select="@title"/></div>
			<div><xsl:value-of select="@desc"/></div></div>
		</td>
		<xsl:for-each select="c">
			<td align="center" class="p_box">
            <xsl:if test="@dateCompleted"><xsl:attribute name="class">completed</xsl:attribute></xsl:if>
				<xsl:choose>
	                <xsl:when test="@dateCompleted">
	                    <div class="comp_points"><xsl:value-of select="../@points"/></div>
						<div class="comp_date">[<xsl:value-of select="@dateCompleted"/>]</div>
					</xsl:when>
	                <xsl:otherwise>
	                	&#8212;
	                </xsl:otherwise>
                </xsl:choose>
			</td>
		</xsl:for-each>
	</tr>
</xsl:template>

</xsl:stylesheet>