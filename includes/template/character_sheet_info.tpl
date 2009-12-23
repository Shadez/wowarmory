<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="profile" tab="character" tabGroup="character" tabUrl="{{$character_url_string}}"></tabInfo>
<link href="_css/character/sheet.css" rel="stylesheet" type="text/css" />
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<script type="text/javascript">	
                                var theClassId 		= {{$class}};
								var theRaceId 		= {{$race}};
								var theClassName 	= "{{$className}}";
								var theLevel 		= {{$level}};		
								var theRealmName 	= "{{$realm}}";
								var theCharName 	= "{{$name}}";		
						
								var talentsTreeArray = new Array;
								$(document).ready(function(){
								{{if $dualSpec}}		
								
									talentsTreeArray["group1"] = [];
									talentsTreeArray["group2"] = [];
									
									talentsTreeArray["group1"][0] = [1, {{$ds_0.0}}, 
																""];
									talentsTreeArray["group1"][1] = [2, {{$ds_0.1}}, 
																""];
									talentsTreeArray["group1"][2] = [3, {{$ds_0.2}}, 
																""];
									
									talentsTreeArray["group2"][0] = [1, {{$ds_1.0}}, 
																""];
									talentsTreeArray["group2"][1] = [2, {{$ds_1.1}}, 
																""];
									talentsTreeArray["group2"][2] = [3, {{$ds_1.2}}, 
																""];	
								{{else}}
                                
									talentsTreeArray["group1"] = [];
									talentsTreeArray["group2"] = [];
									
									talentsTreeArray["group1"][0] = [1, {{$tree_js.0}}, 
																""];
									talentsTreeArray["group1"][1] = [2, {{$tree_js.1}}, 
																""];
									talentsTreeArray["group1"][2] = [3, {{$tree_js.2}}, 
																""];
									
									talentsTreeArray["group2"][0] = [1, 0, 
																""];
									talentsTreeArray["group2"][1] = [2, 0, 
																""];
									talentsTreeArray["group2"][2] = [3, 0, 
																""];	
                                {{/if}}
									calcTalentSpecs();
									
									setCharSheetUpgradeMenu();
								
								});	
							</script>
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
<a class="selected-subTab" href="character-sheet.xml?r={{$realm}}&amp;n={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="profile_subTab"><span>{{#armory_character_sheet_profile_tab#}}</span></a>
<a class="" href="character-talents.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="talents_subTab"><span>{{#armory_character_sheet_talents_tab#}}</span></a>
<a class="" href="character-reputation.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="reputation_subTab"><span>{{#armory_character_sheet_reputaion_tab#}}</span></a>
<a class="" href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="achievements_subTab"><span>{{#armory_character_sheet_achievements_tab#}}</span></a>
<a class="" href="character-statistics.xml?r={{$realm}}&amp;cn={{$name}}{{if $guildName}}&amp;gn={{$guildName}}{{/if}}" id="statistics_subTab"><span>{{#armory_character_sheet_statistic_tab#}}</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile">
<script type="text/javascript">
		var charUrl = "{{$character_url_string}}";
		var bookmarkMaxedToolTip = "{{#armory_you_can_remember_string#}}";
		var bookmarkThisChar = "{{#armory_remember_this_character#}}";	
	</script>
<div class="faction-{{$faction_string_class}}">
<div class="profile-right" id="profileRight">
<a class="bmcLink" id="bmcLink"><span>{{#armory_login_to_remember_profile#}}</span><em></em></a>
</div>
<div class="profile-achieve">
<img src="images/portraits/{{$portrait_path}}" /><div class="points">
<a href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}">{{$pts}}</a>
</div>
<div>
<link href="atom/character.xml?r={{$realm}}&amp;n={{$name}}" rel="alternate" title="WoW Feed" type="application/atom+xml" />
</div>
<div id="leveltext" style="display:none;"></div>
<script type="text/javascript">
		var flashId="leveltext";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("leveltext", "images/{{$ArmoryConfig.locale}}/flash/level.swf", "transparent", "", "", "38", "38", "best", "images/{{$ArmoryConfig.locale}}/flash", "charLevel={{$level}}&pts={{$pts}}", "<div class=level-noflash>{{$level}}<em>{{$level}}</em></div>")
		
		</script>
</div>
<div id="charHeaderTxt_Dark">
<span class="prefix">{{$character_title_prefix}} </span>
<div class="charNameHeader">{{$name}}<span class="suffix">{{$character_title_suffix}}</span>
</div>
{{if $guildName}}<a class="charGuildName" href="guild-info.xml?r={{$realm}}&amp;gn={{$guildName}}&cn={{$name}}">{{$guildName}}</a>{{/if}}<span class="charLvl">{{#armory_character_sheet_level_string#}}&nbsp;{{$level}}&nbsp;{{$class_text}}&nbsp;{{$race_text}}</span>
</div>
<div id="charHeaderTxt_Light">
<span class="prefix">{{$character_title_prefix}} </span>
<div class="charNameHeader">{{$name}}<span class="suffix">{{$character_title_suffix}}</span>
</div>
{{if $guildName}}<a class="charGuildName" href="guild-info.xml?r={{$realm}}&amp;gn={{$guildName}}&cn={{$name}}">{{$guildName}}</a>{{/if}}<span class="charLvl">{{#armory_character_sheet_level_string#}}&nbsp;{{$level}}&nbsp;{{$class_text}}&nbsp;{{$race_text}}</span>
</div>
<div id="forumLinks">
<a class="smFrame" href="javascript:void(0)">
<div>{{$realm}}</div>
<img src="images/icon-header-realm.gif"></a>
</div>
</div>
<div class="profile-master2">
<div class="leftItems">
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{{$gear_head_icon}}.jpg')">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_head_item}}" id="i={{$gear_head_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=0">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_head_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_neck_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_neck_item}}" id="i={{$gear_neck_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=1">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_neck_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_shoulder_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_shoulder_item}}" id="i={{$gear_shoulder_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=2">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_shoulder_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_back_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_back_item}}" id="i={{$gear_back_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=14">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_back_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_chest_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_chest_item}}" id="i={{$gear_chest_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=4">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_chest_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_shirt_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_shirt_item}}" id="i={{$gear_shirt_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=4">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_shirt_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_tabard_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_tabard_item}}" id="i={{$gear_tabard_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=4">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_tabard_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{{$gear_wrist_icon}}.jpg')">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_wrist_item}}" id="i={{$gear_wrist_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=8">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_wrist_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
</div>
<div class="rightItems">
<div class="gearItem" style="background-image: url('wow-icons/_images/51x51/{{$gear_gloves_icon}}.jpg')">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_gloves_item}}" id="i={{$gear_gloves_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=9">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_gloves_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_belt_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_belt_item}}" id="i={{$gear_belt_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=5">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_belt_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_legs_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_legs_item}}" id="i={{$gear_legs_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=6">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_legs_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_boots_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_boots_item}}" id="i={{$gear_boots_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=7">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_boots_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_ring1_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_ring1_item}}" id="i={{$gear_ring1_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=10">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_ring1_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_ring2_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_ring2_item}}" id="i={{$gear_ring2_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=11">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_ring2_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_trinket1_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_trinket1_item}}" id="i={{$gear_trinket1_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=12">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_trinket1_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_trinket2_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_trinket2_item}}" id="i={{$gear_trinket2_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=13">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_trinket2_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
</div>
<div class="bottomItems">
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_mainhand_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_mainhand_item}}" id="i={{$gear_mainhand_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=15">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_mainhand_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_offhand_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_offhand_item}}" id="i={{$gear_offhand_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=16">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_offhand_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
<div class="gearItem" style="
					background-image: url('wow-icons/_images/51x51/{{$gear_relic_icon}}.jpg')
				">
<a class="staticTip itemToolTip gearFrame" href="item-info.xml?i={{$gear_relic_item}}" id="i={{$gear_relic_item}}&amp;r={{$realm}}&amp;n={{$name}}&amp;s=17">
<div class="upgradeBox"></div>
</a>
<div class="fly-horz">
<a class="upgrd" href="search.xml?searchType=items&amp;pr={{$realm}}&amp;pn={{$name}}&amp;pi={{$gear_relic_item}}">{{#armory_character_sheet_upgrade_gear#}}</a>
</div>
</div>
</div>
<div class="profileCenter">
<div class="statsLeft">
<div class="brownBox" style="height: 120px;">
<em class="ptl">
<!----></em><em class="ptr">
<!----></em><em class="pbl">
<!----></em><em class="pbr">
<!----></em>
<div class="spec">
<h4>{{#armory_character_sheet_talnets_info#}}:</h4>
<div class="spec-wrapper{{$disabledDS_0}}">
{{if $disabledDS_1}}
<div class="activeSpecTxt">{{#armory_character_sheet_active_dualspec#}}</div>
{{/if}}
<div style="position:absolute; left:12px;">
<img id="talentSpecImage" src="images/icons/class/talents/untalented.gif" /></div>
<h4>
{{if $dualSpec}}
<a href="character-talents.xml?r={{$realm}}&amp;cn={{$name}}&amp;group=1" id="replaceTalentSpecText">{{$treeName_0}}</a>
{{else}}
<a href="character-talents.xml?r={{$realm}}&amp;cn={{$name}}&amp;group=1" id="replaceTalentSpecText">{{$treeName}}</a>
{{/if}}
</h4>
{{if $dualSpec}}
<span>{{$talents_builds_0}}</span>
{{else}}
<span>{{$talents_builds}}</span>
{{/if}}
</div>
{{if $dualSpec}}
    {{if $dualSpecError}}
    <div class="spec-wrapper{{$disabledDS_1}}">
    <div style="position:absolute; left:12px;">
    <img src="images/icons/class/talents/untalented.gif" /></div>
    <h4>
    <a class="staticTip" href="javascript:void(0)" id="replaceTalentSpecText2" onmouseover="setTipText('{{#armory_character_sheet_character_dont_have_dualspec#}}');">{{#armory_character_sheet_unknown#}}</a>
    </h4>
    <span>0 / 0 / 0</span>
    </div>
    {{else}}
    <div class="spec-wrapper{{$disabledDS_1}}">
    {{if $disabledDS_0}}
    <div class="activeSpecTxt">{{#armory_character_sheet_active_dualspec#}}</div>
    {{/if}}
    <div style="position:absolute; left:12px;">
    <img id="talentSpecImage2" src="images/icons/class/talents/untalented.gif" /></div>
    <h4>
    <a href="character-talents.xml?r={{$realm}}&amp;cn={{$name}}&amp;group=2" id="replaceTalentSpecText">{{$treeName_1}}</a>
    </h4>
    <span>{{$talents_builds_1}}</span>
    </div>
    {{/if}}
{{else}}
<div class="spec-wrapper{{$disabledDS_1}}">
<div style="position:absolute; left:12px;">
<img src="images/icons/class/talents/untalented.gif" /></div>
<h4>
<a class="staticTip" href="javascript:void(0)" id="replaceTalentSpecText2" onmouseover="setTipText('{{#armory_character_sheet_character_dont_have_dualspec#}}');">{{#armory_character_sheet_unknown#}}</a>
</h4>
<span>0 / 0 / 0</span>
</div>
{{/if}}
</div>
<div class="clear"></div>
</div>
<div class="brownBox" style="margin-top: 2px; height: 70px;">
<em class="ptl">
<!----></em><em class="ptr">
<!----></em><em class="pbl">
<!----></em><em class="pbr">
<!----></em>
<h4>{{#armory_character_sheet_primary_skills#}}:</h4>
<div class="prof1" style="background:url('images/icons/professions/{{$primary_trade_skill_1.icon}}.gif') 0 50% no-repeat;">
<div class="bar-container staticTip" onmouseover="setTipText('{{$primary_trade_skill_1.name}}')">
<b style=" width: {{$primary_trade_skill_1.pct}}%">{{$primary_trade_skill_1.skill_line}}</b>
</div>
</div>
<div class="prof1" style="background:url('images/icons/professions/{{$primary_trade_skill_2.icon}}.gif') 0 50% no-repeat;">
<div class="bar-container staticTip" onmouseover="setTipText('{{$primary_trade_skill_2.name}}')">
<b style=" width: {{$primary_trade_skill_2.pct}}%">{{$primary_trade_skill_2.skill_line}}</b>
</div>
</div>
<div class="clear"></div>
</div>
<div class="brownBox hp_mana_stats">
<em class="ptl">
<!----></em><em class="ptr">
<!----></em><em class="pbl">
<!----></em><em class="pbr">
<!----></em>
<div class="health-stat">
<p>
<span>{{#armory_character_sheet_health#}}:&nbsp;&nbsp;{{$healthValue}}</span>
</p>
</div>
<div class="{{$additionalBarInfo.class}}-stat">
<p>
<span>{{$additionalBarInfo.title}}:&nbsp;&nbsp;{{$additionalBarInfo.value}}</span>
</p>
</div>
<div class="clear"></div>
</div>
</div>
<div class="achRight">
<em class="ptl">
<!----></em><em class="ptr">
<!----></em><em class="pbl">
<!----></em><em class="pbr">
<!----></em>
<h4>{{#armory_character_sheet_achievements_tab#}}</h4>
<a class="achPointsLink" href="character-achievements.xml?r={{$realm}}&amp;cn={{$name}}"><span style="color: #FFF; float: right; margin: 0 0px 0 0;">{{$pts}}</span>{{#armory_character_sheet_achievement_points_string#}}</a>
<div class="achieve-bar" style="text-align:center;">
<div class="progressTxt">&nbsp;&nbsp;{{#armory_character_sheet_achievements_progress#}}&nbsp;{{$fullCharacterAchievementsCount}}/986</div>
<b style="width: {{$character_progress_percent}}%;"></b>
</div>
<div class="achList">
<span>{{$achievements_1}}/54</span>{{#achievements_category_1#}}</div>
<div class="achList">
<span>{{$achievements_2}}/49</span>{{#achievements_category_2#}}</div>
<div class="achList">
<span>{{$achievements_3}}/70</span>{{#achievements_category_3#}}</div>
<div class="achList">
<span>{{$achievements_4}}/164</span>{{#achievements_category_4#}}</div>
<div class="achList">
<span>{{$achievements_5}}/391</span>{{#achievements_category_5#}}</div>
<div class="achList">
<span>{{$achievements_6}}/75</span>{{#achievements_category_6#}}</div>
<div class="achList">
<span>{{$achievements_7}}/44</span>{{#achievements_category_7#}}</div>
<div class="achList">
<span>{{$achievements_8}}/139</span>{{#achievements_category_8#}}</div>
<div class="achList">
<span>{{$achievements_9}}</span>{{#achievements_category_9#}}</div>
</div>
<script type="text/javascript">
		var varOverLeft = 0;

		function dropdownMenuToggle(whichOne){
			theStyle = document.getElementById(whichOne).style;
	
			if (theStyle.display == "none")	theStyle.display = "block";
			else							theStyle.display = "none";	
		}
	</script>
<div class="dropdown1" onMouseOut="javascript: varOverLeft = 0;" onMouseOver="javascript: varOverLeft = 1;">
<a class="profile-stats" href="javascript: document.formDropdownLeft.dummyLeft.focus();" id="displayLeft">{{#armory_character_sheet_basic_stats#}}</a>
</div>
<div style="position: relative;">
<div style="position: absolute;">
<form id="formDropdownLeft" name="formDropdownLeft" style="height: 0px;">
<input id="dummyLeft" onBlur="javascript: if(!varOverLeft) document.getElementById('dropdownHiddenLeft').style.display='none';" onFocus="javascript: dropdownMenuToggle('dropdownHiddenLeft');" size="2" style="position: relative; left: -5000px;" type="button">
</form>
</div>
</div>
<div class="drop-stats" id="dropdownHiddenLeft" onMouseOut="javascript: varOverLeft=0;" onMouseOver="javascript: varOverLeft=1;" style="display: none; z-index: 99999;">
<div class="tooltip">
<table width="98%">
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"></td><td class="bg">
<ul>
<li>
<a href="#" onClick="changeStats('Left', replaceStringBaseStats, 'BaseStats', baseStatsDisplay); return false;">{{#armory_character_sheet_basic_stats#}}<img class="checkmark" id="checkLeftBaseStats" src="images/icons/icon-check.gif" style="visibility: visible;" /></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringMelee, 'Melee', meleeDisplay); return false;">{{#armory_character_sheet_melee_stats#}}<img class="checkmark" id="checkLeftMelee" src="images/icons/icon-check.gif" style="visibility: hidden;" /></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringRanged, 'Ranged', rangedDisplay); return false;">{{#armory_character_sheet_ranged_stats#}}<img class="checkmark" id="checkLeftRanged" src="images/icons/icon-check.gif" style="visibility: hidden;" /></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringSpell, 'Spell', spellDisplay); return false;">{{#armory_character_sheet_spells_stats#}}<img class="checkmark" id="checkLeftSpell" src="images/icons/icon-check.gif" style="visibility: hidden;" /></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringDefenses, 'Defenses', defensesDisplay); return false;">{{#armory_character_sheet_defence_stats#}}<img class="checkmark" id="checkLeftDefenses" src="images/icons/icon-check.gif" style="visibility: hidden;" /></a>
</li>
</ul>
</td><td class="r"></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<script type="text/javascript">
		var varOverRight = 0;

		function dropdownMenuToggle(whichOne){
			theStyle = document.getElementById(whichOne).style;
	
			if (theStyle.display == "none")	theStyle.display = "block";
			else							theStyle.display = "none";	
		}
	</script>
<div class="dropdown2" onMouseOut="javascript: varOverRight = 0;" onMouseOver="javascript: varOverRight = 1;">
<a class="profile-stats" href="javascript: document.formDropdownRight.dummyRight.focus();" id="displayRight">{{#armory_character_sheet_basic_stats#}}</a>
</div>
<div style="position: relative;">
<div style="position: absolute;">
<form id="formDropdownRight" name="formDropdownRight" style="height: 0px;">
<input id="dummyRight" onBlur="javascript: if(!varOverRight) document.getElementById('dropdownHiddenRight').style.display='none';" onFocus="javascript: dropdownMenuToggle('dropdownHiddenRight');" size="2" style="position: relative; left: -5000px;" type="button">
</form>
</div>
</div>
<div class="drop-stats" id="dropdownHiddenRight" onMouseOut="javascript: varOverRight=0;" onMouseOver="javascript: varOverRight=1;" style="display: none; z-index: 9999999; left: 190px;">
<div class="tooltip">
<table width="98%">
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"></td><td class="bg">
<ul>
<li>
<a href="#" onClick="changeStats('Right', replaceStringBaseStats, 'BaseStats', baseStatsDisplay); return false;">{{#armory_character_sheet_basic_stats#}}<img class="checkmark" id="checkRightBaseStats" src="images/icons/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringMelee, 'Melee', meleeDisplay); return false;">{{#armory_character_sheet_melee_stats#}}<img class="checkmark" id="checkRightMelee" src="images/icons/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringRanged, 'Ranged', rangedDisplay); return false;">{{#armory_character_sheet_ranged_stats#}}<img class="checkmark" id="checkRightRanged" src="images/icons/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringSpell, 'Spell', spellDisplay); return false;">{{#armory_character_sheet_spells_stats#}}<img class="checkmark" id="checkRightSpell" src="images/icons/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringDefenses, 'Defenses', defensesDisplay); return false;">{{#armory_character_sheet_defence_stats#}}<img class="checkmark" id="checkRightDefenses" src="images/icons/icon-check.gif" style="visibility: hidden;"></a>
</li>
</ul>
</td><td class="r"></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<div class="stats1">
<em class="ptl">
<!----></em><em class="ptr">
<!----></em><em class="pbl">
<!----></em><em class="pbr">
<!----></em>
<div class="character-stats">
<div id="replaceStatsLeft"></div>
</div>
</div>
<div class="stats2">
<em class="ptl">
<!----></em><em class="ptr">
<!----></em><em class="pbl">
<!----></em><em class="pbr">
<!----></em>
<div class="character-stats">
<div id="replaceStatsRight"></div>
</div>
</div>
<script src="_js/character/functions.js" type="text/javascript"></script>
<script type="text/javascript">
	
		function strengthObject() {
			this.base="{{$characterStat.stat_strenght}}";
			this.effective="{{$characterStat.effective_strenght}}";
			this.block="{{$characterStat.bonus_strenght_block}}";
			this.attack="{{$characterStat.bonus_strenght_attackpower}}";
		
			this.diff=this.effective - this.base;
		}
		
		function agilityObject() {
			this.base="{{$characterStat.stat_agility}}";
			this.effective="{{$characterStat.effective_agility}}";
			this.critHitPercent="{{$characterStat.crit_agility}}";
			this.attack="{{$characterStat.bonus_agility_attackpower}}";
			this.armor="{{$characterStat.bonus_agility_armor}}";
		
			this.diff=this.effective - this.base;
		}
		
		function staminaObject(base, effective, health, petBonus) {
			this.base="{{$characterStat.stat_stamina}}";
			this.effective="{{$characterStat.effective_stamina}}";
			this.health="{{$characterStat.bonus_stamina_health}}";
			this.petBonus="{{$characterStat.bonus_stamina_petstamina}}";
		
			this.diff=this.effective - this.base;
		}
		
		function intellectObject() {
			this.base="{{$characterStat.stat_intellect}}";
			this.effective="{{$characterStat.effective_intellect}}";
			this.mana="{{$characterStat.mana_intellect}}";
			this.critHitPercent="{{$characterStat.bonus_intellect_spellcrit}}";
			this.petBonus="{{$characterStat.bonus_intellect_petintellect}}";
		
			this.diff=this.effective - this.base;
		}
		
		function spiritObject() {
			this.base="{{$characterStat.stat_spirit}}";
			this.effective="{{$characterStat.effective_spirit}}";
			this.healthRegen="{{$characterStat.bonus_spirit_hpregeneration}}";
			this.manaRegen="{{$characterStat.bonus_spitit_manaregeneration}}";
		
			this.diff=this.effective - this.base;
		}
		
		function armorObject() {
			this.base="{{$characterStat.stat_armor}}";
			this.effective="{{$characterStat.effective_armor}}";
			this.reductionPercent="{{$characterStat.bonus_armor_reduction}}";
			this.petBonus="{{$characterStat.bonus_armor_petbonus}}";
		
			this.diff=this.effective - this.base;
		}
		
		function resistancesObject() {
			this.arcane=new resistArcaneObject("0", "-1");
			this.nature=new resistNatureObject("0", "-1");
			this.fire=new resistFireObject("0", "-1");
			this.frost=new resistFrostObject("0", "-1");
			this.shadow=new resistShadowObject("0", "-1");
		}
		
		function meleeMainHandWeaponSkillObject() {
			this.value="{{$characterStat.stat_melee_skill}}";
			this.rating="{{$characterStat.melee_skill_defrating}}";
			this.additional="{{$characterStat.melee_skill_ratingadd}}";
			this.percent="0.00";
		}
		
		function meleeOffHandWeaponSkillObject() {
			this.value="";
			this.rating="";
		}	
		
		function meleeMainHandDamageObject() {
			this.speed="{{$characterStat.speed_melee_dmg}}";
			this.min="{{$characterStat.min_melee_dmg}}";
			this.max="{{$characterStat.max_melee_dmg}}";
			this.percent="0";
			this.dps="{{$characterStat.dps_melee_dmg}}";
		
			if (this.percent > 0)		this.effectiveColor="class='mod'";
			else if (this.percent < 0)	this.effectiveColor="class='moddown'";
		}
		
		function meleeOffHandDamageObject() {
			this.speed="1.88";
			this.min="0";
			this.max="0";
			this.percent="0";
			this.dps="0.0";
		}
		
		
		function meleeMainHandSpeedObject() {
			this.value="{{$characterStat.speed_melee_dmg}}";
			this.hasteRating="{{$characterStat.hasterating_melee_dmg}}";
			this.hastePercent="{{$characterStat.hastepct_melee_dmg}}";
		}
		
		function meleeOffHandSpeedObject() {
			this.value="1.88";
			this.hasteRating="159";
			this.hastePercent="6.30";
		}
		
		function meleePowerObject() {
			this.base="{{$characterStat.effective_melee_ap}}";
			this.effective="{{$characterStat.stat_melee_ap}}";
			this.increasedDps="{{$characterStat.bonus_ap_dps}}";
		
			this.diff=this.effective - this.base;
		}
		
		function meleeHitRatingObject() {
			this.value="{{$characterStat.melee_hit_rating}}";
			this.increasedHitPercent="{{$characterStat.melee_hit_ratingpct}}";
			this.armorPenetration="{{$characterStat.melee_hit_penetration}}";	
			this.reducedArmorPercent="0.00";
		}
		
		function meleeCritChanceObject() {
			this.percent="{{$characterStat.melee_crit}}";
			this.rating="{{$characterStat.melee_crit_rating}}";
			this.plusPercent="{{$characterStat.melee_crit_ratingpct}}";
		}
		
		function rangedWeaponSkillObject() {
			this.value=-1;
			this.rating=-1;
		}
		
		function rangedDamageObject() {
			this.speed={{$characterStat.ranged_dps_speed}};
			this.min={{$characterStat.ranged_dps_min}};
			this.max={{$characterStat.ranged_dps_max}};
			this.dps={{$characterStat.ranged_dps}};
			this.percent={{$characterStat.ranged_dps_pct}};
		
			if (this.percent > 0)		this.effectiveColor="class='mod'";
			else if (this.percent < 0)	this.effectiveColor="class='moddown'";
		
		}
		
		function rangedSpeedObject() {
			this.value={{$characterStat.ranged_speed}};
			this.hasteRating={{$characterStat.ranged_speed_rating}};
			this.hastePercent={{$characterStat.ranged_speed_pct}};
		}
		
		function rangedPowerObject() {
			this.base={{$characterStat.ranged_base}};
			this.effective={{$characterStat.ranged_effective}};
			this.increasedDps={{$characterStat.ranged_dps_ap}};
			this.petAttack={{$characterStat.ranged_pet_ap}};
			this.petSpell={{$characterStat.ranged_pet_spd}};
		
			this.diff=this.effective - this.base;
		}
		
		function rangedHitRatingObject() {
			this.value="{{$characterStat.ranged_hit}}";
			this.increasedHitPercent="{{$characterStat.ranged_hit_pct}}";
			this.armorPenetration="";
			this.reducedArmorPercent="{{$characterStat.ranged_hit_penetration}}";
		}
		
		function rangedCritChanceObject() {
			this.percent={{$characterStat.ranged_crit}};
			this.rating={{$characterStat.ranged_crit_rating}};
			this.plusPercent={{$characterStat.ranged_crit_pct}};
		}
		
		function spellBonusDamageObject() {
			this.holy={{$characterStat.spd_holy}};
			this.arcane={{$characterStat.spd_arcane}};
			this.fire={{$characterStat.spd_fire}};
			this.nature={{$characterStat.spd_nature}};
			this.frost={{$characterStat.spd_frost}};
			this.shadow={{$characterStat.spd_shadow}};
			this.petBonusAttack={{$characterStat.pet_bonus_ap}};
			this.petBonusDamage={{$characterStat.pet_bonus_dmg}};
			this.petBonusFromType="";
		
			this.value=this.holy;
			
			if (this.value > this.arcane)	this.value=this.arcane;
			if (this.value > this.fire)		this.value=this.fire;
			if (this.value > this.nature)	this.value=this.nature;
			if (this.value > this.frost)	this.value=this.frost;
			if (this.value > this.shadow)	this.value=this.shadow;
		}
		
		function spellBonusHealingObject() {
			this.value={{$characterStat.heal_bonus}};
		}
		
		function spellHasteRatingObject(){
			this.value={{$characterStat.spell_haste_rating}};
			this.percent={{$characterStat.spell_haste_pct}};
		}
		
		function spellHitRatingObject() {
			this.value={{$characterStat.spell_hit_rating}};
			this.increasedHitPercent={{$characterStat.spell_hit_pct}};
			this.spellPenetration= {{$characterStat.spell_hit_penetration}};	
		}
		
		function spellCritChanceObject() {
	        this.rating={{$characterStat.spell_crit_rating}};
			this.holy={{$characterStat.spell_crit_holy}};
			this.arcane={{$characterStat.spell_crit_arcane}};
			this.fire={{$characterStat.spell_crit_fire}};
			this.nature={{$characterStat.spell_crit_nature}};
			this.frost={{$characterStat.spell_crit_frost}};
			this.shadow={{$characterStat.spell_crit_shadow}};
		
			this.percent=this.holy;
			
			if (this.percent > this.arcane)	this.percent=this.arcane;
			if (this.percent > this.fire)	this.percent=this.fire;
			if (this.percent > this.nature)	this.percent=this.nature;
			if (this.percent > this.frost)	this.percent=this.frost;
			if (this.percent > this.shadow)	this.percent=this.shadow;
		}
		
		function spellPenetrationObject() {
			this.value=0;
		}
		
		function spellManaRegenObject() {
			this.casting={{$characterStat.mana_regen_cast}};
			this.notCasting={{$characterStat.mana_regen_out_of_cast}};
		}
		
		function defensesArmorObject() {
			this.base=23773;
			this.effective=23773;
			this.percent=60.95;
			this.petBonus=-1;
		
			this.diff=this.effective - this.base;
		}
		
		function defensesDefenseObject() {
			this.rating={{$characterStat.stat_defense_rating}};
			this.plusDefense={{$characterStat.rating_defense_add}};
			this.increasePercent={{$characterStat.defense_percent}};
			this.decreasePercent={{$characterStat.defense_percent}};
			this.value={{$characterStat.rating_defense}} + this.plusDefense;
		}
		
		function defensesDodgeObject() {
			this.percent={{$characterStat.dodge_chance}};
			this.rating={{$characterStat.stat_dodge}};
			this.increasePercent={{$characterStat.stat_dodge_pct}};
		}
		
		function defensesParryObject() {
			this.percent={{$characterStat.parry_chance}};
			this.rating={{$characterStat.stat_parry}};
			this.increasePercent={{$characterStat.stat_parry_pct}};
		}
		
		function defensesBlockObject() {
			this.percent={{$characterStat.block_pct}};
			this.rating={{$characterStat.block_rating}};
			this.increasePercent={{$characterStat.block_chance}};
		}
		
		function defensesResilienceObject() {
			this.value={{$characterStat.min_resilence}};
			this.hitPercent={{$characterStat.spell_resilence_pct}};
			this.damagePercent={{$characterStat.melee_resilence_pct}};
		}	
		
		var theCharacter = new characterObject();		
		var theCharUrl = "{{$character_url_string}}";
	
	</script>
    <script src="_js/_lang/{{$ArmoryConfig.locale}}/character-sheet.js" type="text/javascript"></script>
    <script src="_js/character/textObjects.js" type="text/javascript"></script>
</div>
</div>
<div style="width: 500px; margin: 5px auto 20px;">
<span style="float: right">{{#armory_character_sheet_total_honor_kills#}}: <strong>{{$playerHonorKills}}</strong></span><!--{{#armory_character_sheet_last_updated#}}:&nbsp;
		<strong>14 Ноябрь 2009 г.</strong>-->
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
{{include file="faq_character_sheet.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}