<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="includes.xsl"/>

<xsl:template match="pageIndex">
	<div class="front-top">
		<xsl:call-template name="loginLogoutLink"/>
		<div class="logo">
			<a href="armoryLink"><span>World of Warcraft Armory</span></a>
		</div>

	</div>
	<div class="data-container">
		<div class="data-shadow-top"><xsl:comment/></div>
		<div class="data-shadow-sides">
			<div class="parch-front">
				<xsl:call-template name="searchInput"/>
			</div>
		</div>
		<div class="data-shadow-bot"><xsl:comment/></div>

	</div>
	<div class="page-bot">
        <xsl:call-template name="related-info">
            <xsl:with-param name="src" select="concat('../_content/',$lang,'/ri-armory.xml')"/>
        </xsl:call-template>
    </div>

    <script type="text/javascript">
		function setArmorySearchFocus() {
			document.formSearch.armorySearch.focus();
		}
		window.onload = setArmorySearchFocus;	
    </script>

</xsl:template>	
	
</xsl:stylesheet>