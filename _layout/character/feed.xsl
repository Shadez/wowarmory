<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" encoding="utf-8" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

<xsl:template name="head-content"><link rel="stylesheet" type="text/css" href="_css/character-select.css" /><link rel="stylesheet" type="text/css" href="_css/character/feed.css" /><link rel="alternate" type="application/rss+xml" title="{characterInfo/character/@name} - {$loc/strs/custom-rss/str[@id='activity']}" href="character-feed.atom?{characterInfo/character/@charUrl}" />



<script src="_js/character/character-select.js"></script>
	
</xsl:template>

<xsl:template match="characterInfo">

	<xsl:choose>
		<xsl:when test="@errCode">
			<div id="dataElement">
				<div class="parchment-top">
					<div class="parchment-content">
						<div class="list">
							<div class="player-side notab">
								<div class="info-pane">									
									<xsl:call-template name="errorSection" />									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</xsl:when>
		<xsl:otherwise>
			<div id="dataElement">
				<div class="parchment-top">
					<div class="parchment-content">
						<div class="list">
							<xsl:call-template name="newCharTabs" />
							<div class="full-list">
								<div class="info-pane">
									<div class="profile-wrapper">
										<div class="profile type_{character/@faction}">
											<xsl:call-template name="charContent" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="charContent">

	<!-- character header -->
	<xsl:call-template name="newCharHeader" />
    
    <div class="activity_bg">
    	<div class="share_container">            	
		<xsl:if test="document(concat('../../character-model.xml?rhtml=false&amp;',character/@charUrl))/page/character/@owned = '1'">
			<a href="http://apps.facebook.com/wow-armory" onclick="window.open(this.href); return false;" class="share_fb_icon staticTip" onmouseover="setTipText('{$loc/strs/custom-rss/str[@id='facebook_link']}')"></a>
				</xsl:if>
			<a href="character-feed.atom?{character/@charUrl}" onclick="location.href='/custom-rss.xml?{character/@charUrl}'; return false;" class="share_rss_icon"></a></div>
    
        <h1><xsl:value-of select="$loc/strs/custom-rss/str[@id='activity']"/>
         <span><xsl:value-of select="$loc/strs/custom-rss/str[@id='activity_desc']"/></span>        </h1>
       
        <div class="activity_body_rpt"><div class="activity_body_top"><div class="activity_body_btm"><div class="activity_body_int">
            <xsl:variable name="feeddata" select="document(concat('../../character-feed-data.xml?',character/@charUrl,'&amp;loc=',$lang))" />
            
            <xsl:if test="count($feeddata/feed/event[@sort='today']) &gt; 0">
                <h3><xsl:value-of select="$loc/strs/custom-rss/str[@id='today']"/></h3>
                <xsl:apply-templates select="$feeddata/feed/event[@sort='today']">
                	<xsl:with-param name="charUrl" select="character/@charUrl"/>
                </xsl:apply-templates>
            </xsl:if>
            <xsl:if test="count($feeddata/feed/event[@sort='yesterday']) &gt; 0">
                <h3><xsl:value-of select="$loc/strs/custom-rss/str[@id='yesterday']"/></h3>
                <xsl:apply-templates select="$feeddata/feed/event[@sort='yesterday']">
                    <xsl:with-param name="charUrl" select="character/@charUrl"/>
                </xsl:apply-templates>
            </xsl:if>
                <h3><xsl:value-of select="$loc/strs/custom-rss/str[@id='previous']"/></h3>
                <xsl:apply-templates select="$feeddata/feed/event[@sort='earlier']">
                    <xsl:with-param name="charUrl" select="character/@charUrl"/>
                </xsl:apply-templates>


        </div></div></div></div>
    </div>
    
</xsl:template>

