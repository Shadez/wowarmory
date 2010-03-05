<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<link href="_css/arena-report.css" rel="stylesheet" />
<span style="display:none;">start</span>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<link href="_css/character/global.css" rel="stylesheet" type="text/css" />
<div class="tabs">
<div class="selected-tab" id="tab_character">
<a href="character-sheet.xml?r={$realm}&amp;n={$name}{if $guildName}&amp;gn={$guildName}{/if}">{#armory_character_sheet_character_string#}</a>
</div>
{if $guildName}
<div class="tab" id="tab_guild">
<a href="guild-info.xml?r={$realm}&amp;cn={$name}&amp;gn={$guildName}">{#armory_character_sheet_guild_string#}</a>
</div>
{/if}
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="selected-subTab" href="character-sheet.xml?r={$realm}&amp;n={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="profile_subTab"><span>{#armory_character_sheet_profile_tab#}</span></a>
<a class="" href="character-talents.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="talents_subTab"><span>{#armory_character_sheet_talents_tab#}</span></a>
<a class="" href="character-reputation.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="reputation_subTab"><span>{#armory_character_sheet_reputaion_tab#}</span></a>
<a class="" href="character-achievements.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="achievements_subTab"><span>{#armory_character_sheet_achievements_tab#}</span></a>
<!--<a class="" href="character-statistics.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="statistics_subTab"><span>{#armory_character_sheet_statistic_tab#}</span></a>
-->
<a class="" href="character-feed.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="feed_subTab"><span>{#armory_character_sheet_feed_tab#}</span></a>
{if $characterArenaTeamInfoButton}
<a class="" href="character-arenateams.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}"><span>{#armory_character_sheet_arena#}</span></a>
{/if}
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile">
<script type="text/javascript">
		var charUrl = "{$character_url_string}";
		var bookmarkMaxedToolTip = "{#armory_you_can_remember_string#}";
		var bookmarkThisChar = "{#armory_remember_this_character#}";	
	</script>
<div class="profile_header header_{$faction_string_class}">
<div class="points">
<a href="character-achievements.xml?r={$realm}&amp;cn={$name}">{$pts}</a>
</div>
<div id="forumLinks">
<a class="staticTip" href="javascript:void();">{$realm}</a></div>
<div class="profile-right" id="profileRight">
{if $_wow_login}
<a class="staticTip" href="javascript:void(0);" onclick="window.location='bookmarks.xml?action=1&amp;n={$name}'" id="bmcLink" onmouseover="setTipText('{#armory_remember_this_character#}');">
<!----></a>
{elseif $characterIsBookmarked}
<a class="bmcEnabled" href="javascript:;">
<!----></a>
{else}
<a class="bmcLink staticTip" id="bmcLink" onmouseover="setTipText('{#armory_login_to_remember_profile#}');">
<!----></a>
{/if}
</div>
<div class="profile-achieve">
<a class="staticTip" href="character-sheet.xml?r={$realm}&amp;cn={$name}" onmouseover="setTipText('{#armory_character_sheet_level_string#}&nbsp;{$level}&nbsp;{get_wow_race race=$race}&nbsp;{get_wow_class class=$class}')">
<img src="images/portraits/{$portrait_path}" /></a>
<div id="leveltext">{$level}</div>
</div>
<div id="charHeaderTxt_Light">
{if $guildName}
<div class="charGuildName">
<a href="guild-info.xml?r={$realm}&amp;gn={$guildName}">{$guildName}</a>
</div>
{/if}
<span class="prefix">{$character_title_prefix} </span>
<div class="charNameHeader">{$name}<span class="suffix">{$character_title_suffix}</span>
</div>
</div>
</div>
<div class="header_break">
<!---->
</div>
{if $characterAT.2x2}
<!-- START ARENATEAMINFO -->
<blockquote style="clear:both">
<b class="iarenateams">
<h2>{if $ArmoryConfig.locale == 'en_gb'}2v2 {#armory_character_arenateams_arena_team#}{else}{#armory_character_arenateams_arena_team#} 2v2{/if}</h2>
</b>
</blockquote>
<div class="arenareport-header-single">
<div class="arenareport-moldingleft-s">
<div class="reldiv">
<div class="arenareport-moldingleft-s-flash">
<div id="teamicon2" style="display:none;"></div>
<script type="text/javascript">
		var flashId="teamicon2";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("teamicon2", "images/icons/team/pvpemblems.swf", "transparent", "", "#{$characterAT.2x2.BackgroundColor}", "78", "78", "high", "", "totalIcons=1&totalIcons=1&startPointX=4&initScale=100&overScale=100&largeIcon=1&iconColor1={$characterAT.2x2.EmblemColor}&iconName1=images/icons/team/pvp-banner-emblem-{$characterAT.2x2.EmblemStyle}.png&bgColor1={$characterAT.2x2.BackgroundColor}&borderColor1={$characterAT.2x2.BorderColor}&teamUrl1=", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{$ArmoryConfig.locale}/getflash.png class=p /></a></div>")
		
		</script>
</div>
<div class="arenareport-moldingleft-name">
<div class="reldiv">
<div class="teamnameshadow">{$characterAT.2x2.name}<span style="font-family:Arial, Helvetica, sans-serif;">
                            &lt;2v2&gt;
                            </span>
</div>
<div class="teamnamehighlight">
<a class="teamnamehighlight" href="team-info.xml?r={$realm}&amp;ts=2&amp;t={$characterAT.2x2.name}">{$characterAT.2x2.name}<span style="font-family:Arial, Helvetica, sans-serif; display: inline;">
                            &lt;2v2&gt;
                            </span></a>
</div>
</div>
</div>
<div class="arenareport-moldingleft-info">
<div style="float: left;">
<div class="reldiv">
<div style="position: absolute; top:-1px;">
<div class="team-members">{#armory_teaminfo_team_members#}: 
{foreach from=$characterAT.2x2.members item=char}
<a href="character-sheet.xml?r={$realm}&amp;cn={$char.name}">{$char.name}</a> {/foreach}
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="arena-badge-container" style="float: right; margin-top: 20px;">
<div class="arenaTeam-badge" style="margin: 0 auto; float: none; padding: 1px;">
<div class="teamSide1"></div>
<div class="teamRank">
<span>{#armory_teaminfo_this_week#}</span>
<p>{#armory_arenaladder_rank#}</p>
</div>
<div class="rank-num" id="arenarank2" style="padding-top: 5px;">
<div id="arenarank2" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank2";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("arenarank2", "images/rank.swf", "transparent", "", "", "100", "50", "best", "", "rankNum=None", "<div class=teamstanding-noflash>None</div>")
		
		</script>
</div>
<div class="arenaBadge-icon" style="background-image:url(images/icons/badges/arena/arena-6.jpg);">
<img class="p" src="images/badge-border-arena-parchment.gif" /></div>
</div>
<a class="standing-link" href="arena-ladder.xml?ts=2"><img src="images/pixel.gif" /></a>
</div>
<div class="filterTitle">{#armory_teaminfo_statistic#}</div>
<div class="stats-container" style="margin-bottom: 10px;">
<div class="arenaTeam-data">
<div class="innerData">
<table>
<tr class="team-header">
<td></td><td align="center" width="25%"><span>{#armory_teaminfo_games#}</span></td><td align="center" width="25%"><span>{#armory_teaminfo_wins_losses#}</span></td><td align="center" width="25%"><span>{#armory_teaminfo_wins_percent#}</span></td><td align="center" width="25%"><span>{#armory_arenaladder_rating#}</span></td>
</tr>
<tr class="hl">
<td>
<p>{if $ArmoryConfig.locale == 'en_gb'}2v2 {#armory_character_arenateams_team_stats#}{else}{#armory_character_arenateams_team_stats#} 2v2{/if}</p>
</td><td align="center">
<p>{$characterAT.2x2.stats.played}</p>
</td><td align="center">
<p>{$characterAT.2x2.stats.wins} - {$characterAT.2x2.stats.played-$characterAT.2x2.stats.wins}</p>
</td><td align="center">
<p>{$characterAT.2x2.stats.percent}%</p>
</td><td align="center">
<p class="rating">{$characterAT.2x2.stats.rating}</p>
</td>
</tr>
{foreach from=$characterAT.2x2.members item=char}
    {if $char.name == $name}
    <tr>
    <td>
    <p>{if $ArmoryConfig.locale == 'en_gb'}{$char.name}'s {#armory_character_arenateams_char_stats#}{else}{#armory_character_arenateams_char_stats#} {$char.name}{/if}</p>
    </td><td align="center">
    <p>{$char.played_week}</p>
    </td><td align="center">
    <p>{$char.wons_week} - {$char.played_week-$char.wons_week}</p>
    </td><td align="center">
    <p>{$char.percent}%</p>
    </td><td align="center">
    <p class="rating">{$char.personal_rating}</p>
    </td>
    </tr>
    {/if}
{/foreach}
</table>
</div>
</div>
</div>
{/if}
{if $characterAT.3x3}
<!-- START ARENATEAMINFO -->
<blockquote style="clear:both">
<b class="iarenateams">
<h2>{if $ArmoryConfig.locale == 'en_gb'}3v3 {#armory_character_arenateams_arena_team#}{else}{#armory_character_arenateams_arena_team#} 3v3{/if}</h2>
</b>
</blockquote>
<div class="arenareport-header-single">
<div class="arenareport-moldingleft-s">
<div class="reldiv">
<div class="arenareport-moldingleft-s-flash">
<div id="teamicon3" style="display:none;"></div>
<script type="text/javascript">
		var flashId="teamicon3";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("teamicon3", "images/icons/team/pvpemblems.swf", "transparent", "", "#{$characterAT.3x3.BackgroundColor}", "78", "78", "high", "", "totalIcons=1&totalIcons=1&startPointX=4&initScale=100&overScale=100&largeIcon=1&iconColor1={$characterAT.3x3.EmblemColor}&iconName1=images/icons/team/pvp-banner-emblem-{$characterAT.3x3.EmblemStyle}.png&bgColor1={$characterAT.3x3.BackgroundColor}&borderColor1={$characterAT.3x3.BorderColor}&teamUrl1=", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{$ArmoryConfig.locale}/getflash.png class=p /></a></div>")
		
		</script>
</div>
<div class="arenareport-moldingleft-name">
<div class="reldiv">
<div class="teamnameshadow">{$characterAT.3x3.name}<span style="font-family:Arial, Helvetica, sans-serif;">
                            &lt;3v3&gt;
                            </span>
</div>
<div class="teamnamehighlight">
<a class="teamnamehighlight" href="team-info.xml?r={$realm}&amp;ts=3&amp;t={$characterAT.3x3.name}">{$characterAT.3x3.name}<span style="font-family:Arial, Helvetica, sans-serif; display: inline;">
                            &lt;3v3&gt;
                            </span></a>
</div>
</div>
</div>
<div class="arenareport-moldingleft-info">
<div style="float: left;">
<div class="reldiv">
<div style="position: absolute; top:-1px;">
<div class="team-members">{#armory_teaminfo_team_members#}: 
{foreach from=$characterAT.3x3.members item=char}
<a href="character-sheet.xml?r={$realm}&amp;cn={$char.name}">{$char.name}</a> {/foreach}
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="arena-badge-container" style="float: right; margin-top: 20px;">
<div class="arenaTeam-badge" style="margin: 0 auto; float: none; padding: 1px;">
<div class="teamSide1"></div>
<div class="teamRank">
<span>{#armory_teaminfo_this_week#}</span>
<p>{#armory_arenaladder_rank#}</p>
</div>
<div class="rank-num" id="arenarank2" style="padding-top: 5px;">
<div id="arenarank3" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank3";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("arenarank3", "images/rank.swf", "transparent", "", "", "100", "50", "best", "", "rankNum=None", "<div class=teamstanding-noflash>None</div>")
		
		</script>
</div>
<div class="arenaBadge-icon" style="background-image:url(images/icons/badges/arena/arena-6.jpg);">
<img class="p" src="images/badge-border-arena-parchment.gif" /></div>
</div>
<a class="standing-link" href="arena-ladder.xml?ts=3"><img src="images/pixel.gif" /></a>
</div>
<div class="filterTitle">{#armory_teaminfo_statistic#}</div>
<div class="stats-container" style="margin-bottom: 10px;">
<div class="arenaTeam-data">
<div class="innerData">
<table>
<tr class="team-header">
<td></td><td align="center" width="25%"><span>{#armory_teaminfo_games#}</span></td><td align="center" width="25%"><span>{#armory_teaminfo_wins_losses#}</span></td><td align="center" width="25%"><span>{#armory_teaminfo_wins_percent#}</span></td><td align="center" width="25%"><span>{#armory_arenaladder_rating#}</span></td>
</tr>
<tr class="hl">
<td>
<p>{if $ArmoryConfig.locale == 'en_gb'}3v3 {#armory_character_arenateams_team_stats#}{else}{#armory_character_arenateams_team_stats#} 3v3{/if}</p>
</td><td align="center">
<p>{$characterAT.3x3.stats.played}</p>
</td><td align="center">
<p>{$characterAT.3x3.stats.wins} - {$characterAT.3x3.stats.played-$characterAT.3x3.stats.wins}</p>
</td><td align="center">
<p>{$characterAT.3x3.stats.percent}%</p>
</td><td align="center">
<p class="rating">{$characterAT.3x3.stats.rating}</p>
</td>
</tr>
{foreach from=$characterAT.3x3.members item=char}
    {if $char.name == $name}
    <tr>
    <td>
    <p>{if $ArmoryConfig.locale == 'en_gb'}{$char.name}'s {#armory_character_arenateams_char_stats#}{else}{#armory_character_arenateams_char_stats#} {$char.name}{/if}</p>
    </td><td align="center">
    <p>{$char.played_week}</p>
    </td><td align="center">
    <p>{$char.wons_week} - {$char.played_week-$char.wons_week}</p>
    </td><td align="center">
    <p>{$char.percent}%</p>
    </td><td align="center">
    <p class="rating">{$char.personal_rating}</p>
    </td>
    </tr>
    {/if}
{/foreach}
</table>
</div>
</div>
</div>
{/if}
{if $characterAT.5x5}
<!-- START ARENATEAMINFO -->
<blockquote style="clear:both">
<b class="iarenateams">
<h2>{if $ArmoryConfig.locale == 'en_gb'}5v5 {#armory_character_arenateams_arena_team#}{else}{#armory_character_arenateams_arena_team#} 5v5{/if}</h2>
</b>
</blockquote>
<div class="arenareport-header-single">
<div class="arenareport-moldingleft-s">
<div class="reldiv">
<div class="arenareport-moldingleft-s-flash">
<div id="teamicon5" style="display:none;"></div>
<script type="text/javascript">
		var flashId="teamicon5";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("teamicon5", "images/icons/team/pvpemblems.swf", "transparent", "", "#{$characterAT.5x5.BackgroundColor}", "78", "78", "high", "", "totalIcons=1&totalIcons=1&startPointX=4&initScale=100&overScale=100&largeIcon=1&iconColor1={$characterAT.5x5.EmblemColor}&iconName1=images/icons/team/pvp-banner-emblem-{$characterAT.5x5.EmblemStyle}.png&bgColor1={$characterAT.5x5.BackgroundColor}&borderColor1={$characterAT.5x5.BorderColor}&teamUrl1=", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{$ArmoryConfig.locale}/getflash.png class=p /></a></div>")
		
		</script>
</div>
<div class="arenareport-moldingleft-name">
<div class="reldiv">
<div class="teamnameshadow">{$characterAT.5x5.name}<span style="font-family:Arial, Helvetica, sans-serif;">
                            &lt;5v5&gt;
                            </span>
</div>
<div class="teamnamehighlight">
<a class="teamnamehighlight" href="team-info.xml?r={$realm}&amp;ts=5&amp;t={$characterAT.5x5.name}">{$characterAT.5x5.name}<span style="font-family:Arial, Helvetica, sans-serif; display: inline;">
                            &lt;5v5&gt;
                            </span></a>
</div>
</div>
</div>
<div class="arenareport-moldingleft-info">
<div style="float: left;">
<div class="reldiv">
<div style="position: absolute; top:-1px;">
<div class="team-members">{#armory_teaminfo_team_members#}: 
{foreach from=$characterAT.5x5.members item=char}
<a href="character-sheet.xml?r={$realm}&amp;cn={$char.name}">{$char.name}</a> {/foreach}
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="arena-badge-container" style="float: right; margin-top: 20px;">
<div class="arenaTeam-badge" style="margin: 0 auto; float: none; padding: 1px;">
<div class="teamSide1"></div>
<div class="teamRank">
<span>{#armory_teaminfo_this_week#}</span>
<p>{#armory_arenaladder_rank#}</p>
</div>
<div class="rank-num" id="arenarank2" style="padding-top: 5px;">
<div id="arenarank5" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank5";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("arenarank5", "images/rank.swf", "transparent", "", "", "100", "50", "best", "", "rankNum=None", "<div class=teamstanding-noflash>None</div>")
		
		</script>
</div>
<div class="arenaBadge-icon" style="background-image:url(images/icons/badges/arena/arena-6.jpg);">
<img class="p" src="images/badge-border-arena-parchment.gif" /></div>
</div>
<a class="standing-link" href="arena-ladder.xml?ts=2"><img src="images/pixel.gif" /></a>
</div>
<div class="filterTitle">{#armory_teaminfo_statistic#}</div>
<div class="stats-container" style="margin-bottom: 10px;">
<div class="arenaTeam-data">
<div class="innerData">
<table>
<tr class="team-header">
<td></td><td align="center" width="25%"><span>{#armory_teaminfo_games#}</span></td><td align="center" width="25%"><span>{#armory_teaminfo_wins_losses#}</span></td><td align="center" width="25%"><span>{#armory_teaminfo_wins_percent#}</span></td><td align="center" width="25%"><span>{#armory_arenaladder_rating#}</span></td>
</tr>
<tr class="hl">
<td>
<p>{if $ArmoryConfig.locale == 'en_gb'}5v5 {#armory_character_arenateams_team_stats#}{else}{#armory_character_arenateams_team_stats#} 5v5{/if}</p>
</td><td align="center">
<p>{$characterAT.5x5.stats.played}</p>
</td><td align="center">
<p>{$characterAT.5x5.stats.wins} - {$characterAT.5x5.stats.played-$characterAT.5x5.stats.wins}</p>
</td><td align="center">
<p>{$characterAT.5x5.stats.percent}%</p>
</td><td align="center">
<p class="rating">{$characterAT.5x5.stats.rating}</p>
</td>
</tr>
{foreach from=$characterAT.5x5.members item=char}
    {if $char.name == $name}
    <tr>
    <td>
    <p>{if $ArmoryConfig.locale == 'en_gb'}{$char.name}'s {#armory_character_arenateams_char_stats#}{else}{#armory_character_arenateams_char_stats#} {$char.name}{/if}</p>
    </td><td align="center">
    <p>{$char.played_week}</p>
    </td><td align="center">
    <p>{$char.wons_week} - {$char.played_week-$char.wons_week}</p>
    </td><td align="center">
    <p>{$char.percent}%</p>
    </td><td align="center">
    <p class="rating">{$char.personal_rating}</p>
    </td>
    </tr>
    {/if}
{/foreach}
</table>
</div>
</div>
</div>
{/if}
<!-- END ARENATEAM INFO -->
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
{include file="faq_arenas.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}