<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="language.xsl"/>

<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="nav/menu.xsl" />
<xsl:include href="nav/user-menu.xsl" />
<xsl:include href="template-common.xsl"/>

<!-- battlegroups list -->
<xsl:variable name="bgXML" select="document('../battlegroups.xml')/page/battlegroups" />

<!--page start-->
<xsl:template match="@*|node()">
<xsl:copy>
	  <xsl:apply-templates select="@*|node()"/>

</xsl:copy>
</xsl:template>

<xsl:template match="processing-instruction()"/>

<xsl:template name="head-content"/>

<xsl:template match="page">
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
    <link rel="search" type="application/opensearchdescription+xml" href="../_content/{$lang}/searchplugin.xml" title="{$loc/strs/common/str[@id='the-wow-armory']}" />
	<title><xsl:value-of select="$loc/strs/common/str[@id='the-wow-armory']"/>
        <xsl:if test="tabInfo/@tab = 'character'" > - <xsl:value-of select="characterInfo/character/@name"/> @ <xsl:value-of select="characterInfo/character/@realm"/> - <xsl:variable name="tablabel" select="concat('armory.tabs.',tabInfo/@subTab)"/><xsl:value-of select="$loc/strs/unsorted/str[@id=$tablabel]"/></xsl:if>

        <xsl:if test="tabInfo/@tab = 'guild'" > - <xsl:value-of select="guildInfo/guildHeader/@name"/> @ <xsl:value-of select="guildInfo/guildHeader/@realm"/> - <xsl:variable name="tablabel" select="concat('armory.tabs.',tabInfo/@subTab)"/><xsl:value-of select="$loc/strs/unsorted/str[@id=$tablabel]"/></xsl:if>
        <xsl:if test="@title"> - <xsl:variable name="titlestringid" select="concat('armory.title.',@title)"/><xsl:value-of select="$loc/strs/str[@id=$titlestringid]"/></xsl:if>
    </title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<meta name="description" content="{$loc/strs/common/str[@id='meta-description']}" />
	<style type="text/css" media="screen, projection">
		@import "_css/master.css";
		@import "shared/global/menu/topnav/topnav.css";
		<xsl:if test="not(/page/pageIndex)">
			@import "_css/int.css";
		</xsl:if>
		@import "_css/_lang/<xsl:value-of select="$lang"/>/language.css";
		@import "_css/_region/<xsl:value-of select="translate($region,'CEKNORSTUW','ceknorstuw')"/>/region.css";
	</style>
   
	<script type="text/javascript" src="shared/global/third-party/jquery/jquery.js"></script>

    <script type="text/javascript" src="shared/global/third-party/jquery/datefunctions.js"></script>
    <script type="text/javascript" src="shared/global/third-party/jquery/jquery.datepicker.js"></script>
    <script type="text/javascript" src="shared/global/third-party/jquery/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="shared/global/third-party/jquery/jquery.tablesorter.pager.js"></script>
	<script type="text/javascript" src="shared/global/third-party/jquery/jquery.bgiframe.min.js"></script>	
    <script type="text/javascript" src="shared/global/third-party/jquery/jquery.color.js"></script>
	<script type="text/javascript" src="shared/global/third-party/sarissa/0.9.9.3/sarissa.js"></script>
	<script type="text/javascript" src="_js/common.js"></script>
	<script type="text/javascript" src="_js/armory.js"></script>

	<script type="text/javascript" src="http://ads1.msn.com/library/dap.js"></script> <!-- MS Ad code-->
	
    <!-- After JavaScript, before browser-specific CSS addition -->
	<xsl:call-template name="head-content"/>
	
	<script type="text/javascript">
		/* <![CDATA[ */
		if(Browser.iphone && Number(getcookie2("mobIntPageVisits")) < 3 && getcookie2("hasSeenMobInt") == ""){
			setcookie("mobIntPageOrigin",window.location.href,"session");
			window.location.href = "mobile-armory-splash.xml";
		}
		/* ]]>*/
	</script>
	
	<script type="text/javascript">
		//browser detection		
		if($.browser.msie){
			if($.browser.version == "8.0")		addStylesheet('_css/browser/ie8.css');
			if($.browser.version == "7.0")		addStylesheet('_css/browser/ie7.css');
			if($.browser.version == "6.0")		addStylesheet('_css/browser/ie.css');
		}else if($.browser.mozilla){
			if(parseFloat($.browser.version) &lt;= 1.9)	addStylesheet('_css/browser/firefox2.css');
		}else if($.browser.opera)				addStylesheet('_css/browser/opera.css');
		else if($.browser.safari)				addStylesheet('_css/browser/safari.css');

		//set global login var
		var isLoggedIn = ("<xsl:value-of select="document('../login-status.xml')/page/loginStatus/@username"/>" != '');
		var bookmarkToolTip = "<xsl:value-of select="$loc/strs/common/str[@id='user.bookmark.tooltip']"/>";

		var isHomepage 		 = ("<xsl:value-of select="not(/page/pageIndex)" />" != "true");
		var globalSearch 	 = "<xsl:value-of select = "@globalSearch" />";
		var theLang 		 = "<xsl:value-of select="/page/@lang"/>";
		var region 			 = "<xsl:value-of select="$region" />"; //in language.xsl DO NOT REMOVE
		
		var regionUrl = {
			armory: 	"<xsl:value-of select="$regionArmoryURL" />",
			forums: 	"<xsl:value-of select="$regionForumsURL" />",
			wow: 		"<xsl:value-of select="$regionWoWURL" />"
		}	

		/* <![CDATA[ */		
		$(document).ready(function() {			
			initializeArmory(); //initialize the armory!
		});		
		/* ]]>*/		
	</script>

