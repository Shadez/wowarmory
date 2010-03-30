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
                                        <!--
										<xsl:otherwise>
											<xsl:call-template name = "armorymsg">
												<xsl:with-param name="title" select = "$loc/strs/guildBank/str[@id='error.accessdenied']" />
												<xsl:with-param name="message" select = "$loc/strs/guildBank/str[@id='error.notmember']" />
											</xsl:call-template>										
										</xsl:otherwise> -->
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

	<script type="text/javascript" src="_js/guild/bank-contents.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			initGuildBankContents("<xsl:value-of select="$loc/strs/guildBank/str[@id='showguildinfo']"/>", 
								  "<xsl:value-of select="$loc/strs/guildBank/str[@id='hideguildinfo']"/>",
								  "<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.search.label.noSearchResults']" />");
		});
	</script>

	<!-- character header -->
	<xsl:call-template name="newGuildHeader" />
	
	<!-- gmotd -->
	<div class="filterTitle"><xsl:value-of select="$loc/strs/guildBank/str[@id='guildmsgotd']"/>
	<a id="guildInfoToggler" class="dropdownicon" onclick="javascript:;"><xsl:value-of select="$loc/strs/guildBank/str[@id='showguildinfo']"/></a>
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
		<xsl:when test="guildBank/items/item">
			<xsl:call-template name="guildContentListing" />
		
		</xsl:when>
		<xsl:otherwise>
			<br />
			<div class="filtercrest"></div>
			<div class="filtercontainer" style="margin: 0 10px;">
				<xsl:value-of select="$loc/strs/guildBank/str[@id='errortitle']" />
			</div>
			<div class="bottomshadow"></div>
			<br />
	
		</xsl:otherwise>
	
	</xsl:choose>
</xsl:template>



