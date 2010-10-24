<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:include href="includes.xsl"/>


<xsl:template name="charactersTable"><style type="text/css" media="screen, projection">
		@import "_css/character-select.css";	
	</style>
    
	<script type="text/javascript" src="_js/character/character-select.js"></script>
	<script type="text/javascript">           
        $(document).ready(function(){
			//get how many characters are selected
			var numCharsSelected = <xsl:value-of select="count(/page/characters/character/@selected)" />;
					
            initializeCharacterSelect(numCharsSelected);
        });
        
        //bind tooltips for primary/secondary characters
        function setCharacterToolTips(){				
            $(".secondaryChar").mouseover(function(){
                setTipText("<xsl:value-of select="$loc/strs/character/str[@id='character.tip.secondary']"/>");
            });
            
            $(".primaryChar").mouseover(function(){ 				
                setTipText("<xsl:value-of select="$loc/strs/character/str[@id='character.tip.primary']"/>");
            });
        }

        $(function() {
            $('.selSecondaryChar').click(function() {
                var that = $(this);
                var name = that.parent().find('h6 a').html();
                var realm = that.parent().find('.char-realm').html();

                changeMainCharacter(name, realm);
            });

            $('.charListIcons').click(function() {
                var that = $(this);
                var name = that.parent().find('.menu-char-name').val();
                var realm = that.parent().find('.menu-char-realm').val();

                changeMainCharacter(name, realm);
            });
        });
	</script>
    
    <div class="sel-char">  
		<div class="sel-intro">
        	<h1><xsl:value-of select="$loc/strs/character-select/str[@id='charSelection']"/></h1>
		</div>
        
        <xsl:choose>
            <xsl:when test="/page/characters/character">
                <div id="charList">
                    <xsl:call-template name="topCharList" />
                </div>
                <div id="searchTable">        
                    <xsl:call-template name="printCharSelectTable" />
                </div>	
            </xsl:when>
            <xsl:otherwise>
               <div class="page-body" style="padding-left: 20px;">
					<xsl:value-of select="$loc/strs/login/str[@id='armory.login.nochars']"/><br />						
				</div>
            </xsl:otherwise>
        </xsl:choose>
    </div>
    
</xsl:template>

<!-- prints a table row based on a character element -->
<xsl:template match="character" mode="printRow">
    <!-- define vars -->            
    <xsl:variable name="classTxt"	select="$loc/strs/classes/str[@id=concat('armory.classes.class.',current()/@classId,'.',current()/@genderId)]" />
    <xsl:variable name="raceTxt"	select="$loc/strs/races/str[@id=concat('armory.races.race.',current()/@raceId,'.',current()/@genderId)]" />
    <xsl:variable name="factionTxt" select="$loc/strs/unsorted/str[@id=concat('armory.labels.faction.',current()/@factionId)]" />
    
    <!-- print row -->
    <xsl:if test="not(@selected)">
        <tr>
            <td style="text-align:left; padding-left: 3px;">
                <span style="display: none;"><xsl:value-of select="@name" /></span>
                
                <xsl:call-template name="characterPromote">
                    <xsl:with-param name="char" select="current()" />
                </xsl:call-template>
                
                <a href="character-sheet.xml?{@url}"><xsl:value-of select="@name" /></a>
                <input type="hidden" class="menu-char-name" value="{@name}" />
                <input type="hidden" class="menu-char-realm" value="{@realm}" />
            </td>
			<td style="text-align:right; padding-right:3px; font-weight: bold; width: 50px;">
				<span style="display: none;"><xsl:value-of select="@achPoints" /></span>
                <span class="achievPtsSpan"><xsl:value-of select="@achPoints" /></span>
            </td>
            <td class="rightNum">
                <strong><xsl:value-of select="@level" /></strong>
            </td>
            <td style="text-align:right; padding-right:3px;">
                <span style="display: none;"><xsl:value-of select="$raceTxt" /></span>
                <img class="staticTip" onmouseover="setTipText('{$raceTxt}');" src="images/icons/race/{@raceId}-{@genderId}.gif" />
            </td>
            <td style="text-align:left; padding-left:3px;">
                <span style="display: none;"><xsl:value-of select="$classTxt"/></span>
                <img class="staticTip" onmouseover="setTipText('{$classTxt}');" src="images/icons/class/{@classId}.gif" />
            </td>
            <td style="text-align:center;">
                <img class="staticTip" onmouseover="setTipText('{$factionTxt}');" src="images/icons/faction/icon-{@factionId}.gif" />
            </td>
            <td>
                <a href="guild-info.xml?n={@guild}&amp;r={@realm}"><xsl:value-of select="@guild" /></a>
            </td>
            <td style="text-align:left; padding-left:3px;">
                <xsl:value-of select="@realm" />
            </td>
            
            <td class="relevance">
                <span style="display: none;"><xsl:value-of select="@relevance" />%</span>
                <q class="staticTip" onmouseover="setTipText('{@relevance}%');">
                    <del class="rel-container"><a><em style="width:{@relevance}%"></em></a></del>
                </q>
            </td>
        </tr>
    </xsl:if>

</xsl:template>

