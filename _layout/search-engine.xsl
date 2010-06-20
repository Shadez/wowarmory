<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="includes.xsl"/>

<xsl:template name="searchEngine">
	
	<div class="parchment-top">
		<div class="parchment-content">		
			<div class="list">			
				<div class="full-list notab">
					<div class="info-pane">
						<div class="profile-wrapper">
							<div class="searchplugin">
								<xsl:call-template name="pluginContent" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</xsl:template>


<xsl:template name="pluginContent">

	<script type="text/javascript">
	
		//for ie and firefox
		function addProvider(whichLang){
			
			var currDomain = "http://" + document.domain;
			var currPort = window.location.port;
			if (currPort) { currDomain += ":" + currPort; }
			window.external.AddSearchProvider(currDomain + "/_content/"+whichLang+"/searchplugin.xml");
					
			return false;
		}
	
	
	</script>


	<div class="plugin-intro">
		<h2><xsl:value-of select="$loc/strs/searchPlugin/str[@id='maintitle']"/></h2>
		<p><xsl:value-of select="$loc/strs/searchPlugin/str[@id='subtitle']"/></p>
	</div>


	<div class="plugin firefox" style="background:url(images/{$lang}/plugin-firefox.jpg) 0 0 no-repeat;">
		<div class="installbutton">
			<a href="javascript:void(0)" onClick="addProvider('{$lang}');">
				<span><xsl:value-of select="$loc/strs/searchPlugin/str[@id='installnow']"/></span>
			</a>
		</div>
	</div>

	<div class="plugin ie7" style="background:url(images/{$lang}/plugin-ie7.jpg) 0 0 no-repeat;">
		<div class="installbutton">
			<a href="javascript:void(0)" onClick="addProvider('{$lang}');">
				<span><xsl:value-of select="$loc/strs/searchPlugin/str[@id='installnow']"/></span>
			</a>
		</div>
	</div>
	
	<xsl:if test = "$lang = 'en_us'">	
		<div class="plugin opera" style="background:url(images/{$lang}/plugin-opera.jpg) 0 0 no-repeat;">
			<div class="installbutton">
				<a href="opera:/edit/Search,%22{$loc/strs/common/str[@id='url.armory']}search.xml?searchQuery=%s&amp;searchType=all%22" 
					title="{$loc/strs/searchPlugin/str[@id='operaplugintitle']}">
					<span><xsl:value-of select="$loc/strs/searchPlugin/str[@id='installnow']"/></span>
				</a>
			</div>
		</div>
		
		<div class="rlbox2 operainstructions">
			<div>
				<h3><xsl:value-of select="$loc/strs/searchPlugin/str[@id='instructionsforopera']"/></h3>
				<ol>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera1']" /></li>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera2']" /></li>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera3']" />
						<img src="images/{$lang}/plugin-opera1.jpg"/>
					</li>
				</ol>
					
				<h4><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera4']" /></h4>
					
				<xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera5']" />
				<ol>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera6']" /></li>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera7']" /></li>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera8']" />
						<blockquote>
							<xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera9']" />
						</blockquote>
					</li>
					<li><xsl:apply-templates select = "$loc/strs/searchPlugin/str[@id='instructionsforopera10']" /></li>
				</ol>
			
			</div>
		</div>
	
	</xsl:if>


</xsl:template>

<xsl:template match="page/searchEngine">
	<div id="dataElement">
		<xsl:call-template name="searchEngine" />
	</div>
</xsl:template>

</xsl:stylesheet>
