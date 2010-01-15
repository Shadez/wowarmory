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
<!--<a class="" href="character-statistics.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="statistics_subTab"><span>{{#armory_character_sheet_statistic_tab#}}</span></a>
--></div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile type_{{$faction_string_class}}">
<script type="text/javascript">
		var charUrl = "{{$character_url_string}}";
		var bookmarkMaxedToolTip = "{{#armory_you_can_remember_string#}}";
		var bookmarkThisChar = "{{#armory_remember_this_character#}}";	
	</script>
<div class="profile_header header_{{$faction_string_class}}">
<div class="points">
<a href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}">{{$pts}}</a>
</div>
<div id="forumLinks">
<a class="staticTip" href="javascript:void();">{{$realm}}</a></div>
<div class="profile-right" id="profileRight">
<a class="bmcLink staticTip" id="bmcLink" onmouseover="setTipText('{{#armory_login_to_remember_profile#}}');">
<!----></a>
</div>
<div class="profile-achieve">
<a class="staticTip" href="character-sheet.xml?r={{$realm}}&amp;cn={{$name}}" onmouseover="setTipText('{{#armory_character_sheet_level_string#}}&nbsp;{{$level}}&nbsp;{{get_wow_race race=$race}}&nbsp;{{get_wow_class class=$class}}')">
<img src="images/portraits/{{$portrait_path}}" /></a>
<div id="leveltext">{{$level}}</div>
</div>
<div id="charHeaderTxt_Light">
{{if $guildName}}
<div class="charGuildName">
<a href="guild-info.xml?r={{$realm}}&amp;gn={{$guildName}}">{{$guildName}}</a>
</div>
{{/if}}
<span class="prefix">{{$character_title_prefix}} </span>
<div class="charNameHeader">{{$name}}<span class="suffix">{{$character_title_suffix}}</span>
</div>
</div>
</div>
<script src="_js/JsHttpRequest.js"></script>
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
{{$achievementsTree}}
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
<div class="prog_int_text">Всего выполнено: {{$achievement_count}} / 1054</div>
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
<div class="prog_int_text">{{$ach_4}} / 166</div>
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
<div class="prog_int_text">{{$ach_5}} / 454</div>
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
<div class="prog_int_text">{{$ach_7}} / 45</div>
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
<div class="prog_int_text">{{$ach_8}} / 141</div>
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