<!-- makes the ul/li for tabs based on accounts -->
<xsl:template match="accounts" mode="accountTabs">    
    <ul id="navTabs">
        <xsl:for-each select="account">           
			<li><a href="#{@username}"><xsl:value-of select="@username" /></a></li>
        </xsl:for-each>
    </ul>
</xsl:template>

<!-- print tht character select table -->
<xsl:template name="printCharSelectTable">
    <!-- print tabs -->
	<xsl:apply-templates mode="accountTabs" select="/page" />
	    
    <xsl:for-each select="/page/accounts/account">    	
        <div id="{@username}" class="charSelectTabDiv data" style="min-height: 100px;">
            <xsl:choose>
            	<xsl:when test="current()/@characters = 0">
					<div class="page-body" style="padding-left: 20px;">
						<xsl:value-of select="$loc/strs/character-select/str[@id='noCharsAvailable']"/><br />						
					</div>
                </xsl:when>
                <xsl:when test="current()/@characters and current()/@selected &lt; current()/@characters">
                    <table class="data-table sortTable" width="100%" cellpadding="0" cellspacing="0">
                                
                        <!-- print the column headers -->
                        <xsl:call-template name="printColumnHeaders" />
                
                        <tbody>
                            <xsl:for-each select="/page/characters/character[@account=current()/@username]">
                                <xsl:apply-templates mode="printRow" select="current()" />
                            </xsl:for-each>
                        </tbody>
                    </table>
                    <xsl:if test="not(@active = '1')">
                    	<div class="page-body">
							<div style="padding: 0 12px 0 0; text-align:right;line-height:22px;">
								<xsl:value-of select="$loc/strs/character-select/str[@id='inactiveLicense']"/>
							</div>
						</div>
					</xsl:if>
                </xsl:when>
                <xsl:otherwise>
                	<div class="page-body" style="padding-left: 20px;">
						<xsl:value-of select="$loc/strs/character-select/str[@id='noCharsAvailable']"/><br />						
					</div>
                </xsl:otherwise>
            </xsl:choose>
            
        </div>    	
    </xsl:for-each>
</xsl:template>

<!-- headers for character select table -->
<xsl:template name="printColumnHeaders">
    <thead>
        <tr class="masthead">
            <th style="text-align:left;"><a><xsl:value-of select="$loc/strs/character/str[@id='character-name']"/><span class='sortArw'> </span></a></th>
			<th class="numericSort">
                <a class="staticTip">
                    <xsl:attribute name="onmouseover">setTipText("<xsl:value-of select="$loc/strs/login/str[@id='armory.login.achievements']"/>");</xsl:attribute>
                    <xsl:value-of select="substring($loc/strs/login/str[@id='armory.login.achievements'],1,4)"/>
                    <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.period']" />
                    <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.period']" />
                    <xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.period']" />
					<span class='sortArw'> </span>
                </a>
            </th>
            <th><a><xsl:value-of select="$loc/strs/character/str[@id='character-level']"/><span class='sortArw'> </span></a></th>                
            <th><a><xsl:value-of select="$loc/strs/general/str[@id='race']"/><span class='sortArw'> </span></a></th>
            <th><a><xsl:value-of select="$loc/strs/general/str[@id='class']"/><span class='sortArw'> </span></a></th>
            <th><a><xsl:value-of select="$loc/strs/semicommon/str[@id='faction']"/><span class='sortArw'> </span></a></th>
            <th style="text-align:left"><a><xsl:value-of select="$loc/strs/guild/str[@id='guild']"/><span class='sortArw'> </span></a></th>
            <th style="text-align:left;"><a><xsl:value-of select="$loc/strs/semicommon/str[@id='realm']"/><span class='sortArw'> </span></a></th>
            <th class="headerSortUp"><a><xsl:value-of select="$loc/strs/common/str[@id='search.relevance']"/><span class='sortArw'> </span></a></th>        
        </tr>
    </thead>
</xsl:template>

<!-- prints icon-link to add characters (gets called in table row) -->
<xsl:template name="characterPromote">
    <xsl:param name="char" />
    
	<a href="javascript:void(0)" class="charListIcons add_on staticTip" onmouseover="setTipText('{$loc/strs/character-select/str[@id='makePrimary']}');">
    	<!--<xsl:choose>
        	<xsl:when test="count(/page/characters/character/@selected) = 5">
            	if we're at max character count, grey out links
            	<xsl:attribute name="class">charListIcons add_off staticTip</xsl:attribute>
	            <xsl:attribute name="onmouseover">setTipText("<xsl:value-of select="$loc/strs/character-select/str[@id='easyAccessLimit']"/>");</xsl:attribute>
            </xsl:when>
            <xsl:otherwise>
            	<xsl:attribute name="class">charListIcons add_on staticTip</xsl:attribute>
	            <xsl:attribute name="onmouseover">setTipText("<xsl:value-of select="$loc/strs/character-select/str[@id='addToEasyAccess']"/>");</xsl:attribute>            
            </xsl:otherwise>
		</xsl:choose>-->
	</a>
</xsl:template>

