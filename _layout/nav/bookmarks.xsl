<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="page">
		
	<script type="text/javascript">
		var currBookmarks	 = "<xsl:value-of select='characters/@count' />";
		var maxBookmarks	 = "<xsl:value-of select='characters/@max' />";		
		
		
	   $("#bookmarksRemaining").html(currBookmarks);
		
		if(currBookmarks &lt; 1){		
			$("#bmArrows").hide();
		}
		
		//if we arent at max bookmarks anymore, show link
		if(currBookmarks &lt; maxBookmarks){
			$(".bmcMaxed").replaceWith('<a id="bmcLink" href="javascript:ajaxBookmarkChar()">'+
				'<span><xsl:value-of select="$loc/strs/common/str[@id='user.bookmark.character']"/></span><em></em></a>');		
		}
    </script>

	
    <xsl:choose>
        <!-- character has bookmarks -->    
        <xsl:when test="characters/@count != 0">        
        	<xsl:apply-templates mode="listBookmarks" select="characters" />
        </xsl:when>
        <xsl:otherwise>
            <!-- no bookmarks -->
            <div class="user-line-item nobookmark" style="height: auto;">
                <strong><xsl:value-of select="$loc/strs/login/str[@id='armory.login.bookmark.nobookmark']"/></strong>
                <p><xsl:value-of select="$loc/strs/login/str[@id='armory.login.bookmark.nobookmark.desc']"/></p>

           </div>
        </xsl:otherwise>
    </xsl:choose>

</xsl:template>

<!-- print the bookmark list -->
<xsl:template mode="listBookmarks" match="characters">
	<div id="bookmarkHolder">

		<xsl:variable name="charPerPage" select="'6'" />
		<xsl:variable name="totalPages" select="ceiling(count(character) div $charPerPage)" />       
        
        <span id="bm-currPage" style="display: none;">1</span>

        <span id="bm-totalPages" style="display: none;"><xsl:value-of select="ceiling(count(character) div $charPerPage)" /></span>
        
        <!-- go through each bookmarked character -->
        <xsl:for-each select="/page/characters/character">
        	<xsl:choose>
            	<xsl:when test="position() = '1'">
                    <xsl:call-template name="singlePage">
                        <xsl:with-param name="currPosition" select="(position() + $charPerPage) - 1" />
                        <xsl:with-param name="pagenum" select="'1'" />
                        <xsl:with-param name="charPerPage" select="$charPerPage" />

                    </xsl:call-template>
                </xsl:when>
                <xsl:when test="position() = (($charPerPage * 1) + 1)">
                    <xsl:call-template name="singlePage">
                        <xsl:with-param name="currPosition" select="position() + $charPerPage" />
                        <xsl:with-param name="pagenum" select="'2'" />
                        <xsl:with-param name="charPerPage" select="$charPerPage" />
                    </xsl:call-template>
                </xsl:when>

                <xsl:when test="position() = (($charPerPage * 2) + 1)">
                    <xsl:call-template name="singlePage">
                        <xsl:with-param name="currPosition" select="position() + $charPerPage" />
                        <xsl:with-param name="pagenum" select="'3'" />
                        <xsl:with-param name="charPerPage" select="$charPerPage" />
                    </xsl:call-template>
                </xsl:when>
                <xsl:when test="position() = (($charPerPage * 3) + 1)">
                    <xsl:call-template name="singlePage">

                        <xsl:with-param name="currPosition" select="position() + $charPerPage" />
                        <xsl:with-param name="pagenum" select="'4'" />
                        <xsl:with-param name="charPerPage" select="$charPerPage" />
                    </xsl:call-template>
                </xsl:when>
                <xsl:when test="position() = (($charPerPage * 4) + 1)">
                    <xsl:call-template name="singlePage">
                        <xsl:with-param name="currPosition" select="position() + $charPerPage" />
                        <xsl:with-param name="pagenum" select="'5'" />

                        <xsl:with-param name="charPerPage" select="$charPerPage" />
                    </xsl:call-template>
                </xsl:when>
                <xsl:when test="position() = (($charPerPage * 5) + 1)">
                    <xsl:call-template name="singlePage">
                        <xsl:with-param name="currPosition" select="position() + $charPerPage" />
                        <xsl:with-param name="pagenum" select="'6'" />
                        <xsl:with-param name="charPerPage" select="$charPerPage" />
                    </xsl:call-template>

                </xsl:when>
            </xsl:choose>
        	
        </xsl:for-each>
    </div>
</xsl:template>


<xsl:template name="singlePage">

	<xsl:param name="pagenum" />
	<xsl:param name="currPosition" />

    <xsl:param name="charPerPage" />    
    
	<div id="page{$pagenum}" class="bmPage" style="display: none;">
		<xsl:if test="$pagenum = '1'">
        	<xsl:attribute name="style">display: block</xsl:attribute>
		</xsl:if>
		<xsl:for-each select="/page/characters/character">			
			<xsl:if test="position() &lt;= ($pagenum * $charPerPage) and position() &gt;= ((($pagenum - 1) * $charPerPage) + 1)">
            	<xsl:call-template name="singleBookmark">
                	<xsl:with-param name="charNode" select="current()" />

				</xsl:call-template>
			</xsl:if>
		</xsl:for-each>
	</div>

</xsl:template>

<!-- print a single bookmark item -->
<xsl:template name="singleBookmark">

	<xsl:param name="charNode" />
    
	<xsl:variable name="txtClassbm" select="$loc/strs/classes/str[@id=concat('armory.classes.class.', $charNode/@classId,'.', $charNode/@genderId)]" />

    
    <div class="menuItem bmlist">
    	<a class="character-achievement staticTip" onMouseOver="setTipText('{$loc/strs/login/str[@id='armory.login.achievements']}');" 
            href="character-achievements.xml?{@url}"><xsl:value-of select="@achPoints"/></a>
    	
        <a href="javascript:void(0);" class="rmBookmark staticTip"
            onMouseOver="setTipText('{$loc/strs/login/str[@id='armory.login.bookmark.remove']}');">&#160;</a>    
    
    	<em class="classId{@classId} staticTip" onmouseover="setTipText('{$txtClassbm}')"></em>
        <a href="character-sheet.xml?{@url}" class="charName"><xsl:value-of select="@name"/></a>
        <span>&#160;-&#160;<xsl:value-of select="@realm"/></span>      
    
        <p>
			<xsl:apply-templates mode="printf" select="$loc/strs/character/str[@id='charLevelStr']">
				<xsl:with-param name="param1" select="@level" />

				<xsl:with-param name="param2" select="''" />
				<xsl:with-param name="param3" select="$txtClassbm" />
			</xsl:apply-templates>
        </p>        
	</div>

</xsl:template>


</xsl:stylesheet>
