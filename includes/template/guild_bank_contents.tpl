<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="guildBankContents" tab="guild" tabGroup="guild" tabUrl=""></tabInfo>
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
<a class="" href="guild-info.xml?r={{$realm}}&gn={{$guildName}}" id="guildRoster_subTab"><span>{{#armory_guild_info_guild_roster#}}</span></a>
<a class="" href="guild-stats.xml?r={{$realm}}&gn={{$guildName}}" id="guildStats_subTab"><span>{{#armory_guild_info_statistic#}}</span></a>
<a class="subTabLocked" href="guild-bank-contents.xml?r={{$realm}}&gn={{$guildName}}" id="guildBankContents_subTab"><span>{{#armory_guild_info_guildbank#}}</span></a>
<a class="subTabLocked" href="guild-bank-log.xml?r={{$realm}}&gn={{$guildName}}" id="guildBankLog_subTab"><span>{{#armory_guild_info_guildbanklog#}}</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile">
<script src="_js/guild/bank-contents.js" type="text/javascript"></script><script type="text/javascript">
		$(document).ready(function(){
			initGuildBankContents("{{#armory_guild_bank_show_guildinfo#}}", 
								  "{{#armory_guild_bank_hide_guildinfo#}}",
								  "{{#armory_error_not_found#}}");
		});
	</script>
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
<div class="filterTitle">{{#armory_guild_bank_guild_motd#}}:<a class="dropdownicon" id="guildInfoToggler" onclick="javascript:;">{{#armory_guild_bank_show_guildinfo#}}</a>
</div>
<div class="filtercontainer" style="padding-left: 20px; margin: 0 10px;">
<div style="width:820px; font-weight: bold;">{{$guildMotd}}</div>
<div id="guildInfoContainer">
<strong>{{#armory_guild_bank_guildinfo#}}:</strong>
<br />{{$guildInfoText}}
</div>
</div>
<div class="filterTitle">{{#armory_guild_bank_contents#}}</div>
<div style="width: 819px; height: 519px; background: url('images/guildbanks-frame.jpg') top left no-repeat; margin: 0 auto; position:relative; ">
<div class="filtertitle" id="whichTabDisplay" style="background: url('wow-icons/_images/43x43/inv_jewelcrafting_azurehare.png') no-repeat;">Сейф 1</div>
<div id="tabContentHolder" style="width: 800px; height: 331px; top: 93px; left: 49px; position: absolute;">
{{foreach from=$GuildBankContents item=bank}}
    {{if isset($i)}}
        {{assign var='i' value=$i+1}}
    {{else}}
        {{assign var='i' value='0'}}
    {{/if}}
<div class="oneBankTab" id="banktab{{$i}}" style="display: block">
{{foreach from=$bank item=banktab}}
<!-- START BANKTAB {{$i}} -->
<div class="bankCol">
{{foreach from=$banktab item=slot}}
<a class="singleBankItem staticTip itemToolTip" href="javascript:void(0)" id="{{$slot.item_entry}}" style="background:url(wow-icons/_images/43x43/{{$slot.item_icon}}.png) no-repeat 4px 1px;">
<div class="hoverBankItem">
<span>{{if $slot.item_count > 1}}{{$slot.item_count}}{{/if}}</span>
</div>
</a>
{{/foreach}}
</div>
{{/foreach}}
</div>
{{/foreach}}

</div>
<div id="banktabs" style="margin-top: 18px;">
{{foreach from=$guildBankTabs item=tab}}
<a class="staticTip bankTabIcon" href="javascript:void(0)" onclick="toggleBankTab(this,'{{$tab.id}}','{{$tab.name}}','{{$tab.icon}}');" onmouseover="setTipText('{{$tab.name}}');" style="background:url('wow-icons/_images/43x43/{{$tab.icon}}.png') no-repeat;">
<div class="hoverBankTab">
<img id="bankHighlight{{$tab.id}}" src="images/guildbank-tab-selected.gif" style="display: block" /></div>
</a>
{{/foreach}}
</div>
<div style="position:absolute; top: 463px; right: 65px; width: 215px; text-align:center; color: #FFFFFF;">
<span class="goldCoin_d">{{$GuildBankMoney.gold}}</span><span class="silverCoin_d">{{$GuildBankMoney.silver}}</span><span class="copperCoin_d">{{$GuildBankMoney.copper}}</span>
</div>
</div>
<div class="filtercrest">
<div class="filterTitle">{{#armory_guild_bank_contents_filter#}}</div>
</div>
<div class="filtercontainer" style="margin: 0 10px;">
<div class="filterBox">Название: <br>
<input class="filterInput" id="filItemName" maxlength="40" size="40" style="width: 200px;" type="text" value="">
</div>
<div class="filterBox">Качество: <br>
<select id="filRarity" onchange="runBankContentFilters()"><option value="-1">Все типы</option><option value="0">Часто встреч.</option><option value="1">Обыкновенный</option><option value="2">Необыкновенный</option><option value="3">Редкий</option><option value="4">Эпический</option><option value="5">Легендарный</option><option value="6">Фамильный</option></select>
</div>
<div class="filterBox">Категория: <br>
<select id="filItemType" onchange="runBankContentFilters()"><option value="-1">Все типы</option><option>Оружие</option><option>Броня</option><option>Драгоценности</option><option>Контейнеры</option><option>Расходуемые материалы</option><option>Ремесленные товары</option><option>Снаряды</option><option>Колчан</option><option>Реагенты</option><option>Разное</option><option>Заклинания</option><option>Верховые животные</option><option>Ручные животные</option><option>Символы</option><option>Ключи</option></select>
</div>
<div class="filterBox">Закладка: <br>
<select id="filTab" onchange="runBankContentFilters()" style="width: 100px;"><option value="-1">Все</option><option value="0">Сейф 1</option><option value="1">Сейф 2</option><option value="2">Сейф 3</option><option value="3">Сейф 4</option></select>
</div>
<div class="clear"></div>
<div id="filterButtonHolder">
<a href="javascript:void(0)" id="runFilterButton" onclick="resetBankContentsFilters();" style="cursor: pointer;"><span class="btnRight">Очистить критерии</span></a>
</div>
</div>
<div class="bottomshadow"></div>
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">{{#armory_guild_info_page_string#}} <input id="pagingInput" type="text"> {{#armory_guild_info_page_string_2#}} <span id="totalPages"></span>
</div>
<div style="float: left; margin-left: 25px; line-height: 24px; height: 24px;">{{#armory_guild_info_show_string#}} <span class="bold" id="currResults">{{$GuildBankItemsNum}}</span> {{#armory_guild_info_page_string_2#}} <span class="bold" id="totalResults">{{$GuildBankItemsNum}}</span> {{#armory_guild_info_results_string#}}</div>
<div id="pageSelector" style="float: right">
<a class="firstPg firstPg-on" href="javascript:void(0)"></a><a class="prevPg prevPg-on" href="javascript:void(0)"></a><a class="p" href="javascript:void(0)" id="pageSelect1"></a><a class="p" href="javascript:void(0)" id="pageSelect2"></a><a class="p" href="javascript:void(0)" id="pageSelect3"></a><a class="nextPg nextPg-on" href="javascript:void(0)"></a><a class="lastPg lastPg-on" href="javascript:void(0)"></a>
</div>{{#armory_guild_info_results_per_page#}}:<select id="pageSize"><option selected value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option></select>
</form>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="bankContentsTable" style="width: 100%">
<thead>
<tr class="masthead">
<th style="width: 350px; text-align:left;"><a>{{#armory_item_info_items_string#}}<span class="sortArw"></span></a></th><th style="width: 200px; text-align:left;"><a>Тип<span class="sortArw"></span></a></th><th style="width: 150px; text-align:left;"><a>Подтип<span class="sortArw"></span></a></th><th style="text-align:left; min-width: 100px;"><a>Закладка<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{{foreach from=$GuildBankItemList item=item}}
<tr>
<td><a class="staticTip itemToolTip rarity{{$item.Quality}}" href="item-info.xml?i={{$item.entry}}" id="i={{$item.entry}}" style="background: url('wow-icons/_images/21x21/{{$item.icon}}.png') no-repeat 0 50%; padding: 3px 0 3px 25px; line-height: 28px;">{{$item.name}}</a></td><td style="white-space:nowrap;"></td><td><span style="display: none"></span></td><td><span style="display: none"></span></td>
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
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{{include file="faq_index.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}