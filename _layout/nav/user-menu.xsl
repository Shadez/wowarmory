<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="bookmarks.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template name="loginLogoutLink">

	<xsl:variable name="login-status" select="document('../../login-status.xml')" />   
    <xsl:variable name="username" select="$login-status/page/loginStatus/@username" />    
	
    <xsl:choose>    
    	<!-- logged in -->
        <xsl:when test="string-length($username) != 0">
        
        	<xsl:variable name="user" select="document('../../character-select.xml?sel=2')" />
			<xsl:variable name="pinned" select="$user/page/characters/character[@selected=1]" />
        	<xsl:variable name="txtPinClass" select="$loc/strs/classes/str[@id=concat('armory.classes.class.', $pinned/@classId,'.', $pinned/@genderId)]" />
		    <xsl:variable name="txtPinLevel" select="$loc/strs/character/str[@id='character-level-sheet']" />
		    <xsl:variable name="txtPinRace" select="$loc/strs/races/str[@id=concat('armory.races.race.', $pinned/@raceId,'.', $pinned/@genderId)]" />
       		
            <!-- print dropdown menu -->    
            <xsl:call-template name="userMenu" />
            
            <!-- login/logout area -->
            <div class="user-mod" style="text-align: right;">
            	<xsl:if test="/page/pageIndex">
                	<xsl:attribute name="class">user-mod loginbg</xsl:attribute>
                    <xsl:attribute name="style">text-align: right; </xsl:attribute>
                </xsl:if>

            	<!-- menu hover link -->
	            <a href="javascript:void(0)" id="bookmark-user">
                	<xsl:if test="/page/pageIndex">
                        <xsl:attribute name="style">margin: 3px 6px 0 0;</xsl:attribute>                
                    </xsl:if>
                </a>
                
                <xsl:choose>                    
                    <xsl:when test="string-length($txtPinClass) = 0">
                        <span class="loggedInAs"><xsl:value-of select="$loc/strs/login/str[@id='armory.login.nochars']"/></span>
                        <br />
                        <a id="logoutLink" href="index.xml?logout=1"><xsl:value-of select="$loc/strs/login/str[@id='armory.login.logout']" /></a>
                    </xsl:when>
                    <xsl:otherwise>
						<span class="loggedInAs"><xsl:value-of select="$loc/strs/login/str[@id='armory.login.logged']"/></span>                        
                        <br />
                                                
                        <a href="character-sheet.xml?{$pinned/@url}" class="userName iconClassId{$pinned/@classId} staticTip" onmouseover="setTipText('{$txtPinClass}')">
						<xsl:value-of select="$pinned/@name"/></a> |                        
                        <a id="logoutLink" href="index.xml?logout=1"><xsl:value-of select="$loc/strs/login/str[@id='armory.login.logout']" /></a>
                  </xsl:otherwise>
                </xsl:choose>
            </div>        
        </xsl:when>
        <xsl:otherwise>
        	<xsl:choose>
                <xsl:when test="not(/page/pageIndex)">
                	<a id="loginLinkRedirect" class="loginLink" 
							href="{/page/@requestUrl}?login&amp;cr"><xsl:value-of select="$loc/strs/login/str[@id='armory.login.login']" /></a>                
                </xsl:when>
                <xsl:otherwise>
                    <div class="loginbg">
                        <a id="loginLinkRedirect" class="loginLink" 
                        	href="{/page/@requestUrl}?login&amp;cr"><xsl:value-of select="$loc/strs/login/str[@id='armory.login.login']" /></a>
                    </div>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template name="userMenu">	
	<script type="text/javascript">
        <![CDATA[
        function loadCalendarAlerts(data) {
            if(!data.invites || !data.invites.length)
                return;

            $("#pendingInvitesNotification").show();

            var bookmarks = $("#userSelect .js-bookmark-characters");
            var names = bookmarks.find(".js-character-name"); // no
            var realms = bookmarks.find(".js-character-realm");
            var inviteNodes = bookmarks.find(".user-alerts");

            for(var j = 0, invite, invites = data.invites; invite = invites[j]; j++) {
                for(var i = 0; i < names.length; i++) {
                    if($(names[i]).text() == invite.character && $(realms[i]).text() == invite.realm) {
                        $(inviteNodes[i]).show().text(invite.invites);
                    }
                }
            }
        }

        ]]>
    </script>

    <xsl:variable name="user" select="document('../../character-select.xml?sel=2')" />
    <xsl:variable name="profile" select="$user/page/characters/character" />
    <xsl:variable name="bookmark" select="document('../../bookmarks.xml')/page/characters" />

	<div id="menuHolder">
    	<xsl:if test="/page/pageIndex">
        	<xsl:attribute name="style">top: 64px; right: 10px;</xsl:attribute>
        </xsl:if>
        
        <div id="myCharacters">
        	<a id="changeLink" href="character-select.xml"> <xsl:value-of select="$loc/strs/common/str[@id='user.manage.more']"/></a>
            <xsl:value-of select="$loc/strs/common/str[@id='user.change.character']"/>
		  </div>

          <script type="text/javascript">
              $(function() {
                $('.charlist').click(function() {
                    var that = $(this);
                    var name = $('.menu-char-name', that).val();
                    var realm = $('.menu-char-realm', that).val();

                    changeMainCharacter(name, realm, this);
                });
              });
          </script>

          <div id="characterHolder">

		  <!-- print each selected character -->
		  <xsl:for-each select="$profile[@selected &lt; 5]">
				<xsl:sort select="@selected"/>
				<xsl:variable name="txtClass" select="$loc/strs/classes/str[@id=concat('armory.classes.class.', current()/@classId,'.', current()/@genderId)]" />
				
				<div class="menuItem charlist">
                    <input type="hidden" class="menu-char-name" value="{@name}" />
                    <input type="hidden" class="menu-char-realm" value="{@realm}" />

                    <div class="menuItemRank" style="visibility: hidden">
                        <xsl:if test="@selected = 1">
                            <xsl:attribute name="style"></xsl:attribute>
                        </xsl:if>

                        <img src="images/icons/icon-guildmaster.gif" alt="Selected" class="staticTip" onmouseover="setTipText('{$loc/strs/character-select/str[@id='primaryChar']}')" />
                    </div>
                    
                    <div class="menuItemAvatar">
                        <xsl:choose>
                            <xsl:when test="@level = '80'">
                                <img class="primchar-avatar" src="images/portraits/wow-80/{@genderId}-{@raceId}-{@classId}.gif" width="30" height="30" />
                            </xsl:when>
                            <xsl:when test="@level &gt;= '70'">
                                <img class="primchar-avatar" src="images/portraits/wow-70/{@genderId}-{@raceId}-{@classId}.gif" width="30" height="30" />
                            </xsl:when>
                            <xsl:when test="@level &gt;= '60'">
                                <img class="primchar-avatar" src="images/portraits/wow/{@genderId}-{@raceId}-{@classId}.gif" width="30" height="30" />
                            </xsl:when>
                            <xsl:otherwise>
                                <img class="primchar-avatar" src="images/portraits/wow-default/{@genderId}-{@raceId}-{@classId}.gif" width="30" height="30" />
                            </xsl:otherwise>
                        </xsl:choose>
                    </div>

                    <div class="menuItemMeta">
                        <a href="character-calendar.xml?{@url}" class="user-alerts staticTip" style="display: none;" onmouseover="setTipText('{$loc/strs/login/str[@id='armory.login.calendar.pending']}')">0</a>

                        <a href="character-sheet.xml?{@url}" class="charName js-character-name"><xsl:value-of select="@name" /></a> -
                        <span class="js-character-realm"><xsl:value-of select="@realm" /></span>

                        <p>
                            <a href="character-achievements.xml?{@url}" class="character-achievement staticTip" onmouseover="setTipText('{$loc/strs/login/str[@id='armory.login.achievements']}');"><xsl:value-of select="@achPoints" /></a>
                        
                            <xsl:apply-templates mode="printf" select="$loc/strs/character/str[@id='charLevelStr']">
                                <xsl:with-param name="param1" select="@level" />
                                <xsl:with-param name="param2" select="''" />
                                <xsl:with-param name="param3" select="$txtClass" />
                            </xsl:apply-templates>
                        </p>
                    </div>

                    <span class="clear"><!-- --></span>
				</div>
		  </xsl:for-each>
          </div>
          
		<!-- bookmarks -->
		<div id="myBookmarks">
		  	<!-- paging arrows --> 
				<div id="bmArrows">
					 <a id="bmBack" class="staticTip" onmouseover="setTipText('{$loc/strs/common/str[@id='user.bookmark.previous']}');" href="javascript:void(0)"> </a>
					 <a id="bmFwd" class="staticTip" onmouseover="setTipText('{$loc/strs/common/str[@id='user.bookmark.forward']}');" href="javascript:void(0)"> </a>										 
				</div>
				<xsl:value-of select="$loc/strs/common/str[@id='user.change.bookmarks']"/>
		  </div>
		  <xsl:choose>
				<xsl:when test="$bookmark">
					 <!-- call bookmarks -->
					 <xsl:apply-templates mode="listBookmarks" select="$bookmark" />
				</xsl:when>
				<xsl:otherwise>
					 <div class="menuItem nobookmark" style="height: auto;">
						  <strong><xsl:value-of select="$loc/strs/login/str[@id='armory.login.bookmark.nobookmark']"/></strong>
						  <p><xsl:value-of select="$loc/strs/login/str[@id='armory.login.bookmark.nobookmark.desc']"/></p>
					 </div>
				</xsl:otherwise>
		  </xsl:choose>
	</div>
    
    <span class="clear"><!-- --></span>
</xsl:template>


</xsl:stylesheet>
