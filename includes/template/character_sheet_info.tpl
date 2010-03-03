<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="profile" tab="character" tabGroup="character" tabUrl="{$character_url_string}"></tabInfo>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<script type="text/javascript">	
                                var theClassId 		= {$class};
								var theRaceId 		= {$race};
								var theClassName 	= "{$className}";
								var theLevel 		= {$level};		
								var theRealmName 	= "{$realm}";
								var theCharName 	= "{$name}";		
						
								var talentsTreeArray = new Array;
								{literal}
                                $(document).ready(function(){
                                {/literal}
								{if $dualSpec}		
								
									talentsTreeArray["group1"] = [];
									talentsTreeArray["group2"] = [];
									
									talentsTreeArray["group1"][0] = [1, {$ds_0.0}, 
																""];
									talentsTreeArray["group1"][1] = [2, {$ds_0.1}, 
																""];
									talentsTreeArray["group1"][2] = [3, {$ds_0.2}, 
																""];
									
									talentsTreeArray["group2"][0] = [1, {$ds_1.0}, 
																""];
									talentsTreeArray["group2"][1] = [2, {$ds_1.1}, 
																""];
									talentsTreeArray["group2"][2] = [3, {$ds_1.2}, 
																""];	
								{else}
                                
									talentsTreeArray["group1"] = [];
									talentsTreeArray["group2"] = [];
									
									talentsTreeArray["group1"][0] = [1, {$tree_js.0}, 
																""];
									talentsTreeArray["group1"][1] = [2, {$tree_js.1}, 
																""];
									talentsTreeArray["group1"][2] = [3, {$tree_js.2}, 
																""];
									
									talentsTreeArray["group2"][0] = [1, 0, 
																""];
									talentsTreeArray["group2"][1] = [2, 0, 
																""];
									talentsTreeArray["group2"][2] = [3, 0, 
																""];	
                                {/if}
									calcTalentSpecs();
									
								/*
                                    // Disable `Upgrade` menu for items until this feature not implemented
                                	setCharSheetUpgradeMenu();
								*/
								{literal}
                                });
                                {/literal}	
							</script>
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
{if $characterArenaTeamInfoButton}
<a class="" href="character-arenateams.xml?r={$realm}&amp;cn={$name}{if $guildName}&amp;gn={$guildName}{/if}"><span>{#armory_character_sheet_arena#}</span></a>
{/if}
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper char_sheet">
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
<div class="detail_active" id="gear-profile">
<div class="gear_display_option">
<a class="toggle_gear_list staticTip" href="javascript:;" onclick="toggle_gear('list_active')" onmouseover="setTipText('{#armory_character_sheet_gear_list#}')"></a><a class="toggle_gear_detail staticTip" href="javascript:;" onclick="toggle_gear('detail_active')" onmouseover="setTipText('{#armory_character_sheet_view_model#}')"></a>
</div>
<div class="btn_dual_tooltip">
<label><input id="checkboxDualTooltip" onclick="javascript:setDualTooltipCookie();" type="checkbox" />{#armory_vault_dualtooltips#}</label>
</div>
<div class="gear_bg">
<div class="health_stat">{#armory_character_sheet_health#}:<em>{$healthValue}</em>
</div>
<div class="secondary_stat">
<div class="{$additionalBarInfo.class}-stat">{$additionalBarInfo.title}:<em>{$additionalBarInfo.value}</em>
</div>
</div>
<div class="leftItems">{if $characterItems.0.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=0" onmouseover="setTipText(getEmptySlotToolTip('0','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.0.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.0.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.0.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.0.entry}" id="i={$characterItems.0.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=0"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.1.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=1" onmouseover="setTipText(getEmptySlotToolTip('1','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.1.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.1.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.1.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.1.entry}" id="i={$characterItems.1.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=1"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.2.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=2" onmouseover="setTipText(getEmptySlotToolTip('2','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.2.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.2.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.2.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.2.entry}" id="i={$characterItems.2.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=2"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.3.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=3" onmouseover="setTipText(getEmptySlotToolTip('3','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.3.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.3.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.3.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.3.entry}" id="i={$characterItems.3.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=3"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.4.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=4" onmouseover="setTipText(getEmptySlotToolTip('4','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.4.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.4.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.4.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.4.entry}" id="i={$characterItems.4.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=4"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.5.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=5" onmouseover="setTipText(getEmptySlotToolTip('5','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.5.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.5.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.5.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.5.entry}" id="i={$characterItems.5.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=5"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.6.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=6" onmouseover="setTipText(getEmptySlotToolTip('6','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.6.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.6.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.6.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.6.entry}" id="i={$characterItems.6.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=6"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.7.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=7" onmouseover="setTipText(getEmptySlotToolTip('7','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.7.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.7.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.7.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.7.entry}" id="i={$characterItems.7.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=7"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
</div>
<div class="rightItems">{if $characterItems.8.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=8" onmouseover="setTipText(getEmptySlotToolTip('8','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.8.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.8.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.8.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.8.entry}" id="i={$characterItems.8.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=8"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.9.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=9" onmouseover="setTipText(getEmptySlotToolTip('9','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.9.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.9.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.9.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.9.entry}" id="i={$characterItems.9.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=9"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.10.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=10" onmouseover="setTipText(getEmptySlotToolTip('10','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.10.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.10.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.10.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.10.entry}" id="i={$characterItems.10.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=10"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.11.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=11" onmouseover="setTipText(getEmptySlotToolTip('11','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.11.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.11.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.11.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.11.entry}" id="i={$characterItems.11.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=11"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.12.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=12" onmouseover="setTipText(getEmptySlotToolTip('12','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.12.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.12.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.12.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.12.entry}" id="i={$characterItems.12.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=12"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.13.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=13" onmouseover="setTipText(getEmptySlotToolTip('13','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.13.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.13.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.13.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.13.entry}" id="i={$characterItems.13.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=13"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.14.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=14" onmouseover="setTipText(getEmptySlotToolTip('14','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.14.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.14.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.14.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.14.entry}" id="i={$characterItems.14.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=14"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.15.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=15" onmouseover="setTipText(getEmptySlotToolTip('15','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.15.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.15.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.15.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.15.entry}" id="i={$characterItems.15.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=15"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
</div>
<div class="bottomItems">{if $characterItems.16.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=16" onmouseover="setTipText(getEmptySlotToolTip('16','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.16.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.16.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.16.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.16.entry}" id="i={$characterItems.16.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=16"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.17.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=17" onmouseover="setTipText(getEmptySlotToolTip('17','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.17.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.17.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.17.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.17.entry}" id="i={$characterItems.17.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=17"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
{if $characterItems.18.entry == 0}
<div class="gearItem">
<div class="rarityglow rarity">
<a class="staticTip noUpgrade gearFrame" href="javascript:void(0)" id="i=&amp;r={$realm}&amp;cn={$name}&amp;s=18" onmouseover="setTipText(getEmptySlotToolTip('18','2'))"></a>
</div>
</div>
{else}
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{$characterItems.18.icon}.jpg')">
<div class="rarityglow rarity{$characterItems.18.rarity}">
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={$realm}&amp;pn={$name}&amp;pi={$characterItems.18.entry}">{#armory_character_sheet_upgrade_gear#}</a>
</div>
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={$characterItems.18.entry}" id="i={$characterItems.18.entry}&amp;r={$realm}&amp;cn={$name}&amp;s=18"><span class="upgradeBox"></span></a>
</div>
</div>
{/if}
</div>
<div id="debugtxt"></div>
<div class="profileCenter" id="center_target">
<div id="pose_saving">
<span>Saving...</span>
</div>
<div id="pose_save_ok">
<span>Pose saved!</span>
</div>
<div id="ModelViewer3">
<div class="noFlash">
<a class="noflash" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" target="_blank">
<img align="right" class="p" src="images/{$ArmoryConfig.locale}/getflash.gif" /></a>{#armory_install_flash_player_string#}</div>
<script src="_js/character/charactermodel.js" type="text/javascript"></script>
<script src="shared/global/third-party/swfobject2/swfobject.js" type="text/javascript"></script>
<script type="text/javascript">
		 if(!init3dvars) var init3dvars = null
		 if(!charUrl) var charUrl = '{$urlName}'
		  function buildModelViewer(attr) {literal}
		  {		{/literal}
                var lang = "{$ArmoryConfig.locale}".split("_")[0].toLowerCase()
		  		if ("{$ArmoryConfig.locale}" == "zh_tw") lang = "zh_tw"
		  		var modelserver = "{$ArmoryConfig.modelserver}"
                var embedlink = '<iframe src="'+String(window.location).split('character')[0]+'character-model-embed.xml?r={$realm}&cn={$name}&rhtml=true" scrolling="no" height="588" width="321" frameborder="0"></iframe>'
				var stringslink = "_content/{$ArmoryConfig.locale}/modelConfig_strings.xml";
				var logolink = "{$ArmoryConfig.modelserver}/models/images/logo/armory-logo-"+lang+".png" 
                {literal}
				var params = { menu: "false", scale: "noScale", allowFullscreen: "true", allowScriptAccess: "always", bgcolor:"#E3C96A", wmode:"opaque" };
                var attributes = { id:"ModelViewer3" };
                var flashvars = { character: theCharName, modelUrl: "character-model.xml?"+encodeURIComponent(charUrl), fileServer: "models/", 
								  embedlink:encodeURIComponent(embedlink), strings:stringslink, logoImg:logolink,
								  loadingtxt:"Loading." //"
								};
				if(getcookie2){ var modelCookies = getArmoryCookies("3d"); 
								for(xi in modelCookies) { flashvars[xi] = modelCookies[xi] } 
							  }
				if(init3dvars)	{ for (var i in init3dvars){ flashvars[i] = init3dvars[i]; } 
									if(init3dvars.bgColor){ params.bgcolor = "#"+init3dvars.bgColor.slice(2) }
								}
				if(attr){ for (var i in attr){ flashvars[i] = attr[i]; } }
                {/literal}
                swfobject.embedSWF("{$ArmoryConfig.modelserver}/models/flash/ModelViewer3.swf", "ModelViewer3", "100%", "100%", "10.0.0", "{$ArmoryConfig.modelserver}/models/flash/expressInstall.swf", flashvars, params, attributes);
				{literal}
                $(document).ready(function () { bindMouseActions() });	
		  }
			var str_loginExpired = "Enter username." //"
			buildModelViewer()
            {/literal}
            </script>
</div>
</div>
</div>
<div class="gear_list">
<div class="gear_list_int">
<table class="gear_list_table">
<tr>
<th>
<!----></th>
<th class="glist_name">{#armory_character_sheet_list_item_name#}</th>
<th>{#armory_character_sheet_level_string#}</th>
<th>{#armory_character_sheet_list_gems#}</th>
<th>{#armory_character_sheet_list_enchants#}</th>
</tr>
{foreach from=$characterItems item=item}
{if $item.entry > 0}
<tr>
<td class="glist_icon">
<a class="staticTip itemToolTip" href="item-info.xml?i={$item.entry}" id="i={$item.entry}&amp;r={$realm}&amp;cn={$name}&amp;s={$item.i}">
<img class="stats_rarity{$item.rarity}" src="wow-icons/_images/21x21/{$item.icon}.png" /></a>
</td>
<td class="glist_name">
<a class="staticTip itemToolTip" href="item-info.xml?i={$item.entry}" id="i={$item.entry}&amp;r={$realm}&amp;cn={$name}&amp;s={$item.i}"><span class="stats_rarity{$item.rarity}">{$item.name}</span></a>
</td>
<td class="glist_ilvl">{$item.ilevel}</td>
<td class="glist_gems"></td>
<td class="glist_ench"></td>
</tr>
{/if}
{/foreach}
</table>
</div>
</div>
<div class="stats_drop">
<div class="stat_drop_titles">
<div class="stat_drop_titles_int">
<a class="stats_page_right" href="javascript:;" onclick="page_stats(1)"></a><a class="stats_page_left" href="javascript:;" onclick="page_stats(-1)"></a>
<div id="displayLeft">{#armory_character_sheet_basic_stats#}</div>
<div id="displayRight">
<!--Secondary Stat-->
</div>
</div>
</div>
<div class="stats_holder">
<div class="stats1">
<div class="character-stats">
<div id="replaceStatsLeft"></div>
</div>
</div>
<div class="stats2">
<div class="character-stats">
<div id="replaceStatsRight"></div>
</div>
</div>
</div>
<script src="_js/character/functions.js" type="text/javascript"></script>
<script type="text/javascript">
		function strengthObject() {literal} { {/literal}
			this.base="{$characterStat.stat_strenght}";
			this.effective="{$characterStat.effective_strenght}";
			this.block="{$characterStat.bonus_strenght_block}";
			this.attack="{$characterStat.bonus_strenght_attackpower}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		function agilityObject() {literal} { {/literal}
			this.base="{$characterStat.stat_agility}";
			this.effective="{$characterStat.effective_agility}";
			this.critHitPercent="{$characterStat.crit_agility}";
			this.attack="{$characterStat.bonus_agility_attackpower}";
			this.armor="{$characterStat.bonus_agility_armor}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function staminaObject(base, effective, health, petBonus) {literal} { {/literal}
			this.base="{$characterStat.stat_stamina}";
			this.effective="{$characterStat.effective_stamina}";
			this.health="{$characterStat.bonus_stamina_health}";
			this.petBonus="{$characterStat.bonus_stamina_petstamina}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function intellectObject() {literal} { {/literal}
			this.base="{$characterStat.stat_intellect}";
			this.effective="{$characterStat.effective_intellect}";
			this.mana="{$characterStat.mana_intellect}";
			this.critHitPercent="{$characterStat.bonus_intellect_spellcrit}";
			this.petBonus="{$characterStat.bonus_intellect_petintellect}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function spiritObject() {literal} { {/literal}
			this.base="{$characterStat.stat_spirit}";
			this.effective="{$characterStat.effective_spirit}";
			this.healthRegen="{$characterStat.bonus_spirit_hpregeneration}";
			this.manaRegen="{$characterStat.bonus_spitit_manaregeneration}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function armorObject() {literal} { {/literal}
			this.base="{$characterStat.stat_armor}";
			this.effective="{$characterStat.effective_armor}";
			this.reductionPercent="{$characterStat.bonus_armor_reduction}";
			this.petBonus="{$characterStat.bonus_armor_petbonus}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function resistancesObject() {literal} { {/literal}
			this.arcane=new resistArcaneObject("0", "-1");
			this.nature=new resistNatureObject("0", "-1");
			this.fire=new resistFireObject("0", "-1");
			this.frost=new resistFrostObject("0", "-1");
			this.shadow=new resistShadowObject("0", "-1");
{literal}
        }
{/literal}
		
		function meleeMainHandWeaponSkillObject() {literal} { {/literal}
			this.value="{$characterStat.stat_melee_skill}";
			this.rating="{$characterStat.melee_skill_defrating}";
			this.additional="{$characterStat.melee_skill_ratingadd}";
			this.percent="0.00";
{literal}
        }
{/literal}
		
		function meleeOffHandWeaponSkillObject() {literal} { {/literal}
			this.value="";
			this.rating="";
{literal}
        }
{/literal}	
		
		function meleeMainHandDamageObject() {literal} { {/literal}
			this.speed="{$characterStat.speed_melee_dmg}";
			this.min="{$characterStat.min_melee_dmg}";
			this.max="{$characterStat.max_melee_dmg}";
			this.percent="0";
			this.dps="{$characterStat.dps_melee_dmg}";
		
			if (this.percent > 0)		this.effectiveColor="class='mod'";
			else if (this.percent < 0)	this.effectiveColor="class='moddown'";
{literal}
        }
{/literal}
		
		function meleeOffHandDamageObject() {literal} { {/literal}
			this.speed="1.88";
			this.min="0";
			this.max="0";
			this.percent="0";
			this.dps="0.0";
{literal}
        }
{/literal}
		
		
		function meleeMainHandSpeedObject() {literal} { {/literal}
			this.value="{$characterStat.speed_melee_dmg}";
			this.hasteRating="{$characterStat.hasterating_melee_dmg}";
			this.hastePercent="{$characterStat.hastepct_melee_dmg}";
{literal}
        }
{/literal}
		
		function meleeOffHandSpeedObject() {literal} { {/literal}
			this.value="1.88";
			this.hasteRating="159";
			this.hastePercent="6.30";
{literal}
        }
{/literal}
		
		function meleePowerObject() {literal} { {/literal}
			this.base="{$characterStat.effective_melee_ap}";
			this.effective="{$characterStat.stat_melee_ap}";
			this.increasedDps="{$characterStat.bonus_ap_dps}";
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function meleeHitRatingObject() {literal} { {/literal}
			this.value="{$characterStat.melee_hit_rating}";
			this.increasedHitPercent="{$characterStat.melee_hit_ratingpct}";
			this.armorPenetration="{$characterStat.melee_hit_penetration}";	
			this.reducedArmorPercent="0.00";
{literal}
        }
{/literal}
		
		function meleeCritChanceObject() {literal} { {/literal}
			this.percent="{$characterStat.melee_crit}";
			this.rating="{$characterStat.melee_crit_rating}";
			this.plusPercent="{$characterStat.melee_crit_ratingpct}";
{literal}
        }
{/literal}
		
		function rangedWeaponSkillObject() {literal} { {/literal}
			this.value=-1;
			this.rating=-1;
{literal}
        }
{/literal}
		
		function rangedDamageObject() {literal} { {/literal}
			this.speed={$characterStat.ranged_dps_speed};
			this.min={$characterStat.ranged_dps_min};
			this.max={$characterStat.ranged_dps_max};
			this.dps={$characterStat.ranged_dps_pct};
			this.percent=0;
		
			if (this.percent > 0)		this.effectiveColor="class='mod'";
			else if (this.percent < 0)	this.effectiveColor="class='moddown'";
{literal}
        }
{/literal}
		
		function rangedSpeedObject() {literal} { {/literal}
			this.value={$characterStat.ranged_speed};
			this.hasteRating={$characterStat.ranged_speed_rating};
			this.hastePercent={$characterStat.ranged_speed_pct};
{literal}
        }
{/literal}
		
		function rangedPowerObject() {literal} { {/literal}
			this.base={$characterStat.ranged_base};
			this.effective={$characterStat.ranged_effective};
			this.increasedDps={$characterStat.ranged_dps_ap};
			this.petAttack={$characterStat.ranged_pet_ap};
			this.petSpell={$characterStat.ranged_pet_spd};
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function rangedHitRatingObject() {literal} { {/literal}
			this.value="{$characterStat.ranged_hit}";
			this.increasedHitPercent="{$characterStat.ranged_hit_pct}";
			this.armorPenetration="";
			this.reducedArmorPercent="{$characterStat.ranged_hit_penetration}";
{literal}
        }
{/literal}
		
		function rangedCritChanceObject() {literal} { {/literal}
			this.percent={$characterStat.ranged_crit};
			this.rating={$characterStat.ranged_crit_rating};
			this.plusPercent={$characterStat.ranged_crit_pct};
{literal}
        }
{/literal}
		
		function spellBonusDamageObject() {literal} { {/literal}
			this.holy={$characterStat.spd_holy};
			this.arcane={$characterStat.spd_arcane};
			this.fire={$characterStat.spd_fire};
			this.nature={$characterStat.spd_nature};
			this.frost={$characterStat.spd_frost};
			this.shadow={$characterStat.spd_shadow};
			this.petBonusAttack={$characterStat.pet_bonus_ap};
			this.petBonusDamage={$characterStat.pet_bonus_dmg};
			this.petBonusFromType="";
		
			this.value=this.holy;
			
			if (this.value > this.arcane)	this.value=this.arcane;
			if (this.value > this.fire)		this.value=this.fire;
			if (this.value > this.nature)	this.value=this.nature;
			if (this.value > this.frost)	this.value=this.frost;
			if (this.value > this.shadow)	this.value=this.shadow;
{literal}
        }
{/literal}
		
		function spellBonusHealingObject() {literal} { {/literal}
			this.value={$characterStat.heal_bonus};
{literal}
        }
{/literal}
		
		function spellHasteRatingObject() {literal} { {/literal}
			this.value={$characterStat.spell_haste_rating};
			this.percent={$characterStat.spell_haste_pct};
{literal}
        }
{/literal}
		
		function spellHitRatingObject() {literal} { {/literal}
			this.value={$characterStat.spell_hit_rating};
			this.increasedHitPercent={$characterStat.spell_hit_pct};
			this.spellPenetration= {$characterStat.spell_hit_penetration};	
{literal}
        }
{/literal}
		
		function spellCritChanceObject() {literal} { {/literal}
	        this.rating={$characterStat.spell_crit_rating};
			this.holy={$characterStat.spell_crit_holy};
			this.arcane={$characterStat.spell_crit_arcane};
			this.fire={$characterStat.spell_crit_fire};
			this.nature={$characterStat.spell_crit_nature};
			this.frost={$characterStat.spell_crit_frost};
			this.shadow={$characterStat.spell_crit_shadow};
		
			this.percent=this.holy;
			
			if (this.percent > this.arcane)	this.percent=this.arcane;
			if (this.percent > this.fire)	this.percent=this.fire;
			if (this.percent > this.nature)	this.percent=this.nature;
			if (this.percent > this.frost)	this.percent=this.frost;
			if (this.percent > this.shadow)	this.percent=this.shadow;
{literal}
        }
{/literal}

{literal}		
		function spellPenetrationObject() {
			this.value=0;
		}
{/literal}		
		
        function spellManaRegenObject() {literal} { {/literal}
			this.casting={$characterStat.mana_regen_cast};
			this.notCasting={$characterStat.mana_regen_out_of_cast};
{literal}
        }
{/literal}
		
		function defensesArmorObject() {literal} { {/literal}
			this.base=23773;
			this.effective=23773;
			this.percent=60.95;
			this.petBonus=-1;
		
			this.diff=this.effective - this.base;
{literal}
        }
{/literal}
		
		function defensesDefenseObject() {literal} { {/literal}
			this.rating={$characterStat.stat_defense_rating};
			this.plusDefense={$characterStat.rating_defense_add};
			this.increasePercent={$characterStat.defense_percent};
			this.decreasePercent={$characterStat.defense_percent};
			this.value={$characterStat.rating_defense} + this.plusDefense;
{literal}
        }
{/literal}
		
		function defensesDodgeObject() {literal} { {/literal}
			this.percent={$characterStat.dodge_chance};
			this.rating={$characterStat.stat_dodge};
			this.increasePercent={$characterStat.stat_dodge_pct};
{literal}
        }
{/literal}
		
		function defensesParryObject() {literal} { {/literal}
			this.percent={$characterStat.parry_chance};
			this.rating={$characterStat.stat_parry};
			this.increasePercent={$characterStat.stat_parry_pct};
{literal}
        }
{/literal}
		
		function defensesBlockObject() {literal} { {/literal}
			this.percent={$characterStat.block_pct};
			this.rating={$characterStat.block_chance};
			this.increasePercent={$characterStat.block_rating};
{literal}
        }
{/literal}
		
		function defensesResilienceObject() {literal} { {/literal}
			this.value={$characterStat.min_resilence};
			this.hitPercent={$characterStat.spell_resilence_pct};
			this.damagePercent={$characterStat.melee_resilence_pct};
{literal}
        }
{/literal}
		
		var theCharacter = new characterObject();		
		var theCharUrl = "{$character_url_string}";
	
	</script>
<script src="_js/_lang/{$ArmoryConfig.locale}/character-sheet.js" type="text/javascript"></script>
<script src="_js/character/textObjects.js" type="text/javascript"></script>
</div>
</div>
<script>
{literal}
	    if(getcookie2("armory.cookieGearMode")){  toggle_gear(getcookie2("armory.cookieGearMode")); }
	    if(location.href.indexOf("list=true")>0){ toggle_gear("list_active") }
		if(getcookie2("armory.cookieDualTooltip") == 1){ $("#checkboxDualTooltip").attr("checked","checked"); }
{/literal}
</script>
<div class="char-profile_stats">
<div class="char-profile_stats_int">
<div class="char-profile_name">{$name}<span class="desc">{#armory_character_sheet_level_string#}&nbsp;<span>{$level}</span>&nbsp;{get_wow_race race=$race}&nbsp;{get_wow_class class=$class}</span>
</div>
<div class="spec">
<h4>{#armory_character_sheet_talnets_info#}</h4>
{if $dualSpec}
<a class="{if $disabledDS_0}left_spec{else}active_spec{/if}" href="character-talents.xml?{$character_url_string}&amp;group=1" id="replaceTalentSpecText"><span class="talent_icon"><img src="wow-icons/_images/43x43/{$treeIcon_0}.png" /></span><span class="talent_name">{$treeName_0}<span class="talent_value">{$talents_builds_0}</span></span></a>
    {if $dualSpecError}
        <a class="na_right_empty staticTip" href="javascript:void(0)" id="replaceTalentSpecText2" onmouseover="setTipText('{#armory_character_sheet_character_dont_have_dualspec#}');"><span class="talent_name">{#armory_character_sheet_na_dualspec#}</span></a>
    {else}
        <a class="{if $disabledDS_1}right_spec{else}active_spec{/if}" href="character-talents.xml?{$character_url_string}&amp;group=2" id="replaceTalentSpecText"><span class="talent_icon"><img src="wow-icons/_images/43x43/{$treeIcon_1}.png" /></span><span class="talent_name">{$treeName_1}<span class="talent_value">{$talents_builds_1}</span></span></a>
    {/if}
{else}
<a class="active_spec" href="character-talents.xml?{$character_url_string}&amp;group=1" id="replaceTalentSpecText"><span class="talent_icon"><img src="wow-icons/_images/43x43/{$currentTreeIcon}.png" /></span><span class="talent_name">{$treeName}<span class="talent_value">{$talents_builds}</span></span></a>
<a class="na_right_empty staticTip" href="javascript:void(0)" id="replaceTalentSpecText2" onmouseover="setTipText('{#armory_character_sheet_character_dont_have_dualspec#}');"><span class="talent_name">{#armory_character_sheet_na_dualspec#}</span></a>
{/if}
</div>
<div class="prof">
<h4>{#armory_character_sheet_primary_skills#}</h4>
<div class="prof_bg">
{if $primary_trade_skill_1.name == '' && $primary_trade_skill_2 == ''}
<div class="no_skills">{#armory_character_sheet_na_profession#}</div>
{else}
    {if $primary_trade_skill_1.name == ''}
    <div class="no_skills">{#armory_character_sheet_na_profession#}</div>
    {else}
    <div class="char_profession">
    <div class="prof_icon">
    <img src="images/icons/professions/{$primary_trade_skill_1.icon}.gif" /></div>
    <div class="prof_name">
    <div>{$primary_trade_skill_1.name}</div>
    <div class="prof_value">{$primary_trade_skill_1.value}</div>
    </div>
    </div>
    {/if}
    
    {if $primary_trade_skill_2.name == ''}
    <div class="no_skills">{#armory_character_sheet_na_profession#}</div>
    {else}
    <div class="char_profession">
    <div class="prof_icon">
    <img src="images/icons/professions/{$primary_trade_skill_2.icon}.gif" /></div>
    <div class="prof_name">
    <div>{$primary_trade_skill_2.name}</div>
    <div class="prof_value">{$primary_trade_skill_2.value}</div>
    </div>
    </div>
    {/if}
{/if}
</div>
</div>
<div class="character_act">
<div class="char_feed_title">
<div class="share_container">
<a class="share_rss_icon" href="javascript:void();" onclick="javascript:void();"></a>
</div>{#armory_character_sheet_recent_activity#}</div>
</div>
</div>
</div>
<div class="last_modified"></div>
{if $characterArenaTeamInfo}
<div class="bonus-stats">
<table class="deco-frame">
<thead>
<tr>
<td class="sl"></td><td class="ct st"></td><td class="sr"></td>
</tr>
</thead>
<tbody>
<tr>
<td class="sl"><b><em class="port"></em></b></td><td class="ct">
<div class="arena-ranking">
<h2>{#armory_character_sheet_arena#}</h2>
</div>
<ul class="badges-pvp">
{if $characterArenaTeamInfo.2x2.name==''}
<li>
<div class="arena-team-faded">
<h4>2{#armory_arenaladder_versus#}2</h4>
<em><span>{#armory_character_no_team#}</span></em>
</div>
</li>
{else}
<li>
<div class="arenacontainer">
<h4>2{#armory_arenaladder_versus#}2</h4>
<em><span>{#armory_arenaladder_rating#}: {$characterArenaTeamInfo.2x2.rating}</span></em>
<div class="icon" onclick="window.location='team-info.xml?r={$realm}&amp;ts=2&amp;t={$characterArenaTeamInfo.2x2.name}'" style="background-image: url('images/icons/badges/arena/arena-4.jpg'); cursor: pointer;">
<img border="0" src="images/badge-border-pvp-bronze.gif" /><div class="rank-num" id="arenarank2_2">
<div id="arenarank2_2" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank2_2";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("arenarank2_2", "images/rank.swf", "transparent", "", "", "100", "40", "best", "", "rankNum={$characterArenaTeamInfo.2x2.rank}", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{$ArmoryConfig.locale}/getflash.png class=p/></a></div>")
		
		</script>
</div>
</div>
</div>
</li>
{/if}
{if $characterArenaTeamInfo.3x3.name==''}
<li>
<div class="arena-team-faded">
<h4>3{#armory_arenaladder_versus#}3</h4>
<em><span>{#armory_character_no_team#}</span></em>
</div>
</li>
{else}
<li>
<div class="arenacontainer">
<h4>3{#armory_arenaladder_versus#}3</h4>
<em><span>{#armory_arenaladder_rating#}: {$characterArenaTeamInfo.3x3.rating}</span></em>
<div class="icon" onclick="window.location='team-info.xml?r={$realm}&amp;ts=3&amp;t={$characterArenaTeamInfo.3x3.name}'" style="background-image: url('images/icons/badges/arena/arena-5.jpg'); cursor: pointer;">
<img border="0" src="images/badge-border-pvp-bronze.gif" /><div class="rank-num" id="arenarank2_3">
<div id="arenarank2_3" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank2_3";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("arenarank2_3", "images/rank.swf", "transparent", "", "", "100", "40", "best", "", "rankNum={$characterArenaTeamInfo.3x3.rank}", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{$ArmoryConfig.locale}/getflash.png class=p/></a></div>")
		
		</script>
</div>
</div>
</div>
</li>
{/if}
{if $characterArenaTeamInfo.5x5.name==''}
<li>
<div class="arena-team-faded">
<h4>5{#armory_arenaladder_versus#}5</h4>
<em><span>{#armory_character_no_team#}</span></em>
</div>
</li>
{else}
<li>
<div class="arenacontainer">
<h4>5{#armory_arenaladder_versus#}5</h4>
<em><span>{#armory_arenaladder_rating#}: {$characterArenaTeamInfo.5x5.rating}</span></em>
<div class="icon" onclick="window.location='team-info.xml?r={$realm}&amp;ts=5&amp;t={$characterArenaTeamInfo.5x5.name}'" style="background-image: url('images/icons/badges/arena/arena-5.jpg'); cursor: pointer;">
<img border="0" src="images/badge-border-pvp-bronze.gif" /><div class="rank-num" id="arenarank2_5">
<div id="arenarank2_5" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank2_5";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback"))//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		else
			printFlash("arenarank2_5", "images/rank.swf", "transparent", "", "", "100", "40", "best", "", "rankNum={$characterArenaTeamInfo.5x5.rank}", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{$ArmoryConfig.locale}/getflash.png class=p/></a></div>")
		
		</script>
</div>
</div>
</div>
</li>
{/if}
</ul>
<ul class="badges-pvp personalrating">
{if $characterArenaTeamInfo.2x2.name}
<li>
<div>
<em><span><b>{$characterArenaTeamInfo.2x2.name}</b>
<br />{#armory_teaminfo_pr_tooltip#}: {$characterArenaTeamInfo.2x2.personalrating}<br>
</span></em>
</div>
</li>
{else}
<li>
<div>
<em><span><b></b>
<br /><br />
</span></em>
</div>
</li>
{/if}
{if $characterArenaTeamInfo.3x3.name}
<li>
<div>
<em><span><b>{$characterArenaTeamInfo.3x3.name}</b>
<br />{#armory_teaminfo_pr_tooltip#}: {$characterArenaTeamInfo.3x3.personalrating}<br>
</span></em>
</div>
</li>
{else}
<li>
<div>
<em><span><b></b>
<br /><br />
</span></em>
</div>
</li>
{/if}
{if $characterArenaTeamInfo.5x5.name}
<li>
<div>
<em><span><b>{$characterArenaTeamInfo.5x5.name}</b>
<br />{#armory_teaminfo_pr_tooltip#}: {$characterArenaTeamInfo.5x5.personalrating}<br>
</span></em>
</div>
</li>
{else}
<li>
<div>
<em><span><b></b>
<br /><br />
</span></em>
</div>
</li>
{/if}
</ul>
</td><td class="sr"><b><em class="star"></em></b></td>
</tr>
</tbody>
<tfoot>
<tr>
<td class="sl"></td><td align="center" class="ct sb"></td><td class="sr"></td>
</tr>
</tfoot>
</table>
</div>
<div class="clear"></div>
<br />
<br />
{/if}
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
{include file="faq_character_sheet.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}