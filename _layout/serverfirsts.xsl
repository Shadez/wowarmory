<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="includes.xsl"/>

<xsl:template name="head-content"><link href="_css/character/achievements.css" rel="stylesheet" type="text/css" /></xsl:template>
<xsl:template match="error">
	<xsl:call-template name="realmInfo"/>
</xsl:template>

<!--############################-->
<xsl:template match="realmInfo" name="realmInfo">
<xsl:variable name="curPage" select="/page/@pageId"/>
<xsl:variable name="firstrealm">
<xsl:if test="not(@realm)"><xsl:choose><xsl:when test="achievement/guild/@realm"><xsl:value-of select="achievement/guild/@realm"/></xsl:when><xsl:otherwise><xsl:value-of select="achievement/character/@realm"/></xsl:otherwise></xsl:choose></xsl:if>
</xsl:variable>

<div id="dataElement">
<div class="parchment-top">
  <div class="parchment-content">
	<div class="server-firsts list">
    <div class="info-header hdr_achvfirsts">
		<h1><xsl:value-of select="$loc/strs/achievements/str[@id='achievementfirsts']"/></h1>
		<h2>
        <xsl:choose>
        <xsl:when test="@realm">
        <a href="achievement-firsts.xml"><xsl:value-of select="$loc/strs/region/str[@id=$region]/@name"/></a> » <xsl:value-of select="@realm"/>
        </xsl:when>
        <xsl:otherwise>
        <xsl:value-of select="$loc/strs/region/str[@id=$region]/@name"/>
        </xsl:otherwise>
        </xsl:choose>
        </h2>
	</div>

    <div class="achieve-firsts">

      <div class="firsts_top">
    <div class="closed" id="realmnav">
      <div class="f_nav_top">

        <div class="f_nav_title"><xsl:value-of select="$loc/strs/achievements/str[@id='serverfirsts.realmnav.viewing']"/>:</div>
        <a href="javascript:;" onclick="rlmnv = document.getElementById('realmnav'); rlmnv.className=(rlmnv.className=='closed')?'':'closed'">
        <div class="arrow"><xsl:comment/></div>
        <xsl:choose>
            <xsl:when test="@realm">
            <xsl:value-of select="@realm"/>
            </xsl:when>
            <xsl:otherwise>
            <xsl:value-of select="$loc/strs/region/str[@id=$region]/@name"/>
            </xsl:otherwise>
            </xsl:choose>
        </a>
        </div>
            <div class="f_nav_bgrpt">
             <div class="f_nav_bgtop">
              <div class="f_nav_bgbtm">

               <xsl:variable name="login-status" select="document('../login-status.xml')" />
               <xsl:variable name="username" select="$login-status/page/loginStatus/@username" />

               <xsl:if test="string-length($username) != 0">
               <xsl:variable name="realms" select="document('../character-select.xml?sel=2')/page/characters/character/@realm"/>
                <xsl:if test="$realms">
                 <div class="f_nav_stitle"><xsl:value-of select="$loc/strs/achievements/str[@id='serverfirsts.realmnav.myrealms']"/>:</div>
	                <xsl:for-each select="$realms[not(. = preceding::character/@realm)]"> <!-- distinct-values -->
   						 <a href="achievement-firsts.xml?r={.}"><xsl:value-of select="."/></a>
                    </xsl:for-each>
                 </xsl:if>
                </xsl:if>

				 <div class="f_nav_stitle"><xsl:value-of select="$loc/strs/achievements/str[@id='serverfirsts.realmnav.otherrealms']"/>:</div>
                 <form onsubmit="frst_valid(this,r); return false; ">
                 <input name="r" id="r" type="text"/>
                 <input class="frst_realm_submit" type="submit" value="{$loc/strs/unsorted/str[@id='armory.labels.search']}"/>
                 </form>
                 <div id="rsearch_results" style="display:none">
                 <div class="rsearch_top">
                 <!--  
                 <xsl:comment>
                 <a href="#">Lightbringer</a>
                 <div class="sepdiv"></div>
                 <a href="#">Lightning's Edge</a>
                 <div class="sepdiv"></div>
                 <a href="#">Lightninghoof</a>
                 </xsl:comment>
                 -->
                 </div>
                 </div>
     <br clear="all" />
              </div>
             </div>
            </div>

      </div>
        <div class="firsts_btm">
                <div class="firsts_l"><div class="firsts_r">
                   <xsl:choose>
                   <xsl:when test="/page/realmInfo">
                    <xsl:apply-templates>
                    <xsl:with-param name="firstrealm" select="$firstrealm"/>
                    </xsl:apply-templates>
                   </xsl:when>
                   <xsl:otherwise>
                   <div style="text-align:center; padding:70px 0; background:url(images/tip-bg1.gif); font-size:21px; vertical-align:middle;">
                   <xsl:value-of select="$loc/strs/achievements/str[@id='error']"/>
                   <div class="error"><xsl:variable name="errcode" select="concat('error.',/page/error/@errCode)"/>
                    <xsl:choose><xsl:when test="/page/error/@attempt">
                    <xsl:apply-templates select="$loc/strs/achievements/str[@id=$errcode]" mode="printf">
                    	<xsl:with-param name="param1">
                        <xsl:value-of select="/page/error/@attempt"/>
                        </xsl:with-param>
                    </xsl:apply-templates>
                    </xsl:when>
                    <xsl:otherwise><xsl:value-of select="$loc/strs/achievements/str[@id='error.unknown']"/></xsl:otherwise>
                    </xsl:choose>
                    </div>

                   </div>
                   </xsl:otherwise>
                   </xsl:choose>
                </div></div>
                <script type="text/javascript">
					L10n.formatTimestamps("b.timestamp-firsts", <xsl:value-of select="$loc/strs/achievements/str[@id='date.format']"/>);
				</script>
          </div></div>
      </div>
	 </div>
	</div>
