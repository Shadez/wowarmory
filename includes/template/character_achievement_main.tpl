<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="achievements" tab="character" tabGroup="character" tabUrl="{{$character_url_string}}"></tabInfo>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<link href="_css/character/global.css" rel="stylesheet" type="text/css" />
<link href="_css/character/achievements.css" rel="stylesheet" type="text/css" />
<div class="tabs">
<div class="selected-tab" id="tab_character">
<a href="character-sheet.xml?r={{$realm}}&amp;n={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}">{{#armory_character_sheet_character_string#}}</a>
</div>
{{if $guildName}}
<div class="tab" id="tab_guild">
<a href="guild-info.xml?r={{$realm}}&amp;cn={{$name}}&amp;gn={{$guildName}}">{{#armory_character_sheet_guild_string#}}</a>
</div>
{{/if}}
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="" href="character-sheet.xml?r={{$realm}}&amp;n={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="profile_subTab"><span>{{#armory_character_sheet_profile_tab#}}</span></a>
<a class="" href="character-talents.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="talents_subTab"><span>{{#armory_character_sheet_talents_tab#}}</span></a>
<a class="" href="character-reputation.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="reputation_subTab"><span>{{#armory_character_sheet_reputaion_tab#}}</span></a>
<a class="selected-subTab" href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="achievements_subTab"><span>{{#armory_character_sheet_achievements_tab#}}</span></a>
<a class="" href="character-statistics.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="statistics_subTab"><span>{{#armory_character_sheet_statistic_tab#}}</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile">
<script type="text/javascript">
		var charUrl = "{{$character_url_string}}";
		var bookmarkMaxedToolTip = "{{#armory_you_can_remember_string#}}";
		var bookmarkThisChar = "{{#armory_remember_this_character#}}";	
	</script>
<div class="faction-{{$faction_string_class}}">
<div class="profile-right" id="profileRight">
<a class="bmcLink" id="bmcLink"><span>{{#armory_login_to_remember_profile#}}</span><em></em></a>
</div>
<div class="profile-achieve">
<img src="images/portraits/{{$portrait_path}}" /><div class="points">
<a href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}">{{$pts}}</a>
</div>
<div>
<link href="atom/character.xml?r={{$realm}}&amp;n={{$name}}" rel="alternate" title="WoW Feed" type="application/atom+xml" />
</div>
<div id="leveltext" style="display:none;"></div>
<script type="text/javascript">
		var flashId="leveltext";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("leveltext", "images/{{$ArmoryConfig.locale}}/flash/level.swf", "transparent", "", "", "38", "38", "best", "images/ru_ru/flash", "charLevel={{$level}}&pts={{$pts}}", "<div class=level-noflash>{{$level}}<em>{{$level}}</em></div>")
		
		</script>
</div>
<div id="charHeaderTxt_Dark">
<span class="prefix">{{$character_title_prefix}} </span>
<div class="charNameHeader">{{$name}}<span class="suffix">{{$character_title_suffix}}</span>
</div>
{{if $guildName}}<a class="charGuildName" href="guild-info.xml?r={{$realm}}&amp;gn={{$guildName}}">{{$guildName}}</a>{{/if}}<span class="charLvl">{{#armory_character_sheet_level_string#}}&nbsp;{{$level}}&nbsp;{{$class_text}}&nbsp;{{$race_text}}</span>
</div>
<div id="charHeaderTxt_Light">
<span class="prefix">{{$character_title_prefix}} </span>
<div class="charNameHeader">{{$name}}<span class="suffix">{{$character_title_suffix}}</span>
</div>
{{if $guildName}}<a class="charGuildName" href="guild-info.xml?r={{$realm}}&amp;gn={{$guildName}}">{{$guildName}}</a>{{/if}}<span class="charLvl">{{#armory_character_sheet_level_string#}}&nbsp;{{$level}}&nbsp;{{$class_text}}&nbsp;{{$race_text}}</span>
</div>
<div id="forumLinks">
<a class="smFrame" href="javascript:void(0)">
<div>{{$realm}}</div>
<img src="images/icon-header-realm.gif" /></a>
</div>
</div>
<script src="js/JsHttpRequest.js"></script>
<script type="text/javascript" language="JavaScript">
function loadAchievements(name, category)
{
	// Create new JsHttpRequest object.
	var req = new JsHttpRequest();
	// Code automatically called on load finishing.
	req.onreadystatechange = function()
	{
		if (req.readyState == 4)
		{
			// Write result to page element (_RESULT becomes responseJS). 
			document.getElementById('result').innerHTML = req.responseJS.achievements;
		}
	}
	// Prepare request object (automatically choose GET or POST).
   	req.open(null, 'achievements-loader.php?cn=' + name + '&c=' + category, true);
	// Send data to backend.
	document.getElementById('result').innerHTML = '{{#armory_character_achievements_loading_achievements#}}';
	req.send( {  } );
}
</script>
<!-- Хаковый способ реализации ачивментов. Надеюсь, временно. -->
<div class="achievements">
<div class="achv_lnav">
<div class="achv_bdr">
<img src="images/achievements/achv_lnav_top.jpg" /></div>
<div class="category-root">
<div class="selected">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode)">Обзор</a>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '92'); loadAchievements('{{$name}}', 92)">Общее</a>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '96'); loadAchievements('{{$name}}', 96)">Задания</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 14861)">World of Warcraft</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 14862)">The Burning Crusade</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 14863)">Wrath of the Lich King</a>
</div>
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '97'); loadAchievements('{{$name}}', 97)">Исследование</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 14777)">Восточные королевства</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 14778)">Калимдор</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 14779)">Запределье</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '4'); loadAchievements('{{$name}}', 14780)">Нордскол</a>
</div>
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '95'); loadAchievements('{{$name}}', 95)">PvP</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 165)">Арена</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 14801)">Альтеракская долина</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 14802)">Низина Арати</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '4'); loadAchievements('{{$name}}', 14803)">Око Бури</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '5'); loadAchievements('{{$name}}', 14804)">Ущелье Песни Войны</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '6'); loadAchievements('{{$name}}', 14881)">Берег Древних</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '7'); loadAchievements('{{$name}}', 14901)">Ледяные Оковы</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '8'); loadAchievements('{{$name}}', 15003)">Остров Завоеваний</a>
</div>
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '168'); loadAchievements('{{$name}}', 168)">Подземелья и рейды</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 14808)">World of Warcraft</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 14805)">The Burning Crusade</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 14806)">Подземелья Lich King</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '4'); loadAchievements('{{$name}}', 14921)">Lich King (героич.)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '5'); loadAchievements('{{$name}}', 14922)">Рейды Lich King (10 игроков)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '6'); loadAchievements('{{$name}}', 14923)">Рейды Lich King (25 игроков)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '7'); loadAchievements('{{$name}}', 14961)">Тайны Ульдуара (10)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '8'); loadAchievements('{{$name}}', 14962)">Тайны Ульдуара (25)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '9'); loadAchievements('{{$name}}', 15001)">Призыв авангарда (10)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '10'); loadAchievements('{{$name}}', 15002)">Призыв авангарда (25)</a>
</div>
<!-- 
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.openSubcategory(this.parentNode, '11'); loadAchievements('{{$name}}', 15003)">Падение Короля-лича (10)</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.openSubcategory(this.parentNode, '12'); loadAchievements('{{$name}}', 15004)">Падение Короля-лича (25)</a>
</div>-->
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '169'); loadAchievements('{{$name}}', 169)">Профессии</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 170)">Кулинария</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 171)">Рыбная ловля</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 172)">Первая помощь</a>
</div>
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '201'); loadAchievements('{{$name}}', 201)">Репутация</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 14864)">World of Warcraft</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 14865)">The Burning Crusade</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 14866)">Wrath of the Lich King</a>
</div>
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '155'); loadAchievements('{{$name}}', 155)">Игровые события</a>
<div class="cat_list">
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '1'); loadAchievements('{{$name}}', 160)">Лунный фестиваль</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '2'); loadAchievements('{{$name}}', 187)">Любовная лихорадка</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '3'); loadAchievements('{{$name}}', 159)">Сад чудес</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '4'); loadAchievements('{{$name}}', 163)">Детская неделя</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '5'); loadAchievements('{{$name}}', 161)">Огненный солнцеворот</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '6'); loadAchievements('{{$name}}', 162)">Хмельной фестиваль</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '7'); loadAchievements('{{$name}}', 158)">Тыквовин</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '8'); loadAchievements('{{$name}}', 14981)">Пиршество странников</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '9'); loadAchievements('{{$name}}', 156)">Зимний Покров</a>
</div>
<div class="nav-subcat">
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '10'); loadAchievements('{{$name}}', 14941)">Серебряный турнир</a>
</div>
</div>
</div>
<div>
<a href="javascript:void(0)" onclick="Armory.Achievements.toggleCategory(this.parentNode, '81'); loadAchievements('{{$name}}', 81)">Великие подвиги</a>
</div>
</div>
<div class="achv_bdr">
<img src="images/achievements/achv_lnav_btm.jpg" /></div>
</div>
<div class="achieve_rcol">
<div style="line-height:0">
<img src="images/achievements/achv_rcol_top.jpg" /></div>
<div class="achievements-container">
<div id="achievements-content">
<div class="summary">
<div>
<div class="prog_bar ">
<div class="progress_cap">
<!---->
</div>
<div class="progress_cap_r" style="background-position:bottom">
<!---->
</div>
<div class="progress_int">
<div class="progress_fill" style="width:{{$achievement_progress_percent}}%">
<!---->
</div>
<div class="prog_int_text">Всего выполнено: {{$achievement_count}} / 986</div>
</div>
</div>
</div>
<div class="summary_progress_container">
<div class="summary_progress">
<div>Общее: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_1_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_1}} / 54</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Задания: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_2_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_2}} / 49</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Исследование: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_3_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_3}} / 70</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>PvP: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_4_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_4}} / 164</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Подземелья и рейды: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_5_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_5}} / 391</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Профессии: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_6_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_6}} / 75</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Репутация: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_7_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_7}} / 44</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Игровые события: </div>
<div>
<div class="prog_bar blue">
<div class="progress_int">
<div class="progress_fill" style="width:{{$ach_8_percent}}%">
<!---->
</div>
<div class="prog_int_text">{{$ach_8}} / 139</div>
</div>
</div>
</div>
</div>
<div class="summary_progress">
<div>Великие подвиги: </div>
<div>
<div class="null_progress">{{$ach_9}}</div>
</div>
</div>
<br clear="all" />
<br />
</div>
<div class="recent_header">Недавние достижения</div>
{{foreach from=$lastAchievements item=ach}}

<div class="s_achievement">
<div class="s_ach_stat">{{$ach.points}}<img src="images/achievements/tiny_shield.gif">
	        	({{$ach.date}})
	        </div>
<span>{{$ach.name}}</span><span class="achv_desc">{{$ach.description}}</span>
</div>
{{/foreach}}
</div>
<div class="loading" id="result" style="display:none;">Идет загрузка.</div>
</div>
</div>
<div class="achv_r_btm">
<img src="images/achievements/achv_rcol_btm.jpg" /></div>
</div>
<br clear="all" />
</div>
<div style="clear:both"></div>
<script src="_js/achievements.js" type="text/javascript"></script><script type="text/javascript">
		Armory.Achievements.init("achievements", "single",
			[
				
					["{{$realm}}","{{$name}}"],
				
			]);
	</script>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div></div>
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