<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:variable name="IS_LOGGED_IN" select="not(document('../../login-status.xml')/page/loginStatus/@username = '')"/>

<!-- tabs -->
<xsl:template name="newCharTabs"><link rel="stylesheet" href="_css/character/global.css" type="text/css" />

	<xsl:call-template name="tabs">
		<xsl:with-param name="tabGroup" select="/page/tabInfo/@tabGroup" />
		<xsl:with-param name="currTab" select="/page/tabInfo/@tab" />
		<xsl:with-param name="subTab" select="/page/tabInfo/@subTab" />
		<xsl:with-param name="tabUrlAppend" select="/page/tabInfo/@tabUrl" />
		<xsl:with-param name="subtabUrlAppend" select="/page/tabInfo/@tabUrl" />
	</xsl:call-template>

</xsl:template>


<!-- character header -->
<xsl:template name="newCharHeader">

	<script type="text/javascript">
		var charUrl = "<xsl:value-of select="/page/characterInfo/character/@charUrl"/>";
		var bookmarkMaxedToolTip = "<xsl:value-of select="$loc/strs/common/str[@id='user.bookmark.maxedtooltip']"/>";
		var bookmarkThisChar = "<xsl:value-of select="$loc/strs/common/str[@id='user.bookmark.character']" />";	
		<xsl:comment>"</xsl:comment>
	</script>


	<xsl:variable name="c" select="character[1]" />
	<xsl:variable name="level" select="$c/@level" />
	<xsl:variable name="points" select="$c/@points" />
	
	
	<div class="profile_header header_Horde">	
	    <xsl:choose>
			<xsl:when test="$c/@tournamentRealm = '1'">
				<xsl:attribute name="class">profile_header header_Propass</xsl:attribute>
			</xsl:when>
			<xsl:when test="$c/@factionId=0">
				<xsl:attribute name="class">profile_header header_Alliance</xsl:attribute>
			</xsl:when>			
		</xsl:choose>
        <!-- achievement points -->
			<div class="points">
				<a href="character-achievements.xml?{$c/@charUrl}"><xsl:value-of select="$points" /></a>
			</div>

        
        <div id="forumLinks">
			<!-- ahref around the whole block so the entire thing is clickable -->			
			<a class="staticTip" href="{$regionForumsURL}board.html?sid=1&amp;forumName={$c/@realm}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.realm']}');" onclick="window.open(this.href);return false;">
				<xsl:if test="not($region = 'US' or $region = 'EU')">
					<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
					<xsl:attribute name="class"></xsl:attribute>
					<xsl:attribute name="onmouseover"></xsl:attribute>						
				</xsl:if>
				<xsl:value-of select="$c/@realm" />
			</a> /
			<a class="staticTip" href="{$regionForumsURL}board.html?sid=1&amp;forumName={character/@battleGroup}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.battleGroup']}');" onclick="window.open(this.href);return false;">
				<xsl:if test="not($region = 'US' or $region = 'EU')">
					<xsl:attribute name="href">javascript:void(0)</xsl:attribute>
					<xsl:attribute name="class"></xsl:attribute>
					<xsl:attribute name="onmouseover"></xsl:attribute>						
				</xsl:if>
				<xsl:value-of select="$c/@battleGroup" />
			</a>			
		</div> 

        
		<div id="profileRight" class="profile-right">				
			<xsl:choose>
				<xsl:when test="$IS_LOGGED_IN = 'true'">
					<xsl:variable name="bm" select = "document('../../bookmarks.xml')/page/characters"/>
					<xsl:variable name="userHasMaxBookmarks" select="$bm/@count &gt;= $bm/@max"/>
					<xsl:variable name="isBookmarkedCharacter" select="$bm/character/@name = $c/@name and $bm/character/@realm = $c/@realm"/>

					<a id="bmcLink" class="staticTip" href="javascript:ajaxBookmarkChar()" onmouseover="setTipText('{$loc/strs/common/str[@id='user.bookmark.character']}');"><xsl:comment> </xsl:comment></a>
					<xsl:choose>
						<xsl:when test="$isBookmarkedCharacter">
                   			<a href="javascript:;" class="bmcEnabled"><xsl:comment> </xsl:comment></a>
                		</xsl:when>
						<xsl:when test="$userHasMaxBookmarks">
                    		<a class="bmcMaxed staticTip" href="javascript:;" onmouseover="setTipText(bookmarkMaxedToolTip)"><xsl:comment> </xsl:comment></a>
                		</xsl:when>
					</xsl:choose>
				</xsl:when>
				<xsl:otherwise>
					<a id="bmcLink" class="bmcLink staticTip" onmouseover="setTipText('{$loc/strs/common/str[@id='user.bookmark.logintobookmark']}');"><xsl:comment> </xsl:comment></a>
				</xsl:otherwise>
			</xsl:choose>
		</div>
		<div class="profile-achieve">			
			<a href="character-sheet.xml?{/page/characterInfo/character/@charUrl}" class="staticTip">
            <xsl:variable name="character_desc"><xsl:apply-templates mode="printf" select="$loc/strs/character/str[@id='charLevelStr']"> <xsl:with-param name="param1" select="/page/characterInfo/character/@level" /> <xsl:with-param name="param2" select="/page/characterInfo/character/@race" /> <xsl:with-param name="param3" select="/page/characterInfo/character/@class" /> </xsl:apply-templates></xsl:variable>
            <xsl:attribute name="onmouseover">setTipText('<xsl:value-of select="normalize-space($character_desc)"/>')</xsl:attribute>
            <xsl:choose>
				<xsl:when test="$level &lt; 60">
					<img src="images/portraits/wow-default/{$c/@genderId}-{$c/@raceId}-{$c/@classId}.gif" />
				</xsl:when>
				<xsl:when test="$level &lt; 70">
					<img src="images/portraits/wow/{$c/@genderId}-{$c/@raceId}-{$c/@classId}.gif" />
				</xsl:when>
				<xsl:when test="$level &lt; 80">
					<img src="images/portraits/wow-70/{$c/@genderId}-{$c/@raceId}-{$c/@classId}.gif" />
				</xsl:when>
				<xsl:otherwise>
					<img src="images/portraits/wow-80/{$c/@genderId}-{$c/@raceId}-{$c/@classId}.gif" />
				</xsl:otherwise>
			</xsl:choose>
			</a>
			
            <!-- Auto-discovery of character feed -->	
				<link href="atom/character.xml?{$c/@charUrl}" title="WoW Feed" rel="alternate" type="application/atom+xml"/>
						
			<!-- level -->
                <div id="leveltext"><xsl:value-of select="$level"/></div>
		</div>		
		
		
		<div id="charHeaderTxt_Light">
			<xsl:if test="not($c/@guildName = '')">
				<div class="charGuildName"><a href="guild-info.xml?{$c/@guildUrl}"><xsl:value-of select="$c/@guildName" /></a></div>
			</xsl:if>
			<span class="prefix">
				<xsl:value-of select="$c/@prefix" />&#160;
			</span>
			<div class="charNameHeader"><xsl:value-of select="/page/characterInfo/character/@name" />
				<span class="suffix">
                <xsl:if test="substring($c/@suffix,1,1) = ','"><xsl:attribute name="class">suffix no-margin</xsl:attribute></xsl:if>
                <xsl:value-of select="$c/@suffix" /></span></div>
		</div>		
	
		
	</div>
    <div class="header_break"><xsl:comment> </xsl:comment></div>

</xsl:template>

</xsl:stylesheet>
