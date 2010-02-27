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
<div class="tabs">
<div class="selected-tab" id="tab_factions">
<a href="factions.xml">{#armory_dungeons_factions#}</a>
</div>
<div class="tab" id="tab_dungeons">
<a href="dungeons.xml">{#armory_dungeons_raids#}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="{$wowclassictab}" href="factions.xml" id="classic_subTab"><span>WoW Classic</span></a>
<a class="{$wowtbctab}" href="factions0.xml" id="bc_subTab"><span>Burning Crusade</span></a>
<a class="{$wowwotlktab}" href="factions1.xml" id="wotlk_subTab"><span>Wrath of the Lich King</span></a>
</div>
<div class="full-list">
<div class="info-pane dungeon-container">
<div class="info-header dhbg{if $wowclassictab}classic{elseif $wowtbctab}bc{elseif $wowwotlktab}wotlk{/if}">
<h1>{#armory_dungeons_factions#}</h1>
<h2>{if $wowclassictab}{#armory_factions_classic#}{elseif $wowtbctab}{#armory_factions_tbc#}{elseif $wowwotlktab}{#armory_factions_wotlk#}{/if}</h2>
</div>
<div class="dungeon-header">
<table>
<tr>
<td style="width: 90%;"><span>{#armory_factions_faction#}</span></td><td><span>{#armory_factions_side#}</span></td>
</tr>
</table>
</div>
<div class="dungeon-content">
<table>
{foreach from=$factionList item=faction}
<tr class="expand-list">
<td class="rc0" width="90%"><a href="search.xml?source=reputation&amp;faction={$faction.id}&amp;searchType=items">{$faction.name}</a></td>
<td class="rc0">
{* 0 - alliance ; 1 - horde ; 2 - both *}
{if $faction.side == 0}
<q class="side-col"><img class="staticTip" onmouseover="setTipText('{#string_alliance#}');" src="images/icon-alliance.gif" /></q>
{elseif $faction.side == 1}
<q class="side-col"><img class="staticTip" onmouseover="setTipText('{#string_horde#}');" src="images/icon-horde.gif" style="margin-left: 25px" /></q>
{else}
<q class="side-col"><img class="staticTip" onmouseover="setTipText('{#string_alliance#}');" src="images/icon-alliance.gif" /><img class="staticTip" onmouseover="setTipText('{#string_horde#}');" src="images/icon-horde.gif" style="margin-left: 5px;" /></q></td>
{/if}
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