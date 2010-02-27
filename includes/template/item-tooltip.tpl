<!DOCTYPE table PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td valign="top">
<div class="myTable">
<span class="{$quality_color} myBold myItemName"><span class="">{$item_name}</span><span class=""> </span></span><br />
{if $is_heroic}<span class="bonusGreen">{#armory_item_tooltip_item_heroic#}</span><br />{/if}
{if $bonding}{$bonding}<br />{/if}
{if $quality}{$quality}<br />{/if}

<span class="tooltipRight" style="display: inline;">
{if $armor_type}{$armor_type}{/if}
</span>

{if $item_equip}{$item_equip}<br />{/if}
{if $weapon_damage}<span class="">{$minDmg}-{$maxDmg}&nbsp;</span><span class="">{#tooltip_damage#}</span><span class="tooltipRight">{#tooltip_speed#}&nbsp;{$dmg_speed}</span>
<br />(<span class="">{$dmg_per_sec}&nbsp;</span><span class="">{#tooltip_dps#}</span>)
<br />{/if}

{if $item_armor}<span class=""><span class="">{$item_armor}&nbsp;</span><span class="">{#tooltip_armor#}</span></span><br />{/if}
{$first_bonuses}
{if $ench}<span class="bonusGreen"><span class="">{$ench}&nbsp;</span><span class="">&nbsp;</span></span><br />{/if}
{if $sockets}{$sockets}
    {if $socketBonusEnable}
        <span class="bonusGreen">{#tooltip_socketbonus#}&nbsp;{$socket_bonus}</span>
    {else}
        <span class="setItemGray">{#tooltip_socketbonus#}&nbsp;{$socket_bonus}</span>
    {/if}
<br />
{/if}

{if $durability.max > 1}{#tooltip_durability#}&nbsp;{$durability.current} / {$durability.max}<br />{/if}
{if $races}{#tooltip_races#}&nbsp;{$races}<br />{/if}
{if $classes}{#tooltip_classes#}&nbsp;{$classes}<br />{/if}
{if $need_level}{#tooltip_required_level#}&nbsp;{$need_level}<br />{/if}
{if $itemLevel > 0}{#armory_item_tooltip_itemlevel#}: {$itemLevel}<br />{/if}
{if $need_skill}{#tooltip_required_skill#}&nbsp;{$need_skill} ({$need_skill_rank})<br />{/if}
{if $need_reputation_faction} 
    {if $ArmoryConfig.locale == 'en_gb'} 
        {#tooltip_required_reputation#} {$need_reputation_faction} - {$need_reputation_rank}
    {else}
        {#tooltip_required_reputation#} &nbsp;{$need_reputation_rank} {$need_reputation_faction}
    {/if}
{/if}
{if $description}<span class="myYellow">"{$description}"</span><br />{/if}
{if $green_bonuses}{$green_bonuses}<br />{/if}
{if $itemsetInfo}<br />{$itemsetInfo}<br />{/if}
{if $source}<span class="tooltipContentSpecial" style="float: left;">{#armory_item_tooltip_source#}:&nbsp;</span>{$source}<br />{/if}
{if $fullLootInfo}<br />
<span class="tooltipContentSpecial" style="float: left;">{#armory_item_tooltip_source#}:&nbsp;</span>{$fullLootInfo.dungeon}<br />
<span class="tooltipContentSpecial" style="float: left;">{#tooltip_source_boss#}&nbsp;</span>{$fullLootInfo.boss}<br />
<span class="tooltipContentSpecial" style="float: left;">{#tooltip_source_drop_percent#}&nbsp;</span>{$fullLootInfo.percent}
{/if}
</div>
</td>
</tr>
</tbody>
</table>