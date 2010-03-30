<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="guildInfo">

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">
					<xsl:call-template name="newGuildTabs" />
                    <div class="full-list">
                        <div class="info-pane">
							<div class="profile-wrapper">
								<div class="profile">
									<xsl:choose>
										<xsl:when test="guildBank">
		                           			<xsl:call-template name="guildContent" />
										</xsl:when>
										<xsl:otherwise>
											<xsl:call-template name = "armorymsg">
												<xsl:with-param name="title" select = "$loc/strs/guildBank/str[@id='error.accessdenied']" />
												<xsl:with-param name="message" select = "$loc/strs/guildBank/str[@id='error.notmember']" />
											</xsl:call-template>
										</xsl:otherwise>
									</xsl:choose>
						   		</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>


<xsl:template name="guildContent">

	<!-- character header -->
	<xsl:call-template name="newGuildHeader" />
	
	<script type="text/javascript" src="_js/guild/bank-log.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			initGuildBankLog(
								"<xsl:value-of select="$loc/strs/guildBank/str[@id='showguildinfo']"/>", 
								"<xsl:value-of select="$loc/strs/guildBank/str[@id='hideguildinfo']"/>",
								"<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.noSearchResults']" />");
		});
	</script>

	<!-- gmotd -->
	<div class="filterTitle"><xsl:value-of select="$loc/strs/guildBank/str[@id='guildmsgotd']"/>
	<a  id="guildInfoToggler" class="dropdownicon" href="javascript:;"><xsl:value-of select="$loc/strs/guildBank/str[@id='showguildinfo']"/></a>
	</div>
	<div class="filtercontainer" style="padding-left: 20px; margin: 0 10px;">
		<div style="width:820px; font-weight: bold;">
			<xsl:value-of select="substring(guildMessages/@motd,1,100)" />
			<xsl:if test="string-length(guildMessages/@motd) &gt; 100">
				<br /><xsl:value-of select="substring(guildMessages/@motd,101)" />
			</xsl:if>
		</div>
				
		<div id="guildInfoContainer">
			<strong><xsl:value-of select="$loc/strs/guildBank/str[@id='guildmsginfo']"/></strong><br />
			<xsl:value-of select="guildMessages/@info" />
		</div>
	</div>
	
	<xsl:choose>
		<xsl:when test="guildBank/banklogs/banklog">
			<xsl:call-template name="logFilters" />	
		</xsl:when>
		<xsl:otherwise>
			<br />
			<div class="filtercrest"></div>
			<div class="filtercontainer" style="margin: 0 10px;">
				<xsl:value-of select="$loc/strs/guildBank/str[@id='emptyLogs']" />
			</div>
			<div class="bottomshadow"></div>
			<br />
		</xsl:otherwise>
	</xsl:choose>
	
</xsl:template>

