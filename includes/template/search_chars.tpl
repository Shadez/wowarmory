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
			
			var filterValues = [];
			
			//store filters						
			
			initSearchResults("characters", "{{$searchQuery}}", "", filterValues, "8");
		});	
	</script>
<div class="tabs">
{{if $charactersResultNum > 0}}
<div class="{{$characters_tab}}tab">
<a href="search.xml?searchType=all&amp;searchQuery={{$searchQuery}}&amp;selectedTab=characters">Персонажи<span class="tab-count" style="display: inline;">({{$charactersResultNum}})</span></a>
</div>
{{/if}}
{{if $itemsResultNum > 0}}
<div class="{{$items_tab}}tab">
<a href="search.xml?searchType=all&amp;searchQuery={{$searchQuery}}&amp;selectedTab=items">Предметы<span class="tab-count" style="display: inline;">({{$itemsResultNum}})</span></a>
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
<b class="icharacters">
<h4>
<a href="index.xml">Поиск по Оружейной</a>
</h4>
<h3 id="replaceHeaderTitle">Персонажи</h3>
</b>
</blockquote>
<div class="clear"></div>
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">Страница <input id="pagingInput" type="text" /> из <span id="totalPages"></span>
</div>
<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">Показать <span class="bold" id="currResults"></span> из <span class="bold" id="totalResults">1</span> результатов</div>
<div id="pageSelector" style="float: right">
<a class="firstPg firstPg-on" href="javascript:void(0)"></a><a class="prevPg prevPg-on" href="javascript:void(0)"></a><a class="p" href="javascript:void(0)" id="pageSelect1"></a><a class="p" href="javascript:void(0)" id="pageSelect2"></a><a class="p" href="javascript:void(0)" id="pageSelect3"></a><a class="nextPg nextPg-on" href="javascript:void(0)"></a><a class="lastPg lastPg-on" href="javascript:void(0)"></a>
</div>Результатов на странице:<select id="pageSize"><option value="10">10</option><option selected value="20">20</option><option value="30">30</option><option value="40">40</option></select>
</form>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="searchResultsTable" style="width: 100%">
<thead>
<tr class="masthead">
<th><a>Имя персонажа<span class="sortArw"></span></a></th><th><a>Уровень<span class="sortArw"></span></a></th><th><a>Раса<span class="sortArw"></span></a></th><th><a>Класс<span class="sortArw"></span></a></th><th><a>Фракция<span class="sortArw"></span></a></th><th><a>Гильдия<span class="sortArw"></span></a></th><th><a>Игровой мир<span class="sortArw"></span></a></th><th><a>Боевая группа<span class="sortArw"></span></a></th><th style="width: 90px;"><a>Соответствие<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{{foreach from=$charactersResult item=char}}
<tr>
<td><a href="character-sheet.xml?n={{$char.name}}">{{$char.name}}</a></td>
<td class="rightNum">{{$char.level}}</td>
<td style="text-align:right;"><span style="display: none;">{{$char.race}}</span><img class="staticTip" onmouseover="setTipText('{{$char.race}}');" src="images/icons/race/{{$char.race}}-{{$char.gender}}.gif"></td>
<td><span style="display: none;">{{$char.race}}</span><img class="staticTip" onmouseover="setTipText('{{$char.class}}');" src="images/icons/class/{{$char.class}}.gif"></td>
<td class="centNum"><img class="staticTip" onmouseover="setTipText('Орда');" src="images/icons/faction/icon-1.gif"></td>
<td><a href="guild-info.xml?gn=Синтезис">Синтезис</a></td>
<td>{{$realmName}}</td>
<td>Отсутствует</td>
<td><span style="display: none;">100%</span><q class="staticTip" onmouseover="setTipText('100%');"><del class="rel-container"><a><em style="width:100%"></em></a></del></q></td>
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
</div><script type="text/javascript">
var theClassId 		= ;
var theRaceId 		= ;
var theClassName 	= "";
var theLevel 		= ;		
var theRealmName 	= "";
var theCharName 	= "";		
						
var talentsTreeArray = new Array;
										
$(document).ready(function(){
								
	talentsTreeArray["group1"] = [];
	talentsTreeArray["group2"] = [];
									
	talentsTreeArray["group1"][0] = [1, 15, 
	""];
	talentsTreeArray["group1"][1] = [2, 5, 
	""];
	talentsTreeArray["group1"][2] = [3, 51, 
	""];
									
	talentsTreeArray["group2"][0] = [1, 5, 
	""];
	talentsTreeArray["group2"][1] = [2, 15, 
	""];
	talentsTreeArray["group2"][2] = [3, 51, 
	""];	
								
	calcTalentSpecs();
									
	setCharSheetUpgradeMenu();
								
});</script><div class="page-bot"></div>
{{include file="faq_character_sheet.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}