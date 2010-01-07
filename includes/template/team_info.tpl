<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<teamInfo>
<link href="_css/arena-report.css" rel="stylesheet" />
<script src="_js/arena-report/team-info.js" type="text/javascript"></script><script type="text/javascript">
                $(document).ready(function(){			
                    initializeTeamInfo();
                });	
            </script>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="tabs">
<div class="selected-tab" id="tab_teamInfo">
<a href="team-info.xml?r={{$realm}}&amp;ts={{$team.type}}&amp;t={{$team.name}}">{{#armory_teaminfo_profile#}}</a>
</div>
<!--<div class="tab" id="tab_matchHistory">
<a href="arena-team-game-chart.xml?r={{$realm}}&amp;ts={{$team.type}}&amp;t={{$team.name}}">История матчей</a>
</div>
<div class="tab" id="tab_opponentHistory">
<a href="arena-team-report-opposing-teams.xml?r={{$realm}}&amp;ts={{$team.type}}&amp;t={{$team.name}}">История противника</a>
</div>-->
<div class="clear"></div>
</div>
<div class="subTabs" style="height: 1px;">
<div class="upperLeftCorner" style="height: 5px;"></div>
<div class="upperRightCorner" style="height: 5px;"></div>
</div>
<div class="full-list">
<div class="info-pane">
<div class="arenareport-header-single">
<div class="arenareport-moldingleft-s">
<div class="reldiv">
<div class="arenareport-moldingleft-s-flash">
<div id="teamicon2" style="display:none;"></div>
<script type="text/javascript">
		var flashId="teamicon2";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("teamicon2", "images/icons/team/pvpemblems.swf", "transparent", "", "#ff000000", "78", "78", "high", "", "{{$team.logo}}", "<div class=teamicon-noflash><a target=_blank href=http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash><img src=images/{{$ArmoryConfig.locale}}/getflash.png class=p/></a></div>")
		
		</script>
</div>
<div class="arenareport-moldingleft-name">
<div class="reldiv">
<div class="teamnameshadow">{{$team.name}}<span style="font-family:Arial, Helvetica, sans-serif;">&lt;{{$team.type}}v{{$team.type}}&gt;</span>
</div>
<div class="teamnamehighlight">
<a class="teamnamehighlight" href="team-info.xml?r={{$realm}}&amp;ts={{$team.type}}&amp;t={{$team.name}}">{{$team.name}}<span style="font-family:Arial, Helvetica, sans-serif; display: inline;">&lt;{{$team.type}}v{{$team.type}}&gt;</span></a>
</div>
</div>
</div>
<div class="arenareport-moldingleft-info">
<div style="float: left; margin: 10px 0 0 -25px">
<a class="smFrame" href="javascript:void(0);">
<div>{{$realm}}</div>
<img src="images/icon-header-realm.gif" /></a>
</div>
</div>
</div>
</div>
</div>
<div class="arena-badge-container" style="float: right; margin-top: 20px;">
<div class="arenaTeam-badge" style="margin: 0 auto; float: none; padding: 1px;">
<div class="teamSide{{$team.faction}}"></div>
<div class="teamRank">
<span>&nbsp;<!--На прошлой неделе--></span>
<p>{{#armory_arenaladder_rank#}}</p>
</div>
<div class="rank-num" id="arenarank2" style="padding-top: 5px;">
<div id="arenarank2" style="display:none;"></div>
<script type="text/javascript">
		var flashId="arenarank2";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("arenarank2", "images/rank.swf", "transparent", "", "", "100", "50", "best", "", "rankNum={{$teamstats.rank}}", "<div class=teamstanding-noflash>1-й</div>")
		
		</script>
</div>
<div class="arenaBadge-icon" style="background-image:url(images/icons/badges/arena/arena-2.jpg);">
<img class="p" src="images/badge-border-arena-gold.gif" /></div>

<!-- Borders are not calculated now, it's static image -->

</div>
<a class="standing-link" href="arena-ladder.xml?ts=2"><img src="images/pixel.gif" /></a>
</div>
<div class="filterTitle">{{#armory_teaminfo_statistic#}}</div>
<div class="stats-container" style="margin-bottom: 10px;">
<div class="arenaTeam-data">
<div class="innerData">
<table>
<tr class="team-header">
<td></td><td align="center"><strong>{{#armory_teaminfo_games#}}</strong></td><td align="center"><strong>{{#armory_teaminfo_wins_losses#}}</strong></td><td align="center"><strong>{{#armory_teaminfo_wins_percent#}}</strong></td><td align="center"><strong>{{#armory_teaminfo_teamrating#}}</strong></td>
</tr>
<tr class="hl">
<td>
<p>{{#armory_teaminfo_this_week#}}</p>
</td><td align="center">
<p>{{$teamstats.games}}</p>
</td><td align="center">
<p>{{$teamstats.wins}} - {{$teamstats.games-$teamstats.wins}}</p>
</td><td align="center">
<p>{{$teamstats.percent_week}}%</p>
</td><td align="center">
<p class="rating">{{$teamstats.rating}}</p>
</td>
</tr>
<tr>
<td>
<p>{{#armory_teaminfo_this_season#}}</p>
</td><td align="center">
<p>{{$teamstats.played}}</p>
</td><td align="center">
<p>{{$teamstats.wins2}} - {{$teamstats.played-$teamstats.wins2}}</p>
</td><td align="center">
<p>{{$teamstats.percent_season}}%</p>
</td><td align="center">
<p class="rating">{{$teamstats.rating}}</p>
</td>
</tr>
</table>
</div>
</div>
</div>
<div class="data">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" id="teamsTable" style="width: 100%">
<thead>
<tr class="masthead">
<th style="text-align:left; width: 150px;"><a>{{#armory_teaminfo_team_members#}}<span class="sortArw"></span></a></th><th style="text-align:left; width: 240px;"><a>{{#armory_searchguilds_guild#}}<span class="sortArw"></span></a></th><th style="text-align:left; width: 130px;"><a>{{#armory_teaminfo_class_race#}}<span class="sortArw"></span></a></th><th><a class="staticTip" onmouseover="setTipText('{{#armory_teaminfo_tooltip_mp#}}')">{{#armory_teaminfo_mp#}}<span class="sortArw"></span></a></th><th><a class="staticTip" onmouseover="setTipText('{{#armory_teaminfo_wins_tooltip#}}')">{{#armory_teaminfo_wins#}}<span class="sortArw"></span></a></th><th><a class="staticTip" onmouseover="setTipText('{{#armory_teaminfo_losses_tooltip#}}')">{{#armory_teaminfo_losses#}}<span class="sortArw"></span></a></th><th><a>{{#armory_teaminfo_wins_percent#}}<span class="sortArw"></span></a></th><th><a class="staticTip" onmouseover="setTipText('{{#armory_teaminfo_pr_tooltip#}}')">{{#armory_teaminfo_pr#}}<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{{foreach from=$teamplayers item=player}}
<tr class="data{{if $player.captain}}3{{else}}4{{/if}}">
<td><a href="character-sheet.xml?r={{$realm}}&amp;n={{$player.name}}">{{$player.name}}</a></td><td>{{if $player.guildname}}<a href="guild-info.xml?r={{$realm}}&amp;gn={{$player.guildname}}">{{$player.guildname}}</a>{{else}}&nbsp;{{/if}}</td><td><img class="staticTip" onmouseover="setTipText('{{get_wow_race race=$player.race}}');" src="images/icons/race/{{$player.race}}-{{$player.gender}}.gif" />&nbsp;
<img class="staticTip" onmouseover="setTipText('{{get_wow_class class=$player.class}}');" src="images/icons/class/{{$player.class}}.gif" /></td><td class="rightNum">{{$player.played_season}}</td><td class="rightNum" style="color: #678705;">{{$player.wons_season}}</td><td class="rightNum" style="color: #9A1401;">{{$player.played_season-$player.wons_season}}</td><td class="rightNum">{{$player.percent_season}}%</td><td class="rightNum">{{$player.personal_rating}}</td>
</tr>
{{/foreach}}
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</teamInfo>
<season end="today" id="7" start="1251763200000"></season>
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