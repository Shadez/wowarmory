<body>
<form id="historyStorageForm" method="GET">
<textarea id="historyStorageField" name="historyStorageField"></textarea>
</form>
<script src="_js/_lang/{{$ArmoryConfig.locale}}/strings.js" type="text/javascript"></script>
<script type="text/javascript">global_nav_lang = '{{$ArmoryConfig.locale}}'</script>
<div class="tn_armory" id="shared_topnav">
<script src="shared/global/menu/topnav/buildtopnav.js"></script>
</div>
<div class="outer-container">
<div class="inner-container">
<div class="int-top">
<div class="logo">
<a href="index.xml"><span>Оружейная World of Warcraft</span></a>
</div>
<div class="adbox">
<div class="ad-container">
<div id="ad_728x90"></div>
</div>
</div>
</div>
<div class="int">
<div class="search-bar">
<div class="module">
<div class="search-container">
<div class="search-module">
<em class="search-icon"></em>
<form action="search.xml" method="get" name="formSearch" onSubmit="return menuCheckLength(document.formSearch);">
<input id="armorySearch" maxlength="72" name="searchQuery" onkeypress="$('#formSearch_errorSearchLength').html('')" size="16" type="text" value="" /><a class="submit" href="javascript:void(0);" onclick="return menuCheckLength(document.formSearch)"><span>{{#armory_search_button#}}</span></a>
<div id="errorSearchType"></div>
<div id="formSearch_errorSearchLength"></div>
<input name="searchType" type="hidden" value="all">
</form>
{{include file="$menu_file.tpl"}}
</div>
</div>
<div class="login-container">
<a class="loginLink" href="search.xml?login=1" id="loginLinkRedirect">Войти</a>
</div>
</div>
</div>
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
						
			
			initSearchResults("characters", "кайнах", "", filterValues, "8");
		});	
	</script>
<div class="tabs">
<div class="selected-tab">
<a href="search.xml?searchType=all&amp;searchQuery=%D0%BA%D0%B0%D0%B9%D0%BD%D0%B0%D1%85&amp;selectedTab=characters">Персонажи<span class="tab-count" style="display: inline;">(1)</span></a>
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
<b class="icharacters">
<h4>
<a href="index.xml">Поиск по Оружейной</a>
</h4>
<h3 id="replaceHeaderTitle">Персонажи</h3>
</b>
</blockquote>
<div class="clear" style="border:1px solid transparent"></div>
<div class="pager page-body" id="pager" style="text-align:right;">
<form id="pagingForm" onsubmit="return false;" style="margin: 0; padding: 0; display: inline;">
<div id="searchTypeHolder"></div>
<div style="float: left; margin-left: 5px;">Страница <input id="pagingInput" type="text"> из <span id="totalPages"></span>
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
<tr>
<td><a href="character-sheet.xml?r=%D0%91%D0%BE%D1%80%D0%B5%D0%B9%D1%81%D0%BA%D0%B0%D1%8F+%D1%82%D1%83%D0%BD%D0%B4%D1%80%D0%B0&amp;n=%D0%9A%D0%B0%D0%B9%D0%BD%D0%B0%D1%85">Кайнах</a></td><td class="rightNum">72</td><td style="text-align:right;"><span style="display: none;">Нежить</span><img class="staticTip" onmouseover="setTipText('Нежить');" src="/images/icons/race/5-0.gif"></td><td><span style="display: none;">Рыцарь смерти</span><img class="staticTip" onmouseover="setTipText('Рыцарь смерти');" src="/images/icons/class/6.gif"></td><td class="centNum"><img class="staticTip" onmouseover="setTipText('Орда');" src="/images/icons/faction/icon-1.gif"></td><td><a href="/guild-info.xml?r=%D0%91%D0%BE%D1%80%D0%B5%D0%B9%D1%81%D0%BA%D0%B0%D1%8F %D1%82%D1%83%D0%BD%D0%B4%D1%80%D0%B0&amp;n=%D0%A1%D1%82%D1%80%D0%B0%D0%B6%D0%B8 %D0%A1%D0%BC%D0%B5%D1%80%D1%82%D0%B8">Стражи Смерти</a></td><td>Борейская тундра</td><td>Вихрь</td><td><span style="display: none;">100%</span><q class="staticTip" onmouseover="setTipText('100%');"><del class="rel-container"><a><em style="width:100%"></em></a></del></q></td>
</tr>
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
{{include file="faq_index.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
<script type="text/javascript">
    function setArmorySearchFocus() {
        document.formSearch.armorySearch.focus();
    }
    window.onload = setArmorySearchFocus;	
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}