</head>

<body>
	<form id="historyStorageForm" method="GET">
		<textarea id="historyStorageField" name="historyStorageField"></textarea>
	</form>

	<script type="text/javascript" src="_js/_lang/{$lang}/strings.js"></script>
	<!-- javascript variable used by shared project -->
	<script type="text/javascript">global_nav_lang = '<xsl:value-of select="/page/@lang"/>'</script>

	<div id="shared_topnav" class="tn_armory"><script src="shared/global/menu/topnav/buildtopnav.js"></script></div>
	
	<!-- containers-->
	<div class="outer-container">
		
	  <div class="inner-container">
		<xsl:choose>
			<xsl:when test="/page/pageIndex"><!-- *HOME PAGE TEMPLATE -->
				<div id="replaceMain">
					<xsl:apply-templates />
				</div>

			</xsl:when>
			<xsl:otherwise><!-- *INTERIOR PAGES TEMPLATE -->
				<div class="int-top">
					<div class="logo">
						<a href="index.xml"><span><xsl:value-of select="$loc/strs/common/str[@id='the-wow-armory']"/></span></a>
					</div>
					</div>
                    <div class="int">
                        <div class="search-bar">
                            <div class="module">
                                <div class="search-container">
                                    <xsl:call-template name="searchInput"/>
                                </div>

                                <div class="login-container">
                                    <xsl:call-template name="loginLogoutLink"/>
                                </div>
                            </div>
                        </div>
                        <div class="data-container">
                            <div class="data-shadow-top"><xsl:comment/></div>
                                <div class="data-shadow-sides">
                                    <div class="parch-int">

                                        <div class="parch-bot">
                                            <div id="replaceMain">
                                                <xsl:apply-templates />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="data-shadow-bot"><xsl:comment/></div>
                        </div>

                        <div class="page-bot"></div>
                        <xsl:call-template name="relatedContainer"/>
                </div>
			</xsl:otherwise>
		</xsl:choose>
	</div>
		<xsl:call-template name="footer"/>
	</div>

	<!-- NEW TOOLTIP -->
	<div id="globalToolTip">
		<table>
			<tr>
				<td class="tl"><em></em></td><td class="tm"></td><td class="tr"><em></em></td>
			</tr>
			<tr>
				<td class="ml"></td><td class="mm" valign="top"><div id="globalToolTip_text"></div></td><td class="mr"></td>
			</tr>

			<tr>
				<td class="bl"><em></em></td><td class="bm"></td><td class="br"><em></em></td>
			</tr>
		</table>
	</div>

	<div id="output"></div>
	<div id="blackout" style="display:none"></div>
</body>
</html>
</xsl:template>

<xsl:template name="searchInput">
	<div class="search-module">
		<em class="search-icon"></em>

		<form name="formSearch" action="search.xml" method="get" onSubmit="return menuCheckLength(document.formSearch);">
			<input id="armorySearch" type="text" name="searchQuery" value="" size="16" maxlength="72" onkeypress="$('#formSearch_errorSearchLength').html('')" />
			<a href="#" class="submit" onclick="menuCheckLength(document.formSearch); return false;">
				<span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.search']"/></span>
			</a>
			<div id="errorSearchType"></div>
			<div id="formSearch_errorSearchLength"></div>
			<input type="hidden" name="searchType" value="all" />
		</form>

		<div class="navigation">
			<iframe id="iframeNav" src="javascript:'';" marginwidth="0" marginheight="0" align="bottom" 
				scrolling="no" style="" frameborder="1">
			</iframe>
			<xsl:apply-templates mode="createNavMenu" select="document('nav/menu.xml')" />
		</div>
	</div>
