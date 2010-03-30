<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:include href="includes.xsl"/>

<xsl:template name="dungeonLevel">
	<xsl:param name="levelMin" />
	<xsl:param name="levelMax" />
	
	<xsl:if test="$levelMin != -1">
		<xsl:value-of select = "$levelMin" />
		<xsl:if test="$levelMin != $levelMax"> - <xsl:value-of select = "$levelMax" /></xsl:if>
	</xsl:if>
</xsl:template>

<xsl:template match="dungeons">

	<xsl:variable name="dungeonsXml" select="document('../_data/dungeons.xml')" />
	<xsl:variable name="locDungeons" select="document('../data/dungeonStrings.xml')" />
	<xsl:variable name="releaseId" select="@releaseid" />

	<script type="text/javascript">	
		function toggleDungeon(dungeonId){
			elementId = $blizz('showHideBosses'+ dungeonId);
			if (elementId.style.display == 'block') {
				$blizz('toggleExpand' + dungeonId).className = "expand-list";
				elementId.style.display = 'none';
			} else {
				$blizz('toggleExpand' + dungeonId).className = "collapse-list";	
				elementId.style.display = 'block';
			}
		}
	</script>

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">				
                <div class="list">				
					<xsl:call-template name="tabs">
						<xsl:with-param name="tabGroup" select="/page/tabInfo/@tabGroup" />
						<xsl:with-param name="currTab" select="/page/tabInfo/@tab" />
						<xsl:with-param name="subTab" select="/page/tabInfo/@subTab" />
						<xsl:with-param name="tabUrlAppend" select="''" />
						<xsl:with-param name="subtabUrlAppend" select="''" />
					</xsl:call-template>
                    <div class="full-list">
                        <div class="info-pane dungeon-container">
							<div class="info-header dhbg{@release}">
								<h1><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons']"/></h1>
								<h2><xsl:value-of select="$loc/strs/unsorted/str[@id=$releaseId]"/></h2>
							</div>
						</div>
						<div class="dungeon-header">
							<table>
								<tr>
								<td width="25"></td>
								<td width="250"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.dungeon']"/></span></td>
								<td width="120"><span><xsl:value-of select="$loc/strs/dungeons/str[@id='bosses']"/></span></td>
								<td width="80"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.level']"/></span></td>
								<td width="150"><span><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.type']"/></span></td>
								</tr>
							</table>
						</div>
						<div class="dungeon-content">
							<table>
								<xsl:for-each select="$locDungeons/page/dungeons/dungeon[@release=$releaseId]">
									<xsl:variable name="dungeonId"   select="@id" />
									<xsl:variable name="dungeonKey"   select="@key" />
									<xsl:variable name="dungeonName" select="@name" />
									<xsl:variable name="dungeonPath" select="$dungeonsXml/config/dungeons/dungeon[@key=$dungeonKey]" />			
									<xsl:variable name="isRaid" 	 select="$dungeonPath/@raid" />
									<xsl:variable name="partySize" 	 select="$dungeonPath/@partySize" />
									<xsl:variable name="altId">
										<xsl:choose>
											<xsl:when test="position() mod 2 != 1">rc1</xsl:when>
											<xsl:otherwise>rc0</xsl:otherwise>
										</xsl:choose>
									</xsl:variable>
								
									<tr id="toggleExpand{$dungeonKey}" class="expand-list">
										<td width="25" valign="top" class="{$altId}">		
											<a class="expandToggle" href="javascript: javascript: toggleDungeon('{$dungeonKey}');"></a>
										</td>
										<td width="250" valign="top" class="{$altId}">
											<a href="search.xml?source=dungeon&amp;dungeon={$dungeonKey}&amp;boss=all&amp;difficulty=all&amp;searchType=items">
												<xsl:value-of select = "$dungeonName" />
											</a>
											<div class="d-bosses" id="showHideBosses{$dungeonKey}" style="display:none;">
												<xsl:for-each select="$locDungeons/page/dungeons/dungeon[@key=$dungeonKey]/boss">
													<em></em><a href = "search.xml?source=dungeon&amp;dungeon={$dungeonKey}&amp;boss={@id}&amp;difficulty=all&amp;searchType=items"><xsl:value-of select = "@name" /></a>
												</xsl:for-each>
											</div>
										</td>
										<td width="120" valign="top" class="{$altId}">
											<a href="javascript: toggleDungeon('{$dungeonKey}');"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.viewbosses']"/></a>
											<span>(<xsl:for-each select="$locDungeons/page/dungeons/dungeon[@key=$dungeonKey]"><xsl:value-of select="count(*)"/></xsl:for-each>)</span>
										</td>
										<td width="80" valign="top" class="{$altId}">
											<xsl:call-template name="dungeonLevel">
												<xsl:with-param name="levelMin" select="$dungeonPath/@levelMin" />
												<xsl:with-param name="levelMax" select="$dungeonPath/@levelMax" />
											</xsl:call-template>
										</td>
										<td width="150" valign="top" class="{$altId}">			
											<xsl:choose>
												<xsl:when test="$isRaid = 1"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.partysize.before']"/><xsl:value-of select = "$dungeonPath/@partySize" /><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.partysize.after']"/></xsl:when>
												<xsl:otherwise><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.dungeon']"/></xsl:otherwise>
											</xsl:choose>
										</td>									
									</tr>								
								</xsl:for-each>							
							</table>
							<xsl:choose>
								<xsl:when test="$releaseId = 1">
									<div class="table-footnote">
										<span style="padding-left: 30px;">		  
											<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.seealsocolon']"/>&#160;<a href="search.xml?source=dungeon&amp;dungeon=badgeofjustice&amp;boss=all&amp;difficulty=all&amp;searchType=items"><img src="/wow-icons/_images/21x21/spell_holy_championsbond.png" class="boj" /><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.bojr']"/></a>
										</span><br /><br />
									</div>
								</xsl:when>
								<xsl:when test="$releaseId = 2">
									<div class="table-footnote">
										<span style="padding-left: 30px;">		  
											<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.dungeons.seealsocolon']"/>&#160;
											<a href="search.xml?source=dungeon&amp;dungeon=emblemofheroism&amp;boss=all&amp;difficulty=all&amp;searchType=items"><img src="/wow-icons/_images/21x21/spell_holy_proclaimchampion.png" class="boj" /><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eohr']"/></a></span>&#160;&#160;
										<span><a href = "search.xml?source=dungeon&amp;dungeon=emblemofvalor&amp;boss=all&amp;difficulty=all&amp;searchType=items"><img src="/wow-icons/_images/21x21/spell_holy_proclaimchampion_02.png" class="boj" /><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eovr']"/></a></span>&#160;&#160;
										<span><a href = "search.xml?source=dungeon&amp;dungeon=emblemofconquest&amp;boss=all&amp;difficulty=all&amp;searchType=items"><img src="/wow-icons/_images/21x21/spell_holy_championsgrace.png" class="boj" /><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eocr']"/></a></span>&#160;&#160;
										<span><a href = "search.xml?source=dungeon&amp;dungeon=emblemoftriumph&amp;boss=all&amp;difficulty=all&amp;searchType=items"><img src="/wow-icons/_images/21x21/spell_holy_summonchampion.png" class="boj" /><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eotr']"/></a></span>&#160;&#160;
										<span><a href = "search.xml?source=dungeon&amp;dungeon=emblemoffrost&amp;boss=all&amp;difficulty=all&amp;searchType=items"><img src="/wow-icons/_images/21x21/inv_misc_frostemblem_01.png" class="boj" /><xsl:value-of select="$loc/strs/itemsOptions/str[@id='armory.item-search.select.eofr']"/></a></span>&#160;&#160;
										<br/><br/>
									</div>
								</xsl:when>
							</xsl:choose>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</xsl:template>


</xsl:stylesheet>