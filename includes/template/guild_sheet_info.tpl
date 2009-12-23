<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="guildRoster" tab="guild" tabGroup="guild" tabUrl=""></tabInfo>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<link href="_css/guild/global.css" rel="stylesheet" type="text/css" />
<div class="tabs">
{{if $name}}
<div class="tab" id="tab_character">
<a href="character-sheet.xml?r={{$realm}}&amp;n={{$name}}&amp;gn={{$guildName}}">{{#armory_character_sheet_character_string#}}</a>
</div>
{{/if}}
<div class="selected-tab" id="tab_guild">
<a href="guild-info.xml?r={{$realm}}&gn={{$guildName}}">{{#armory_character_sheet_guild_string#}}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="selected-subTab" href="guild-info.xml?r={{$realm}}&gn={{$guildName}}" id="guildRoster_subTab"><span>{{#armory_guild_info_guild_roster#}}</span></a>
<a class="" href="guild-stats.xml?r={{$realm}}&gn={{$guildName}}" id="guildStats_subTab"><span>{{#armory_guild_info_statistic#}}</span></a>
<a class="subTabLocked" href="vault/guild-bank-contents.xml?r={{$realm}}&gn={{$guildName}}" id="guildBankContents_subTab"><span>{{#armory_guild_info_guildbank#}}</span></a>
<a class="subTabLocked" href="vault/guild-bank-log.xml?r={{$realm}}&gn={{$guildName}}" id="guildBankLog_subTab"><span>{{#armory_guild_info_guildbanklog#}}</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile">
<div class="guildbanks-faction-horde" style="margin-bottom: 40px;">
<div class="profile-left">
<div class="profile-right">
<div style="height: 140px; width: 100%;">
<div class="reldiv">
<div class="guildheadertext">
<div class="guild-details">
<div class="guild-shadow">
<table>
<tr>
<td>
<h1>{{$guildName}}</h1>
<h2>{{$guildMembersCount}}&nbsp;{{#armory_guild_info_members_string#}}</h2>
</td>
</tr>
</table>
</div>
<div class="guild-white">
<table>
<tr>
<td>
<h1>{{$guildName}}</h1>
<h2>{{$guildMembersCount}}&nbsp;{{#armory_guild_info_members_string#}}</h2>
</td>
</tr>
</table>
</div>
</div>
</div>
<div style="position: absolute; margin: -10px 0 0 -10px; z-index: 10000;">
<div id="guild_emblem" style="display:none;"></div>
<script type="text/javascript">
		var flashId="guild_emblem";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("guild_emblem", "images/emblem_ex.swf", "transparent", "", "", "230", "200", "best", "", "{{$guildEmblemStyle}}", "")
		
		</script>
</div>
<div style="position: absolute; margin: 116px 0 0 210px;">
<a class="smFrame" href="javascript:void(0);">
<div>{{$realm}}</div>
<img src="images/icon-header-realm.gif" /></a>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="_js/guild/roster.js" type="text/javascript"></script><script type="text/javascript">
		$(document).ready(function(){
			initGuildRoster("{{#armory_guild_info_string_not_found#}}");		
		});	
	</script>
<div class="filtercrest">
<div class="filterTitle">{{#armory_guild_info_search_criteria_string#}}</div>
</div>
<div class="filtercontainer">
<div class="filterBox" id="nameFilter">{{#armory_guild_info_character_name#}}: <br>
<input class="filterInput" id="filCharName" maxlength="20" style="width: 150px;" type="text" value="">
</div>
<div class="filterBox" id="nameFilter">{{#armory_guild_info_level#}}<br>
<input class="filterInput" id="filMinLevel" maxlength="2" size="2" style="width: 30px;" type="text" value="10"><span class="inlineTxt"> - </span><input class="filterInput" id="filMaxLevel" maxlength="2" size="2" style="width: 30px;" type="text" value="80">
</div>
<div class="filterBox" id="nameFilter">{{#armory_guild_info_race#}}<br>
{{if $gFaction == '1'}}
<select id="filRaceSelect" onchange="runGuildRosterFilters();"><option value="-1">Все типы</option><option value="2">Орк</option><option value="5">Нежить</option><option value="10">Эльф крови</option><option value="6">Таурен</option><option value="8">Тролль</option></select>
{{else}}
<select id="filRaceSelect" onchange="runGuildRosterFilters();"><option value="-1">Все типы</option><option value="3">Дворф</option><option value="1">Человек</option><option value="4">Ночной эльф</option><option value="7">Гном</option><option value="11">Дреней</option></select>
{{/if}}
</div>
<div class="filterBox" id="nameFilter">{{#armory_guild_info_gender#}}:<br>
<select id="filGenderSelect" onchange="runGuildRosterFilters();"><option value="-1">{{#armory_guild_info_both_gender#}}</option><option value="0">{{#armory_guild_info_gender_male#}}</option><option value="1">{{#armory_guild_info_gender_female#}}</option></select>
</div>
<div class="filterBox" id="nameFilter">{{#armory_guild_info_class#}}<br>
<select id="filClassSelect" onchange="runGuildRosterFilters();"><option value="-1">{{#armory_guild_info_classes_alltypes#}}</option><option value="6">Рыцарь смерти</option><option value="11">Друид</option><option value="2">Паладин</option><option value="3">Охотник</option><option value="4">Разбойник</option><option value="5">Жрец</option><option value="7">Шаман</option><option value="8">Маг</option><option value="9">Чернокнижник</option><option value="1">Воин</option></select>
</div>
<div class="filterBox" id="nameFilter">{{#armory_guild_info_guildrank#}}<br>
<select id="filRankSelect" onchange="runGuildRosterFilters();"><option value="-1">Все</option><option value="0">{{#armory_guild_info_gm#}}</option><option value="5">Ранг 5</option><option value="3">Ранг 3</option><option value="1">Ранг 1</option><option value="2">Ранг 2</option><option value="4">Ранг 4</option></select>
</div>
<div class="clear"></div>
<div id="filterButtonHolder">
<a href="javascript:void(0)" id="runFilterButton" onclick="resetRosterFilters();" style="cursor: pointer;"><span class="btnRight">{{#armory_guild_info_clear_critera#}}</span></a>
</div>
</div>
<div class="bottomshadow"></div>
<div class="filterTitle">{{#armory_guild_info_members_string#}}</div>
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">{{#armory_guild_info_page_string#}} <input id="pagingInput" type="text"> {{#armory_guild_info_page_string_2#}} <span id="totalPages"></span>
</div>
<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">{{#armory_guild_info_show_string#}} <span class="bold" id="currResults">{{$guildMembersCount}}</span> {{#armory_guild_info_page_string_2#}} <span class="bold" id="totalResults">{{$guildMembersCount}}</span> {{#armory_guild_info_results_string#}}</div>
<div id="pageSelector" style="float: right">
<a class="firstPg firstPg-on" href="javascript:void(0)"></a><a class="prevPg prevPg-on" href="javascript:void(0)"></a><a class="p" href="javascript:void(0)" id="pageSelect1"></a><a class="p" href="javascript:void(0)" id="pageSelect2"></a><a class="p" href="javascript:void(0)" id="pageSelect3"></a><a class="nextPg nextPg-on" href="javascript:void(0)"></a><a class="lastPg lastPg-on" href="javascript:void(0)"></a>
</div>{{#armory_guild_info_results_per_page#}}:<select id="pageSize"><option selected value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option></select>
</form>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="rosterTable" style="width: 100%">
<thead>
<tr class="masthead">
<th style="width: 100%; text-align:left;"><a>{{#armory_guild_info_character_name#}}<span class="sortArw"></span></a></th><th style="text-align:left;"><a>{{#armory_guild_info_achievement_points#}}<span class="sortArw"></span></a></th><th style="text-align:left; width: 80px;"><a>{{#armory_guild_info_level#}}<span class="sortArw"></span></a></th><th style="text-align:left;"><a>{{#armory_guild_info_race#}}<span class="sortArw"></span></a></th><th style="text-align:left;"><a>{{#armory_guild_info_class#}}<span class="sortArw"></span></a></th><th style="text-align:left; width: 200px; min-width: 150px;"><a>{{#armory_guild_info_guildrank#}}<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{{foreach from=$gmList item=char}}
<tr class="data3">
<td style="padding-left: 7px;"><a href="character-sheet.xml?r={{$realm}}&n={{$char.name}}">{{$char.name}}</a></td><td class="rightNum"><span class="achievPtsSpan">{{$char.ach_points}}</span></td><td class="rightNum">{{$char.level}}</td><td style="text-align:right;"><span style="display: none;">{{get_wow_race race=$char.race}}</span><span style="display: none;">{{$char.race}}</span><img class="staticTip" onmouseover="setTipText('{{get_wow_race race=$char.race}}');" src="images/icons/race/{{$char.race}}-{{$char.gender}}.gif" /></td><td><span style="display: none;">{{get_wow_class class=$char.class}}</span><span style="display: none;">{{$char.class}}</span><span style="display: none;">{{$char.gender}}</span><img class="staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}');" src="images/icons/class/{{$char.class}}.gif" /></td><td class="centNum" style="white-space:nowrap"><span style="display: none">0</span><q><strong class="gm">{{#armory_guild_info_gm#}}</strong></q></td>
</tr>
{{/foreach}}
{{foreach from=$guildList item=char}}
<tr>
<td style="padding-left: 7px;"><a href="character-sheet.xml?r={{$realm}}&n={{$char.name}}">{{$char.name}}</a></td><td class="rightNum"><span class="achievPtsSpan">{{$char.ach_points}}</span></td><td class="rightNum">{{$char.level}}</td><td style="text-align:right;"><span style="display: none;">{{get_wow_race race=$char.race}}</span><span style="display: none;">{{$char.race}}</span><img class="staticTip" onmouseover="setTipText('{{get_wow_race race=$char.race}}');" src="images/icons/race/{{$char.race}}-{{$char.gender}}.gif" /></td><td><span style="display: none;">{{get_wow_class class=$char.class}}</span><span style="display: none;">{{$char.class}}</span><span style="display: none;">{{$char.gender}}</span><img class="staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}');" src="images/icons/class/{{$char.class}}.gif" /></td><td class="centNum" style="white-space:nowrap"><span style="display: none">{{$char.rank}}</span><q><strong>{{#armory_guild_info_guildrank#}} {{$char.rank}}</strong></q></td>
</tr>
{{/foreach}}
</tbody>
</table>
</div>
<div class="page-body">
<div style="padding: 0 12px 0 0; text-align:right;line-height:22px;">{{#armory_guild_info_warning#}}</div>
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
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{{include file="faq_guild_info.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}