<xsl:template match="event">
<xsl:param name="charUrl"/>
	<div class="feed_entry">
    <xsl:if test="position() mod 2 = 0"><xsl:attribute name="class">feed_entry zebra</xsl:attribute></xsl:if>     
        <table><tr><td class="td_icon">
            <div class="feed_icon"><a class="event_{@type}">
                <xsl:if test="@icon"><xsl:attribute name="style">background-image:url(wow-icons/_images/21x21/<xsl:value-of select="@icon"/>.png)</xsl:attribute>
                <xsl:attribute name="class">staticTip itemToolTip</xsl:attribute>
				<xsl:attribute name="id">
                  <xsl:choose>
                    <xsl:when test="@slot &gt; -1"> <xsl:value-of select="concat('i=',@id,'&amp;',character/@characterurl,'&amp;s=',@slot)"/> </xsl:when>
                    <xsl:otherwise> <xsl:value-of select="concat('i=',@id)"/> </xsl:otherwise>
                  </xsl:choose>
                </xsl:attribute>        
                <xsl:attribute name="href">item-info.xml?i=<xsl:value-of select="@id"/> </xsl:attribute>
                </xsl:if>
                <xsl:if test="@type = 'achievement' or @type = 'criteria'">
                <xsl:attribute name="class">staticTip</xsl:attribute>
                    <xsl:attribute name="onmouseover">setTipText('<xsl:value-of select="tooltip"/>');</xsl:attribute>
                </xsl:if>
                <img class="p" src="images/feed_icon_{@type}.png"/>
            </a></div>
            </td><td>
            <div class="timestamp">
            <xsl:choose>
                <xsl:when test="@reldate != ''"><xsl:value-of select="@reldate"/></xsl:when>
                <xsl:when test="@sort = 'yesterday'"><xsl:value-of select="$loc/strs/custom-rss/str[@id='yesterday']"/> - <xsl:value-of select="@time"/></xsl:when>
                <xsl:otherwise><xsl:value-of select="@date"/></xsl:otherwise>
            </xsl:choose>
			</div>
            <xsl:apply-templates select="desc/."/>
			<xsl:if test="@type = 'loot' and @slot != '-1'">&#160;<strong><xsl:value-of select="$loc/strs/custom-rss/str[@id='currently_equipped']"/></strong></xsl:if>

        </td></tr></table>
    </div>    

</xsl:template>

<xsl:template match="customrss">
<xsl:variable name="login-status" select="document('../../login-status.xml')" />
<xsl:variable name="username" select="$login-status/page/loginStatus/@username" />

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
            <div class="list"><div class="full-list notab"><div class="info-pane">

<a id="feed_return" href=""></a>

    <div class="sel-char">
        <div class="sel-intro">
            <h1><xsl:value-of select="$loc/strs/custom-rss/str[@id='feedcustom']"/></h1>
        </div>

<div class="sel-char_int">

<div class="form_bg_rpt"><div class="form_bg_top"><div class="form_bg_btm">

