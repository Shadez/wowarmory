<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:include href="includes.xsl"/>
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:variable name="newLang">
	<xsl:choose>
		<xsl:when test="$lang = 'en_gb'">en_us</xsl:when>
		<xsl:otherwise><xsl:value-of select="$lang"/></xsl:otherwise>
	</xsl:choose>
</xsl:variable>

<xsl:variable name="wamURL">
	<xsl:choose>
		<xsl:when test="$region = 'US'">https://www.worldofwarcraft.com/account/wow-remote-payment-method.html</xsl:when>
		<xsl:when test="$region = 'EU'">https://www.wow-europe.com/account/wow-remote-payment-method.html</xsl:when>
		<xsl:when test="$region = 'KR'">http://goblin-web2.worldofwarcraft.co.kr:8086/account/wow-remote/intro.do</xsl:when>
	</xsl:choose>
</xsl:variable>

<xsl:template name="wowRemote">
	<div class="parchment-top">
		<div class="parchment-content">		
			<div class="list">			
				<div class="full-list notab">
					<div class="info-pane" style="margin-top:20px">
						<div class="profile-wrapper" style="width:auto">
							<div class="searchplugin">
								<xsl:call-template name="pra-template" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</xsl:template>

<xsl:template name="pra-head">
	<script type="text/javascript">
		/* <![CDATA[ */
			$(document).ready(function(){
				$('#blackout').click(function(){
					$('#blackout').hide();
				});
				
				if(Browser.ie6){
					$('.break').css('background','url("images/wow-remote/line.gif") no-repeat -10px 0px;');
					$('.check').html('<img src="images/wow-remote/checkmark.gif"/>');
					$('.table-shadow').css('background','none');
				} else {
					$('.check').html('<img src="images/wow-remote/checkmark.png"/>');				
				};
				
				var wowaImgWidth = parseInt($('#wowa-screens-slide a').css('width'));
				var wowaImgMargin = parseInt($('#wowa-screens-slide a').css('margin-right'));
				var wowaImgCount = $('#wowa-screens-slide a').length; 
				var getPerWidth=(((wowaImgWidth+(2*wowaImgMargin)) * (wowaImgCount) + ($(".wowa-screens-nav").width())*2)/$("#wowa-screens-slide").width())*100;
				$("#wowa-screens-slide").width(getPerWidth+'%');
				
				$("#slide-left").click(function() {
					$(".wowa-screens").animate({"scrollLeft":"-=350"},700);
				});

				$("#slide-right").click(function() {
					$(".wowa-screens").animate({"scrollLeft":"+=350"},700);
				});

			});
			
			function callLightbox(image){
				if(Browser.ie6){
					$('#blackout').css('position','absolute');
					$('#blackout').css('background','none');
					$('#blackout').html("<div style='background:url("+image+") center center no-repeat;width:700px;height:700px;margin:0 auto;margin-top:"+($(window).scrollTop())+"px;'> </div>").show();
				} else {
					$('#blackout').html("<div style='background:url("+image+") center center no-repeat;width:100%;height:100%;'> </div>").show();
				}
			};
		/* ]]>*/

	</script>

</xsl:template>

