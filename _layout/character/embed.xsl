<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl"/>
<xsl:import href="../language.xsl"/>
<xsl:import href="sheet.xsl"/>
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>


<xsl:template name="tabInfo">
</xsl:template>

<xsl:template name="characterInfo" match="characterInfo">
<xsl:choose>
	<xsl:when test="@errCode = 'noCharacter'">
		<xsl:call-template name="noCharacter"/>
    </xsl:when>
    <xsl:otherwise>
            <xsl:variable name="theClassId" select="character/@classId" />
            <xsl:variable name="theRaceId" select="character/@raceId" />
            <xsl:variable name="theGenderId" select="character/@genderId" />
            <xsl:variable name="theFactionId" select="character/@factionId" />
            <xsl:variable name="charUrl" select="character/@charUrl" />
            <xsl:variable name="level" select="character/@level" />
            <xsl:variable name="lastModified" select="character/@lastModified" />
            <xsl:variable name="guildUrl" select="character/@guildUrl" />
            <xsl:variable name="c" select="character" />
            <xsl:variable name="points" select="$c/@points" />
            <xsl:variable name="character_desc"><xsl:apply-templates mode="printf" select="$loc/strs/character/str[@id='charLevelStr']"> <xsl:with-param name="param1" select="/page/characterInfo/character/@level" /> <xsl:with-param name="param2" select="/page/characterInfo/character/@race" /> <xsl:with-param name="param3" select="/page/characterInfo/character/@class" /> </xsl:apply-templates></xsl:variable>
            
            <script type="text/javascript">	
                var theClassId 		= <xsl:value-of select="$theClassId" />;
                var theRaceId 		= <xsl:value-of select="$theRaceId" />;
                var theClassName 	= "<xsl:value-of select="character/@class" />";
                var theLevel 		= <xsl:value-of select="$level" />;		
                var theRealmName 	= "<xsl:value-of select="character/@realm" />";
                var theCharName 	= "<xsl:value-of select="character/@name" />";	
                var actTalentSpec 	= "<xsl:value-of select="characterTab/talentSpecs/talentSpec[@active='1']/@prim"/>"
                var getcookie2 = null
                <xsl:comment>//"</xsl:comment>
            </script>		
    
            <script type="text/javascript" src="_js/functions.js"></script>
            <script type="text/javascript" src="shared/global/third-party/jquery/jquery.js"></script>
            <script type="text/javascript" src="_js/armory.js"></script>
            <script type="text/javascript" src="_js/character/charactermodel.js"></script>
            <script type="text/javascript">
                var urlp = HTTP.getURLParams()["skin"];
                var init3dvars = {embedded:true}
                if(urlp){ document.getElementById("wowCharacterEmbed").className = urlp; 
                          init3dvars = {embedded:true,bg:"none",bgColor:"0xFFFFFF"}; 
                        }
            </script>
    
            <xsl:call-template name="character_model"/>
    
    
    <div>
    <xsl:attribute name="class">embed_bg <xsl:if test="character/@factionId='0'">embed_Alliance</xsl:if><xsl:if test="character/@factionId='1'">embed_Horde</xsl:if><xsl:if test="character/@factionId='2'">embed_Propass</xsl:if></xsl:attribute>
        <div class="points">
            <a href="character-achievements.xml?{$c/@charUrl}" onclick="window.open(this.href);return false;"><xsl:value-of select="$points" /></a>
        </div>
        <div id="forumLinks">
            <xsl:value-of select="$c/@realm" /> / <xsl:value-of select="$c/@battleGroup" />
        </div> 
        
       
        <div id="charHeaderTxt_Light">
            <div class="charNameHeader"><a class="charLink" href="character-sheet.xml?{$c/@charUrl}" onclick="window.open(this.href);return false;"><xsl:value-of select="/page/characterInfo/character/@name" /></a></div>
            <xsl:if test="not($c/@guildName = '')">
                <div class="charGuildName"><a href="guild-info.xml?{$c/@guildUrl}" onclick="window.open(this.href);return false;"><xsl:value-of select="$c/@guildName" /></a></div>
            </xsl:if>
            <div class="character_desc"><xsl:value-of select="$character_desc" /></div>
        </div>		
    <div class="embed_links">
    <a class="trialLink" href="http://www.battle.net/account/creation/wow/region-selection.html" onclick="window.open(this.href);return false;"><xsl:value-of select="$loc/strs/embed/str[@id='armory.embed.trial']"/></a>
    <a href="character-sheet.xml?{$c/@charUrl}" onclick="window.open(this.href);return false;"><xsl:value-of select="$loc/strs/embed/str[@id='armory.embed.armorylink']"/></a>
    </div>
    </div>
    </xsl:otherwise>
</xsl:choose>
</xsl:template>


<xsl:template match="page">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="{$loc/strs/common/str[@id='meta-description']}" />
    <title><xsl:value-of select="$loc/strs/common/str[@id='the-wow-armory']"/></title>
	<link type="text/css" rel="stylesheet" href="_css/master.css"/>
    <link type="text/css" rel="stylesheet" href="_css/int.css"/>
    <link type="text/css" rel="stylesheet" href="_css/character/global.css"/>
	<script type="text/javascript" src="shared/global/third-party/jquery/jquery.js"></script>
    <xsl:call-template name="head-content"/>
</head>
<body id="wowCharacterEmbed">
<xsl:apply-templates select="characterInfo"/>
</body>
</html>
</xsl:template>


</xsl:stylesheet>