<div class="custom_rss_container">
        <div class="filter_options">
        <h2><xsl:value-of select="$loc/strs/custom-rss/str[@id='feedoptions']"/></h2>
                <div class="filter_option top_level">	
                	<a class="check_box checked" href="javascript:;" id="achievement"></a>
                	<div class="filter_desc"><xsl:value-of select="$loc/strs/custom-rss/filters/str[@id='achievements']"/></div>
                    <a class="feed_filter_arrow" href="javascript:;" onclick="toggle_subfilter('achievement_subfilter',this)">
                    	<span class="more"><xsl:value-of select="$loc/strs/custom-rss/str[@id='more']"/></span>
                        <span><xsl:value-of select="$loc/strs/custom-rss/str[@id='less']"/></span> »
                    </a>
                <table id="achievement_subfilter">
                <tr class="sub_filter_option">
                <!-- Dummy loc parameter guarantees language-specific client-side caching  -->
                    <td><xsl:for-each select="document(concat('/data/achievementStrings.xml?loc=',$lang))/page/rootCategories/category">
                    		<div class="sub"><xsl:if test="position() mod 2"><xsl:attribute name="style">clear:left;</xsl:attribute></xsl:if>
                            <a class="check_box checked" href="javascript:;" id="{@id}"></a>
                            				 <span class="filter_desc"><xsl:value-of select="@name"/></span>
                            </div>
                        </xsl:for-each>
                    </td>
                    </tr>                    
                </table>

                </div>
                <div class="filter_option top_level">	
                    <a class="check_box checked" href="javascript:;" id="criteria"></a>
                	<div class="filter_desc"><xsl:value-of select="$loc/strs/custom-rss/filters/str[@id='criteria']"/></div>
                </div>
                <div class="filter_option top_level">	
                    <a class="check_box checked" href="javascript:;" id="bosskill"></a>
                	<div class="filter_desc"><xsl:value-of select="$loc/strs/custom-rss/filters/str[@id='bosskills']"/></div>
                </div>

                <div class="filter_option top_level">	              
                    <a class="check_box checked" href="javascript:;" id="loot"></a>
                	<div class="filter_desc"><xsl:value-of select="$loc/strs/custom-rss/filters/str[@id='loot']"/></div>
                    <a class="feed_filter_arrow" href="javascript:;" onclick="toggle_subfilter('loot_subfilter',this)">
                    	<span class="more"><xsl:value-of select="$loc/strs/custom-rss/str[@id='more']"/></span>
                        <span><xsl:value-of select="$loc/strs/custom-rss/str[@id='less']"/></span> »
                    </a>
                <table id="loot_subfilter">
                <tr class="sub_filter_option">
                    <td><xsl:value-of select="$loc/strs/custom-rss/str[@id='min.rarity']"/> </td>
                    <td>
                <select id="loot_rarity">
                    <option style="color:green" value="uncommon"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.uncommon']"/></option>
                    <option style="color:blue" value="rare"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.rare']"/></option>
                    <option style="color:purple" value="" selected="selected"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.epic']"/></option>
                    <option style="color:#ba740f" value="legendary"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.legendary']"/></option>
                    <option style="color:#c2a061" value="heirloom"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.heirloom']"/></option>
                </select>
                    </td>
                    </tr>                    
                <tr class="sub_filter_option"><td><xsl:value-of select="$loc/strs/custom-rss/str[@id='min.ilvl']"/> </td><td><input maxlength="3" id="loot_ilvl" value=""/></td></tr>
                </table>
                </div> 

                <div class="filter_option top_level" style="display:none">	
                	<a class="check_box checked" href="javascript:;" id="respec"></a>
                	<div class="filter_desc"><xsl:value-of select="$loc/strs/custom-rss/filters/str[@id='respec']"/></div>
                </div>
                
 
        </div>        
        <div id="character_container">
            <h3><xsl:value-of select="$loc/strs/custom-rss/str[@id='add_chars']"/>
                <span> <xsl:value-of select="$loc/strs/custom-rss/str[@id='add_example']"/>
                <xsl:choose>
                    <xsl:when test="string-length($username) != 0">
                        <xsl:variable name="pinned_char" select="document('../../character-select.xml?sel=2')/page/characters/character[@selected=1]" />
                        <xsl:choose>
                        	<xsl:when test="string-length($pinned_char/@name) != 0">
	                        	<xsl:value-of select="$pinned_char/@name"/>@<xsl:value-of select="$pinned_char/@realm"/>
                            </xsl:when>
                            <xsl:otherwise><xsl:value-of select="$loc/strs/custom-rss/str[@id='add_example.char_realm']"/></xsl:otherwise>
                         </xsl:choose>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="$loc/strs/custom-rss/str[@id='add_example.char_realm']"/>
                    </xsl:otherwise>
                </xsl:choose>
               	</span> <span id="def_realm"><xsl:comment> </xsl:comment></span>
            </h3>
             <div class="character_row" style="display:block;">
               <div class="char_add_field">
                   1 <input type="text" id="character1" onfocus="char_check(this)" onblur="char_check(this,true)"/> 
               </div> 
               <div class="rss_port"></div>
                <a href="javascript:;" onclick="add_rss_char(1)"></a>
               <div class="ajax_error"><xsl:comment> </xsl:comment></div>
             </div>
             <div class="character_row">
               <div class="char_add_field">
                   2 <input type="text" id="character2" onfocus="char_check(this)" onblur="char_check(this,true)"/> 
               </div> 
               <div class="rss_port"></div>
               <a href="javascript:;" onclick="add_rss_char(2)"></a> 
               <div class="ajax_error"><xsl:comment> </xsl:comment></div>
             </div>
             <div class="character_row">
               <div class="char_add_field">
                   3 <input type="text" id="character3" onfocus="char_check(this)" onblur="char_check(this,true)"/>
				</div> 
               <div class="rss_port"></div>
               <a href="javascript:;" onclick="add_rss_char(3)"></a> 
               <div class="ajax_error"><xsl:comment> </xsl:comment></div>
             </div>
             <div class="character_row">
               <div class="char_add_field">
                   4 <input type="text" id="character4" onfocus="char_check(this)" onblur="char_check(this,true)"/>
				</div> 
               <div class="rss_port"></div>
               <a href="javascript:;" onclick="add_rss_char(4)"></a> 
               <div class="ajax_error"><xsl:comment> </xsl:comment></div>
             </div>
             <div class="character_row">
               <div class="char_add_field">
                   5 <input type="text" id="character5" onfocus="char_check(this)" onblur="char_check(this,true)"/>
               </div> 
               <div class="rss_port"></div>
               <a href="javascript:;" onclick="add_rss_char(5)"></a> 
               <div class="ajax_error"><xsl:comment> </xsl:comment></div>
             </div>
        </div>
        
        <div class="url_output">
            <h3><xsl:value-of select="$loc/strs/custom-rss/str[@id='rss_url']"/></h3>
            <textarea rows="5" id="customfeed_url"></textarea>
            <div id="rss_link_copy_container"><a id="rss_link_copy" href="javascript:;"><span><xsl:value-of select="$loc/strs/custom-rss/str[@id='copy_to']"/></span></a></div>
            <div id="copy_ok"><xsl:value-of select="$loc/strs/custom-rss/str[@id='copied']"/></div>
			<script type="text/javascript" src="shared/global/third-party/zeroclipboard/zeroclipboard.js"></script>
            <script language="JavaScript">
                ZeroClipboard.setMoviePath( 'shared/global/third-party/zeroclipboard/zeroclipboard.swf' );
				$(document).ready(function(){clipboard_init("rss_link_copy","customfeed_url")});
                function zClipboard_complete(client, text) {
                   // alert("Copied text to clipboard: " + text );
					$("#copy_ok").stop(false,true)
					$("#copy_ok").fadeIn("fast",function(){ $(this).animate({opacity:1}, 2000,function(){$(this).fadeOut(2000)} )}); 
                }
            </script><br clear="all"/>&#160;
            <div style="display:none"><a href="javascript:;" onclick="refresh_rss_url()">refresh</a> </div>
        </div>
        
    </div>

