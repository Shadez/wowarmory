<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<script src="_js/items/functions.js" type="text/javascript"></script>
<script src="_js/search/search.js" type="text/javascript"></script>
<script type="text/javascript">
{literal}
		$(document).ready(function(){	
			changetype('all');
{/literal}			
			var filterValues = [];
   {if $search_filters}
            filterValues["source"] = "{$search_filters.source}";
            filterValues["type"] = "{$search_filters.type}";
            filterValues["dungeon"] = "{$search_filters.dungeon}";
            filterValues["rrt"] = "{$search_filters.rrt}";
            filterValues["boss"] = "{$search_filters.boss}";
            filterValues["andor"] = "{$search_filters.andor}";
            filterValues["rqrMin"] = "";
            filterValues["usbleBy"] = "all";
            filterValues["difficulty"] = "{$search_filters.difficulty}";
            filterValues["advOpt"] = "none";
            filterValues["rqrMax"] = "";
   {/if}
			//store filters
			initSearchResults("items", "{$searchQuery}", "", filterValues, "3");
{literal}		});	{/literal}
	</script>
<div class="tabs">
{if $charactersResultNum > 0}
<div class="{$characters_tab}tab">
<a href="search.xml?searchType=all&amp;searchQuery={$searchQuery}&amp;selectedTab=characters">{#armory_searchpage_characters#}<span class="tab-count" style="display: inline;">({$charactersResultNum})</span></a>
</div>
{/if}
{if $arenateamsResultNum > 0}
<div class="{$arenateams_tab}tab">
<a href="search.xml?searchType=all&amp;searchQuery={$searchQuery}&amp;selectedTab=arenateams">{#armory_searchpage_arenateams#}<span class="tab-count" style="display: inline;">({$arenateamsResultNum})</span></a>
</div>
{/if}
{if $guildsResultNum > 0}
<div class="{$guilds_tab}tab">
<a href="search.xml?searchType=all&amp;searchQuery={$searchQuery}&amp;selectedTab=guilds">{#armory_searchpage_guilds#}<span class="tab-count" style="display: inline;">({$guildsResultNum})</span></a>
</div>
{/if}
{if $itemsResultNum > 0}
<div class="{$items_tab}tab">
<a href="search.xml?searchType=all&amp;searchQuery={$searchQuery}&amp;selectedTab=items">{#armory_searchpage_items#}<span class="tab-count" style="display: inline;">({$itemsResultNum})</span></a>
</div>
{/if}
<div class="clear"></div>
</div>
<div class="subTabs" style="height: 1px;">
<div class="upperLeftCorner" style="height: 5px;"></div>
<div class="upperRightCorner" style="height: 5px;"></div>
</div>
<div class="full-list">
<div class="info-pane">
<blockquote>
<b class="iitems">
<h4>
<a href="index.xml">{#armory_searchpage_searcharmory#}</a>
</h4>
<h3 id="replaceHeaderTitle">{#armory_item_info_items_string#}</h3>
</b>
</blockquote>
<div class="filter-containter" style="display: block; margin-bottom: 25px;">
<p>
<div class="filter-loc">
<div class="open-filter">
<em class="copy-link-left"><a class="filter-red" href="javascript: toggleItemFilter();triggerRender();"><strong id="replaceShowFilters1">Показать фильтры</strong><b id="replaceShowFilters2">Показать фильтры</b></a></em>
</div>
</div>
</p>
</div>
<div class="clear"></div>

{include file="search_filter_$locale.tpl"}


<script src="_js/items/functions.js" type="text/javascript"></script>
<script type="text/javascript">
{literal}	
	var theCounter = 0;
	var currentAdvOpt = "";  

	$(document).ready(function(){

		theCurrentForm="default";
	
		cloneDelete('childItemName', 'parentItemName');
		cloneDelete('childItemType', 'parentItemType');
		cloneDelete('childSource', 'parentSource');  
	  
		document.getElementById('parentAdvancedFilters').appendChild(document.getElementById('childAdvOptionsWeapon'));		
	
		var advOptArray = new Array;
	
{/literal}		
			
					var filterName="source";
					var filterValue="{$search_filters.source}";
{literal}	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changesource)
								changesource(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
				
			
					var filterName="type";
					var filterValue="all";
	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changetype)
								changetype(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
{/literal}          
        {if $search_filters.dungeon}          
                    var filterName="dungeon";
					var filterValue="{$search_filters.dungeon}";
	
{literal}	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName('fl['+ filterName +']')[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('fl[andor]')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('fl[andor]')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changedungeon)
								changedungeon(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
{/literal}
        {/if}
{literal}
			
					var filterName="rrt";
					var filterValue="all";
	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changerrt)
								changerrt(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
{/literal}
        {if $search_filters.boss}				
                    var filterName="boss";
					var filterValue="{$search_filters.boss}";
{literal}	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName('fl['+ filterName +']')[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('fl[andor]')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('fl[andor]')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changeboss)
								changeboss(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
{/literal}
        {/if}
{literal}		
					var filterName="andor";
					var filterValue="and";
	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changeandor)
								changeandor(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
				
			
					var filterName="rqrMin";
					var filterValue="";
	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changerqrMin)
								changerqrMin(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
				
			
					var filterName="usbleBy";
					var filterValue="all";
	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changeusbleBy)
								changeusbleBy(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
					
					advOptArray[1 - 1]="none";	
{/literal}				
			
					var filterName="difficulty";
					var filterValue="{$search_filters.difficulty}";
{literal}	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName('fl['+ filterName +']')[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('fl[andor]')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('fl[andor]')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changedifficulty)
								changedifficulty(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
					
					advOptArray[1 - 1]="none";
                    
                    var filterName="rqrMax";
					var filterValue="";
	
	
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName(''+ filterName)[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('andor')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('andor')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changerqrMax)
								changerqrMax(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}
					{/literal}
                    
                    var filterName="faction";
					var filterValue="{$search_filters.faction}";
	
	               {literal}
					if(!(filterName == "selSubTp") && !(filterName == "selSlot") && !(filterName == "selType")){
					
						var formElement=document.getElementsByName('fl['+ filterName +']')[0];
						
						if (formElement.nodeName == "INPUT" && filterValue != "all") {
							if (filterValue == "and")
								document.getElementsByName('fl[andor]')[0].checked=1;
							else if (filterValue == "or")
								document.getElementsByName('fl[andor]')[1].checked=1;
							else
								formElement.value=filterValue;
						}else if (formElement.nodeName == "SELECT") {		
							if (window.changefaction)
								changefaction(filterValue);
							
							document.getElementsByName(filterName + filterValue)[0].selected=1;
						}
					}		

		for (y=0; y < advOptArray.length; y++) {
			theString = advOptArray[y];
			theString = theString.split("_");
			addPredefinedAdvOpt(theString[0], theString);
		}
	
{/literal}		
		theCounter = 0;
		searchText = "black"
		document.getElementById('searchQuery').value="{$searchQuery}";
	
{literal}
		//on enter make it submit the form
		$("#formItem").keypress(function(e){
			//submit form
			if(e.which == 13){
				$("#formItem")[0].submit();
			}
		});

	});
{/literal}
</script>
<div class="clear"></div>
</div>
<div class="clear" style="border:1px solid transparent"></div>
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">{#armory_guild_info_page_string#} <input id="pagingInput" type="text" /> {#armory_guild_info_page_string_2#} <span id="totalPages"></span>
</div>
<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">{#armory_guild_info_show_string#} <span class="bold" id="currResults"></span> {#armory_guild_info_page_string_2#} <span class="bold" id="totalResults">{$itemsResultNum}</span> {#armory_guild_info_results_string#}</div>
<div id="pageSelector" style="float: right">
<a class="firstPg firstPg-on" href="javascript:void(0)"></a><a class="prevPg prevPg-on" href="javascript:void(0)"></a><a class="p" href="javascript:void(0)" id="pageSelect1"></a><a class="p" href="javascript:void(0)" id="pageSelect2"></a><a class="p" href="javascript:void(0)" id="pageSelect3"></a><a class="nextPg nextPg-on" href="javascript:void(0)"></a><a class="lastPg lastPg-on" href="javascript:void(0)"></a>
</div>{#armory_guild_info_results_per_page#}:<select id="pageSize"><option value="10">10</option><option selected value="20">20</option><option value="30">30</option><option value="40">40</option></select>
</form>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="searchResultsTable" style="width: 100%">
<thead>
<tr class="masthead">
<th><a>{#armory_searchitems_item#}<span class="sortArw"></span></a></th><th style="width: 150px;"><a>{#armory_searchitems_ilevel#}<span class="sortArw"></span></a></th><th style="width: 250px;"><a>{#armory_searchitems_source#}<span class="sortArw"></span></a></th><th style="width: 150px;"><a>{#armory_searchpage_relevance#}<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{foreach from=$itemResults item=item}
<tr>
<td><a class="rarity{$item.Quality} staticTip itemToolTip" href="item-info.xml?i={$item.entry}" id="{$item.entry}" style="background: url('wow-icons/_images/21x21/{$item.icon}.png') 0 0 no-repeat; padding: 2px 0 4px 25px;">{$item.name}</a></td><td class="leftNum">{$item.ItemLevel}</td><td>{if $item.source}
<a href="search.xml?source=dungeon&amp;dungeon={$item.source_instance_key}&amp;boss={if $item.source_boss_key}{$item.source_boss_key}{else}all{/if}&amp;difficulty=all&amp;type=all&amp;searchType=items">{$item.source}</a>{else}<!-- Unknown source -->{#string_class_10#} <!-- // Unknown source-->{/if}</td><td style="text-align:left;"><span style="display: none;">100%</span><q class="staticTip" onmouseover="setTipText('100%');"><del class="rel-container"><a><em style="width:100%"></em></a></del></q></td>
</tr>
{/foreach}
</tbody>
</table>
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
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{include file="faq_character_sheet.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}