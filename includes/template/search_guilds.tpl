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
		$(document).ready(function(){	
			changetype('all');
			
			var filterValues = [];
			
			//store filters
						
			
			initSearchResults("guilds", "{{$searchQuery}}", "", filterValues, "4");
		});	
	</script>
<div class="tabs">
{{if $charactersResultNum > 0}}
<div class="{{$characters_tab}}tab">
<a href="search.xml?searchType=all&amp;searchQuery={{$searchQuery}}&amp;selectedTab=characters">{{#armory_searchpage_characters#}}<span class="tab-count" style="display: inline;">({{$charactersResultNum}})</span></a>
</div>
{{/if}}
{{if $arenateamsResultNum > 0}}
<div class="{{$arenateams_tab}}tab">
<a href="search.xml?searchType=all&amp;searchQuery={{$searchQuery}}&amp;selectedTab=arenateams">{{#armory_searchpage_arenateams#}}<span class="tab-count" style="display: inline;">({{$arenateamsResultNum}})</span></a>
</div>
{{/if}}
{{if $guildsResultNum > 0}}
<div class="{{$guilds_tab}}tab">
<a href="search.xml?searchType=all&amp;searchQuery={{$searchQuery}}&amp;selectedTab=guilds">{{#armory_searchpage_guilds#}}<span class="tab-count" style="display: inline;">({{$guildsResultNum}})</span></a>
</div>
{{/if}}
{{if $itemsResultNum > 0}}
<div class="{{$items_tab}}tab">
<a href="search.xml?searchType=all&amp;searchQuery={{$searchQuery}}&amp;selectedTab=items">{{#armory_searchpage_items#}}<span class="tab-count" style="display: inline;">({{$itemsResultNum}})</span></a>
</div>
{{/if}}
<div class="clear"></div>
</div>
<div class="subTabs" style="height: 1px;">
<div class="upperLeftCorner" style="height: 5px;"></div>
<div class="upperRightCorner" style="height: 5px;"></div>
</div>
<div class="full-list">
<div class="info-pane">
<blockquote>
<b class="iguilds">
<h4>
<a href="index.xml">{{#armory_searchpage_searcharmory#}}</a>
</h4>
<h3 id="replaceHeaderTitle">{{#armory_searchpage_guilds#}}</h3>
</b>
</blockquote>
<div class="clear" style="border:1px solid transparent"></div>
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">{{#armory_guild_info_page_string#}} <input id="pagingInput" type="text"> {{#armory_guild_info_page_string_2#}} <span id="totalPages"></span>
</div>
<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">{{#armory_guild_info_show_string#}} <span class="bold" id="currResults"></span> {{#armory_guild_info_page_string_2#}} <span class="bold" id="totalResults">4</span> {{#armory_guild_info_results_string#}}</div>
<div id="pageSelector" style="float: right">
<a class="firstPg firstPg-on" href="javascript:void(0)"></a><a class="prevPg prevPg-on" href="javascript:void(0)"></a><a class="p" href="javascript:void(0)" id="pageSelect1"></a><a class="p" href="javascript:void(0)" id="pageSelect2"></a><a class="p" href="javascript:void(0)" id="pageSelect3"></a><a class="nextPg nextPg-on" href="javascript:void(0)"></a><a class="lastPg lastPg-on" href="javascript:void(0)"></a>
</div>{{#armory_guild_info_results_per_page#}}:<select id="pageSize"><option value="10">10</option><option selected value="20">20</option><option value="30">30</option><option value="40">40</option></select>
</form>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="searchResultsTable" style="width: 100%">
<thead>
<tr class="masthead">
<th><a>{{#armory_searchguilds_guild#}}<span class="sortArw"></span></a></th><th style="width: 200px;"><a>{{#armory_searchpage_realmname#}}<span class="sortArw"></span></a></th><th style="width: 200px;"><a>{{#armory_searchpage_battlegroup#}}<span class="sortArw"></span></a></th><th style="width: 100px;"><a>{{#armory_searchpage_faction#}}<span class="sortArw"></span></a></th><th style="width: 120px;"><a>{{#armory_searchpage_relevance#}}<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{{foreach from=$guildsResult item=guild}}
<tr>
<td><a href="guild-info.xml?r={{$realmName}}&amp;gn={{$guild.name}}">{{$guild.name}}</a></td><td>{{$realmName}}</td><td>{{#armory_searchpage_battlegroup_none#}}</td><td class="centNum"><img class="staticTip" onmouseover="setTipText('{{get_wow_faction race=$guild.race}}');" src="images/icons/faction/icon-{{get_wow_faction race=$guild.race numeric=true}}.gif"></td><td><span style="display: none;">100%</span><q class="staticTip" onmouseover="setTipText('100%');"><del class="rel-container"><a><em style="width:100%"></em></a></del></q></td>
</tr>
{{/foreach}}
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
{{include file="faq_character_sheet.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}