<xsl:template name="guildContentListing">
	<!-- bank contents view -->	
	<div class="filterTitle"><xsl:value-of select="$loc/strs/guildBank/str[@id='bankcontents']"/></div>
	
	<div style="width: 819px; height: 519px; background: url('images/guildbanks-frame.jpg') top left no-repeat; margin: 0 auto; position:relative; ">
		<div id="whichTabDisplay" class="filtertitle" style="background: url('wow-icons/_images/43x43/{guildBank/bags/bag[@viewable='true']/@icon}.png') no-repeat;">
			<xsl:value-of select="guildBank/bags/bag[@viewable='true']/@name" />
		</div>
		<!-- print the icons -->
		<div id="tabContentHolder" style="width: 800px; height: 331px; top: 93px; left: 49px; position: absolute;">			
			<!-- print 14 guild columns -->
			<xsl:for-each select="guildBank/bags/bag[@viewable='true']">				
				<div id="banktab{@id}" class="oneBankTab" style="display: none;">
					<xsl:if test="position() = 1">
						<xsl:attribute name="style">display: block</xsl:attribute>
					</xsl:if>
					<xsl:call-template name="oneBankColumn">
						<xsl:with-param name="start" select="'0'" />
						<xsl:with-param name="end" select="'13'" />
						<xsl:with-param name="whichTab" select="current()/@id" />	
					</xsl:call-template>	
				</div>
			</xsl:for-each>
		</div>
	
		<!-- print tab icons -->
		<div id="banktabs" style="margin-top: 18px;">
			<xsl:for-each select="guildBank/bags/bag[@viewable='true']">
				<xsl:if test="@name != ''">			
					<a href="javascript:void(0)" class="staticTip bankTabIcon" onclick="toggleBankTab(this,'{@id}','{@name}','{@icon}');" 
						onmouseover="setTipText('{@name}');" 
						style="background:url('wow-icons/_images/43x43/{@icon}.png') no-repeat;">
							<div class="hoverBankTab">
								<img id="bankHighlight{@id}" src="images/guildbank-tab-selected.gif">
									<xsl:if test="position() = 1"><xsl:attribute name="style">display: block</xsl:attribute></xsl:if>
								</img>
							</div>
					</a>
				</xsl:if>
				
			</xsl:for-each>
		</div>
		
		<!-- guild bank money -->
		<div style="position:absolute; top: 463px; right: 65px; width: 215px; text-align:center; color: #FFFFFF;">
			<xsl:call-template name="goldFormat">
				<xsl:with-param name="totalMoney" select="guildBank/@money" />
				<xsl:with-param name="styleSuffix" select="'_d'" />
			</xsl:call-template>
		</div>
		
	</div>	
	
	<!-- filters -->
	<div class="filtercrest"><div class="filterTitle"><xsl:value-of select="$loc/strs/guildBank/str[@id='bankcontentsfilters']"/></div></div>
	<div class="filtercontainer" style="margin: 0 10px;">
		<div class="filterBox">
			<xsl:value-of select="$loc/strs/guildBank/str[@id='itemname']"/><br />
			<input id="filItemName" type="text" size="40" maxlength="40" value="" class="filterInput" style="width: 200px;"/>
		</div>
		<div class="filterBox">
			<xsl:value-of select="$loc/strs/guildBank/str[@id='itemquality']"/><br />
			<select id="filRarity" onchange="runBankContentFilters()">
				<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
				<option value="0"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.poor']"/></option>
				<option value="1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.common']"/></option>
				<option value="2"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.uncommon']"/></option>
				<option value="3"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.rare']"/></option>
				<option value="4"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.epic']"/></option>
				<option value="5"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.legendary']"/></option>
                <option value="6"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.heirloom']"/></option>
			</select>
		</div>
		<!-- item type -->
		<div class="filterBox">
			<xsl:value-of select="$loc/strs/guildBank/str[@id='itemtype']"/><br />
			<select id="filItemType" onchange="runBankContentFilters()">
				<option value="-1"><xsl:value-of select="$loc/strs/items/rarity/str[@id='armory.item-search.all']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.weapons']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.armor']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.gems']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.containers']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.consumables']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.tradegoods']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.projectiles']"/></option>				
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.quivers']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.reagents']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.miscellaneous']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.enchantments']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.mounts']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.smallpets']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.glyphs']"/></option>
				<option><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.keys']"/></option>
			</select>
		</div>
		
		<!-- tab -->
		<div class="filterBox">
			<xsl:value-of select="$loc/strs/guildBank/str[@id='bag']"/><br />
			<select id="filTab" style="width: 100px;" onchange="runBankContentFilters()">
				<option value="-1"><xsl:value-of select="$loc/strs/arenaReport/str[@id='filter.all']"/></option>
				<xsl:for-each select="guildBank/bags/bag">
					<xsl:if test="@viewable = 'true' and @name != ''">
						<option value="{@id}"><xsl:value-of select="@name" /></option>
					</xsl:if>
				</xsl:for-each>
			</select>
		</div>		
		<div class="clear"></div>
		<!-- reset filters -->
		<div id="filterButtonHolder">
			<a id="runFilterButton" href="javascript:void(0)" onclick="resetBankContentsFilters();" style="cursor: pointer;">
				<span class="btnRight"><xsl:value-of select="$loc/strs/guildBank/str[@id='resetfilters']"/></span>
			</a>            
		</div>	
	</div>
	<div class="bottomshadow"></div>
	
	<!-- tab contents -->
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
						<span id="currResults" class="bold"><xsl:value-of select="count(guildBank/items/item)" /></span>
					</xsl:with-param>
					<xsl:with-param name="param2">
						<span id="totalResults" class="bold"><xsl:value-of select="count(guildBank/items/item)" /></span>
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
        <table id="bankContentsTable" class="data-table sortTable" cellpadding="0" cellspacing="0" style="width: 100%">
            <thead>
                <tr class="masthead">					
                    <th style="width: 350px; text-align:left;"><a><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.items']"/><span class='sortArw'> </span></a></th>
					<th style="width: 200px; text-align:left;"><a><xsl:value-of select="$loc/strs/guildBank/str[@id='type']"/><span class='sortArw'> </span></a></th>
                    <th style="width: 150px; text-align:left;"><a><xsl:value-of select="$loc/strs/guildBank/str[@id='subtype']"/><span class='sortArw'> </span></a></th>
					<th style="text-align:left; min-width: 100px;"><a><xsl:value-of select="$loc/strs/guildBank/str[@id='bagnospaceone']"/><span class='sortArw'> </span></a></th>
					<!--<th style="text-align:left;"><a>Slot<span class='sortArw'> </span></a></th>-->
                </tr>
            </thead>
            <tbody>
				<xsl:for-each select="guildBank/items/item">				
					<tr>
						<td>							
							<a href="/item-info.xml?i={@id}" class="staticTip itemToolTip rarity{@qi}" id="i={@id}" 
								style="background: url('wow-icons/_images/21x21/{@icon}.png') no-repeat 0 50%; padding: 3px 0 3px 25px; line-height: 28px;">
								<xsl:value-of select="@name" />
							</a> x <xsl:value-of select="@quantity" />
						</td>
						<td style="white-space:nowrap;"><xsl:value-of select="$loc/strs/items/types/str[@id=concat('armory.item-search.', current()/@type)]"/>
						</td>
						<td>
							<span style="display: none"><xsl:value-of select="@qi"/></span>
							<xsl:value-of select="@subtypeLoc" />
						</td>
						<td>
							<span style="display: none"><xsl:value-of select="@bag"/></span>
							<xsl:value-of select="/page/guildInfo/guildBank/bags/bag[@id=current()/@bag]/@name" /></td>
						<!--<td><xsl:value-of select="@slot" /></td>-->
					</tr>
				</xsl:for-each>
			</tbody>
		</table>
	</div>
