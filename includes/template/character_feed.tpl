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
<link href="_css/character/global.css" rel="stylesheet" type="text/css" />
<link href="_css/character/feed.css" rel="stylesheet" type="text/css" />
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
<a class="" href="character-sheet.xml?r={$realm}&amp;n={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="profile_subTab"><span>{#armory_character_sheet_profile_tab#}</span></a>
<a class="" href="character-talents.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="talents_subTab"><span>{#armory_character_sheet_talents_tab#}</span></a>
<a class="" href="character-reputation.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="reputation_subTab"><span>{#armory_character_sheet_reputaion_tab#}</span></a>
<a class="" href="character-achievements.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="achievements_subTab"><span>{#armory_character_sheet_achievements_tab#}</span></a>
<!--<a class="" href="character-statistics.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="statistics_subTab"><span>{#armory_character_sheet_statistic_tab#}</span></a>
-->
<a class="selected-subTab" href="character-feed.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}" id="feed_subTab"><span>{#armory_character_sheet_feed_tab#}</span></a>
{if $characterArenaTeamInfoButton}
<a class="" href="character-arenateams.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}"><span>{#armory_character_sheet_arena#}</span></a>
{/if}
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile type_{$faction_string_class}">
<script type="text/javascript">
		var charUrl = "{$urlName}";
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
<div class="activity_bg">
<h1>{#armory_character_feed_title#}<span>{#armory_character_feed_title_info#}</span>
</h1>
<div class="activity_body_rpt">
<div class="activity_body_top">
<div class="activity_body_btm">
<div class="activity_body_int">
<h3>{#armory_character_feed_recent_news#}</h3>
{foreach from=$characterFeed item=feed}
<div class="feed_entry">
<table>
<tr>
<td class="td_icon">
<div class="feed_icon">
{if $feed.type == 1}
<a class="staticTip" onmouseover="setTipText('<div class=\&quot;myTable\&quot;\><img src=\&quot;/wow-icons/_images/51x51/{$feed.iconname}.jpg\&quot; align=\&quot;left\&quot; class=\&quot;ach_tooltip\&quot; /\><strong style=\&quot;color: #fff;\&quot;\>{$feed.name} ({$feed.points})</strong\><br /\>{$feed.description}');"><img class="p" src="images/feed_icon_achievement.png" /></a>
</div>
</td>
<td>
{#armory_character_feed_achievement_1#} <strong>[<a class="criteria staticTip" href="character-achievements.xml?r={$realm}&amp;cn={$name}" onmouseover="setTipText('<div class=\&quot;myTable\&quot;\><img src=\&quot;/wow-icons/_images/51x51/{$feed.iconname}.jpg\&quot; align=\&quot;left\&quot; class=\&quot;ach_tooltip\&quot; /\><strong style=\&quot;color: #fff;\&quot;\>{$feed.name} ({$feed.points})</strong\><br /\>{$feed.description}')">{$feed.name}</a>]</strong> {#armory_character_feed_achievement_2#} {$feed.points} {#armory_character_feed_achievement_3#}.                    
&nbsp;<span class="timestamp">{$feed.date|date_format:"%d.%m.%Y"}</span>
</td>
{elseif $feed.type == 2}
<a class="staticTip itemToolTip" href="item-info.xml?i={$feed.data}" id="i={$feed.data}" style="background-image:url(/wow-icons/_images/21x21/{$feed.icon}.png)"><img class="p" src="images/feed_icon_loot.png" /></a>
</div>
</td>
<td>
<div class="timestamp">{$feed.date|date_format:"%d.%m.%Y"}</div>
{#armory_character_feed_obtained#} <a class="staticTip itemToolTip" href="item-info.xml?i={$feed.data}" id="i={$feed.data}"><span class="stats_rarity{$feed.quality}">[{$feed.name}]</span></a>.
</td>
{elseif $feed.type == 3}
<a class="event_bosskill"><img class="p" src="images/feed_icon_bosskill.png" /></a>
</div>
</td><td>
<div class="timestamp">{$feed.date|date_format:"%d.%m.%Y"}</div>
{if $ArmoryConfig.locale == 'en_gb'}{$feed.counter} {$feed.name} {#armory_character_feed_boss_kill#}.
{else}
{$feed.counter} {#armory_character_feed_boss_kill#} {$feed.name}.
{/if}
</td>
{/if}
</tr>
</table>
</div>
{/foreach}
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
</div>
</div>
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{include file="faq_index.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}