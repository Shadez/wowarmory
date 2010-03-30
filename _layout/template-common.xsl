<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:variable name="pageType" select="/page/@type"/>

<!-- NOTE: taken from p. 41-42 of XSLT Cookbook (c) 2006 O'Reilly Media, Inc. -->
<xsl:template name="search-and-replace">
	<xsl:param name="input" />
	<xsl:param name="search-string" />
	<xsl:param name="replace-string" />
	<xsl:choose>
		<!-- See if the input contains the search string -->

		<xsl:when test="$search-string and contains($input, $search-string)">
		<!-- If so, then concatenate the substring before the search
		    string to the replacement string and to the result of
		    recursively applying this template to the remaining substring.
		-->
			<xsl:value-of select="substring-before($input, $search-string)" />
			<xsl:value-of select="$replace-string"/>
			<xsl:call-template name="search-and-replace">
				<xsl:with-param name="input" select="substring-after($input, $search-string)" />
				<xsl:with-param name="search-string" select="$search-string" />
				<xsl:with-param name="replace-string" select="$replace-string" />
			</xsl:call-template>

		</xsl:when>
		<xsl:otherwise>
			<!-- There are no more occurrences of the search string so
			    just return the current input string -->
			<xsl:value-of select="$input" />
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="dropdownMenu">
    <xsl:param name="defaultValue" />

    <xsl:param name="hiddenId" />
    <xsl:param name="divClass" />
    <xsl:param name="anchorClass" />    
    <xsl:param name="dropdownList" />

	<script type="text/javascript">
		var varOver<xsl:value-of select ="$hiddenId" /> = 0;

		function dropdownMenuToggle(whichOne){
			theStyle = document.getElementById(whichOne).style;
	
			if (theStyle.display == "none")	theStyle.display = "block";
			else							theStyle.display = "none";	
		}
	</script>
    
	<div class="{$divClass}" onMouseOver="javascript: varOver{$hiddenId} = 1;" onMouseOut="javascript: varOver{$hiddenId} = 0;">

		<a class="{$anchorClass}" id="display{$hiddenId}" href="javascript: document.formDropdown{$hiddenId}.dummy{$hiddenId}.focus();">
			<xsl:value-of select = "$defaultValue" />
		</a>
	</div>
	<div style="position: relative;">
		<div style="position: absolute;">
			<form name="formDropdown{$hiddenId}" id="formDropdown{$hiddenId}" style="height: 0px;">
				<input type="button" id="dummy{$hiddenId}" onFocus="javascript: dropdownMenuToggle('dropdownHidden{$hiddenId}');" onBlur="javascript: if(!varOver{$hiddenId}) document.getElementById('dropdownHidden{$hiddenId}').style.display='none';" size="2" style = "position: relative; left: -5000px;"/>
			</form>

		</div>
	</div>
</xsl:template>

<xsl:template name="positionSuffix">
   <xsl:param name="pos"/>
   <xsl:choose>
     <xsl:when test="($pos = 1) "><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.1st']"/></xsl:when>
     <xsl:when test="($pos mod 10 &gt; 3) or ($pos mod 10 = 0) or (($pos mod 100 &gt;= 11) and ($pos mod 100 &lt;= 13)) "><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.th']"/></xsl:when>
     <xsl:when test="($pos mod 10 = 1) "><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.st']"/></xsl:when>

     <xsl:when test="($pos mod 10 = 2) "><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.nd']"/></xsl:when>
     <xsl:when test="($pos mod 10 = 3) "><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.rd']"/></xsl:when>
     <xsl:otherwise><xsl:value-of select="$loc/strs/arena/arenaLadderData/str[@id='armory.arena-ladder-data.th']"/></xsl:otherwise>
   </xsl:choose>
</xsl:template>



<!-- ######## Flash Template (used for flash objects) ################################################ -->
<xsl:template match="flash" >
    <xsl:call-template name="flash">
            <xsl:with-param name="id" select="@id"></xsl:with-param>

            <xsl:with-param name="width" select="@width"></xsl:with-param>
            <xsl:with-param name="height" select="@height"></xsl:with-param>    
            <xsl:with-param name="src" select="@src"></xsl:with-param>
            <xsl:with-param name="quality" select="@quality"></xsl:with-param>
            <xsl:with-param name="base" select="@base"></xsl:with-param>
            <xsl:with-param name="flashvars" select="@flashvars"></xsl:with-param>
            <xsl:with-param name="bgcolor" select="@bgcolor"></xsl:with-param>
            <xsl:with-param name="menu" select="@menu"></xsl:with-param>
            <xsl:with-param name="wmode" select="@wmode"></xsl:with-param>

    </xsl:call-template>
