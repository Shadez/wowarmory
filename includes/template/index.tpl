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
<div id="replaceMain">
<div class="front-top">
<!-- -->
{{if $_wow_login}}
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
           loadScript('vault/calendar/alerts-user.json', 'jsonAlerts');
        });
        
        
    </script>
<div id="menuHolder" style="top: 64px; right: 10px;">
<div id="myCharacters">
<a href="character-select.xml" id="changeLink">[{{#armory_vault_change_characters_button#}}]</a>{{#armory_vault_my_characters#}}</div>
{{foreach from=$myVaultCharacters item=char}}
<div class="menuItem charlist">
<a class="character-achievement staticTip" href="character-achievements.xml?r={{$realm}}&amp;n={{$char.name}}" onmouseover="setTipText('{{#armory_guild_info_achievement_points#}}');">{{$char.ach_points}}</a>
<a class="charName js-character-name" href="character-sheet.xml?r={{$realm}}&amp;n={{$char.name}}"><em class="classId{{$char.class}} staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}')"></em>{{$char.name}}</a> - 
<span class="js-character-realm">{{$realm}}</span>
<p>{{#armory_character_sheet_level_string#}}&nbsp;{{$char.level}}&nbsp;&nbsp;{{get_wow_class class=$char.class}}</p>
</div>
{{/foreach}}
<div id="myBookmarks">
<div id="bmArrows">
<a class="staticTip" href="javascript:void(0)" id="bmBack" onmouseover="setTipText('{{#armory_vault_previous#}}');"></a><a class="staticTip" href="javascript:void(0)" id="bmFwd" onmouseover="setTipText('{{#armory_vault_next#}}');"></a>
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
<div class="user-mod loginbg" style="text-align: right; ">
<a href="javascript:void(0)" id="bookmark-user" style="margin: 3px 6px 0 0;"></a><span class="loggedInAs">{{#armory_vault_you_logged_as#}}</span>
<br />
<a class="userName" href="character-sheet.xml?r={{$realm}}&amp;n={{$selectedVaultCharacter.name}}"><em class="classId{{$selectedVaultCharacter.class}} staticTip" onmouseover="setTipText('{{get_wow_class class=$selectedVaultCharacter.class}}')" style="margin: 2px 4px 0 0;"></em>{{$selectedVaultCharacter.name}}</a> |                        
<a href="index.xml?logout=1" id="logoutLink">{{#armory_vault_logoff#}}</a>
</div>
{{else}}
<div class="loginbg">
<a class="loginLink" href="index.xml?login=1" id="loginLinkRedirect">{{#armory_login_string#}}</a>
</div>
{{/if}}
<div class="logo">
<a href="armoryLink"><span>World of Warcraft Armory</span></a>
</div>
</div>
<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-front">
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
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot">
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