</div>
</div>

</xsl:template>




<!--############################-->
<xsl:template match="achievement">
<xsl:param name="frstrlm">
<xsl:choose><xsl:when test="guild/@realm"><xsl:value-of select="guild/@realm"/></xsl:when><xsl:otherwise><xsl:value-of select="character/@realm"/></xsl:otherwise></xsl:choose>
</xsl:param>
<xsl:param name="realmUrl">
<xsl:choose><xsl:when test="character/@realmUrl"><xsl:value-of select="character/@realmUrl"></xsl:value-of></xsl:when></xsl:choose>
</xsl:param>

<div class="firsts_achievement firsts_closed" onclick="toggle_first(this)">
<div class="expand_btn"><xsl:comment/></div>

<div class="firsts_icon" style='background-image:url("wow-icons/_images/51x51/{@icon}.jpg")'><img class="p" src="images/achievements/fst_iconframe.png"/></div>

<h3><xsl:value-of select="@title"/></h3>
<div class="firsts_tshadow">
<div class="firsts_desc"> <xsl:value-of select="@desc"/></div>

<div class="briefchars">
<xsl:choose>
	<xsl:when test="$lang='ko_kr'">
		<xsl:if test="not(../@realm)"><xsl:text> </xsl:text><xsl:value-of select="@realm"/><xsl:text> </xsl:text><xsl:value-of select="$loc/strs/achievements/str[@id='achv.on']"/> </xsl:if>
		<xsl:for-each select="guild">
			<xsl:if test="position() = last() and last() &gt; 1"> <xsl:value-of select="$loc/strs/achievements/str[@id='achv.and']"/> </xsl:if>
			<xsl:choose>
			<xsl:when test="@name != ''">
			<a class="gld" href="guild-info.xml?{@guildUrl}">&lt;<xsl:value-of select="@name"/>&gt;</a>(<xsl:value-of select="@count"/>)<xsl:if test="position() != last()">, </xsl:if>
			</xsl:when>
			<xsl:otherwise>
			<xsl:value-of select="@count"/>&#160;<strong><xsl:value-of select="$loc/strs/achievements/str[@id='achv.solo']"/></strong> <xsl:if test="position() != last()">, </xsl:if>
			</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
		<xsl:for-each select="character">
				<a href="character-sheet.xml?{@url}"><xsl:value-of select="@name"/></a><xsl:if test="position() != last()">, </xsl:if>
		</xsl:for-each>
		<xsl:value-of select="$loc/strs/achievements/str[@id='achv.by']"/>
	</xsl:when>
	<xsl:otherwise>
		<xsl:value-of select="$loc/strs/achievements/str[@id='achv.by']"/>
		<xsl:for-each select="guild">
			<xsl:if test="position() = last() and last() &gt; 1"> <xsl:value-of select="$loc/strs/achievements/str[@id='achv.and']"/> </xsl:if>
			<xsl:choose>
			<xsl:when test="@name != ''">
			<a class="gld" href="guild-info.xml?{@guildUrl}">&lt;<xsl:value-of select="@name"/>&gt;</a>(<xsl:value-of select="@count"/>)<xsl:if test="position() != last()">, </xsl:if>
			</xsl:when>
			<xsl:otherwise>
			<xsl:value-of select="@count"/>&#160;<strong><xsl:value-of select="$loc/strs/achievements/str[@id='achv.solo']"/></strong> <xsl:if test="position() != last()">, </xsl:if>
			</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
		<xsl:for-each select="character">
				<a href="character-sheet.xml?{@url}"><xsl:value-of select="@name"/></a><xsl:if test="position() != last()">, </xsl:if>
		</xsl:for-each>
		<xsl:if test="not(../@realm)"><xsl:text> </xsl:text><xsl:value-of select="$loc/strs/achievements/str[@id='achv.on']"/><xsl:text> </xsl:text><xsl:value-of select="@realm"/> </xsl:if>
	</xsl:otherwise>
