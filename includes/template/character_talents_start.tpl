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
{{if $_wow_login}}
<div class="login-container">
<script type="text/javascript">
        
        function loadCalendarAlerts(data) {
            if(!data.invites || !data.invites.length)
                return;

            $("#pendingInvitesNotification").show();

            var bookmarks = $("#userSelect .js-bookmark-characters");
            var names = bookmarks.find(".js-character-name"); // no
            var realms = bookmarks.find(".js-character-realm");
            var inviteNodes = bookmarks.find(".user-alerts");

            for(var j = 0, invite, invites = data.invites; invite = invites[j]; j++) {
                for(var i = 0; i < names.length; i++) {
                    if($(names[i]).text() == invite.character && $(realms[i]).text() == invite.realm) {
                        $(inviteNodes[i]).show().text(invite.invites);
                    }
                }
            }
        }

        $(document).ready(function() {
           loadScript('vault/calendar/alerts-user.json?callback=loadCalendarAlerts', 'jsonAlerts');
        });
        
        
    </script>
<div id="menuHolder">
<div id="myCharacters">
<a href="character-select.xml" id="changeLink">[{{#armory_vault_change_characters_button#}}]</a>{{#armory_vault_my_characters#}}</div>
{{foreach from=$myVaultCharacters item=char}}
<div class="menuItem charlist">
<a class="character-achievement staticTip" href="character-achievements.xml?r={{$realm}}&amp;n={{$char.name}}" onmouseover="setTipText('{{#armory_guild_info_achievement_points#}}');">{{$char.ach_points}}</a>
<a class="user-alerts staticTip" href="vault/character-calendar.xml?r={{$realm}}&amp;cn={{$char.name}}" onmouseover="setTipText('Pending Calendar Invites')" style="display: none;">0</a>
<a class="charName js-character-name" href="character-sheet.xml?r={{$realm}}&amp;n={{$char.name}}"><em class="classId{{$char.class}} staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}')"></em>{{$char.name}}</a> - 
					 <span class="js-character-realm">{{$realm}}</span>
<p>{{#armory_character_sheet_level_string#}}&nbsp;{{$char.level}}&nbsp;&nbsp;{{get_wow_class class=$char.class}}</p>
</div>
{{/foreach}}
<div id="myBookmarks">
<div id="bmArrows">
<a class="staticTip" href="javascript:void(0)" id="bmBack" onmouseover="setTipText('Previous');"></a><a class="staticTip" href="javascript:void(0)" id="bmFwd" onmouseover="setTipText('Forward');"></a>
</div>{{#armory_vault_bookmarks#}}</div>
<div id="bookmarkHolder">
<span id="bm-currPage" style="display: none;">1</span><span id="bm-totalPages" style="display: none;">1</span>
<div class="bmPage" id="page1" style="display: block">
{{foreach from=$myVaultBookmarkCharacters item=char}}
<div class="menuItem bmlist">
<a class="character-achievement staticTip" href="character-achievements.xml?r={{$realm}}&amp;cn={{$char.name}}" onmouseover="setTipText('{{#armory_guild_info_achievement_points#}}');">{{$char.apoints}}</a><a class="rmBookmark staticTip" href="javascript:void(0);" onclick="window.location='bookmarks.xml?action=2&amp;n={{$char.name}}'" onmouseover="setTipText('{{#armory_vault_remove_bookmark#}}');">&nbsp;</a><em class="classId{{$char.class}} staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}')"></em><a class="charName" href="character-sheet.xml?r={{$realm}}&amp;cn={{$char.name}}">{{$char.name}}</a><span>&nbsp;-&nbsp;{{$realm}}</span>
<p>{{#armory_character_sheet_level_string#}}&nbsp;{{$char.level}}&nbsp;&nbsp;{{get_wow_class class=$char.class}}</p>
</div>
{{/foreach}}
</div>
</div>
</div>
<div class="clear">
<!---->
</div>
<div class="user-mod" style="text-align: right;">
<a href="javascript:void(0)" id="bookmark-user"></a><span class="loggedInAs">{{#armory_vault_you_logged_as#}}</span>
<br />
<a class="userName" href="character-sheet.xml?r={{$realm}}&amp;n={{$selectedVaultCharacter.name}}"><em class="classId{{$selectedVaultCharacter.class}} staticTip" onmouseover="setTipText('{{get_wow_class class=$selectedVaultCharacter.class}}')" style="margin: 2px 4px 0 0;"></em>{{$selectedVaultCharacter.name}}</a> |                    
                        <a href="index.xml?logout=1" id="logoutLink">{{#armory_vault_logoff#}}</a>
</div>
</div>
{{else}}
<div class="login-container">
<a class="loginLink" href="?login=1" id="loginLinkRedirect">{{#armory_login_string#}}</a>
</div>
{{/if}}
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
-->
{{if $characterArenaTeamInfoButton}}
<a class="" href="character-arenateams.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}"><span>{{#armory_character_sheet_arena#}}</span></a>
{{/if}}
</div>
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
{{if $_wow_login}}
<a class="staticTip" href="javascript:void(0);" onclick="window.location='bookmarks.xml?action=1&amp;n={{$name}}'" id="bmcLink" onmouseover="setTipText('{{#armory_remember_this_character#}}');">
<!----></a>
{{elseif $characterIsBookmarked}}
<a class="bmcEnabled" href="javascript:;">
<!----></a>
{{else}}
<a class="bmcLink staticTip" id="bmcLink" onmouseover="setTipText('{{#armory_login_to_remember_profile#}}');">
<!----></a>
{{/if}}
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
<div class="header_break">
<!---->
</div>
<script src="_js/character/talents.js" type="text/javascript"></script>
<div class="talentGlyphBg">
<div class="talentGlyphFooter">
<div class="talentGlyphHeader">
<div id="glyphHolder">
<div id="glyphSet_2" style="display: none">
</div>
<div id="glyphSet_1">
{{foreach from=$bigGlyphs item=glyph}}
<div class="staticTip glyph major" onmouseover="makeGlyphTooltip('{{$glyph.name}}','{{#armory_character_talents_major_glyph#}}','{{$glyph.description}}')">
<span><img class="majorGlyphIcon" src="images/talents/glyph-small-major-1.gif" />{{$glyph.name}}</span>
</div>

{{/foreach}}

{{foreach from=$smallGlyphs item=glyph}}
<div class="staticTip glyph minor" onmouseover="makeGlyphTooltip('{{$glyph.name}}','{{#armory_character_talents_major_glyph#}}','{{$glyph.description}}')">
<span><img class="minorGlyphIcon" src="images/talents/glyph-small-minor-1.gif" />{{$glyph.name}}</span>
</div>

{{/foreach}}
</div>
</div>
{{if $dualSpec}}
<div class="talentSpecSwitchHolder">
<table class="talentSpecSwitch">
<tr>
<td {{if $disabledDS_0 == true}}class="selectedSet"{{/if}} id="group_1">
<a class="{{if $disabledDS_0 == false}}inA{{else}}a{{/if}}ctiveTalents" href="javascript:void(0)" id="group_1_link" onclick="switchTalentSpec('1','1', '{{$talents_0}}')">
<div>
<img src="wow-icons/_images/21x21/{{$treeIcon_0}}.png" />{{$treeName_0}}</div>
</a>
<div class="buildPointer">
<!---->
</div>
</td>
<td {{if $$disabledDS_1 == true}}class="selectedSet"{{/if}} id="group_2">
<a class="{{if $disabledDS_1 == false}}inA{{else}}a{{/if}}ctiveTalents" href="javascript:void(0)" id="group_2_link" onclick="switchTalentSpec('','2', '{{$talents_1}}')">
<div>
<img src="wow-icons/_images/21x21/{{$treeIcon_1}}.png" />{{$treeName_1}}</div>
</a>
<div class="buildPointer">
<!---->
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