<xsl:template name="pra-pricing">
	<div class="wowa-pricing">
		<div class="wowa-pricing-ast">
		*
		</div>
		<div class="wowa-pricing-wrap">
			<xsl:choose>
				<xsl:when test="$region = 'US'">
					<xsl:choose>
						<xsl:when test="$lang = 'es_mx'">
						<p class="price margin mxp">
							<span class="pricing-num">MXP <em>$39</em></span>
							<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
						</p>
						<p class="price margin clp">
							<span class="pricing-num">CLP <em>$1,600</em></span>
							<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
						</p>
						<p class="price margin ars">
							<span class="pricing-num">ARS <em>$12</em></span>
							<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
						</p>
						</xsl:when>
						<xsl:otherwise>
						<p class="price">
							<span class="pricing-num"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.only']"/> <em>$2.99</em></span>
							<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
						</p>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:when>
				<xsl:when test="$region = 'EU'">
					<p class="price margin eur">
						<xsl:choose>
							<xsl:when test="$lang = 'en_us' or $lang = 'en_gb'">
								<span class="pricing-num">EUR <em>&#8364;2.99</em></span>
							</xsl:when>
							<xsl:when test="$lang = 'fr_fr'">
								<span class="pricing-num"><em>2,99 &#8364;</em></span>								
							</xsl:when>
							<xsl:otherwise>
								<span class="pricing-num"><em>2,99&#8364;</em></span>
							</xsl:otherwise>
						</xsl:choose>
						<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
					</p>
					<p class="price margin rub">
						<xsl:choose>
							<xsl:when test="$lang='ru_ru'">
								<span class="pricing-num"><em>99,00</em> РУБ.</span>
							</xsl:when>
							<xsl:when test="$lang = 'en_us' or $lang = 'en_gb'">
								<span class="pricing-num">RUB <em>99</em></span>
							</xsl:when>
							<xsl:otherwise>
								<span class="pricing-num"><em>99</em> RUB</span>
							</xsl:otherwise>
						</xsl:choose>
						<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
					</p>
					<p class="price margin gbp">
						<xsl:choose>
							<xsl:when test="$lang = 'en_gb' or $lang = 'en_us'">
								<span class="pricing-num">GBP <em>&#163;2.49</em></span>
							</xsl:when>
							<xsl:when test="$lang = 'fr_fr'">
								<span class="pricing-num"><em>2,49 &#163;</em></span>								
							</xsl:when>
							<xsl:otherwise>
								<span class="pricing-num"><em>2,49&#163;</em></span>								
							</xsl:otherwise>
						</xsl:choose>
						<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
					</p>
				</xsl:when>
				<xsl:when test="$region = 'KR'">
					<p class="price">
						<span class="pricing-num"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.only']"/><em> 3,300원</em></span>
						<span class="pricing-per"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.period']"/></span>
					</p>
				</xsl:when>
			</xsl:choose>
		</div>
	<span class="wowa-notice"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='price.notice']"/></span>
	</div>
</xsl:template>

