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
<tabInfo subTab="profile" tab="character" tabGroup="character" tabUrl=""></tabInfo>
<link href="_css/character/sheet.css" rel="stylesheet" type="text/css">
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="player-side notab">
<div class="info-pane">
<div class="profile-wrapper">
<blockquote>
<b class="iguilds">
<h4>
<a href="index.xml">{{#armory_armory_string#}}</a>
</h4>
<h3>{{#armory_error_string#}}</h3>
</b>
</blockquote>
<div class="filtercontainer" style="margin:50px auto;padding:6px; width:80%">
<div class="bankcontentsfiltercontainer" style="width:100%; text-align: center;">
<div style="padding:10px;">
<div class="guildloginmsg" style="padding-left:10px">
<div class="guilderrortitle">{{$errorTitle}}</div>
<str id="armory.labels.nocharacter">{{$errorText}}
</str>
</div>
</div>
</div>
<div class="clearfilterboxsm"></div>
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
<script type="text/javascript">
    function setArmorySearchFocus() {
        document.formSearch.armorySearch.focus();
    }
    window.onload = setArmorySearchFocus;	
</script>
</div>
</div>