</xsl:template>

<xsl:template name="footer">

	<div id="languageFooter" class="language">

		<div class="module">
			<em><xsl:value-of select="$loc/strs/common/str[@id='labels.selectlanguagecolon']"/></em>
			
			<!-- get languages from server -->
			<xsl:variable name="languageLinks" select="document('../data/languages.xml')" />
			
			<xsl:for-each select="$languageLinks/languages/language">
				<a href="?locale={@loc}" class="langLink">
					<xsl:if test="@loc = $lang">
						<xsl:attribute name="class">langLink select</xsl:attribute>

					</xsl:if>
					<xsl:value-of select="@n" />
				</a>
				<xsl:if test="not(position() = last())"><span>|</span></xsl:if>	
			</xsl:for-each>
			
			<br/>
			
			<em><xsl:value-of select="$loc/strs/common/str[@id='labels.selectregioncolon']"/></em>
			<xsl:for-each select="$loc/strs/region/str">
				<a href="{@url}">

				<xsl:attribute name="class">
					<xsl:if test="starts-with($region,@id)">select</xsl:if>
				</xsl:attribute>
				<xsl:value-of select="@name"/></a><span>|</span>
			</xsl:for-each>
		</div>
	</div>

	<div class="footer">
		<a href="{$loc/strs/common/str[@id='url.blizzard']}" class="blizzard"></a>
		<p>
			<a href="{$loc/strs/common/str[@id='url.privacy']}"><xsl:value-of select="$loc/strs/common/str[@id='labels.privacy']"/></a><br/>
			<a href="{$loc/strs/common/str[@id='url.legalfaq']}"><xsl:value-of select="$loc/strs/common/str[@id='labels.copyright']"/></a><br/>
			<xsl:value-of select="$loc/strs/common/str[@id='labels.proprietary']"/>
		</p>
		<xsl:if test="$region = 'US'">
			<div id="legalicon-container" style="display:block; ">

				<a href="{$loc/strs/esrb/str[@id='privacyurl']}" target="_blank" class="legalicon3"/>
				<a href="{$loc/strs/esrb/str[@id='ratingsurl']}" target="_blank" class="legalicon"/>
				<a href="{$loc/strs/esrb/str[@id='ratingsurl']}" target="_blank" class="legalicon2"/>
			</div>
		</xsl:if>
		<div class="clear"><xsl:comment/></div>
	</div>
</xsl:template>


<!-- Localization Ordering Template -->
<xsl:template name="stringorder">
	<xsl:param name="orderid"/>
	<xsl:param name="datainsert1"/>
	<xsl:param name="datainsert2"/>
	<xsl:param name="datainsert3"/>
	<xsl:param name="datainsert4"/>
	<xsl:param name="ResultsInputPaging"/>
	<xsl:param name="selectTeamType"/>

	<xsl:for-each select="$loc/strs/order[@id=$orderid]/str">
	<xsl:variable name="nodecount" select="count($loc/strs/order[@id=$orderid]/str)"/>
	<xsl:variable name="positionNum" select="position()"/>
		<span>
			<xsl:attribute name="class">
			<xsl:choose>
				<xsl:when test="@format = 'italic'">italic</xsl:when>
				<xsl:when test="@format = 'bold'">bold</xsl:when>

			</xsl:choose>
			</xsl:attribute>

			<xsl:choose>
				<xsl:when test="@id">
					<xsl:variable name="comparestring" select="@id"/>
					<xsl:value-of select="../../str[@id=$comparestring]"/>
				</xsl:when>
				<xsl:when test="@select='datainsert1'">

					<xsl:value-of select="$datainsert1"/>
				</xsl:when>
				<xsl:when test="@select='datainsert2'">
					<xsl:value-of select="$datainsert2"/>
				</xsl:when>
				<xsl:when test="@select='datainsert3'">
					<xsl:value-of select="$datainsert3"/>
				</xsl:when>
				<xsl:when test="@select='datainsert4'">

					<xsl:value-of select="$datainsert4"/>
				</xsl:when>
				<xsl:when test="@select='ResultsInputPaging'">
					<input type="text" value="{$datainsert2}" onkeypress="{{return {$datainsert3}.pageSearchOnKeyPress(event)}}" size="3" class="pagesInput" onfocus="this.value=''" onblur="if (this.value=='') this.value='{$datainsert2}'" />
				</xsl:when>
				<xsl:when test="@select='selectTeamType'">
					<a href="javascript:selectTeamTypePageInstance.goToNextPage({$selectTeamType})" title="{$datainsert1}"><span><xsl:value-of select="$datainsert1"/></span></a>
				</xsl:when>
			</xsl:choose>

			<xsl:choose>
				<xsl:when test="$positionNum&lt;$nodecount and @space">&#160;</xsl:when>
			</xsl:choose>
		</span>
	</xsl:for-each>

