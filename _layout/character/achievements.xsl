<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:import href="achievements-async.xsl"/>

<xsl:variable name="MAX_ACHIEVEMENT_COMPARISON_CHARACTERS" select="4"/>

<xsl:template name="head-content"><link href="_css/character/achievements.css" rel="stylesheet" type="text/css" /></xsl:template>

<xsl:variable name="achievementPageType">achievements</xsl:variable>

<!-- TODO this needs to be made into a generic page template -->
<xsl:template match="page/characterInfo">


	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">
					<xsl:call-template name="newCharTabs" />
                    <div class="full-list">
                        <div class="info-pane">
							<div class="profile-wrapper">
								<div class="profile">
                           			<xsl:call-template name="charContent" />
						   		</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
	if(armory_query.alink){
	$(document).ready(function() {
	var alink = armory_query.alink.split(":");
	Armory.Achievements.openCategory(alink[0],alink[1],alink[2]) 
	});}
    </script>
</xsl:template>

<xsl:template name="charContent">

	<!-- character header -->
	<xsl:call-template name="newCharHeader" />

	<xsl:choose>
		<xsl:when test="count(character) = 1">
			<xsl:call-template name="achievement-bookmarks"/>
			<xsl:apply-templates select="../achievements|../statistics" mode="ach"/>
		</xsl:when>
		<xsl:when test="character">
			<xsl:call-template name="achievement-bookmarks"/>
			<xsl:apply-templates select="../achievements|../statistics" mode="compare"/>
		</xsl:when>
		<xsl:otherwise>
			<script type="text/javascript">hide('divCharTabs')</script>
			<xsl:call-template name="unavailable" />
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template match="character[@errorCode]">
	<div class="add_error">
		<a href="javascript:void(0)" onclick="Armory.Achievements.removeCharacter({count(preceding-sibling::character)}); return false">
			<xsl:apply-templates select="$loc/strs/achievements/err[@id=current()/@errorCode]" mode="printf">
				<xsl:with-param name="param1" select="@name"/>
				<xsl:with-param name="param2" select="@realm"/>
			</xsl:apply-templates>
			<xsl:text> </xsl:text>
		</a>
	</div>
</xsl:template>

<xsl:template name="achievements-script">
	<xsl:param name="mode">single</xsl:param>

	<script type="text/javascript" src="_js/achievements.js"></script>

	<script type="text/javascript">
		Armory.Achievements.init("<xsl:value-of select="$achievementPageType"/>", "<xsl:value-of select="$mode"/>",
			[
				<xsl:for-each select="/page/characterInfo/character[not(@errorCode)]">
					["<xsl:value-of select="@realm"/>","<xsl:value-of select="@name"/>"],
				</xsl:for-each>
			]);
	</script>
</xsl:template>

<!-- mode "ach" used to work around overzealous apply-templates in shared XSL -->

<!-- Navigation -->

<xsl:template match="category" mode="nav-sub">
	<div class="nav-subcat">
		<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '{@id}')"><xsl:value-of select="@name"/></a>
	</div>
</xsl:template>

<xsl:template match="category" mode="nav">
	<div>
		<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '{@id}')"><xsl:value-of select="@name"/></a>
		<xsl:if test="category">
			<div class="cat_list">
            <xsl:apply-templates select="category" mode="nav-sub"/>
            </div>
		</xsl:if>
	</div>
</xsl:template>

<xsl:template match="rootCategories" mode="ach">
	<div class="achv_lnav">
    	<div class="achv_bdr"><img src="images/achievements/achv_lnav_top.jpg"/></div>
		<div class="category-root">
			<div class="selected">
				<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode)"><xsl:value-of select="$loc/strs/achievements/str[@id='achievements.summary']"/></a>
			</div>
			<xsl:apply-templates mode="nav"/>
		</div>
        <div class="achv_bdr"><img src="images/achievements/achv_lnav_btm.jpg"/></div>
	</div>
</xsl:template>

<!-- Single character -->

<xsl:template match="summary" mode="ach">
	<div class="summary">
		<div>
			<xsl:call-template name="achievement-progress-bar">
				<xsl:with-param name="value" select="c/@earned"/>
				<xsl:with-param name="max" select="c/@total"/>
                <xsl:with-param name="text" select="'totalcompleted'"/>
			</xsl:call-template>
		</div>
		<div class="summary_progress_container"><xsl:apply-templates select="category" mode="ach"/>
        <br clear="all"/><br /></div>

        <div class="recent_header"><xsl:value-of select="$loc/strs/achievements/str[@id='recent']"/></div>
		<xsl:apply-templates select="achievement" mode="s_ach"/>

	</div>
	<div class="loading" style="display:none;">
		<xsl:value-of select="$loc/strs/common/str[@id='loading']"/>
	</div>
