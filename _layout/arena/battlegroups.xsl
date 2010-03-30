<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:template name="head-content"><link rel="stylesheet" type="text/css" href="_css/battlegroups.css" />   
	
	<script type="text/javascript">
		/* <![CDATA[ */
		var canPop = true;
		function goToArenaLadder(teamSize, bgUrl){
			window.location = "arena-ladder.xml?ts=" + teamSize + "&" + bgUrl;
		}
		function popSelected(div){
			if((canPop == true) && !($.browser.msie && $.browser.version == "6.0"))
				$(div).find("a.selected").attr("style","text-decoration:none;color:#FFF!important;font-size:15px!important;font-weight:bold;");
		}
		function hideSelected(div){
			$(div).find("a.selected").attr("style","");		
		}
		$(document).ready(function(){
			$(".battlegroups .battlegroupList .battlegroup .ladderChoice a").hover(
				function(){
					canPop = false;
					$(this).attr("style","text-decoration:none;color:#FFF!important;font-size:15px!important;font-weight:bold;");
				},
				function(){
					canPop = true;
					$(this).attr("style","");
				}
			);
		});
		/* ]]>*/
	</script>	
</xsl:template>



<xsl:template match="battlegroups">
	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">				
                <div class="list">					
                    <div class="team-side notab">
                        <div class="info-pane">	
							<div class="profile-wrapper">					
								<blockquote>
									<b class="iarenateams">
										<h4><a href="javascript:void(0)"><xsl:value-of select="$loc/strs/arena/str[@id='arena-ladders']"/></a></h4>
										<h3><xsl:value-of select="$loc/strs/arena/str[@id='select-battlegroup']"/></h3>
									</b>									
								</blockquote>
								<xsl:call-template name="battlegroupsContent" />
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>

<xsl:template name="battlegroupsContent">

	<xsl:variable name="teamSize">
		<xsl:choose>
			<xsl:when test="not(battlegroups/@ts)">2</xsl:when>
			<xsl:otherwise><xsl:value-of select="battlegroups/@ts" /></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<!-- battlegroups list -->
	<div class="battlegroups">
		<div class="battlegroupList">
			<div class="selectTitle"><xsl:value-of select="$loc/strs/arena/str[@id='select-battlegroup']"/></div>
			<div class="realmSelect">
				<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.select-battlegroup.label.select-realm']" /> 
				<select onchange="goToArenaLadder('{$teamSize}',this.value);">
					<option value="-1">--</option>
					<xsl:for-each select="battlegroup[not(@tournamentBattleGroup=1)]/realms/realm">
						<xsl:sort select="@name" />
						<option value="{../../@ladderUrl}"><xsl:value-of select="@name" /></option>
					</xsl:for-each>
				</select>
			</div>
			
			<div class="clear" />
			
			<xsl:for-each select="battlegroup[not(@tournamentBattleGroup)]">
				<xsl:sort select="@display" />
				<xsl:if test="realms/realm">
					<div class="battlegroup" onmouseout="hideSelected(this)" onmouseover="popSelected(this);">
						<a href="arena-ladder.xml?ts={$teamSize}&amp;{@ladderUrl}" class="title"><xsl:value-of select="@display" /></a>
						<div class="ladderChoice">
							<table>
								<tr> 
									<td>
										<a href="arena-ladder.xml?ts=2&amp;{@ladderUrl}">
										<xsl:if test="$teamSize = '2'"><xsl:attribute name="class">selected</xsl:attribute></xsl:if>
										<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.team-info.2v2']" /></a></td>
									<td>
										<a href="arena-ladder.xml?ts=3&amp;{@ladderUrl}">
											<xsl:if test="$teamSize = '3'"><xsl:attribute name="class">selected</xsl:attribute></xsl:if>
											<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.team-info.3v3']" /></a></td>
									<td>
										<a href="arena-ladder.xml?ts=5&amp;{@ladderUrl}">
											<xsl:if test="$teamSize = '5'"><xsl:attribute name="class">selected</xsl:attribute></xsl:if>
											<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.team-info.5v5']" /></a></td>
								</tr>
							</table>
						</div>
					</div>
				</xsl:if>
			</xsl:for-each>
			<div class="clear" />
		</div>
		<!-- tournament realms -->
		<div class="battlegroupList tournamentRealms">
			<div class="selectTitle" style="padding-top: 5px"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.arenatab.arenaTournament']" /></div>
			<div class="clear" />
			<xsl:for-each select="battlegroup[@tournamentBattleGroup='1']">
				<div class="battlegroup" onclick="goToArenaLadder('3','{@ladderUrl}');">
					<a href="arena-ladder.xml?ts={$teamSize}&amp;{@ladderUrl}" class="title tournamentRealm"><xsl:value-of select="@display" /></a>
				</div>
			</xsl:for-each>
			<div class="clear" />
		</div>
		<div class="clear" />
	</div>	
</xsl:template>

</xsl:stylesheet>
