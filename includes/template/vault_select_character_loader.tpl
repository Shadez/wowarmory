<div id="charList">
<div class="topcharlist">
<h5>{{#armory_vault_my_characters#}}</h5>
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
<p class="staticTip" onmouseover="setTipText('{{#armory_vault_dualtooltips_tip#}}');">
<label><input id="checkboxDualTooltip" onClick="javascript:setDualTooltipCookie();" type="checkbox" />{{#armory_vault_dualtooltips#}}</label>
</p>
</div>
{{foreach from=$selectedCharacters item=char}}
<div class="select-char2">
{{if $char.name}}
<a class="selChar selSecondaryChar staticTip" href="javascript:void(0)" id="r={{$realm}}&amp;n={{$char.name}}" onmouseover="setTipText('{{#armory_vault_select_main_char#}}');"></a>
<a class="delChar staticTip" href="javascript:void(0)" onmouseover="setTipText('{{#armory_vault_delete_char#}}');"></a>
<img class="staticTip" onmouseover="setTipText('{{get_wow_race race=$char.race}}');" src="images/icons/race/{{$char.race}}-{{$char.gender}}.gif" />
<img class="staticTip" onmouseover="setTipText('{{get_wow_class class=$char.class}}');" src="images/icons/class/{{$char.class}}.gif" />
<h6>
<a href="character-sheet.xml?r={{$realm}}&amp;n={{$char.name}}">{{$char.name}}</a>
</h6>&nbsp;({{$char.level}}) - <span class="char-realm">{{$realm}}</span>
{{else}}
<h6>{{#armory_vault_free_char_slot#}}</h6>
{{/if}}
</div>
{{/foreach}}
</div>
</div>
</div>