</xsl:template>


<!-- recursive bank item -->
<xsl:template name="oneBankItem">
	<xsl:param name="ctr" />
	<xsl:param name="max" />
	<xsl:param name="whichTab" />
	
	<xsl:if test="$ctr &lt;= $max">
		<xsl:variable name="currItem" select="../../items/item[@bag=$whichTab][@slot=$ctr]" />
		
		<a href="javascript:void(0)" class="singleBankItem {$ctr}" style="cursor: default;">			
			<xsl:if test="$currItem">
				<xsl:attribute name="style">background:url(wow-icons/_images/43x43/<xsl:value-of select="$currItem/@icon" />.png) no-repeat 4px 1px;</xsl:attribute>
				<xsl:attribute name="class">singleBankItem staticTip itemToolTip</xsl:attribute>
				<xsl:attribute name="id"><xsl:value-of select="concat('i=',$currItem/@id)" /></xsl:attribute>
				<div class="hoverBankItem">				
					<span><xsl:if test="$currItem/@quantity &gt; 1"><xsl:value-of select="$currItem/@quantity" /></xsl:if></span>
				</div>
			</xsl:if>
		</a>
		<xsl:call-template name="oneBankItem">
			<xsl:with-param name="ctr" select="$ctr + 1" />
			<xsl:with-param name="max" select="$max" />
			<xsl:with-param name="whichTab" select="$whichTab" />
		</xsl:call-template>
	</xsl:if>
</xsl:template>

<!-- recursive bank column -->
<xsl:template name="oneBankColumn">
	
	<xsl:param name="start" />
	<xsl:param name="end" />
	<xsl:param name="whichTab" />
	
	<xsl:if test="$start &lt;= $end">
		<div class="bankCol">
			<xsl:if test="($start + 1) mod 2 = 0">
				<xsl:attribute name="style">margin-right: 1px</xsl:attribute>
			</xsl:if>
			<xsl:call-template name="oneBankItem">
				<xsl:with-param name="ctr" select="($start * 7) + 1" />
				<xsl:with-param name="max" select="($start * 7) + 7" />
				<xsl:with-param name="whichTab" select="$whichTab" />
			</xsl:call-template>
		</div>
		<xsl:call-template name="oneBankColumn">
			<xsl:with-param name="start" select="$start + 1" />
			<xsl:with-param name="end" select="$end" />
			<xsl:with-param name="whichTab" select="$whichTab" />
		</xsl:call-template>
	</xsl:if>
</xsl:template>



</xsl:stylesheet>