</div></div></div>
<script>
	<xsl:if test="string-length($username) != 0">
	<xsl:variable name="pinned_char" select="document('../../character-select.xml?sel=2')/page/characters/character[@selected=1]" />
	default_realm = '<xsl:value-of select="$pinned_char/@realm"/>'
	//$('#def_realm').html("Default Realm is &lt;strong&gt;" + default_realm+"&lt;/strong&gt;")
	</xsl:if>
	$(".check_box").click(check_action);
	$(".check_box + .filter_desc").click(function(){ $(this).prev().click(); });
	$("#loot_rarity").change(refresh_rss_url)
	$("#loot_ilvl").keyup(refresh_rss_url)
	$(".char_add_field > input").keypress(function (e) { if (e.which == 13){ var temp_id = $(this).attr("id").slice(-1); add_rss_char(temp_id); } });
	var lang = "<xsl:value-of select="$lang"/>".split("_")
	var lang = lang[0].toLowerCase()+"_"+lang[1].toUpperCase()
	var str_err_char = "<xsl:value-of select="$loc/strs/custom-rss/str[@id='no_char']"/>" //"
	var str_err_realm = "<xsl:value-of select="$loc/strs/custom-rss/str[@id='no_realm']"/>" //"
	var str_removed = "<xsl:value-of select="$loc/strs/custom-rss/str[@id='removed']"/>" //"
	var backhtml = "<xsl:value-of select="$loc/strs/custom-rss/str[@id='backtoprofile']"/>" //"
	var str_remove = "<xsl:value-of select="$loc/strs/calendar/str[@id='remove']"/>" //"
	var str_cantfind = "<xsl:value-of select="$loc/strs/custom-rss/str[@id='cantfind']"/>" //"
	check_default_char()
</script>

<div class="custom_rss_info"><div class="custom_info_int">
<h3><xsl:value-of select="$loc/strs/custom-rss/str[@id='whatisthis']"/></h3>
<xsl:apply-templates select="$loc/strs/custom-rss/str[@id='whatisthis.help']"/>
<div id="debugtxt">&#160;</div>
</div></div>

<br clear="all"/>&#160;

</div></div></div></div>
</div>

            </div>
        </div>
    </div>

</xsl:template>

</xsl:stylesheet>