</xsl:template>

<xsl:template match="category" mode="ach">
	<div class="summary_progress">
		<xsl:variable name="catpos" select="position()"/>
		<div><xsl:value-of select="../../rootCategories/category[position() = $catpos]/@name"/>: </div>
		<xsl:apply-templates mode="progress"/>
	</div>
</xsl:template>

<xsl:template match="c" mode="progress">
	<div>
		<xsl:choose>
			<xsl:when test="@total">
				<xsl:call-template name="achievement-progress-bar">
					<xsl:with-param name="value" select="@earned"/>
					<xsl:with-param name="max" select="@total"/>
					<xsl:with-param name="stype" select="'blue'"/>
                    <xsl:with-param name="tooltip"><xsl:choose><xsl:when test="@points"><xsl:value-of select="@points"/></xsl:when><xsl:otherwise><xsl:value-of select="@earnedPoints"/></xsl:otherwise></xsl:choose><xsl:value-of select="concat(' / ',@totalPoints,' ',$loc/strs/achievements/str[@id='points'])"/></xsl:with-param>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
			<div class="null_progress">	<xsl:value-of select="@earned"/></div>
			</xsl:otherwise>
		</xsl:choose>
	</div>
</xsl:template>

<xsl:template match="achievements|statistics" mode="ach">
	<div class="achievements">
		<xsl:apply-templates select="rootCategories" mode="ach"/>
		<div class="achieve_rcol">
        	<div class="topcurve"><img src="images/achievements/achv_rcol_top.jpg"/></div>
		<div class="achievements-container">
	        <div id="achievements-content">
	        	<xsl:apply-templates select="summary" mode="ach"/>
	        </div>
        </div>
        	<div class="achv_r_btm"><img src="images/achievements/achv_rcol_btm.jpg"/></div>
        </div>
        <br clear="all"/>
	</div>
	<div style="clear:both"><br/></div>
	<xsl:call-template name="achievements-script"/>
</xsl:template>

<!-- Comparison -->

<xsl:template name="achievement-bookmarks">
	<div id="achievements-characterCompareEntry" class="compare_box">
        <div class="comp_out"><div class="comp_int" >
            <img src="images/achievements/compare_top_btm.gif" class="comp_box_t_btm"/>
            <img src="images/achievements/compare_top_btm_r.gif" class="comp_box_t_btm_r"/>
	        <xsl:choose>
	        	<xsl:when test="count(character[not(@errorCode)]) &gt;= $MAX_ACHIEVEMENT_COMPARISON_CHARACTERS">
	        		<xsl:apply-templates select="$loc/strs/achievements/str[@id='compare.max']" mode="printf">
	        			<xsl:with-param name="param1" select="$MAX_ACHIEVEMENT_COMPARISON_CHARACTERS"/>
	        		</xsl:apply-templates>
	        	</xsl:when>
	        	<xsl:otherwise>
					<form action="." onsubmit="Armory.Achievements.addCharacter(this.n.value, this.r.value); return false">
						<label>
							<div><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.character-name']"/></div>
		                	<input type="text" name="n"/>
		                </label>
						<label>
							<div><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.realm']"/></div>
		                	<input type="text" name="r" value="{/page/characterInfo/character/@realm}"/>
		                </label>
						<div><input class="comp_submit" type="submit" value="{$loc/strs/achievements/str[@id='compare.achievements.button']}"/></div>
					</form>
	        	</xsl:otherwise>
	        </xsl:choose>
        </div></div>
		<div style="cursor:pointer">
			<div class="comp_box_t_l"><xsl:text> </xsl:text></div>
            <div class="comp_box_t_r"><xsl:text> </xsl:text></div>

			<div class="comp_btn_title">
				<xsl:value-of select="$loc/strs/achievements/str[@id='compare.achievements']"/>
			</div>
		</div>
	</div>
</xsl:template>

