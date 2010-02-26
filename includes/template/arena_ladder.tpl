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
<div class="tabs">
<div class="{$team2tab}tab" id="">
<a href="arena-ladder.xml?ts=2">{#armory_arenaladder_rating#} 2{#armory_arenaladder_versus#}2</a>
</div>
<div class="{$team3tab}tab" id="">
<a href="arena-ladder.xml?ts=3">{#armory_arenaladder_rating#} 3{#armory_arenaladder_versus#}3</a>
</div>
<div class="{$team5tab}tab" id="">
<a href="arena-ladder.xml?ts=5">{#armory_arenaladder_rating#} 5{#armory_arenaladder_versus#}5</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs" style="height: 1px;">
<div class="upperLeftCorner" style="height: 5px;"></div>
<div class="upperRightCorner" style="height: 5px;"></div>
</div>
<div class="full-list">
<div class="info-pane">
<blockquote>
<b class="iarenateams">
<h4 style="width: 300px;">
<a href="javascript:void(0);">{#armory_arenaladder_header#}</a>
</h4>
<h3 style="width: 300px;">
{if $ArmoryConfig.locale=='en_gb'}
    {$teamType}{#armory_arenaladder_versus#}{$teamType} {#armory_arenaladder_arenarating#}
{else}
    {#armory_arenaladder_arenarating#} {$teamType}{#armory_arenaladder_versus#}{$teamType}
{/if}
</h3>
</b>
</blockquote>
<script type="text/javascript">//
{literal}
		var ArenaLadder = function() {

			var
				page,
				maxPage,
				battlegroup,
				filterField,
				filterValue,
				sortDir,
				sortField,
				teamSize;

				validTeamSizes = {
					2: true,
					3: true,
					5: true
				};

			this.initialize = function(Page, MaxPage, Battlegroup, FilterField, FilterValue, SortDir, SortField, TeamSize) {

				page        = Page;
				maxPage     = MaxPage;
				battlegroup = Battlegroup;
				filterField = FilterField;
				filterValue = FilterValue;
				sortField   = SortField;
				sortDir     = SortDir;
				teamSize    = TeamSize;

				var arenaTournamentMode = (teamSize == 3 && battlegroup == defaultTournamentBattlegroup);

				// Arena Tournament Tab Selected
				if(arenaTournamentMode) {

					var cook = getcookie2('default-arena-battlegroup');
					if(cook && cook.length)
						defaultNormalBattlegroup = cook;

					for(var size in validTeamSizes) {					
						size = parseInt(size);

						var link = $('#tab_' + size + 'v' + size + ' a:first');
						link.attr('href', getUrl({ teamSize: size, battlegroup: defaultNormalBattlegroup }));
					}

				// 2v2, 3v3, or 5v5 Tab Selected
				} else {

					setcookie('default-arena-battlegroup', battlegroup);

					for(var size in validTeamSizes) {					
						size = parseInt(size);
						if(size != teamSize) {
							var link = $('#tab_' + size + 'v' + size + ' a:first');
							link.attr('href', getUrl({ teamSize: size }));
						}
					}

					var link = $('#tab_arenaTournament a:first');
					link.attr('href', getUrl({ teamSize: 3, battlegroup: defaultTournamentBattlegroup }));
				}
			};

			this.setPage = function(pageNum) {
				pageNum = parseInt(pageNum);
				if(!isNaN(pageNum) && pageNum >= 1 && pageNum <= maxPage && pageNum != page) {
					page = pageNum;
					updateUrl();
				}
			};

			this.setBattlegroup = function(battlegroupName) {
				if(battlegroupName)	{
					resetAll();
					battlegroup = battlegroupName;
					updateUrl();
				}
			};

			this.setFilter = function(field, value) {
				if(field && value) {
					resetAll();
					if(parseInt(value) != -1) {
						filterField = field;
						filterValue = value;
					}
					updateUrl();
				}
			};

			this.setSort = function(field, dir) {
				if(field && dir) {
					sortField = field;
					sortDir   = dir;
					updateUrl();
				}
			};

			this.setTeamSize = function(size) {
				if(validTeamSizes[size]) {
					teamSize = size;
					updateUrl();
				}
			};

			this.toggleSort = function(field) {
				if(field) {
					if(sortField == field && sortDir == 'a') {
						sortDir = 'd';
					} else {
						sortDir = 'a';
					}
					sortField = field;
					updateUrl();
				}
			};

			function resetAll() {
				page        = 1;
				filterField = null;
				filterValue = null;
				sortField   = null;
				sortDir     = null;
			}

			function getDataObject() {

				var data = {
					page:        page,
					maxPage:     maxPage,
					battlegroup: battlegroup,
					filterField: filterField,
					filterValue: filterValue,
					sortField:   sortField,
					sortDir:     sortDir,
					teamSize:    teamSize
				};

				return data;
			}

			function getUrl(overrides) {

				var data = getDataObject();

				if(overrides != null) {
					for(var i in overrides) {
						data[i] = overrides[i];
					}
				}

				var
					url    = 'arena-ladder.xml',
					params = [];

				if(data.page > 1)
					params.push('p=' + data.page);

				params.push('ts=' + data.teamSize);
				params.push('b=' + urlEncode(data.battlegroup));

				if(data.filterField && data.filterValue)
				{
					params.push('ff=' + data.filterField);
					params.push('fv=' + urlEncode(data.filterValue));
				}

				if(
					data.sortField &&
					data.sortDir &&
					!(data.sortField == 'rank' && data.sortDir == 'a') // Default sorting
				) {
					params.push('sf=' + data.sortField);
					params.push('sd=' + data.sortDir);
				}

				for(var i = 0, len = params.length; i < len; ++i) {
					url += (i > 0 ? '&' : '?');
					url += params[i];
				}
				
				return url;			
			}

			function updateUrl() {

				var url = getUrl();

				location.href = url;
			}
		};
	</script><script type="text/javascript">
		var defaultNormalBattlegroup = "Blackout";
		var defaultTournamentBattlegroup = "Coliseum 1";

		var arenaLadder = new ArenaLadder();
		arenaLadder.initialize(
			 1,
			 247,
			"None",
			"",
			"",
			"a",
			"rank",
			 2
		);

		$(document).ready(function(){
			$("#realmSelect").bgiframe();
			$("#battlegroupSelect").bgiframe();
		});
{/literal}
	</script>
<div id="ladderContent">
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">{#armory_guild_info_page_string#} <input id="pagingInput" onkeyup="if(event.which == 13) arenaLadder.setPage(this.value)" type="text" value="1"> {#armory_guild_info_page_string_2#} <span id="totalPages">{$teamsNum}</span>
</div>
<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px; display: none;">{#armory_guild_info_show_string#} <span class="bold" id="currResults"></span> {#armory_guild_info_page_string_2#} <span class="bold" id="totalResults"></span> {#armory_guild_info_results_string#}</div>
<!--<div id="pageSelector" style="float: right">
<a class="firstPg firstPg-off" href="javascript:;" onclick="arenaLadder.setPage(1)"></a><a class="prevPg prevPg-off" href="javascript:;" onclick="arenaLadder.setPage(0)"></a><a class="sel" href="javascript:;" id="pageSelect1">1</a><a class="p" href="javascript:;" id="pageSelect2" onclick="arenaLadder.setPage(2)" style="">2</a><a class="p" href="javascript:;" id="pageSelect3" onclick="arenaLadder.setPage(3)" style="">3</a><a class="nextPg nextPg-on" href="javascript:;" onclick="arenaLadder.setPage(2)"></a><a class="lastPg lastPg-on" href="javascript:;" onclick="arenaLadder.setPage({$teamsNum})"></a>
</div>-->
</form>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="ladderTable" style="width: 100%">
<thead>
<tr class="masthead">
<th class="header headerSortUp"><a href="javascript:;" onclick="arenaLadder.toggleSort('rank')">{#armory_arenaladder_rank#}<span class="sortArw"></span></a></th><th style="width: 100%;"><a href="javascript:;" onclick="arenaLadder.toggleSort('name')">{#armory_arenaladder_teamname#}<span class="sortArw"></span></a>
<div id="teamIconBoxContainer">
<div id="teamIconBox" style="position:absolute; z-index: 2000; zoom: 1;"></div>
</div>
</th><th style="width: 250px;"><a href="javascript:;" onclick="arenaLadder.toggleSort('realm')">{#armory_searchpage_realmname#}<span class="sortArw"></span></a></th><th><a href="javascript:;" onclick="arenaLadder.toggleSort('faction')">{#armory_searchpage_faction#}<span class="sortArw"></span></a></th><th><a href="javascript:;" onclick="arenaLadder.toggleSort('sgw')">{#armory_arenaladder_wins#}<span class="sortArw"></span></a></th><th><a href="javascript:;" onclick="arenaLadder.toggleSort('sgl')">{#armory_arenaladder_losses#}<span class="sortArw"></span></a></th><th><a href="javascript:;" onclick="arenaLadder.toggleSort('rating')">{#armory_arenaladder_rating#}<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{foreach from=$teamList item=team}
<tr onmouseout="popIconSmall('teamIconBoxFlash','iconObject{$team.num}')" onmouseover="popIconLarge('teamIconBoxFlash','iconObject{$team.num}')">
<td class="rightNum" style="font-weight: bold;">{$team.num}</td><td style="padding-left: 40px;"><a href="team-info.xml?r={$realm}&amp;ts={$teamType}&amp;t={$team.name}">{$team.name}</a></td><td style="white-space: nowrap">{$realm}</td><td class="centNum"><img class="staticTip" onmouseover="setTipText('{get_wow_faction race=$team.race}');" src="images/icons/faction/icon-{get_wow_faction race=$team.race numeric=true}.gif"></td><td class="rightNum" style="font-weight: bold; color: #678705;">{$team.wins}</td><td class="rightNum" style="font-weight: bold; color: #9A1401;">{$team.games-$team.wins}</td><td class="rightNum" style="font-weight: bold;">{$team.rating}</td>
</tr>
{/foreach}
</tbody>
</table>
</div>
</div>
<script type="text/javascript">
			var flashVarsString="totalIcons={$teamsNum}&initScale=35&overScale=100&overModifierX=0&overModifierY=0&startPointX=43&";
                
                {foreach from=$teamicons item=team}
				var encodedRealm=encodeURI("{$realm}");
				flashVarsString+="iconName{$team.num}=images/icons/team/pvp-banner-emblem-{$team.EmblemStyle}.png&iconColor{$team.num}={$team.EmblemColor}&bgColor{$team.num}={$team.BackgroundColor}&borderColor{$team.num}={$team.BorderColor}&teamUrl{$team.num}=team-info.xml?r="+encodedRealm+"%26ts={$teamType}%26t={$team.name}&";
				{/foreach}
                		
			var heightCalc=(20*28)+10;
			if(heightCalc < 100) heightCalc = 100;		
			
			printFlash('teamIconBox', 'images/icons/team/pvpemblems.swf', 'transparent', '', '#000000', '76', heightCalc, 'high', '', flashVarsString, '');	
		</script>
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
{include file="faq_arenas.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}