</xsl:template>

<!--errorpage start-->
<xsl:template name="errorSection">
	<div class="profile-wrapper">

		<blockquote><b class="iguilds"><h4><a href="index.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.armory']"/></a></h4><h3>
		<xsl:choose>
			<xsl:when test="/page/characterInfo/@errCode and /page/characterInfo/@errCode='forbidden'">
				<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.accessdenied']"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.errorencountered']"/>
			</xsl:otherwise>
		</xsl:choose>

		</h3></b></blockquote>


		<xsl:choose>
			<xsl:when test="/page/characterInfo/@errCode and /page/characterInfo/@errCode='forbidden'">
				<div class="filtercontainer" style="margin:50px auto 0;padding:6px; width:45%">
				<div class="bankcontentsfiltercontainer" style="width: 100%; text-align: center;">
					<div style="padding: 0pt 10px 10px;">
						<div class="guildloginmsg" style="padding-left:10px">
							<div class="guilderrortitle"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.accessdenied']"/></div>

							<xsl:apply-templates select="$loc/strs/unsorted/str[@id='armory.labels.protectedcontent']"/>
						</div>
					</div>
				</div>
				<div class="clearfilterboxsm"></div>
				</div>
				<div class="bottomshadowsm" style="height:50px"></div>
			</xsl:when>
			<xsl:when test="/page/characterInfo/@errCode and /page/characterInfo/@errCode='belowMinLevel'">

				<script type="text/javascript">document.getElementById('divCharTabs').style.display="none"</script>
				
					<div class="under10">
					<div class="bonus-stats">
					<table class="deco-frame">
					<thead>
					 <tr><td class="sl"></td><td class="ct st"></td><td class="sr"></td></tr>
					</thead>
					<tbody>

					 <tr><td class="sl"><b><em class="port"></em></b></td><td class="ct">
				
					<div class="kids">
					<h2><span><xsl:value-of select="$loc/strs/characterSheet/str[@id='armory.character-sheet.prompt.levelTen']"/></span></h2>
					<div class="levelBar-wrapper">
					  <div></div>
					</div>
					</div>
				
					  </td><td class="sr"><b><em class="star"></em></b></td></tr>
					</tbody>

					<tfoot>
					 <tr><td class="sl"></td><td class="ct sb" align="center"><b><em class="foot"></em></b></td><td class="sr"></td></tr>
					</tfoot>
					</table>
					</div><!--/bonus-stats/-->
					</div>
			</xsl:when>
			<xsl:when test="/page/characterInfo/@errCode and /page/characterInfo/@errCode='noCharacter'">
				<!-- no character -->

				<xsl:call-template name="noCharacter"/>
			</xsl:when>
			<xsl:when test="/page/guildInfo and not(/page/guildKey)">
				<!-- no guild -->
				<div class="filtercontainer" style="margin:50px auto;padding:6px; width:80%">
					<div class="bankcontentsfiltercontainer" style="width:100%; text-align: center;">
						<div style="padding:10px;">
							<div class="guildloginmsg" style="padding-left:10px">
								<div class="guilderrortitle"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.error.filenotfound']"/></div>

								<xsl:apply-templates select="$loc/strs/unsorted/str[@id='armory.labels.noguild']"/>
							</div>
						</div>
					</div>
					<div class="clearfilterboxsm"></div>
				</div>
			</xsl:when>
			<xsl:otherwise>
			<div class="error-message">

					<h3><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.erroroccured']"/></h3>
			</div>
			</xsl:otherwise>
		</xsl:choose>
	</div>
