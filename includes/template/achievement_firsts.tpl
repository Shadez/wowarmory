<link href="_css/character/achievements.css" rel="stylesheet" type="text/css">
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
<div class="server-firsts list">
<div class="info-header hdr_achvfirsts">
<h1>{{#armory_afirsts_header#}}</h1>
<h2>{{$realmName}}</h2>
</div>
<div class="achieve-firsts">
<div class="firsts_top">
<div class="firsts_btm">
<div class="firsts_l">
<div class="firsts_r">
{{foreach from=$achievementFirsts item=achievement}}
<div class="firsts_achievement firsts_closed" onclick="toggle_first(this)">
<div class="expand_btn">
<!---->
</div>
<div class="firsts_icon" style="background-image:url(&quot;wow-icons/_images/51x51/{{$achievement.icon}}.jpg&quot;)">
<img class="p" src="images/achievements/fst_iconframe.png"></div>
<h3>{{$achievement.name}}</h3>
<div class="firsts_tshadow">
<div class="firsts_desc">{{$achievement.description}}</div>
<div class="briefchars">От <a href="character-sheet.xml?r={{$realmName}}&amp;n={{$achievement.charname}}">{{$achievement.charname}}</a> на {{$realmName}}</div>
<div class="allchars single">
{{if $achievement.guildname}}<a class="gld" href="guild-info.xml?gn={{$achievement.guildname}}&amp;r={{$realmName}}">&lt;{{$achievement.guildname}}&gt;</a>&nbsp;{{/if}}<a href="character-sheet.xml?r={{$realmName}}&amp;n={{$achievement.charname}}">{{$achievement.charname}}</a><img src="images/icons/race/{{$achievement.race}}-{{$achievement.gender}}.gif"><img align="absmiddle" src="images/icons/class/{{$achievement.class}}.gif" /></div>
<div class="firsts_timedate">изучено на [<a href="achievement-firsts.xml?r={{$realmName}}">{{$realmName}}</a>] <b class="timestamp-firsts">{{$achievement.timestamp}}</b>
</div>
<br clear="all">
</div>
</div>
{{/foreach}}
</div>
</div>
<script type="text/javascript">
					L10n.formatTimestamps("b.timestamp-firsts", {
			withinHour: "{0} {{#armory_timeformat_1#}}",
			withinHourSingular: "{0} {{#armory_timeformat_2#}}",
			withinDay: "{0} {{#armory_timeformat_3#}}",
			withinDaySingular: "{0} {{#armory_timeformat_4#}}",
			today: "{{#armory_timeformat_5#}} {0}",
			yesterday: "{{#armory_timeformat_6#}}",
			date: "d.M.yyyy"
		});
</script>
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
</div>
{{include file="overall_footer.tpl"}}