<!-- primts out top character area -->
<xsl:template name="topCharList">

	<!-- get primary character -->	
    <xsl:variable name="primChar" select="/page/characters/character[@selected='1']" />
	
	<div class="topcharlist">
    	<!-- show portrait based on level -->
		<h5><xsl:value-of select="$loc/strs/character-select/str[@id='selectedCharacters']"/></h5>
    	<div class="select-charwrap">
			<div class="select-char1">
				<div>
					<xsl:choose>
						<xsl:when test="$primChar/@level = '80'">
							<img class="primchar-avatar" src="images/portraits/wow-80/{$primChar/@genderId}-{$primChar/@raceId}-{$primChar/@classId}.gif" />            
						</xsl:when>
						<xsl:when test="$primChar/@level &gt;= '70'">
							<img class="primchar-avatar" src="images/portraits/wow-70/{$primChar/@genderId}-{$primChar/@raceId}-{$primChar/@classId}.gif" />            
						</xsl:when>
						<xsl:when test="$primChar/@level &gt;= '60'">
							<img class="primchar-avatar" src="images/portraits/wow/{$primChar/@genderId}-{$primChar/@raceId}-{$primChar/@classId}.gif" />
						</xsl:when>
						<xsl:otherwise>
							<img class="primchar-avatar" src="images/portraits/wow-default/{$primChar/@genderId}-{$primChar/@raceId}-{$primChar/@classId}.gif" />
						</xsl:otherwise>
					</xsl:choose>
                    <h6><a id="{$primChar/@url}" class="selChar selPrimaryChar" href="character-sheet.xml?{$primChar/@url}"><xsl:value-of select="$primChar/@name"/></a></h6>
                    <span>
                        Level <xsl:value-of select="$primChar/@level" />&#160;
                        <xsl:value-of select="$loc/strs/races/str[@id=concat('armory.races.race.',$primChar/@raceId,'.',$primChar/@genderId)]" />&#160;
                        <xsl:value-of select="$loc/strs/classes/str[@id=concat('armory.classes.class.',$primChar/@classId)]" />
                    </span>
                    <span class="char-realm"><xsl:value-of select="$primChar/@realm"/></span>
                    <q></q>
				</div>
				<em></em>
				<p class="staticTip" onmouseover="setTipText('{$loc/strs/common/str[@id='pin.dualdesc']}');">
				<label>
                <input type="checkbox" id="checkboxDualTooltip" onClick="javascript:setDualTooltipCookie();" /><xsl:value-of select="$loc/strs/common/str[@id='pin.enabledual']"/>
				</label>
				</p>				
			</div>
			
			<!-- list secondary characters -->
			<xsl:call-template name="printSecondaryChars" />			
		</div>
    </div>
</xsl:template>

<!-- prints secondary characters in top character area -->
<xsl:template name="printSecondaryChars">
    <xsl:if test="count(/page/characters/character/@selected) &gt; 1">

        <xsl:for-each select="/page/characters/character[@selected = '2']">
            <div class="select-char2">
                <a id="{@url}" class="selChar selSecondaryChar staticTip" onmouseover="setTipText('{$loc/strs/character-select/str[@id='makePrimary']}');" href="javascript:void(0)"></a>

                <!--<a class="delChar staticTip" onmouseover="setTipText('{$loc/strs/character-select/str[@id='removeFromEasyAccess']}');" href="javascript:void(0)"></a>-->

                <img class="staticTip" onmouseover="setTipText('{$loc/strs/races/str[@id=concat('armory.races.race.',current()/@raceId)]}');"
                    src="images/icons/race/{current()/@raceId}-{current()/@genderId}.gif" />
                <img class="staticTip" onmouseover="setTipText('{$loc/strs/classes/str[@id=concat('armory.classes.class.',current()/@classId)]}');" 
                    src="images/icons/class/{current()/@classId}.gif" />

                <h6><a href="character-sheet.xml?{@url}"><xsl:value-of select="@name" /></a></h6>&#160;(<xsl:value-of select="@level" />) -
                <span class="char-realm"><xsl:value-of select="current()/@realm" /></span>                        
            </div>                
        </xsl:for-each>        
    </xsl:if>    

    <!-- show text to indicate empty character slots -->
    <xsl:choose>
    	<xsl:when test="count(/page/characters/character/@selected) = '1'">         	
        	<div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
            <div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
            <div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
            <div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
        </xsl:when>
    	<xsl:when test="count(/page/characters/character/@selected) = '2'">
        	<div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
            <div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
            <div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
        </xsl:when>
    	<xsl:when test="count(/page/characters/character/@selected) = '3'">
        	<div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
            <div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
        </xsl:when>
    	<xsl:when test="count(/page/characters/character/@selected) = '4'">
        	<div class="select-char2"><h6><xsl:value-of select="$loc/strs/character-select/str[@id='availableSlot']"/></h6></div>
        </xsl:when>
    </xsl:choose>	
</xsl:template>

<xsl:template match="characters">
    <div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">
                    <div class="full-list notab">
                        <div class="info-pane">
                            <xsl:call-template name="charactersTable">
                                <xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-armory.xml')"/>
                            </xsl:call-template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>


</xsl:stylesheet>