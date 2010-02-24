<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<span style="display:none;">start</span>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="results-side-expanded" id="results-side-switch">
<div class="list">
<div class="team-side notab" style="width: 100%;">
<div class="info-pane">
<div class="profile-wrapper">
<blockquote>
<b class="iitems">
<h4>
<a href="item-search.xml">{{#armory_item_info_items_string#}}</a>
</h4>
<h3>{{#armory_item_info_search_results_header#}}</h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<div class="item-padding">
<div class="item-background">
<div class="item-bottom">
<div class="item-top">
<img height="250" src="images/pixel.gif" style="float: left;" width="1" /><div class="icon-container">
<p></p>
<img class="p" src="wow-icons/_images/64x64/{{$item_icon}}.jpg" /></div>
<div class="alt-stats">
<div class="as-top">
<div class="as-bot">
<em>{{#armory_item_info_string#}}</em>
<p>
<span>{{#armory_item_info_ilevel#}}:</span>
<br />
<strong>{{$item_level}}</strong>
</p>
{{if $buyPrice.gold>0 or $buyPrice.silver>0 or $buyPrice.copper>0 or $price}}
<p>
<span>{{#armory_item_info_cost#}}:</span>
<br />
<strong>{{if $buyPrice.gold>0}}{{$buyPrice.gold}}<img class="pMoney" src="images/icons/money-gold.gif" />{{/if}}{{if $buyPrice.silver>0}}{{$buyPrice.silver}}<img class="pMoney" src="images/icons/money-silver.gif" />{{/if}}{{if $buyPrice.copper>0}}{{$buyPrice.copper}}<img class="pMoney" src="images/icons/money-copper.gif" />{{/if}}&nbsp;</strong>
{{if $price}}
<strong>
{{if $price.item1>0}}<a class="item-count staticTip itemToolTip" href="item-info.xml?i={{$price.item1}}" id="i={{$price.item1}}"><span><b>{{$price.item1count}}</b>{{$price.item1count}}</span><img class="p21" src="wow-icons/_images/21x21/{{$price.item1icon}}.png" /></a>{{/if}}{{if $price.item2>0}}<a class="item-count staticTip itemToolTip" href="item-info.xml?i={{$price.item2}}" id="i={{$price.item2}}"><span><b>{{$price.item2count}}</b>{{$price.item2count}}</span><img class="p21" src="wow-icons/_images/21x21/{{$price.item2icon}}.png" /></a>{{/if}}{{if $price.item3>0}}<a class="item-count staticTip itemToolTip" href="item-info.xml?i={{$price.item3}}" id="i={{$price.item3}}"><span><b>{{$price.item3count}}</b>{{$price.item3count}}</span><img class="p21" src="wow-icons/_images/21x21/{{$price.item3icon}}.png" /></a>{{/if}}{{if $price.item4>0}}<a class="item-count staticTip itemToolTip" href="item-info.xml?i={{$price.item4}}" id="i={{$price.item4}}"><span><b>{{$price.item4count}}</b>{{$price.item4count}}</span><img class="p21" src="wow-icons/_images/21x21/{{$price.item4icon}}.png" /></a>{{/if}}{{if $price.item5>0}}<a class="item-count staticTip itemToolTip" href="item-info.xml?i={{$price.item5}}" id="i={{$price.item5}}"><span><b>{{$price.item5count}}</b>{{$price.item5count}}</span><img class="p21" src="wow-icons/_images/21x21/{{$price.item5icon}}.png" /></a>{{/if}}
</strong>
{{/if}}
</p>
{{/if}}
{{if $sellPrice.gold>0 or $sellPrice.silver>0 or $sellPrice.copper>0}}
<p>
<span>{{#armory_item_info_sells_for#}}:</span>
<br />
<strong>{{if $sellPrice.gold>0}}{{$sellPrice.gold}}<img class="pMoney" src="images/icons/money-gold.gif" />{{/if}}{{if $sellPrice.silver>0}}{{$sellPrice.silver}}<img class="pMoney" src="images/icons/money-silver.gif" />{{/if}}{{if $sellPrice.copper>0}}{{$sellPrice.copper}}<img class="pMoney" src="images/icons/money-copper.gif" />{{/if}}&nbsp;</strong>
</p>
{{/if}}
{{if $disenchant_info}}
<p>
<span>{{#armory_item_info_disenchanting_string#}}:</span>
<br />
<div class="skill-bar">
<b style="width:100%"></b><img class="staticTip" onMouseOver="javascript: setTipText('{{#armory_item_info_disenchanting_1#}} <strong>{{$disenchant_info}}</strong> {{#armory_item_info_disenchanting_2#}}');" src="images/icons/icon-disenchant-sm.gif" /><strong class="staticTip" onMouseOver="javascript: setTipText('{{#armory_item_info_disenchanting_1#}} <strong>{{$disenchant_info}}</strong> {{#armory_item_info_disenchanting_2#}}');">{{$disenchant_info}}</strong>
</div>
</p>
{{/if}}
</div>
</div>
</div>
<div class="item-info">
<div class="item-bound">
<div class="id">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td valign="top">
<div class="myTable">
<span class="{{$quality_color}} myBold myItemName"><span class="">{{$item_name}}</span><span class=""> </span></span><br />
{{if $is_heroic}}<span class="bonusGreen">{{#armory_item_tooltip_item_heroic#}}</span><br />{{/if}}
{{if $bonding}}{{$bonding}}<br />{{/if}}
{{if $quality}}{{$quality}}<br />{{/if}}
{{if $startquest}}{{#armory_item_tooltip_canstartnewquest#}}<br />{{/if}}
<span class="tooltipRight" style="display: inline;">
{{if $armor_type}}{{$armor_type}}{{/if}}
</span>
{{if $item_equip}}{{$item_equip}}<br />{{/if}}
{{if $weapon_damage}}
<span class="">{{$minDmg}}-{{$maxDmg}}&nbsp;</span><span class="">{{#tooltip_damage#}}</span><span class="tooltipRight">{{#tooltip_speed#}}&nbsp;{{$dmg_speed}}</span>
<br />
(<span class="">{{$dmg_per_sec}}&nbsp;</span><span class="">{{#tooltip_dps#}}</span>)
<br />{{/if}}
{{if $item_armor}}<span class=""><span class="">{{$item_armor}}&nbsp;</span><span class="">{{#tooltip_armor#}}</span></span><br />{{/if}}
{{$first_bonuses}}
{{if $sockets}}{{$sockets}}{{/if}}
{{if $durability}}{{#tooltip_durability#}}&nbsp;{{$durability}} / {{$durability}}<br />{{/if}}{{if $races}}{{#tooltip_races#}}&nbsp;{{$races}}<br />{{/if}}{{if $classes}}{{#tooltip_classes#}}&nbsp;{{$classes}}<br />{{/if}}{{if $need_level}}{{#tooltip_required_level#}}&nbsp;{{$need_level}}<br />{{/if}}{{#armory_item_info_ilevel#}} {{$item_level}}<br />{{if $need_skill}}{{#tooltip_required_skill#}}&nbsp;{{$need_skill}} ({{$need_skill_rank}})<br />{{/if}}{{if $need_reputation_faction}}{{#tooltip_required_reputation#}} &nbsp;{{$need_reputation_rank}} {{$need_reputation_faction}}{{/if}}
{{if $green_bonuses}}{{$green_bonuses}}<br />{{/if}}
{{if $itemsetInfo}}<br />{{$itemsetInfo}}{{/if}}
{{if $description}}<span class="myYellow">"{{$description}}"</span><br />{{/if}}
{{if $source}}<span class="tooltipContentSpecial" style="float: left;">{{#tooltip_source#}}&nbsp;</span>{{$source}}<br />{{/if}}
{{if $fullLootInfo}}
<span class="tooltipContentSpecial" style="float: left;">{{#armory_item_tooltip_source#}}:&nbsp;{{$fullLootInfo.instance}}</span><br />
<span class="tooltipContentSpecial" style="float: left;">{{#tooltip_source_boss#}}&nbsp;</span>{{$fullLootInfo.source}}<br />
<span class="tooltipContentSpecial" style="float: left;">{{#tooltip_source_drop_percent#}}&nbsp;</span>{{$fullLootInfo.percent}}
{{/if}}
</div>
</td>
</tr>
</tbody>
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
<div class="item-related"></div>
<div class="scroll-padding"></div>
{{if $boss_loot}}
<div class="rel-tab">
<p class="rel-drop"></p>
<h3>{{#armory_item_info_dropped_by#}}</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_drop_name#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_level_string#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_drop_chance#}}</a></td>
</tr>
{{foreach from=$boss_loot item=boss}}
<tr>
<td><q><span><i class="mobName">{{$boss.name}}</i></span></q></td>
<td align="center"><q>{{$boss.level}}{{if $boss.boss}} ({{#armory_item_info_boss_string#}}){{/if}}</q></td>
<td align="center"><q>
{{if $boss.map}}
    {{$boss.map}}
    {{if $boss.difficult == 0 and $boss.instance_type == 1}}
    &nbsp;
    {{elseif $boss.difficult == 0 and $boss.instance_type == 2}}
    (10)
    {{elseif $boss.difficult == 1 and $boss.instance_type == 1}}
    ({{#armory_item_info_heroic_dungeon#}})
    {{elseif $boss.difficult == 1 and $boss.instance_type == 2}}
    (25)
    {{elseif $boss.difficult == 2}}
    (10) ({{#armory_item_info_heroic_dungeon#}})
    {{elseif $boss.difficult == 3}}
    (25) ({{#armory_item_info_heroic_dungeon#}})
    {{/if}}
{{/if}}
</q></td>
<td align="center"><q>{{$boss.drop_percent}}</q></td>
</tr>
{{/foreach}}
</table>
</div>
{{/if}}
<!---->
{{if $chest_loot}}
<div class="rel-tab">
<p class="rel-drop"></p>
<h3>{{#armory_item_info_contained_in#}}:</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_drop_name#}}</a></td>
<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_drop_chance#}}</a></td>
</tr>
{{foreach from=$chest_loot item=chest}}
<tr>
<td><q><span><i>{{$chest.name}}</i></span></q></td>
<td><q><a href="javascript:;">{{$chest.map}}{{$chest.difficult}}</a></q></td>
<td align="center"><q>{{$chest.drop_percent}}</q></td>
</tr>

{{/foreach}}
</table>
</div>
{{/if}}
{{if $item_loot}}
<div class="rel-tab">
<p class="rel-drop"></p>
<h3>{{#armory_item_info_contained_in#}}:</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_drop_name#}}</a></td>
<!--<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>-->
<td align="center"><a class="noLink">{{#armory_item_info_drop_chance#}}</a></td>
</tr>
{{foreach from=$item_loot item=item}}
<tr>
<td><q><span><i>{{$item.name}}</i></span></q></td>
<!--<td><q><a href="javascript:;">{{$item.map}}</a></q></td>-->
<td align="center"><q>{{$item.drop_percent}}</q></td>
</tr>

{{/foreach}}
</table>
</div>
{{/if}}
<!---->
{{if $vendor_loot}}
<div class="rel-tab">
<p class="rel-drop"></p>
<h3>{{#armory_item_info_sold_by#}}</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_drop_name#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_level_string#}}</a></td>
<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
</tr>
{{foreach from=$vendor_loot item=vendor}}
<tr>
<td><q><span><i>{{$vendor.name}}</i></span></q></td>
<td align="center"><q>{{$vendor.level}}</q></td>
<td><q>{{$vendor.map}}</q></td>
</tr>

{{/foreach}}
</table>
</div>
{{/if}}
{{if $craft_loot}}
<div class="rel-tab">
<p class="rel-reagentreq"></p>
<h3>{{#armory_item_info_created_by#}}</h3>
</div>
<div id="big-results" style="clear: both;">
<div class="data">
<table class="data-table">
<tr class="masthead">
<td colspan="2"><a class="noLink">{{#armory_item_info_drop_name#}}</a></td><td><a class="noLink">{{#armory_item_info_reagents#}}</a></td>
</tr>
{{foreach from=$craft_loot item=craft}}
{{if $craft.item_name_1}}
<tr>
<td width="55"><img class="p43" src="wow-icons/_images/43x43/{{$craft.item_icon_1}}.png" /></td>
<td>
<q><a class="rarity{{$craft.item_icon_1}} staticTip itemToolTip" href="item-info.xml?i={{$craft.item_entry_1}}" id="{{$craft.item_entry_1}}">{{$craft.item_name_1}}</a></q>
</td>
<td style="white-space: nowrap;">
<q>
{{if $craft.entry_reagent_1}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_1}}" id="{{$craft.entry_reagent_1}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_1}}.png" /><b>{{$craft.count_reagent_1}}</b></a>
{{/if}}
{{if $craft.entry_reagent_2}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_2}}" id="{{$craft.entry_reagent_2}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_2}}.png" /><b>{{$craft.count_reagent_2}}</b></a>
{{/if}}
{{if $craft.entry_reagent_3}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_3}}" id="{{$craft.entry_reagent_3}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_3}}.png" /><b>{{$craft.count_reagent_3}}</b></a>
{{/if}}
{{if $craft.entry_reagent_4}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_4}}" id="{{$craft.entry_reagent_4}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_4}}.png" /><b>{{$craft.count_reagent_4}}</b></a>
{{/if}}
{{if $craft.entry_reagent_5}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_5}}" id="{{$craft.entry_reagent_5}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_5}}.png" /><b>{{$craft.count_reagent_5}}</b></a>
{{/if}}
{{if $craft.entry_reagent_6}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_6}}" id="{{$craft.entry_reagent_6}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_6}}.png" /><b>{{$craft.count_reagent_6}}</b></a>
{{/if}}
{{if $craft.entry_reagent_7}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_7}}" id="{{$craft.entry_reagent_7}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_7}}.png" /><b>{{$craft.count_reagent_7}}</b></a>
{{/if}}
{{if $craft.entry_reagent_8}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$craft.entry_reagent_8}}" id="{{$craft.entry_reagent_8}}"><img class="p21" src="wow-icons/_images/21x21/{{$craft.icon_reagent_8}}.png" /><b>{{$craft.count_reagent_8}}</b></a>
{{/if}}
</q>
</td>
</tr>
{{/if}}
{{/foreach}}
</table>
</div>
</div>
{{/if}}
{{if $reagent_loot}}
<div class="rel-tab">
<p class="rel-reagentreq"></p>
<h3>{{#armory_item_info_reagent_for#}}</h3>
</div>
<div id="big-results" style="clear: both;">
<div class="data">
<table class="data-table">
<tr class="masthead">
<td colspan="2"><a class="noLink">{{#armory_item_info_drop_name#}}</a></td><td><a class="noLink">{{#armory_item_info_reagents#}}</a></td>
</tr>
{{foreach from=$reagent_loot item=reagent}}
{{if $reagent.item_name}}
<tr>
<td width="55"><img class="p43 staticTip itemToolTip" id="{{$reagent.item_entry}}" src="wow-icons/_images/43x43/{{$reagent.item_icon}}.png" /></td>
<td class="item-icon" width="50%"><q><a class="rarity{{$reagent.item_quality}} staticTip itemToolTip" href="item-info.xml?i={{$reagent.item_entry}}" id="{{$reagent.item_entry}}">{{$reagent.item_name}}</a></q></td>
<td style="white-space:nowrap;">
<q>
{{if $reagent.Reagent_1 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_1}}" id="{{$reagent.Reagent_1}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_1}}.png" /><b>{{if $reagent.ReagentCount_1 > 1}}{{$reagent.ReagentCount_1}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_2 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_2}}" id="{{$reagent.Reagent_2}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_2}}.png" /><b>{{if $reagent.ReagentCount_2 > 1}}{{$reagent.ReagentCount_2}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_3 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_3}}" id="{{$reagent.Reagent_3}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_3}}.png" /><b>{{if $reagent.ReagentCount_3 > 1}}{{$reagent.ReagentCount_3}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_4 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_4}}" id="{{$reagent.Reagent_4}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_4}}.png" /><b>{{if $reagent.ReagentCount_4 > 1}}{{$reagent.ReagentCount_4}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_5 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_5}}" id="{{$reagent.Reagent_5}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_5}}.png" /><b>{{if $reagent.ReagentCount_5 > 1}}{{$reagent.ReagentCount_5}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_6 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_6}}" id="{{$reagent.Reagent_6}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_6}}.png" /><b>{{if $reagent.ReagentCount_6 > 1}}{{$reagent.ReagentCount_6}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_7 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_7}}" id="{{$reagent.Reagent_7}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_7}}.png" /><b>{{if $reagent.ReagentCount_7 > 1}}{{$reagent.ReagentCount_7}}{{/if}}</b></a>
{{/if}}
{{if $reagent.Reagent_8 > 0}}
<a class="item-add staticTip itemToolTip" href="item-info.xml?i={{$reagent.Reagent_8}}" id="{{$reagent.Reagent_8}}"><img class="p21" src="wow-icons/_images/21x21/{{$reagent.ReagentIcon_8}}.png" /><b>{{if $reagent.ReagentCount_8 > 1}}{{$reagent.ReagentCount_8}}{{/if}}</b></a>
{{/if}}
</q>
</td>
</tr>
{{/if}}
{{/foreach}}
</table>
</div>
</div>
{{/if}}
{{if $disenchant_loot}}
<div class="rel-tab">
<p class="rel-de"></p>
<h3>{{#armory_item_info_disenchants_to#}}</h3>
</div>
<div id="big-results" style="clear: both;">
<div class="data">
<table class="data-table">
<tr class="masthead">
<td colspan="2" style="width: 50%;"><a class="noLink">{{#armory_item_info_drop_name#}}</a></td><td align="center"><a class="noLink">{{#armory_item_info_drop_chance#}}</a></td><td align="center"><a class="noLink">{{#armory_item_info_count#}}</a></td>
</tr>
{{foreach from=$disenchant_loot item=disenchant}}
<tr>
<td width="55"><img class="p43 staticTip itemToolTip" id="{{$disenchant.entry}}" src="wow-icons/_images/43x43/{{$disenchant.icon}}.png" /></td>
<td class="item-icon" width="50%"><q><a class="rarity4 staticTip itemToolTip" href="item-info.xml?i={{$disenchant.entry}}" id="{{$disenchant.entry}}">{{$disenchant.name}}</a></q></td>
<td align="center"><q>{{$disenchant.drop_percent}}</q></td>
<td align="center"><q>{{$disenchant.count}}</q></td>
</tr>
{{/foreach}}
</table>
</div>
</div>
{{/if}}
{{if $quest_loot}}
<div class="rel-tab">
<p class="rel-reward"></p>
<h3>{{#armory_item_info_reward_from#}}</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_reward_title#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_reward_requires_level#}}</a></td>
<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
</tr>
{{foreach from=$quest_loot item=quest}}
<tr>
<td><q><span><i>{{$quest.title}}</i></span></q></td>
<td align="center"><q>{{$quest.reqlevel}}</q></td>
<td><q>{{$quest.map}}</q></td>
</tr>

{{/foreach}}
</table>
</div>
{{/if}}
<!---->
{{if $queststart}}
<div class="rel-tab">
<p class="rel-queststart"></p>
<h3>{{#armory_item_info_startquestitem#}}</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_reward_title#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_reward_requires_level#}}</a></td>
<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
</tr>
{{foreach from=$queststart item=quest}}
<tr>
<td><q><span><i>{{$quest.title}}</i></span></q></td><td align="center"><q>{{$quest.reqlevel}}</q></td><td><q>{{$quest.map}}</q></td>
</tr>
{{/foreach}}
</table>
</div>
<!---->
{{/if}}
{{if $providedfor}}
<div class="rel-tab">
<p class="rel-provided"></p>
<h3>{{#armory_item_info_providedquestitem#}}</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_reward_title#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_reward_requires_level#}}</a></td>
<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
</tr>
{{foreach from=$providedfor item=quest}}
<tr>
<td><q><span><i>{{$quest.title}}</i></span></q></td><td align="center"><q>{{$quest.reqlevel}}</q></td><td><q>{{$quest.map}}</q></td>
</tr>
{{/foreach}}
</table>
</div>
<!---->
{{/if}}
{{if $objectiveof}}
<div class="rel-tab">
<p class="rel-objective"></p>
<h3>{{#armory_item_info_objectivequestitem#}}</h3>
</div>
<div class="data" style="clear: both;">
<table class="data-table">
<tr class="masthead">
<td><a class="noLink">{{#armory_item_info_reward_title#}}</a></td>
<td align="center"><a class="noLink">{{#armory_item_info_reward_requires_level#}}</a></td>
<td><a class="noLink">{{#armory_item_info_zone_string#}}</a></td>
</tr>
{{foreach from=$objectiveof item=quest}}
<tr>
<td><q><span><i>{{$quest.title}}</i></span></q></td><td align="center"><q>{{$quest.reqlevel}}</q></td><td><q>{{$quest.map}}</q></td>
</tr>
{{/foreach}}
</table>
</div>
<!---->
{{/if}}

<div class="clear">
<!---->
</div>
</div>
</div>
</div>
</div>
</div>
<div class="clear"></div>
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
</div>
{{include file="overall_footer.tpl"}}