<xsl:template name="logFilters">
	
	<div class="filtercrest"><div class="filterTitle"><xsl:value-of select="$loc/strs/guildBank/str[@id='banklogresults']"/></div></div>
	<div class="filtercontainer" style="margin: 0 10px;">
	
		<!-- character filters -->
		<div class="outerfilterbox" style="float: left; margin: 0;">
			<div class="innerfilterbox">
				<div id="guildbanksfiltercharacter" class="contentsfilterbox">
					<div class="heightfilterbox">
						<div class="titlefilterbox"><xsl:value-of select="$loc/strs/guildBank/str[@id='characterfilters']" /></div>

						<div><input id="filCharName" type="text" maxlength="40" value="" class="filterInput banklogFilInput" />
							<xsl:value-of select="$loc/strs/guildBank/str[@id='charnamec']" />
						</div>
						<div style="margin: 7px 0 0 0;">
							<select id="filCharRank" class="banklogFilSelect" onchange="runBankLogFilters();">
								<option value="-1"><xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.all']"/></option>
								<xsl:for-each select="guildRanks/rank">									
									<option value="{@name}"><xsl:value-of select="@name" /></option>									
								</xsl:for-each>
							</select>
							<xsl:value-of select="$loc/strs/guildBank/str[@id='guildrankc']" />
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- transaction filters -->
		<div class="outerfilterbox" style="float: left; margin:0;">
			<div class="innerfilterbox">
				<div id="guildbanksfiltercharacter" class="contentsfilterbox">
					<div class="heightfilterbox">
						<div class="titlefilterbox" style="margin-bottom: 10px;"><xsl:value-of select="$loc/strs/guildBank/str[@id='transactionfilters']" /></div>
						
						<div>
							<select id="filTransOrigin" class="banklogFilSelect" onchange="runBankLogFilters();">
								<option value="-1"><xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.all']"/></option>
								<xsl:for-each select="guildBank/bags/bag">
									<xsl:if test="@viewable = 'true' and @name != ''">
										<option value="{@id}"><xsl:value-of select="@name" /></option>
									</xsl:if>
								</xsl:for-each>
							</select>
							<xsl:value-of select="$loc/strs/guildBank/str[@id='origin']" />
						</div>
						<div style="margin: 7px 0 0 0;">
							<select id="filTransType" class="banklogFilSelect" onchange="runBankLogFilters();">
								<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
								<option value="1"><xsl:value-of select="$loc/strs/guildBank/str[@id='deposititem']" /></option>
								<option value="2"><xsl:value-of select="$loc/strs/guildBank/str[@id='withdrawitem']" /></option>
								<option value="3"><xsl:value-of select="$loc/strs/guildBank/str[@id='moveitem']" /></option>
								<option value="4"><xsl:value-of select="$loc/strs/guildBank/str[@id='depositmoney']" /></option>
								<option value="5"><xsl:value-of select="$loc/strs/guildBank/str[@id='withdrawmoney']" /></option>
								<option value="6"><xsl:value-of select="$loc/strs/guildBank/str[@id='repair']" /></option>
								<option value="7"><xsl:value-of select="$loc/strs/guildBank/str[@id='moveitem']" /></option>
							</select>
							<xsl:value-of select="$loc/strs/guildBank/str[@id='ttype']" />
						</div>
						<div style="margin: 7px 0 0 0;">
							<select id="filTransDest" class="banklogFilSelect" onchange="runBankLogFilters();">
								<option value="-1"><xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.all']"/></option>
								<xsl:for-each select="guildBank/bags/bag">
									<xsl:if test="@viewable = 'true' and @name != ''">
										<option value="{@id}"><xsl:value-of select="@name" /></option>
									</xsl:if>
								</xsl:for-each>
							</select>
							<xsl:value-of select="$loc/strs/guildBank/str[@id='destination']" />
						</div>						
					</div>
				</div>
			</div>
		</div>

		<!-- item filters -->
		<div class="outerfilterbox"  style="margin: 0; float: left;">
			<div class="innerfilterbox">
				<div id="guildbanksfiltercharacter" class="contentsfilterbox">
					<div class="heightfilterbox">
						<div class="titlefilterbox"><xsl:value-of select="$loc/strs/guildBank/str[@id='itemfilters']" /></div>					
						
						<div>
							<input id="filItemName" type="text" maxlength="40" value="" class="filterInput banklogFilInput" />
							<xsl:value-of select="$loc/strs/guildBank/str[@id='itemname']" />
						</div>
						
						<div style="margin: 7px 0 0 0;">						
							<select id="filItemQuality" class="banklogFilSelect" onchange="runBankLogFilters();">
								<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
								<option value="0"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.poor']"/></option>
								<option value="1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.common']"/></option>
								<option value="2"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.uncommon']"/></option>
								<option value="3"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.rare']"/></option>
								<option value="4"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.epic']"/></option>
								<option value="5"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.legendary']"/></option>
								<option value="6"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.heirloom']"/></option>
							</select>
							<xsl:value-of select="$loc/strs/guildBank/str[@id='itemquality']"/> 
						</div>												
					</div>
				</div>
			</div>
		</div>	
		
		<div class="clear"></div>
		<!-- reset filters -->
		<div id="filterButtonHolder">
			<a id="runFilterButton" href="javascript:void(0)" onclick="resetBankLogFilters();" style="cursor: pointer;">
				<span class="btnRight"><xsl:value-of select="$loc/strs/guildBank/str[@id='resetfilters']"/></span>
			</a>            
		</div>		
		<div class="clear"></div>	
	</div>
	<div class="bottomshadow"></div>


	<!-- pager -->
	<div id="pager" class="pager page-body" style="text-align:right;">
        <form id="pagingForm" style="margin: 0; padding: 0; display: inline;" onsubmit="return false;">
        	<div id="searchTypeHolder"></div>
            <div style="float: left; margin-left: 5px;">
				<!-- Page X of X -->
				<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.paging']">
					<xsl:with-param name="param1">
						<input id="pagingInput" type="text" />
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalPages"></span>
					</xsl:with-param>				
				</xsl:apply-templates>
            </div>
            <div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">			
				<!-- showing X of X results -->				
				<xsl:apply-templates mode="printf" select="$loc/strs/itemsOptions/str[@id='armory.search.showing']">
					<xsl:with-param name="param1">
						<span id="currResults" class="bold"><xsl:value-of select="count(guildBank/banklogs/banklog[not(@unknown=1)])" /></span>
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalResults" class="bold"><xsl:value-of select="count(guildBank/banklogs/banklog[not(@unknown=1)])" /></span>
					</xsl:with-param>				
				</xsl:apply-templates>
            </div>
            <div id="pageSelector" style="float: right">
                <a class="firstPg firstPg-on" href="javascript:void(0)"> </a>
                <a class="prevPg prevPg-on" href="javascript:void(0)"> </a>
                <a id="pageSelect1" class="p" href="javascript:void(0)"> </a>
                <a id="pageSelect2" class="p" href="javascript:void(0)"> </a>
                <a id="pageSelect3" class="p" href="javascript:void(0)"> </a>
                <a class="nextPg nextPg-on" href="javascript:void(0)"> </a>
                <a class="lastPg lastPg-on" href="javascript:void(0)"> </a>
            </div>
			<xsl:value-of select="$loc/strs/arena/str[@id='resultsPerPage']"/>
            <select id="pageSize">
                <option selected="selected" value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
            </select>
        </form>
    </div>

	<div class="data">
        <table id="bankLogTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
            <thead>
                <tr class="masthead">					
                    <th style="width: 130px;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.tabs.characterSheet']" /><span class='sortArw'> </span></a></th>
					<th style="width: 130px;"><a><xsl:value-of select="$loc/strs/general/str[@id='rank']" /><span class='sortArw'> </span></a></th>
                    <th style="width: 50px;">
						<a class="staticTip" onmouseover="setTipText('{$loc/strs/guildBank/str[@id='col.origin.tooltip']}')">
							<xsl:value-of select="$loc/strs/guildBank/str[@id='col.origin']" /><span class='sortArw'> </span></a>
					</th>
					<th style="width: 50px;">
						<a class="staticTip" onmouseover="setTipText('{$loc/strs/guildBank/str[@id='col.action.tooltip']}')">
							<xsl:value-of select="$loc/strs/guildBank/str[@id='col.action']" /><span class='sortArw'> </span></a>
					</th>
					<th style="width: 50px;">
						<a class="staticTip" onmouseover="setTipText('{$loc/strs/guildBank/str[@id='col.destination.tooltip']}')">
							<xsl:value-of select="$loc/strs/guildBank/str[@id='col.destination']" /><span class='sortArw'> </span></a>
					</th>
					<th><a><xsl:value-of select="$loc/strs/guildBank/str[@id='col.item']" /><span class='sortArw'> </span></a></th>
					<th style="width: 170px;"><a><xsl:value-of select="$loc/strs/arena/str[@id='time']" /><span class='sortArw'> </span></a></th>
                </tr>
            </thead>
            <tbody id="tableTbody">
				<xsl:for-each select="guildBank/banklogs/banklog">
					<xsl:if test="not(@unknown = 1)">
						<xsl:variable name="subInfo" select="current()/item" />			
						<tr>
							<td><a href="/character-sheet.xml?n={@player}&amp;r={/page/guildInfo/guildHeader/@realm}"><xsl:value-of select="@player" /></a></td>
							<td><xsl:value-of select="/page/guildInfo/guildRanks/rank[@id=current()/@rank]/@name" /></td>
							<td>
								<span style="display: none"><xsl:value-of select="@otab" /></span>
								<xsl:if test="not(@otab = '')">
									<span class="staticTip" onmouseover="setTipText('{/page/guildInfo/guildBank/bags/bag[@id=current()/@otab]/@name}')" 
										style="background: url('wow-icons/_images/21x21/{/page/guildInfo/guildBank/bags/bag[@id=current()/@otab]/@icon}.png') no-repeat; 
										display: block; width: 21px; height: 21px;" />
								</xsl:if>
							</td>
							<td>
								<span style="display: none"><xsl:value-of select="@type" /></span>
								<span onmouseover="setTipText('{$loc/strs/guildBank/str[@id=concat('transaction.',current()/@type)]}')" 
									class="staticTip" style="background: url('images/guildbank/transaction/type{@type}.gif') no-repeat; 
									width: 30px; height: 21px; display: block;"></span>
							</td>
							<td>
								<span style="display: none"><xsl:value-of select="@dtab" /></span>
								<xsl:if test="not(@dtab = '')">
									<span class="staticTip" onmouseover="setTipText('{/page/guildInfo/guildBank/bags/bag[@id=current()/@dtab]/@name}')" 
										style="background: url('wow-icons/_images/21x21/{/page/guildInfo/guildBank/bags/bag[@id=current()/@dtab]/@icon}.png') no-repeat; 
										display: block; width: 21px; height: 21px;" />
								</xsl:if>
							</td>
							<td>								
								<xsl:choose>
									<xsl:when test="$subInfo">
										<span style="display: none"><xsl:value-of select="$subInfo/@qi" /></span>
										<a href="item-info.xml?i={@id}" class="staticTip itemToolTip rarity{$subInfo/@qi}" id="i={$subInfo/@id}" 
											style="background: url('wow-icons/_images/21x21/{$subInfo/@icon}.png') no-repeat; padding: 2px 0 5px 25px;">
											<xsl:value-of select="$subInfo/@name" /></a> x <xsl:value-of select="$subInfo/@count" />
									</xsl:when>
									<xsl:otherwise>
										<span style="display: none"></span>
										<span style="display: none"></span>
										<xsl:call-template name="goldFormat">
											<xsl:with-param name="totalMoney" select="@money" />
											<xsl:with-param name="styleSuffix" select="''" />
										</xsl:call-template>
									</xsl:otherwise>
								</xsl:choose>
							</td>
							<td><span class="timeFormat"><xsl:value-of select="@ts" /></span></td>
						</tr>
					</xsl:if>
				</xsl:for-each>
			</tbody>
		</table>
	</div>
</xsl:template>


</xsl:stylesheet>