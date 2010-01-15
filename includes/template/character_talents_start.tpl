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
<a href="index.xml"><span>{{#armory_site_title#}}</span></a>
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
<input id="armorySearch" maxlength="72" name="searchQuery" onkeypress="$('#formSearch_errorSearchLength').html('')" size="16" type="text" value=""><a class="submit" href="javascript:void(0);" onclick="return menuCheckLength(document.formSearch)"><span>{{#armory_search_button#}}</span></a>
<div id="errorSearchType"></div>
<div id="formSearch_errorSearchLength"></div>
<input name="searchType" type="hidden" value="all">
</form>
{{include file="$menu_file.tpl"}}
</div>
</div>
<div class="login-container">
<a class="loginLink" href="?login=1" id="loginLinkRedirect">{{#armory_login_string#}}</a>
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
<tabInfo subTab="talents" tab="character" tabGroup="character" tabUrl="{{$character_url_string}}"></tabInfo>
<link href="_css/tools/talent-calc.css" rel="stylesheet" type="text/css" />
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<link href="_css/character/global.css" rel="stylesheet" type="text/css" />
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
<a class="selected-subTab" href="character-talents.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="talents_subTab"><span>{{#armory_character_sheet_talents_tab#}}</span></a>
<a class="" href="character-reputation.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="reputation_subTab"><span>{{#armory_character_sheet_reputaion_tab#}}</span></a>
<a class="" href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="achievements_subTab"><span>{{#armory_character_sheet_achievements_tab#}}</span></a>
<!--<a class="" href="character-statistics.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="statistics_subTab"><span>{{#armory_character_sheet_statistic_tab#}}</span></a>
--></div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper char_sheet">
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
<script src="_js/character/talents.js" type="text/javascript"></script>
<div class="talentGlyphBg">
<div class="talentGlyphFooter">
<div class="talentGlyphHeaderMultiSpec">
{{if $dualSpec}}
<div class="talentSpecSwitchHolder">
<table class="talentSpecSwitch">
<tr>
<td id="group_1"><a class="inActiveTalents" href="javascript:void(0)" id="group_1_link" onclick="switchTalentSpec('','1', '{{$spec_0.build}}')">
<div>
<img src="wow-icons/_images/21x21/{{$spec_0.icon}}.png" />{{$spec_0.name}}</div>
</a>
<div class="buildPointer">

</div>
</td>
<td  id="group_2"><a class="activeTalents" href="javascript:void(0)" id="group_2_link" onclick="switchTalentSpec('1','2', '{{$spec_1.build}}')">
<div>
<img src="wow-icons/_images/21x21/{{$spec_1.icon}}.png" />{{$spec_1.name}}</div>
</a>
<div class="buildPointer">

</div>
</td>
</tr>
</table>
</div>
{{/if}}
{{include file="talents_$talentsFileName.tpl"}}
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