</xsl:template>

<xsl:template name="noCharacter">
    <div class="filtercontainer" style="margin:50px auto;padding:6px; width:80%">
        <div class="bankcontentsfiltercontainer" style="width:100%; text-align: center;">

            <div style="padding:10px;">
                <div class="guildloginmsg" style="padding-left:10px">
                    <div class="guilderrortitle"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.error.filenotfound']"/></div>
                    <xsl:apply-templates select="$loc/strs/unsorted/str[@id='armory.labels.nocharacter']"/>
                </div>
            </div>
        </div>
        <div class="clearfilterboxsm"></div>
    </div>

</xsl:template>


<xsl:template name="errorPageGeneral">
<span style="display:none;">start</span><!--needed to fix IE bug that ignores script includes-->

<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="mini-search-start-state" id="results-side-switch">
<div class="list">
<div class="full-list">
<div class="info-pane">

<div class="bigbaderror"><xsl:call-template name="errorSection" /></div>

</div>
<!--/end tip/-->
		</div>
<!--/end full-list/-->
	</div><!--/end list/-->
</div><!--/end results-side-expanded/-->
</div>
</div>
</div>
</xsl:template>

<xsl:template name="unavailable">

<br /><br />
<div class="generic-content">

<div class="related-links">
	<table>
		<tr>
			<td class="s-top-left" />
			<td class="s-top" />
			<td class="s-top-right" />
		</tr>
		<tr>
			<td class="s-left"><div class="shim stable" /></td>

			<td class="s-bg" style="padding: 20px;">
<div style="width: 100%; text-align: left; font-size:12px;">
<h5><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.character.refreshheader']"/></h5>
<br/>
<xsl:value-of select="$loc/strs/characterSheet/str[@id='armory.character.refresh']"/>
</div>

			</td>
			<td class="s-right"><div class="shim stable" /></td>
		</tr>
		<tr>
			<td class="s-bot-left" />

			<td class="s-bot" />
			<td class="s-bot-right" />
		</tr>
	</table>
<strong><a style="width: 300px;" href = "index.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.search.return']"/></a></strong>
</div><!--/end related-links/-->
</div>
</xsl:template>
<!--errorpage end-->

<xsl:template name="serverBusy">
<div class="generic-content">
<div class="related-links">

	<table>
		<tr>
			<td class="s-top-left" />
			<td class="s-top" />
			<td class="s-top-right" />
		</tr>
		<tr>
			<td class="s-left"><div class="shim stable" /></td>
			<td class="s-bg" style="padding: 20px;">

<div style="width: 100%; text-align: left; font-size:12px;">
<h5><xsl:value-of select="$loc/strs/serverBusy/str[@id='title']"/></h5>
<br/>
<xsl:value-of select="$loc/strs/serverBusy/str[@id='content']"/>
</div>

			</td>
			<td class="s-right"><div class="shim stable" /></td>
		</tr>
		<tr>
			<td class="s-bot-left" />
			<td class="s-bot" />

			<td class="s-bot-right" />
		</tr>
	</table>
<strong style = "float: right;"><a style="width: 300px;" href = "index.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.search.return']"/></a></strong>
<strong><a style="width: 300px;" href = "#" onclick = "javaScript:location.reload(true); return false;" ><xsl:value-of select="$loc/strs/serverBusy/str[@id='refreshpage']"/></a></strong>

</div><!--/end related-links/-->
</div>
</xsl:template>




<!-- number formatting templates and other stuff -->

<xsl:decimal-format name="eu_numberFormat" decimal-separator="," grouping-separator="." />
<xsl:decimal-format name="us_numberFormat" decimal-separator="." grouping-separator="," />
<!-- TODO: add a decimal-format definition for ko -->

<xsl:template name="formatNumber">
<xsl:param name="value"></xsl:param>
<xsl:choose>
	<xsl:when test="$value = 0">0</xsl:when>
	<xsl:otherwise>
	  <xsl:choose>
		<xsl:when test="$lang = 'en_us'">
		  <xsl:value-of select="format-number($value, '#,###', 'us_numberFormat')"/>

		</xsl:when>
		<xsl:when test="$lang = 'de_de' or $lang = 'en_gb' or $lang = 'es_es' or $lang = 'fr_fr' or $lang = 'ru_ru'">
		  <xsl:value-of select="format-number($value, '#.###', 'eu_numberFormat')"/>
		</xsl:when>
		<xsl:otherwise>
		  <xsl:value-of select="$value"/>
		</xsl:otherwise>
	  </xsl:choose>
	</xsl:otherwise>

