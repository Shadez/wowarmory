<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="includes.xsl"/>

<xsl:template match="updates">

	<script type="text/javascript">
	
	function toggleUpdate(theId) {
		elementId = document.getElementById('showHideUpdate'+theId);
		if (elementId.style.display == "block") {
			$("#replaceToggle"+theId).html("<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.open']"/>");
			elementId.style.display = "none";
		} else {
			$("#replaceToggle"+theId).html("<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.close']"/>");	
			elementId.style.display = "block";	
		}
	}	
	</script>
	
	<div id="dataElement">
		<div class="parchment-top" id="top">
			<div class="parchment-content">			
				<div class="list">
					<div class="full-list notab">
						<div class="info-pane">
							<div class="profile-wrapper">
								<div class="generic-wrapper">
									<div class="generic-right">
										<div class="genericHeader">
											<div class="update-content">
												<xsl:call-template name="updatesContent" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</xsl:template>


<xsl:template name="updatesContent">

	<h1><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.updates.armoryupdates']"/></h1>
	<b><em><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.updates.cache']"/></em></b>
	
	<xsl:for-each select="document(concat('../updates-feed.xml?lang=', $lang))/updates/update[not(contains(@exclude, $region))]">
		<xsl:variable name="thePosition" select="position()" />
	  
		<h2>
			<xsl:value-of select="@date" />
			<a href="#top" class="updateTop staticTip" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.labels.top']}');"></a>
		</h2>
		
		<xsl:for-each select="entry">
			<a name="anchor{@key}"></a>
			<div class="update-item">
				<div class="update-line-item" id="line{@key}">
					<span><xsl:value-of select = "@title" /></span>
					<em class="toggleUpdate"> 
						[ <a href="javascript: toggleUpdate('{@key}');" id="replaceToggle{@key}">			
						<xsl:choose>
							<xsl:when test="$thePosition = 1">
								<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.close']"/>
							</xsl:when>
							<xsl:otherwise>
								<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.open']"/>
							</xsl:otherwise>
						</xsl:choose>
						</a> ] 
					</em>
				</div>
				<div class="update-body" id="showHideUpdate{@key}" style="display: none;">
					<xsl:if test="$thePosition = 1">
						<xsl:attribute name="style">display: block;</xsl:attribute>		
					</xsl:if>					
					<p><xsl:apply-templates/></p>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</xsl:for-each>  
	
	</xsl:for-each>
	
	<script type="text/javascript">
			$("#replaceTogglepinprofile").html("<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.close']"/>");	
			$("#showHideUpdatepinprofile").attr("style","display:block");	
	
			$("#replaceToggledesiredby").html("<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.close']"/>");	
			$("#showHideUpdatedesiredby").attr("style","display:block");	
	
			$("#replaceTogglefindupgrade").html("<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.close']"/>");	
			$("#showHideUpdatefindupgrade").attr("style","display:block");
			
			if(($.browser.msie) &amp;&amp; ($.browser.version == "6.0")){
				$(".updateTop").hide();			
			}
	</script>


</xsl:template>

</xsl:stylesheet>