</xsl:choose>
</div>

<div class="allchars">
<xsl:attribute name="class">allchars<xsl:if test="not(@g)"> single</xsl:if></xsl:attribute>
<xsl:for-each select="guild[@name != '']">

<div class="frst_guilds">
<xsl:if test="position() mod 2"><xsl:attribute name="style">clear:left</xsl:attribute></xsl:if>
<xsl:if test="count(../guild) &lt; 2"><xsl:attribute name="style">width:auto</xsl:attribute></xsl:if>
<div><a class="gld" href="guild-info.xml?{@guildUrl}">&lt;<xsl:value-of select="@name"/>&gt;</a></div>
    <xsl:for-each select="character">
     <xsl:variable name="cstr" select="concat('armory.classes.class.',@classId)"/>
     <xsl:variable name="rstr" select="concat('armory.races.race.',@raceId)"/>
	    <a class="chr staticTip" href="character-sheet.xml?{@url}">
        <xsl:attribute name="onmouseover">setTipText('&lt;img src="images/icons/race/<xsl:value-of select="@raceId"/>-<xsl:value-of select="@genderId"/>.gif" align="absmiddle" /&gt;  <xsl:value-of select="$loc/strs/races/str[@id=$rstr]"/>&lt;br/&gt; &lt;img src="../images/icons/class/<xsl:value-of select="@classId"/>.gif" align="absmiddle"/&gt;  <xsl:value-of select="$loc/strs/classes/str[@id=$cstr]"/>')</xsl:attribute>
        <xsl:value-of select="@name"/></a><xsl:if test="position() != last()">, </xsl:if>
    </xsl:for-each>
</div>

</xsl:for-each>

<xsl:for-each select="guild[@name = '']">

<div class="frst_guilds">
<xsl:if test="position() mod 2 and position != 1"><xsl:attribute name="style"></xsl:attribute></xsl:if>
<div class="gld"><xsl:value-of select="$loc/strs/achievements/str[@id='achv.solo']"/></div>
    <xsl:for-each select="character">
	    <a class="chr staticTip" href="character-sheet.xml?{@url}">
        <xsl:attribute name="onmouseover">setTipText('&lt;img src="images/icons/race/<xsl:value-of select="@raceId"/>-<xsl:value-of select="@genderId"/>.gif" align="absmiddle" /&gt;&lt;img src="images/icons/class/<xsl:value-of select="@classId"/>.gif" align="absmiddle"/&gt;')</xsl:attribute>
        <xsl:value-of select="@name"/></a><xsl:if test="position() != last()">, </xsl:if>
    </xsl:for-each>
</div>

</xsl:for-each>


	<xsl:for-each select="character">
	    <xsl:if test="@guild != ''"><a class="gld" href="guild-info.xml?{@guildUrl}">&lt;<xsl:value-of select="@guild"/>&gt;</a>&#160;</xsl:if>
        <a href="character-sheet.xml?{@url}"> <xsl:value-of select="@name"/></a><img src="images/icons/race/{@raceId}-{@genderId}.gif"/><img src="images/icons/class/{@classId}.gif" align="absmiddle"/>
        <xsl:if test="position() != last()">, </xsl:if>
    </xsl:for-each>
</div>


<div class="firsts_timedate"><xsl:value-of select="$loc/strs/achievements/str[@id='achv.earned']"/> 
	<xsl:text> </xsl:text>
	<xsl:value-of select="$loc/strs/achievements/str[@id='achv.on']"/>
	<xsl:text> </xsl:text>
	<xsl:if test="not(../@realm)">[<a href="achievement-firsts.xml?r={$realmUrl}"><xsl:value-of select="$frstrlm"/></a>] </xsl:if>
	<b class="timestamp-firsts"><xsl:value-of select="@dateCompleted"/></b></div>
<br clear="all"/>
</div>
</div>

</xsl:template>

</xsl:stylesheet>