<xsl:template match="character[not(@errorCode)]" mode="compare-thead">
	<th class="achv_comp_chr">
		<div class="achv_portrait">
    <a class="rem_link staticTip" href="javascript:void(0)" onclick="Armory.Achievements.removeCharacter({position()-1}); return false">
    <xsl:attribute name="onmouseover">setTipText('<xsl:value-of select="$loc/strs/calendar/str[@id='remove']"/>&#160;<xsl:value-of select="@name"/>')</xsl:attribute>
    </a>
			<!-- TODO merge with character-header.xsl -->
			<xsl:variable name="levelSuffix">
				<xsl:choose>
        			<xsl:when test="@level &lt; 60">-default</xsl:when>
      				<xsl:when test="@level &lt; 70"></xsl:when>
      				<xsl:when test="@level &lt; 80">-70</xsl:when>
	    			<xsl:otherwise>-80</xsl:otherwise>
	    		</xsl:choose>
			</xsl:variable>

			<a href="?{@charUrl}">
            <img src="images/portraits/wow{$levelSuffix}/{@genderId}-{@raceId}-{@classId}.gif" alt=""/>
            <span><xsl:value-of select="@name"/></span>
			</a>

		<div class="achv_comp_realm"><xsl:value-of select="@realm"/></div>
		</div>
	</th>
</xsl:template>

<xsl:template match="c" mode="compare-points">
	<td class="comp_points">
		<xsl:value-of select="@points"/><img src="images/achievements/tiny_shield.gif"/>
	</td>
</xsl:template>

<xsl:template match="category" mode="compare-progress">
	<tr>
		<xsl:variable name="catpos" select="position()"/>
		<td class="comp_prog_name"><xsl:value-of select="../../rootCategories/category[position() = $catpos]/@name"/></td>
		<xsl:apply-templates mode="compare-progress"/>
	</tr>
</xsl:template>

<xsl:template match="c" mode="compare-progress">
	<td>
		<xsl:choose>
			<xsl:when test="@total">
                <xsl:call-template name="achievement-progress-bar">
                    <xsl:with-param name="value" select="@earned"/>
                    <xsl:with-param name="max" select="@total"/>
                    <xsl:with-param name="stype" select="'blue'"/>
                    <xsl:with-param name="tooltip"><xsl:choose><xsl:when test="@points"><xsl:value-of select="@points"/></xsl:when><xsl:otherwise><xsl:value-of select="@earnedPoints"/></xsl:otherwise></xsl:choose><xsl:value-of select="concat(' / ',@totalPoints,' ',$loc/strs/achievements/str[@id='points'])"/></xsl:with-param>
                </xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<div class="null_progress">	<xsl:value-of select="@earned"/></div>
			</xsl:otherwise>
		</xsl:choose>
	</td>
</xsl:template>

<xsl:template match="achievements|statistics" mode="compare">
	<div class="achievements">
		<xsl:apply-templates select="rootCategories" mode="ach"/>
		<div class="achieve_rcol">
        <div class="topcurve"><img src="images/achievements/achv_rcol_top.jpg"/></div>
    <div class="achievements-container" >
	  <div class="compare_container">
        <table class="compare_table" id="achievements-content">
			<thead>
            	<tr>
					<th></th>
					<xsl:apply-templates select="../characterInfo/character" mode="compare-thead"/>
				</tr>
			</thead>
			<tbody class="summary">
				<xsl:apply-templates select="." mode="compare-summary"/>
			</tbody>
			<tbody class="loading" style="display:none">
				<tr>
					<td width="100%">
						<xsl:value-of select="$loc/strs/common/str[@id='loading']"/>
					</td>
				</tr>
			</tbody>
		</table>
	  </div>
    </div>
        <div class="achv_r_btm"><img src="images/achievements/achv_rcol_btm.jpg"/></div>
        </div>
	</div>
	<div style="clear:both"><br/></div>
	<xsl:call-template name="achievements-script">
		<xsl:with-param name="mode">compare</xsl:with-param>
	</xsl:call-template>
</xsl:template>

<xsl:template match="achievements/summary" mode="compare-summary">
	<tr class="summary_row1">
		<th><xsl:value-of select="$loc/strs/achievements/str[@id='points']"/></th>
		<xsl:apply-templates select="c" mode="compare-points"/>
	</tr>
	<tr>
		<th><xsl:value-of select="$loc/strs/achievements/str[@id='progress']"/></th>
		<xsl:apply-templates select="c" mode="compare-progress"/>
	</tr>
	<tr><td><br /></td></tr>
	<xsl:apply-templates select="category" mode="compare-progress"/>
</xsl:template>

</xsl:stylesheet>