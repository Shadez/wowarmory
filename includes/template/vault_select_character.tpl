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
<div class="full-list notab">
<div class="info-pane">
<style media="screen, projection" type="text/css">
		@import "_css/character-select.css";	
</style>
<script src="_js/character/character-select.js" type="text/javascript"></script>
<script type="text/javascript">           
        $(document).ready(function(){
			//get how many characters are selected
			var numCharsSelected = 3;
					
            initializeCharacterSelect(numCharsSelected);
        });
        
        //bind tooltips for primary/secondary characters
        function setCharacterToolTips(){				
            $(".secondaryChar").mouseover(function(){
                setTipText("Профиль этого персонажа отмечен закладкой внутри профиля вашего основного персонажа. Щелкните по нему, чтобы выбрать этого персонажа в качестве основного.");
            });
            
            $(".primaryChar").mouseover(function(){ 				
                setTipText("Данный персонаж выбран в качестве вашего основного персонажа. Ссылка на его профиль будет показываться в правом верхнем углу Оружейной.");
            });
        }
	</script>
<div class="sel-char">
<div class="sel-intro">
<h1>Выбор персонажа</h1>
</div>
<div id="charList">
<div class="topcharlist">
<h5>Мои персонажи</h5>
<div class="select-charwrap">
<div class="select-char1">
<div>
<img class="primchar-avatar" src="images/portraits/wow-80/{{$selected_char.gender}}-{{$selected_char.race}}-{{$selected_char.class}}.gif" />
<h6>
<a class="selChar selPrimaryChar" href="character-sheet.xml?r={{$realm}}&amp;n={{$selected_char.name}}" id="r={{$realm}}&amp;n={{$selected_char.name}}">{{$selected_char.name}}</a>
</h6>
<span>Level {{$selected_char.level}}&nbsp;{{get_wow_race race=$selected_char.race}}&nbsp;{{get_wow_class class=$selected_char.class}}</span><span class="char-realm">{{$realm}}</span><q></q>
</div>
<em></em>
<p class="staticTip" onmouseover="setTipText('При включении двойных подсказок к предметам вы сможете просматривать вторую подсказку с харакетристиками для данного типа экипировки в профиле вашего основного персонажа.');">
<label><input id="checkboxDualTooltip" onClick="javascript:setDualTooltipCookie();" type="checkbox">Включить подсказки второго уровня</label>
</p>
</div>
{{foreach from=$selectedCharacters item=char}}
<div class="select-char2">
{{if $char.name}}
<a class="selChar selSecondaryChar staticTip" href="javascript:void(0)" id="r={{$realm}}&amp;n={{$char.name}}" onmouseover="setTipText('Выбрать в качестве основного персонажа');"></a><a class="delChar staticTip" href="javascript:void(0)" onmouseover="setTipText('Удалить персонажа из меню &laquo;Мои персонажи&raquo;');"></a><img class="staticTip" onmouseover="setTipText('{{get_wow_race race=$char.race}}');" src="/images/icons/race/{{$char.race}}-{{$char.gender}}.gif"><img class="staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}');" src="/images/icons/class/{{$char.class}}.gif" /><h6>
<a href="character-sheet.xml?r={{$realm}}&amp;n={{$char.name}}">{{$char.name}}</a>
</h6>&nbsp;({{$char.level}}) - <span class="char-realm">{{$realm}}</span>
{{else}}
<h6>Свободная ячейка для персонажа</h6>
{{/if}}
</div>
{{/foreach}}
</div>
</div>
</div>
<div id="searchTable">
<ul id="navTabs">
<li>
<a href="#{{$_wow_login}}">{{$_wow_login}}</a>
</li>
</ul>
<div class="charSelectTabDiv data" id="{{$_wow_login}}" style="min-height: 100px;">
<table cellpadding="0" cellspacing="0" class="data-table sortTable" width="100%">
<thead>
<tr class="masthead">
<th style="text-align:left;"><a>Имя персонажа<span class="sortArw"></span></a></th><th class="numericSort"><a class="staticTip" onmouseover="setTipText(&quot;Очки достижений&quot;);">Очки...<span class="sortArw"></span></a></th><th><a>Уровень<span class="sortArw"></span></a></th><th><a>Раса<span class="sortArw"></span></a></th><th><a>Класс<span class="sortArw"></span></a></th><th><a>Фракция<span class="sortArw"></span></a></th><th style="text-align:left"><a>Гильдия<span class="sortArw"></span></a></th><th style="text-align:left;"><a>Игровой мир<span class="sortArw"></span></a></th><th class="headerSortUp"><a>Соответствие<span class="sortArw"></span></a></th>
</tr>
</thead>
<tbody>
{{foreach from=$allCharacters item=char}}
<tr>
<td style="text-align:left; padding-left: 3px;"><span style="display: none;">{{$char.name}}</span>
{{if $disallowAddNewChar}}
<a class="charListIcons add_off staticTip" href="javascript:void(0)" onmouseover="setTipText({{#armory_vault_add_new_char_disallowed#}});"></a>
{{else}}
<a class="charListIcons add_on staticTip" href="javascript:void(0)" onmouseover="setTipText({{#armory_vault_add_character_to_list#}});"></a>
{{/if}}
<a href="character-sheet.xml?r={{$realm}}&amp;n={{$char.name}}">{{$char.name}}</a></td>
<td style="text-align:right; padding-right:3px; font-weight: bold; width: 50px;"><span style="display: none;">0</span><span class="achievPtsSpan">0</span></td>
<td class="rightNum"><strong>{{$char.level}}</strong></td>
<td style="text-align:right; padding-right:3px;"><span style="display: none;">{{get_wow_race race=$char.race}}</span><img class="staticTip" onmouseover="setTipText('{{get_wow_race race=$char.race}}');" src="images/icons/race/{{$char.race}}-{{$char.gender}}.gif" /></td>
<td style="text-align:left; padding-left:3px;"><span style="display: none;">{{get_wow_class class=$char.class}}</span><img class="staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}');" src="images/icons/class/{{$char.class}}.gif" /></td><td style="text-align:center;"><img class="staticTip" onmouseover="setTipText('{{get_wow_faction race=$char.race}}');" src="/images/icons/faction/icon-{{get_wow_faction race=$char.race numeric=true}}.gif" /></td>
<td>{{if $char.guildname}}<a href="guild-info.xml?n={{$char.guildname}}&amp;r={{$realm}}">{{$char.guildname}}</a>{{/if}}</td>
<td style="text-align:left; padding-left:3px;">{{$realm}}</td>
<td class="relevance"><span style="display: none;">100%</span><q class="staticTip" onmouseover="setTipText('100%');"><del class="rel-container"><a><em style="width:100%"></em></a></del></q></td>
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