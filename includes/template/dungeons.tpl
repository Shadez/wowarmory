<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">	
<script type="text/javascript">	
{literal}
		function toggleDungeon(dungeonId){
			elementId = $blizz('showHideBosses'+ dungeonId);
			if (elementId.style.display == 'block') {
				$blizz('toggleExpand' + dungeonId).className = "expand-list";
				elementId.style.display = 'none';
			} else {
				$blizz('toggleExpand' + dungeonId).className = "collapse-list";	
				elementId.style.display = 'block';
			}
		}
{/literal}
</script>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="tabs">
<div class="tab" id="tab_factions">
<a href="factions.xml">{#armory_dungeons_factions#}</a>
</div>
<div class="selected-tab" id="tab_dungeons">
<a href="dungeons.xml">{#armory_dungeons_raids#}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="{$wowclassictab}" href="dungeons.xml" id="classic_subTab"><span>WoW Classic</span></a>
<a class="{$wowtbctab}" href="dungeons0.xml" id="bc_subTab"><span>Burning Crusade</span></a>
<a class="{$wowwotlktab}" href="dungeons1.xml" id="wotlk_subTab"><span>Wrath of the Lich King</span></a>
</div>
<div class="full-list">
<div class="info-pane dungeon-container">
<div class="info-header dhbg{if $wowclassictab}classic{elseif $wowtbctab}bc{elseif $wowwotlktab}wotlk{/if}">
<h1>{#armory_dungeons_raids#}</h1>
<h2></h2>
</div>
</div>
<div class="dungeon-header">
<table>
<tr>
<td width="25"></td>
<td width="250"><span>{#armory_dungeons_dungeon_str#}</span></td>
<td width="120"><span>{#armory_dungeons_bosses_str#}</span></td>
<td width="80"><span>{#armory_dungeons_level_str#}</span></td>
<td width="150"><span>{#armory_dungeons_category_str#}</span></td>
</tr>
</table>
</div>
<div class="dungeon-content">
<table>
{foreach from=$dungeonList item=dungeon}
<tr class="expand-list" id="toggleExpand{$dungeon.key}">
<td class="rc0" valign="top" width="25"><a class="expandToggle" href="javascript: javascript: toggleDungeon('{$dungeon.key}');"></a></td>
<td class="rc0" valign="top" width="250"><a href="search.xml?source=dungeon&amp;dungeon={$dungeon.key}&amp;boss=all&amp;difficulty=all&amp;searchType=items">{$dungeon.name}</a>
<div class="d-bosses" id="showHideBosses{$dungeon.key}" style="display:none;">
{foreach from=$dungeon.bosses item=boss}
<em></em><a href="search.xml?source=dungeon&amp;dungeon={$dungeon.key}&amp;boss={$boss.id}&amp;difficulty=all&amp;searchType=items">{$boss.bossname}</a><em></em>
{/foreach}
</div>
</td>
<td class="rc0" valign="top" width="120"><a href="javascript: toggleDungeon('{$dungeon.key}');">{#armory_dungeons_show_bosses#}</a><span>({$dungeon.boss_num})</span></td>
<td class="rc0" valign="top" width="80">{if $dungeon.levelMin == $dungeon.levelMax}{$dungeon.levelMin}{else}{$dungeon.levelMin}-{$dungeon.levelMax}{/if}</td>
<td class="rc0" valign="top" width="150">
{if $dungeon.partySize < 10 && $dungeon.raid == 0}
{#armory_dungeons_dungeon_difficult#}
{elseif $dungeon.partySize == 10}
{#armory_dungeons_raid10_difficult#}
{elseif $dungeon.partySize == 20}
{#armory_dungeons_raid20_difficult#}
{elseif $dungeon.partySize == 25}
{#armory_dungeons_raid25_difficult#}
{elseif $dungeon.partySize == 40}
{#armory_dungeons_raid40_difficult#}
{/if}</td>
</tr>
{/foreach}
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