<xsl:template name="pra-template">
<div id="wowa-wrapper">
	<div id="wowa-header">
	</div>
	<div id="wowa-intro">
		<xsl:call-template name="pra-pricing"/> 
		<div class="wowa-list">
			<img src="images/wow-remote/icon-intro.gif"/>
			<h1><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='intro.title']"/></h1>
			<p class="descrip"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='intro.text']"/></p>
			<ul>
				<li class="break"></li>
				<li class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='feature.browse']"/></li>
				<li class="break"></li>
				<li class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='feature.create']"/></li>
				<li class="break"></li>
				<li class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='feature.collect']"/></li>
				<li class="break"></li>
			</ul>
			<span class="subscribe"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='btn.subscribe.beta']"/></span>
			<!--<a class="subscribe" href="{$wamURL}?locale={$newLang}"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='btn.subscribe']"/></a>-->
			<span class="faq"><a href="http://{$region}.blizzard.com/support/article/REMOTE?locale={$newLang}"><xsl:apply-templates select="$loc/strs/wowRemotePage/str[@id='try.wr.faq']"/></a></span>
		</div>
	</div>
	<div id="wowa-try">
		<div id="wowa-try-wrap">
			<h2><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='try.free.title']"/></h2>
			<p class="descrip">
				<xsl:value-of select="$loc/strs/wowRemotePage/str[@id='try.wr.text']"/>
			</p>
			<span class="try-buttons">
				<a class="web" href="/auctionhouse/"><span><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='btn.try.web']"/></span></a>
				<a class="mobile" href="http://itunes.apple.com/app/world-warcraft-mobile-armory/id321057000?mt=8" target="itunes"><span><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='btn.try.mobile']"/></span></a>
			</span>
			<p class="wowa-notice"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='try.notice']"/></p>			
		</div>
	</div>
	<div id="wowa-table">
		<div id="wowa-table-wrapper">
			<div id="shadow-top" class="table-shadow">
			</div>
			<div id="shadow-body" class="table-shadow">
				<table>
					<thead>
						<tr>
							<th class="c-first text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.head']"/></th>
							<th class="c-second"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.free.head']"/></th>
							<th class="c-third"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.wr.head']"/></th>
						</tr>
					</thead>
					<tbody>
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.1']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.2']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="dark"> 
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.3']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.4']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.5']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.6']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.7']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.8']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>	
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.9']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>	
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.10']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>	
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.11']"/></td>
							<td class="check"></td>
							<td class="check"></td>
						</tr>	
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.12']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>		
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.13']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>	
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.14']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>	
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.15']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>	
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.16']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>	
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.17']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>	
						<tr class="light">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.18']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>
						<tr class="dark">
							<td class="text"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='table.descrip.19']"/></td>
							<td></td>
							<td class="check"></td>
						</tr>				
					</tbody>
				</table>
			</div>
			<div id="shadow-bot" class="table-shadow">
			</div>
		</div>
	</div>
	<div id="wowa-sub-bot">
			<span><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='btn.subscribe.beta']"/></span>
			<!-- Uncomment when beta is done and remove line above.
			<a href="{$wamURL}?locale={$newLang}"><xsl:value-of select="$loc/strs/wowRemotePage/str[@id='btn.subscribe']"/></a>
			-->
	</div>
	<div class="wowa-screens-wrap">
		<div class="wowa-screens-nav nav-left">
			<a id="slide-left"><img src="images/wow-remote/icon-slide-left.gif" alt="Scroll Left"/></a>
		</div>
			<div class="wowa-screens">
				<div id="wowa-screens-slide">
					<a class="screen-w2" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/web/screen_02.jpg')"></a>
					<a class="screen-w4" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/web/screen_04.jpg')"></a>
					<a class="screen-w5" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/web/screen_05.jpg')"></a>
					<a class="screen-m2" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/mobile/screen_02.jpg')"></a>
					<a class="screen-m6" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/mobile/screen_06.jpg')"></a>
					<a class="screen-w1" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/web/screen_01.jpg')"></a>
					<a class="screen-w3" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/web/screen_03.jpg')"></a>
					<a class="screen-m1" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/mobile/screen_01.jpg')"></a>
					<a class="screen-m4" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/mobile/screen_04.jpg')"></a>
					<a class="screen-m3" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/mobile/screen_03.jpg')"></a>
					<a class="screen-m5" href="javascript:void(0);" onclick="callLightbox('images/wow-remote/{$newLang}/mobile/screen_05.jpg')"></a>
				</div>
			</div>	
		<div class="wowa-screens-nav nav-right">
			<div id="slide-right"><img src="images/wow-remote/icon-slide-right.gif" alt="Scroll Right"/></div>
		</div>
		<div id="wowa-ie-preload-w1"></div><div id="wowa-ie-preload-w2"></div><div id="wowa-ie-preload-w3"></div><div id="wowa-ie-preload-w4"></div><div id="wowa-ie-preload-w5"></div>
		<div id="wowa-ie-preload-m1"></div><div id="wowa-ie-preload-m2"></div><div id="wowa-ie-preload-m3"></div><div id="wowa-ie-preload-m4"></div><div id="wowa-ie-preload-m5"></div><div id="wowa-ie-preload-m6"></div>
	</div>
</div>

</xsl:template>

<xsl:template match="page/wowRemote">
	<link rel="stylesheet" type="text/css" href="_css/wow-remote.css"/>
	<xsl:call-template name="pra-head" />
	<div id="dataElement">
	<xsl:call-template name="wowRemote" />
	</div>
</xsl:template>


</xsl:stylesheet>
