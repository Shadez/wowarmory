<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<link href="_css/tools/talent-calc.css" rel="stylesheet" type="text/css" />
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="tabs">
<div class="selected-tab" id="tab_talentCalculator">
<a href="talent-calc.xml">{#armory_talent_calc_talents_calc#}</a>
</div>
<div class="tab" id="tab_petTalentCalculator">
<a href="talent-calc.xml?pid=-1">{#armory_talent_calc_pet_talents#}</a>
</div>
<div class="tab" id="tab_arenaCalculator">
<a href="arena-calculator.xml">{#armory_talent_calc_arena_calc#}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="{$tab_6}" href="talent-calc.xml?c=Death+Knight" id="6_subTab"><span>{#string_class_6#}</span></a>
<a class="{$tab_11}" href="talent-calc.xml?c=Druid" id="11_subTab"><span>{#string_class_11#}</span></a>
<a class="{$tab_3}" href="talent-calc.xml?c=Hunter" id="3_subTab"><span>{#string_class_3#}</span></a>
<a class="{$tab_8}" href="talent-calc.xml?c=Mage" id="8_subTab"><span>{#string_class_8#}</span></a>
<a class="{$tab_2}" href="talent-calc.xml?c=Paladin" id="2_subTab"><span>{#string_class_2#}</span></a>
<a class="{$tab_5}" href="talent-calc.xml?c=Priest" id="5_subTab"><span>{#string_class_5#}</span></a>
<a class="{$tab_4}" href="talent-calc.xml?c=Rogue" id="4_subTab"><span>{#string_class_4#}</span></a>
<a class="{$tab_7}" href="talent-calc.xml?c=Shaman" id="7_subTab"><span>{#string_class_7#}</span></a>
<a class="{$tab_9}" href="talent-calc.xml?c=Warlock" id="9_subTab"><span>{#string_class_9#}</span></a>
<a class="{$tab_1}" href="talent-calc.xml?c=Warrior" id="1_subTab"><span>{#string_class_1#}</span></a>
</div>
{include file="$tpl2includecalc.tpl"}
</div>
</div>
</div>
</div>
<talentTabs>
<talentTab classId="2" name="{#string_class_2#}"></talentTab>
<talentTab classId="4" name="{#string_class_4#}"></talentTab>
<talentTab classId="9" name="{#string_class_9#}"></talentTab>
<talentTab classId="8" name="{#string_class_8#}"></talentTab>
<talentTab classId="6" name="{#string_class_6#}"></talentTab>
<talentTab classId="11" name="{#string_class_11#}"></talentTab>
<talentTab classId="1" name="{#string_class_1#}"></talentTab>
<talentTab classId="3" name="{#string_class_3#}"></talentTab>
<talentTab classId="7" name="{#string_class_7#}"></talentTab>
<talentTab classId="5" name="{#string_class_5#}"></talentTab>
</talentTabs>
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