</xsl:template>



<xsl:template name="flash">
    <xsl:param name="id" />
    <xsl:param name="width" />
    <xsl:param name="height" />
    <xsl:param name="src" />
    <xsl:param name="quality" />

    <xsl:param name="base" select="''" />
    <xsl:param name="flashvars" />
    <xsl:param name="bgcolor" />
    <xsl:param name="menu" />
    <xsl:param name="wmode" />
    <xsl:param name="noflash" />
    

		<div id="{$id}" style="display:none;"></div>
		<script type="text/javascript">
		var flashId="<xsl:value-of select='$id'/>";
		if ((Browser.safari &amp;&amp; flashId=="flashback") || (Browser.linux &amp;&amp; flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("<xsl:value-of select='$id'/>", "<xsl:value-of select='$src'/>", "<xsl:value-of select='$wmode'/>", "<xsl:value-of select='$menu'/>", "<xsl:value-of select='$bgcolor'/>", "<xsl:value-of select='$width'/>", "<xsl:value-of select='$height'/>", "<xsl:value-of select='$quality'/>", "<xsl:value-of select='$base'/>", "<xsl:value-of select='$flashvars'/>", "<xsl:value-of select='$noflash'/>")
		
		</script>	
	

</xsl:template>

<xsl:template name="printMoneyGold">
    <xsl:param name="money" />
    <xsl:if test="$money &gt;= 10000"><xsl:value-of select="floor($money div 10000)" /></xsl:if>
</xsl:template>

<xsl:template name="printMoneySilver">
    <xsl:param name="money" />
    <xsl:if test="($money &gt;= 100) and floor(($money div 100) mod 100) != 0"><xsl:value-of select="floor(($money div 100) mod 100)" /></xsl:if>
</xsl:template>

<xsl:template name="printMoneyCopper">

    <xsl:param name="money" />
    <xsl:if test="($money &gt;= 0) and ($money mod 100 != 0)"><xsl:value-of select="$money mod 100" /></xsl:if>
</xsl:template>

<!-- for tabs -->
<xsl:template name="tabs">

	<xsl:param name="tabGroup" />
	<xsl:param name="currTab" />
	<xsl:param name="subTab" />	
	<xsl:param name="tabUrlAppend" />
	<xsl:param name="subtabUrlAppend" />

	<xsl:variable name="tabData" select="document('nav/tabs.xml')/tabGroups/tabGroup[@id=$tabGroup]" />
	<xsl:variable name="guildName" select="/page/characterInfo/character/@guildName" />

	<!-- print top-level tabs -->
	<div class="tabs"> 
		<xsl:for-each select="$tabData/tab">

			<xsl:variable name="displayed">
				<xsl:choose>
					<xsl:when test="../@id = 'character' and @id = 'guild' and $currTab = 'character'">

						<xsl:choose>
							<xsl:when test="$guildName != ''">
								1
							</xsl:when>
							<xsl:otherwise>
								0
							</xsl:otherwise>
						</xsl:choose>
					</xsl:when>
					<xsl:otherwise>

					<xsl:choose>
			
						<xsl:when test="not(exclude/@region =$region)">
								1
						</xsl:when>
						<xsl:otherwise>
								0
						</xsl:otherwise>
					</xsl:choose>

					</xsl:otherwise>

				</xsl:choose>
			</xsl:variable>
			
			<xsl:if test="$displayed = 1">
				<div id="tab_{@id}" class="tab">
					<xsl:if test="@id = $currTab">
						<xsl:attribute name="class">selected-tab</xsl:attribute>
					</xsl:if>
					<a href="{@href}?{$tabUrlAppend}">

						<xsl:if test="$tabUrlAppend = ''">
							<xsl:attribute name="href"><xsl:value-of select="@href" /></xsl:attribute>
						</xsl:if>
						<xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@key]" />
					</a>
				</div>
			</xsl:if>
		</xsl:for-each>
		<div class="clear"></div>

	</div>
	
	<!-- sub tabs -->
	<xsl:choose>
		<xsl:when test="$tabData/tab[@id=$currTab]/subTab">
			<div class="subTabs">			
				<!-- corners -->
				<div class="upperLeftCorner"></div>
				<div class="upperRightCorner"></div>			
				
				<xsl:variable name="numArenaTeams" select="count(/page/characterInfo/character[1]/arenaTeams/arenaTeam)" />
				
				<!-- loop through subtabs -->

				<xsl:for-each select="$tabData/tab[@id=$currTab]/subTab">
					<xsl:choose>
						<!-- special case for character and arena teams -->
						<xsl:when test="@id='arena'">
							<xsl:if test="$numArenaTeams &gt; 0">
								<a href="{@href}?{$subtabUrlAppend}">
									<xsl:attribute name="class">
										<xsl:choose>
											<xsl:when test="@id = $subTab">

												selected-subTab<xsl:if test="@login = 'true'"> selected-subTabLocked</xsl:if>													
											</xsl:when>
											<xsl:when test="@login = 'true'">
												subTabLocked
											</xsl:when>
										</xsl:choose>
									</xsl:attribute>
									<span><xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@key]" /></span>

								</a>
							</xsl:if>
						</xsl:when>
						<xsl:otherwise>							
							<a id="{@id}_subTab" href="{@href}?{$subtabUrlAppend}">
								<xsl:if test="$subtabUrlAppend = ''">
									<xsl:attribute name="href"><xsl:value-of select="@href" /></xsl:attribute>
								</xsl:if>
								<xsl:if test="@onclick">

									<xsl:if test="not(@href)">
										<xsl:attribute name="href">javascript:;</xsl:attribute>
									</xsl:if>
									<xsl:attribute name="onclick"><xsl:value-of select="@onclick" /></xsl:attribute>
								</xsl:if>
								<xsl:attribute name="class">
									<xsl:choose>
										<xsl:when test="@id = $subTab">

											selected-subTab<xsl:if test="@login = 'true'"> selected-subTabLocked</xsl:if>													
										</xsl:when>
										<xsl:when test="@login = 'true'">
											subTabLocked
										</xsl:when>
									</xsl:choose>
								</xsl:attribute>
								<span><xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@key]" /></span>

							</a>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:for-each>			
			</div>
		</xsl:when>
		<xsl:otherwise>
			<div class="subTabs" style="height: 1px;">
				<div class="upperLeftCorner" style="height: 5px;"></div>

				<div class="upperRightCorner" style="height: 5px;"></div>			
			</div>	
		</xsl:otherwise>
	</xsl:choose>	