</xsl:choose>
</xsl:template>


<!-- paging templates -->
<xsl:template name="pageLink">
<xsl:param name="linkPageNumber">10</xsl:param>
<xsl:param name="currentPageNumber">10</xsl:param>
<xsl:param name="objectName"></xsl:param>
<xsl:choose>
	  <xsl:when test="$linkPageNumber = $currentPageNumber">
		 <li><a class="sel"><xsl:value-of select="$linkPageNumber"/></a></li>
	  </xsl:when>

	  <xsl:otherwise>
		<li><a href="javascript:{$objectName}.setPageNumber({$linkPageNumber});" class="p">
		  <xsl:value-of select="$linkPageNumber"/>
		</a></li>
	  </xsl:otherwise>
</xsl:choose>
</xsl:template>

<xsl:template name="pageLinkLoop">
<xsl:param name="currentPageNumber">10</xsl:param>
<xsl:param name="start" >2</xsl:param>

<xsl:param name="stop" >50</xsl:param>
<xsl:param name="pageLinkStep">100</xsl:param>
<xsl:param name="numSurroundingPages">3</xsl:param>
<xsl:param name="objectName"></xsl:param>
	   <xsl:if test='$start &lt;= $stop'>
		  <xsl:if test='(($start mod $pageLinkStep) = 0) or (($start &gt; $currentPageNumber - $numSurroundingPages) and ($start &lt; $currentPageNumber + $numSurroundingPages))'>
			<xsl:call-template name="pageLink">
				<xsl:with-param name="currentPageNumber" select="$currentPageNumber"/>
				<xsl:with-param name="linkPageNumber" select="$start"/>

				<xsl:with-param name="objectName" select="$objectName"/>
			</xsl:call-template>
		  </xsl:if >
		  <xsl:call-template name="pageLinkLoop">
			  <xsl:with-param name="currentPageNumber" select="$currentPageNumber"/>
			  <xsl:with-param name="start" select="$start + 1"/>
			  <xsl:with-param name="stop" select="$stop"/>
			  <xsl:with-param name="pageLinkStep" select="$pageLinkStep"/>
			  <xsl:with-param name="objectName" select="$objectName"/>

		  </xsl:call-template>
	   </xsl:if>
</xsl:template>

<xsl:template name="pager">
<xsl:param name="minPageNumber" >1</xsl:param>
<xsl:param name="maxPageNumber" >50</xsl:param>
<xsl:param name="currentPageNumber">10</xsl:param>
<xsl:param name="objectName"></xsl:param>
	   <!-- print the first page link -->
	   <xsl:call-template name="pageLink">

		   <xsl:with-param name="currentPageNumber" select="$currentPageNumber"/>
		   <xsl:with-param name="linkPageNumber"  select="$minPageNumber"/>
		   <xsl:with-param name="objectName" select="$objectName"/>
	   </xsl:call-template>
	   <!-- if the min page is equal to (or greater than) the last page than we are done -->
	   <xsl:if test='$minPageNumber &lt; $maxPageNumber'>
		   <!-- algorithmically print up to the second to last page link -->
		   <xsl:call-template name="pageLinkLoop">
			   <xsl:with-param name="currentPageNumber" select="$currentPageNumber"/>

			   <xsl:with-param name="start">2</xsl:with-param>
			   <xsl:with-param name="stop" select="$maxPageNumber - 1"/>
			   <xsl:with-param name="objectName" select="$objectName"/>
		   </xsl:call-template>
		   <!-- print the last page link -->
		   <xsl:call-template name="pageLink">
			   <xsl:with-param name="currentPageNumber" select="$currentPageNumber"/>
			   <xsl:with-param name="linkPageNumber"  select="$maxPageNumber"/>

			   <xsl:with-param name="objectName" select="$objectName"/>
		   </xsl:call-template>
	   </xsl:if>
</xsl:template>