</xsl:template>

<xsl:template name="replace-string-news">
	<xsl:param name="text"/>
	<xsl:param name="replace"/>
	<xsl:param name="with"/>
	
	<xsl:choose>

		<xsl:when test="contains($text,$replace)">
			<xsl:value-of select="substring-before($text,$replace)"/>
			<xsl:value-of select="$with"/>
			<xsl:call-template name="replace-string-news">
				<xsl:with-param name="text" select="substring-after($text,$replace)"/>
				<xsl:with-param name="replace" select="$replace"/>
				<xsl:with-param name="with" select="$with"/>
			</xsl:call-template>
		</xsl:when>

		<xsl:otherwise>
			<xsl:value-of select="$text"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template match="news/achievement">
<xsl:param name="feedtxt"/>
<xsl:param name="lvl80pos"/>
     <xsl:if test="../@icon = 'regionFirst'">
         <div><b style="color:white">

        <xsl:call-template name="replace-string-news">
        <xsl:with-param name="text" select="@title"/>
        <xsl:with-param name="replace" select="$loc/strs/achievements/str[@id='realmfirst']"/>
        <xsl:with-param name="with" select="$loc/strs/achievements/str[@id='achievementfirst']"/>
        </xsl:call-template>
        </b> - <span class="timestamp-news" style="display:none"><xsl:value-of select="../@posted"/></span></div>
    </xsl:if>
    <div>

    <xsl:variable name="skey">
        <xsl:choose>
        <xsl:when test="contains(@key,'.grand.master')">realm.first.grand.master.profession</xsl:when>
        <xsl:when test="contains(@key,'.level.80.')">realm.first.level.80.classrace</xsl:when>
        <xsl:when test="count(guild) = 1">
        <xsl:value-of select="@key"/>.single</xsl:when>
        <xsl:otherwise><xsl:value-of select="@key"/></xsl:otherwise>

        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="textkey" select="concat(../@icon,'.',$skey)"/>
    <xsl:apply-templates select="$feedtxt/strs/str[@id=$textkey]" mode="printf">
    <xsl:with-param name="param1">
        <xsl:choose>
            <xsl:when test="character"><a href="character-sheet.xml?{character/@url}"><xsl:value-of select="character/@name"/></a></xsl:when>
            <xsl:otherwise>

            <xsl:for-each select="guild">

            <xsl:choose>
                <xsl:when test="@name=''"><xsl:value-of select="$loc/strs/achievements/str[@id='solo']"/></xsl:when>
                <xsl:otherwise><a href="guild-info.xml?{@guildUrl}">&lt;<xsl:value-of select="@name"/>&gt;</a></xsl:otherwise>
                </xsl:choose>
                (<xsl:value-of select="@count"/>)<xsl:choose><xsl:when test="position() &lt; last() - 1">, </xsl:when><xsl:when test="position()=last()"></xsl:when><xsl:otherwise> <xsl:text> </xsl:text> <xsl:value-of select="$loc/strs/achievements/str[@id='achv.and']"/><xsl:text> </xsl:text> </xsl:otherwise>

            </xsl:choose>
            </xsl:for-each>

            </xsl:otherwise>
        </xsl:choose>
    </xsl:with-param>
    <xsl:with-param name="param2">
        <a href="achievement-firsts.xml?r={@realm}"><xsl:value-of select="@realm"/></a>
    </xsl:with-param>

    <xsl:with-param name="param3">
      <xsl:choose>
       <xsl:when test="contains(@key,'.grand.master')">
        <xsl:variable name="typekey" select="concat(substring-after(substring-after(@key,'.'),'.'),'.type')"/>
        <xsl:value-of select="$feedtxt/strs/str[@id=$typekey]"/>
       </xsl:when>
       <xsl:when test="contains(@key,'.level.80.')">
        <xsl:variable name="classracekey" select="concat(substring(@key,22),'.name')"/>
        <xsl:value-of select="$feedtxt/strs/str[@id=$classracekey]"/>

       </xsl:when>

       </xsl:choose>
    </xsl:with-param>

    </xsl:apply-templates>
    <xsl:if test="../@icon != 'regionFirst'"> - <span class="timestamp-news" style="display:none"><xsl:value-of select="../@posted"/></span></xsl:if>
    </div>