<xsl:template name="pageBar">
<xsl:param name="maxPageNumber">50</xsl:param>
<xsl:param name="currentPageNumber">10</xsl:param>
<xsl:param name="objectName"></xsl:param>

	<div class="paging">

		<div class="returned">
			<span>
			<!-- string ordering results inputtype paging -->
			<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.paging']">
				<xsl:with-param name="param1">
					<input type="text" value="{$currentPageNumber}" onkeypress="{{return {$objectName}.pageSearchOnKeyPress(event)}}" 
						size="3" class="pagesInput" onfocus="this.value=''" onblur="if (this.value=='') this.value='{$currentPageNumber}'" />
				</xsl:with-param>
				<xsl:with-param name="param2">
					<span style="font-weight: bold;"><xsl:value-of select="$maxPageNumber" /></span>

				</xsl:with-param>
			</xsl:apply-templates>
			</span>
		</div>
		<div class="pnav">
		<ul>
		  <!-- first page -->
		  <li>
		  <xsl:choose>

			<xsl:when test="$currentPageNumber = 1">
			  <a class="prev-first-off"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:when>
			<xsl:otherwise>
			  <a href="javascript:{$objectName}.setPageNumber(1);" class="prev-first"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:otherwise>
		  </xsl:choose>
		  </li>

		  <!-- prev page -->
		  <li>
		  <xsl:choose>
			<xsl:when test="$currentPageNumber &lt;= 1">
			  <a class="prev-off"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:when>
			<xsl:otherwise>
			  <a href="javascript:{$objectName}.setPageNumber({$currentPageNumber - 1});" class="prev"><img src="/_images/pixel.gif" width="1" height="1" /></a>
			</xsl:otherwise>

		  </xsl:choose>
		  </li>

		  <xsl:call-template name="pager">
			 <xsl:with-param name="maxPageNumber" select="$maxPageNumber"/>
			 <xsl:with-param name="currentPageNumber" select="$currentPageNumber"/>
			 <xsl:with-param name="objectName" select="$objectName"/>
		  </xsl:call-template>

		  <!-- next page -->

		  <li>
		  <xsl:choose>
			<xsl:when test="$currentPageNumber &gt;= $maxPageNumber">
			  <a class="next-off"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:when>
			<xsl:otherwise>
			  <a href="javascript:{$objectName}.setPageNumber({$currentPageNumber + 1});" class="next"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:otherwise>
		  </xsl:choose>

		  </li>

		  <!-- last page -->
		  <li>
		  <xsl:choose>
			<xsl:when test="$currentPageNumber &gt;= $maxPageNumber">
			  <a class="next-last-off"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:when>
			<xsl:otherwise>

			  <a href="javascript:{$objectName}.setPageNumber({$maxPageNumber});" class="next-last"><img src="_images/pixel.gif" width="1" height="1" /></a>
			</xsl:otherwise>
		  </xsl:choose>
		  </li>
		</ul>
		</div>
		<!--/end pnav/-->
	</div><!--/end paging/-->

</xsl:template>
<!--layout-utils end-->


<!-- Access Error Window (guild banks) -->
<xsl:template name="armorymsg">
	<xsl:param name="title"></xsl:param>
	<xsl:param name="message"></xsl:param>
	<xsl:param name="displaybutton"></xsl:param>
	<div class="filtercontainer" style="width: 45%; margin: 20px auto 0; padding: 6px;">
		<div class="clearfilterboxsm"/>
		<div class="bankcontentsfiltercontainer" style="width: 100%; text-align: center;">

			<div style="padding: 0 10px 10px; ">
			<div class="guildloginmsg" style=" background: url('_images/parch-warning.gif') center left no-repeat;">
				<table style="height: 55px!important; vertical-align: middle;"><tr><td style="vertical-align: middle!important; color: #836028;">
					<xsl:if test="$title">
						<div class="guilderrortitle"><xsl:value-of select="$title"/></div>
					</xsl:if>
					<xsl:value-of select="$message"/>
				</td></tr></table>
			</div>

			<xsl:if test="string-length($displaybutton) &gt; 0">
				<div style="display: table; margin: 13px auto 5px;">
					<span><h1 class="hbluebutton"><q class="centerbluebutton"><a id="loginsubmitbutton" class="bluebutton" href="javascript: document.loginRedirect.submit();"><div class="bluebutton-a"/><div class="bluebutton-b"><div class="reldiv"><div class="bluebutton-color"><xsl:value-of select="$displaybutton"/></div>
					</div>
					<xsl:value-of select="$displaybutton"/></div><div class="bluebutton-key"/><div class="bluebutton-c"></div></a></q></h1></span>
				</div>
			</xsl:if>
			</div>
		</div>

		<div class="clearfilterboxsm"/>
	</div>
	<div class="bottomshadowsm"/>
</xsl:template>

<xsl:template name="truncate">
	<xsl:param name="string"/>
	<xsl:param name="length"/>
	<xsl:param name="suffix" select="'…'" />

	<xsl:value-of select="substring($string, 1, $length)"/>

	<xsl:if test="string-length($string) &gt; $length">
		<xsl:copy-of select="$suffix"/>
	</xsl:if>
</xsl:template>

<xsl:template name="relatedContainer">
	<xsl:variable name="isPropass">
		<xsl:choose>
			<xsl:when test="/page/characterInfo/character/@tournamentRealm">true</xsl:when>
			<xsl:otherwise>false</xsl:otherwise>

		</xsl:choose>
	</xsl:variable>
	<xsl:variable name="isRecommended" select="/page/armorySearch/searchResults/filters/filter[@name='recc']/@value=1" />
<xsl:choose>
	<xsl:when test="/page/armorySearch/searchResults/arenaTeams">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-arena-ladder.xml')"/>
		</xsl:call-template>
	</xsl:when>

	<xsl:when test="/page/armorySearch/searchResults/characters">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-character-sheet.xml')"/>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/armorySearch/searchResults/guilds">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-guild-info.xml')"/>
		</xsl:call-template>

	</xsl:when>
	<xsl:when test="$isRecommended = 1">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-item-info-recommended.xml')"/>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/armorySearch/searchResults/items">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-item-info.xml')"/>

		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/characterInfo/characterTab">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src">
				<xsl:choose>
					<xsl:when test = "$isPropass != 'true'">../_content/<xsl:value-of select = "$lang" />/ri-character-sheet.xml</xsl:when>
					<xsl:otherwise>../_content/<xsl:value-of select = "$lang" />/ri-propass.xml</xsl:otherwise>

				</xsl:choose>
			</xsl:with-param>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/characterInfo/reputationTab">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-character-reputation.xml')"/>
		</xsl:call-template>
	</xsl:when>

	<xsl:when test="/page/statistics or /page/achievements">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-achievements.xml')"/>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/characterInfo/talents">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src">
				<xsl:choose>

					<xsl:when test = "$isPropass != 'true'">../_content/<xsl:value-of select = "$lang" />/ri-character-talents.xml</xsl:when>
					<xsl:otherwise>../_content/<xsl:value-of select = "$lang" />/ri-propass.xml</xsl:otherwise>
				</xsl:choose>
			</xsl:with-param>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/guildInfo/guild or /page/guildBank">

		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-guild-info.xml')"/>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/teamInfo/arenaTeam">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-team-info.xml')"/>
		</xsl:call-template>
	</xsl:when>

	<xsl:when test="/page/selectTeamType">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-arena-calculator.xml')"/>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/battlegroups">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-arena-ladder.xml')"/>
		</xsl:call-template>

	</xsl:when>
	<xsl:when test="/page/arenaLadderPagedResult/arenaTeams">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src">
				<xsl:choose>
					<xsl:when test = "$isPropass != 'true'">../_content/<xsl:value-of select = "$lang" />/ri-arena-ladder.xml</xsl:when>
					<xsl:otherwise>../_content/<xsl:value-of select = "$lang" />/ri-propass.xml</xsl:otherwise>

				</xsl:choose>
			</xsl:with-param>
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/@requestUrl='../vault/character-calendar.xml'">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-calendar.xml')" />
		</xsl:call-template>
	</xsl:when>

	<xsl:when test="/page/@requestUrl='/vault/calendar-feed.xml'">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-calendar-feed.xml')" />
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/@requestUrl='/arena-team-game-chart.xml'">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-arena-reports.xml')" />
		</xsl:call-template>

	</xsl:when>
	<xsl:when test="/page/@requestUrl='/arena-team-report-opposing-teams.xml'">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-opponent-history.xml')" />
		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/@requestUrl='/arena-game.xml'">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-match-report.xml')" />

		</xsl:call-template>
	</xsl:when>
	<xsl:when test="/page/mobileArmory">
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-mobile-armory.xml')" />
		</xsl:call-template>
	</xsl:when>
    <xsl:when test="/page/customrss or /page/@requestUrl = '../character-feed.xml'">
		<xsl:call-template name="related-info">

			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-character-feed.xml')"/>
		</xsl:call-template>
	</xsl:when>
	<xsl:otherwise>
		<xsl:call-template name="related-info">
			<xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-armory.xml')"/>
		</xsl:call-template>
	</xsl:otherwise>
</xsl:choose>

</xsl:template>

</xsl:stylesheet>