</xsl:template>


<xsl:template match="news/story">
    <xsl:if test="not(contains(../@exclude, $region))">
	<div>
		<b style="color:white"><xsl:value-of select="@title"/></b> -
		<span class="timestamp-news" style="display:none"><xsl:value-of select="../@posted"/></span>
	</div>
	<div><xsl:apply-templates /></div>
	</xsl:if>

</xsl:template>


<!--related info start-->
<xsl:template name="related-info">
	<xsl:param name="src" />
	
	<xsl:for-each select="document($src)/relatedinfo">
		<div class="module-block-left">
			<xsl:if test="$pageType='front'">
				<xsl:variable name="nfeed" select="document(concat('../newsfeed.xml?loc=',$lang))"/>
				<xsl:variable name="feedtext" select="document(concat('../_content/',$lang,'/achievements_feed.xml'))"/>

				<xsl:variable name="level80pos" select="$feedtext/strs/str[@id='level80pos']" />
				
				<xsl:if test="$nfeed/page/news">
					<div class="armory-firsts">
						<div class="module">
							<h1><xsl:value-of select="$loc/strs/common/str[@id='related-info.header.updates']"/></h1>
							<div class="module-lite news_feed">
								<xsl:for-each select="$nfeed/page/news">
									<div class="news_upd">
										<img src="images/news_{@icon}.png" class="p news_icon"/>

										<xsl:apply-templates>
											<xsl:with-param name="feedtxt" select="$feedtext"/>
											<xsl:with-param name="lvl80pos" select="$level80pos"/>
										</xsl:apply-templates>
                        			</div>
								</xsl:for-each>
							</div>
						</div>

					</div>
					<script type="text/javascript">
						L10n.formatTimestamps("span.timestamp-news", <xsl:value-of select="$loc/strs/achievements/str[@id='date.format']"/>);
					</script>
				</xsl:if>
			</xsl:if>

			<div class="rinfo">
				<div class="module">

					<h1><xsl:value-of select="$loc/strs/common/str[@id='related-info.header.faq']"/></h1>
					<div class="faq">
						<div class="rlbox2">
							<div class="module-lite">
								<div class="faq-links">
									<ol>
										<xsl:for-each select="/relatedinfo/faqlist/faq[not(contains(@exclude, $region))]">
											<xsl:variable name="positionNum"><xsl:number value="position()" format="1" /></xsl:variable>
											<li><a href="javascript:faqSwitch({$positionNum});" class="faq-off" id="faqlink{$positionNum}"><xsl:value-of select="@question"/></a></li>

										</xsl:for-each>
									</ol>
								</div>
							</div>
							<div class="module-lite" style="margin-top:5px">
								<div class="speak-bubble">
									<xsl:for-each select="/relatedinfo/faqlist/faq">
										<div id="faq{position()}" style="display:none;">
											<h2><xsl:value-of select="@question"/></h2>

											<xsl:apply-templates/>
										</div>
									</xsl:for-each>
									<div class="faq-desc">
										<div id="faq-container"></div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="module-block-right">
			<xsl:if test="$region != 'CN' and $region != 'TW' and $lang != 'zh_cn' and $lang != 'zh_tw'">
				<div style="margin: 0 0 10px 0">
					<xsl:call-template name="flash">

						<xsl:with-param name="id" select="'mobile_armory_banner'"/>
						<xsl:with-param name="src" select="concat('images/',$lang,'/flash/mobile_armory_banner.swf')"/>
						<xsl:with-param name="wmode" select="'transparent'"/>
						<xsl:with-param name="width" select="'300'"/>
						<xsl:with-param name="height" select="'175'"/>
						<xsl:with-param name="border" select="'1'"/>
						<xsl:with-param name="quality" select="'best'"/>
						<xsl:with-param name="flashvars" select="concat('linkUrl=', 'iphone.xml')"/>
					</xsl:call-template>

				</div>
			</xsl:if>
			<div class="rinfo">
				<div class="module">
					<h1><xsl:value-of select="$loc/strs/common/str[@id='related-info.header.related-links']"/></h1>
					<div id="noflash-message" class="related-links">
						<div class="module-lite">
							<div class="rlbox1">
								<p>

									<b class="noflash"><xsl:value-of select="$loc/strs/common/str[@id='related-info.header.noflash']"/></b><br/>
									<a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" target="_blank" class="noflash"><img src="images/{$lang}/getflash.gif" class="p" align="right"/></a>
									<xsl:value-of select="$loc/strs/common/str[@id='related-info.noflash']"/>
								</p>
							</div>
						</div>
					</div>
					<div class="related-links">
						<div class="module-lite">

							<ul>
								<xsl:for-each select="/relatedinfo/relatedlinks/relatedlink">
									<xsl:choose>
										<xsl:when test="@type = 'hr'"><div class="hr"></div></xsl:when>
										<xsl:otherwise>
											<li>
												<xsl:attribute name="class">
													<xsl:choose>
														<xsl:when test="@type = 'new'">relatedlinknew</xsl:when>

														<xsl:when test="@type = 'external'">external</xsl:when>
														<xsl:when test="@type = 'report'">report</xsl:when>
													</xsl:choose>
												</xsl:attribute>
												<xsl:choose>
													<xsl:when test="@type = 'external'">
														<a href="{@url}" class="staticTip" onmouseover="setTipText('{$loc/strs/common/str[@id='external-link']}')" target="_blank"><xsl:value-of select="@name"/></a>
													</xsl:when>

													<xsl:when test="@type = 'report'">
														<a id="reportLinkError" class="staticTip" href="{@url}" onmouseover="setTipText('{$loc/strs/common/str[@id='report-error']}')"><xsl:value-of select="@name"/></a>
														<script type="text/javascript">
															fixReportLink("reportLinkError", "<xsl:value-of select="$loc/strs/common/str[@id='url.armory']"/>");
														</script>
													</xsl:when>
													<xsl:when test="@type = 'translation'">
														<a id="reportLinkTranslation" href="{@url}" class="staticTip" onmouseover="setTipText('{$loc/strs/common/str[@id='report-translation']}')" target="_blank"><xsl:value-of select="@name"/></a>
														<script type="text/javascript">

															fixReportLink("reportLinkTranslation", "<xsl:value-of select="$loc/strs/common/str[@id='url.armory']"/>");
														</script>
													</xsl:when>
													<xsl:when test="@type = 'hr'"><em></em></xsl:when>
													<xsl:otherwise>
														<a href="{@url}"><xsl:value-of select="@name"/></a>
													</xsl:otherwise>
												</xsl:choose>
											</li>

										</xsl:otherwise>
									</xsl:choose>
								</xsl:for-each>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>		
		<script type="text/javascript">

			faqSwitch(currentFaq);
		</script>
	</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
