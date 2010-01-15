var warriorId = 1;
var paladinId = 2;
var hunterId = 3;
var rogueId = 4;
var priestId = 5;
var shamanId = 7;
var mageId = 8;
var warlockId = 9;
var druidId = 11;
var deathknightId = 6;

var whiteText = "textWhite";
var greenText = "textGreen";
var spanYellow = "&lt;span class = 'tooltipContentSpecial'&gt;";
var spanYellowEnd = '&lt;/span&gt;';

    var buffArray = new Array;
    var debuffArray = new Array;

  function itemsObject() {
    this.head = new itemObject(0, textHead);
	this.neck = new itemObject(1, textNeck);
	this.shoulders = new itemObject(2, textShoulders);
	this.back = new itemObject(14, textBack);
	this.chest = new itemObject(4, textChest);
	this.shirt = new itemObject(3, textShirt);
	this.tabard = new itemObject(18, textTabard);
	this.wrist = new itemObject(8, textWrists);
	this.hands = new itemObject(9, textHands);
	this.waist = new itemObject(5, textWaist);
	this.legs = new itemObject(6, textLegs);
	this.feet = new itemObject(7, textFeet);
	this.finger1 = new itemObject(10, textFinger);
	this.finger2 = new itemObject(11, textFinger);
	this.trinket1 = new itemObject(12, textTrinket);
	this.trinket2 = new itemObject(13, textTrinket);
	this.mainHand = new itemObject(15, textMainHand);
	this.offHand = new itemObject(16, textOffHand);
	this.ranged = new itemObject(17, textRanged);
//	this.ammo = new itemObject(19, "Ammo");
  }

function isApplicable(theValue) {

	if(theValue == -1)
		return false;
	else
		return true;
}

	function sortArray(a, b){
		result = b[1] - a[1];
		return result;
	}


var hasChanged = false; //var to detect if change stats has fired yet
function changeStats(whichSide, whichStats, theKey, theDisplay){

//	document.getElementById("dropdownHidden"+ whichSide).style.display = "none";
	document.getElementById("display"+ whichSide).innerHTML = theDisplay;
	document.getElementById("replaceStats"+ whichSide).innerHTML = whichStats;

	if(hasChanged == false)
		hasChanged = true;
	else
		bindToolTips();
}

stats_pages = ["Melee", "Ranged", "Spell", "Defenses"]

function page_stats(dir)
{ 	current_page += dir; current_page=(current_page>=stats_pages.length)?0:(current_page<0)?stats_pages.length-1:current_page;
    var cpg = stats_pages[current_page];
	changeStats('Right', eval("replaceString"+cpg), cpg, eval(cpg.substring(0,1).toLowerCase()+cpg.substring(1)+"Display"))	
}

function toggle_gear(type)
{
	$("#gear-profile").attr("class",type);
	setcookie("armory.cookieGearMode", type);
}

function enchanttip(name,desc,spelltxt)
{ 
	return "<span class='enchantspell'>"+name+" ("+spelltxt+")</span>"+desc.replace("****","<br/>")
} 


function getBaseStatsTitleAppend(base, diff) {

	var returnArray = new Array;

	if (diff > 0) {
		titleAppend = ' ('+ base +'<i class = \'mod\'> + '+ diff +'&lt;/i>)';
		theColor = 'class = "mod"';
	} else if (diff < 0) {
		diff = 0 - diff;
		titleAppend = ' ('+ base +'<i class = \'moddown\'> - '+ diff +'&lt;/i>)';
		theColor = 'class = "moddown"';
	} else {
		titleAppend = '';
		theColor = '';		
	}
	
	returnArray = [titleAppend, theColor];
	
	return returnArray; 
}

    function returnReplaceDiv(whichSlot){
		return '<div id="flyoutMenu" class="fly-horz"><a href = "javascript: goToUpgrade('+ whichSlot +');" class="upgrd">'+ textFindUpgrade +'</a></div>';
	}

function mouseOverArrow(whichItem, whichSlot) {
	if (whichItem) {
		document.getElementById('flyOver'+ whichSlot +'x').style.visibility = 'visible';
	}
	document.getElementById('slotOver'+ whichSlot +'x').className = 'thisTipOver';
	theCurrentItemId = whichItem;	
}

function mouseOverUpgradeBox(whichSlot) {
		document.getElementById('flyOver'+ whichSlot +'x').style.visibility = 'visible';
		document.getElementById('slotOver'+ whichSlot +'x').className = 'thisTipOver';
}

function mouseOutArrow(whichSlot) {
	document.getElementById('slotOver'+ whichSlot +'x').className = 'thisTip';
	document.getElementById('flyOver'+ whichSlot +'x').style.visibility = 'hidden';
}

function baseStatsObject() {
	this.strength = new strengthObject();
	this.agility = new agilityObject();
	this.stamina = new staminaObject();
	this.intellect = new intellectObject();
	this.spirit = new spiritObject();
	this.armor = new armorObject();
}

function meleeObject() {
	this.weaponSkill = new meleeWeaponSkillObject();
	this.damage = new meleeDamageObject();
	this.speed = new meleeSpeedObject();
	this.power = new meleePowerObject();
	this.hitRating = new meleeHitRatingObject();
	this.critChance = new meleeCritChanceObject();
}

function rangedObject() {
	this.weaponSkill = new rangedWeaponSkillObject();
	this.damage = new rangedDamageObject();
	this.speed = new rangedSpeedObject();
	this.power = new rangedPowerObject();
	this.hitRating = new rangedHitRatingObject();
	this.critChance = new rangedCritChanceObject();
}

function spellObject() {
	this.bonusDamage = new spellBonusDamageObject();
	this.bonusHealing = new spellBonusHealingObject();
	this.hitRating = new spellHitRatingObject();
	this.critChance = new spellCritChanceObject();
	this.hasteRating = new spellHasteRatingObject();
	this.manaRegen = new spellManaRegenObject();
}

function defensesObject() {
	this.armor = new defensesArmorObject();
	this.defense = new defensesDefenseObject();
	this.dodge = new defensesDodgeObject();
	this.parry = new defensesParryObject();
	this.block = new defensesBlockObject();			
	this.resilience = new defensesResilienceObject();			
}

function characterObject() {
	this.classId = theClassId;
	this.className = theClassName;
	this.level = theLevel;
	this.resistances = new resistancesObject();
	this.baseStats = new baseStatsObject();
	this.melee = new meleeObject();
	this.ranged = new rangedObject();
	this.spell = new spellObject();
	this.defenses = new defensesObject; 
}

function meleeWeaponSkillObject() {
	this.mainHandWeaponSkill = new meleeMainHandWeaponSkillObject();
	this.offHandWeaponSkill = new meleeOffHandWeaponSkillObject();	
}

function meleeDamageObject() {
	this.mainHandDamage = new meleeMainHandDamageObject();
	this.offHandDamage = new meleeOffHandDamageObject();	
}

function meleeSpeedObject() {
	this.mainHandSpeed = new meleeMainHandSpeedObject();
	this.offHandSpeed = new meleeOffHandSpeedObject();	
}

if (theLevel < 20)
	var charResistLevel = 20;
else
	var charResistLevel = theLevel;

function calcResistText(theResist) {
	
	theValue = Math.ceil(theResist/(charResistLevel * 1.25)) - 1;

	if (theResist == 0)
		theResist = textNone;
	else if (theValue == 0)
		theResist = textPoor;
	else if (theValue == 1)
		theResist = textFair;
	else if (theValue == 2)
		theResist = textGood;		
	else if (theValue == 3)
		theResist = textVeryGood;		
	else
		theResist = textExcellent;	
	
	return theResist;
	
}

function resistArcaneObject(theResist, thePetBonus) {

	this.effective = theResist;
	this.base = 0;
		
	this.diff = this.effective - this.base;
	
	if (this.diff)
		this.breakdown = ' ('+ this.base +' + <i class = "mod">'+ this.diff +'</i>)';
	else
		this.breakdown = "";

	this.rank = calcResistText(theResist);

	this.value = theResist;

	if (thePetBonus == 0)
		this.petBonus = -1;
	else
		this.petBonus = thePetBonus;

}

function resistFireObject(theResist, thePetBonus) {

	this.effective = theResist;
	this.base = 0;
	this.diff = this.effective - this.base;		

	if (this.diff)
		this.breakdown = " ("+ this.base +" + <i class = 'mod'>"+ this.diff +"</i>)";
	else
		this.breakdown = "";

	this.rank = calcResistText(theResist);

	this.value = theResist;

	if (thePetBonus == 0)
		this.petBonus = -1;
	else
		this.petBonus = thePetBonus;

}

function resistNatureObject(theResist, thePetBonus) {

	this.effective = theResist;
	this.base = 0;
	this.diff = this.effective - this.base;		

	if (this.diff)
		this.breakdown = " ("+ this.base +" + <i class = 'mod'>"+ this.diff +"</i>)";
	else
		this.breakdown = "";

	this.rank = calcResistText(theResist);

	this.value = theResist;

	if (thePetBonus == 0)
		this.petBonus = -1;
	else
		this.petBonus = thePetBonus;

}

function resistFrostObject(theResist, thePetBonus) {

	this.effective = theResist;
	this.base = 0;
	this.diff = this.effective - this.base;

	if (this.diff)
		this.breakdown = " ("+ this.base +" + <i class = 'mod'>"+ this.diff +"</i>)";
	else
		this.breakdown = "";

	this.rank = calcResistText(theResist);

	this.value = theResist;

	if (thePetBonus == 0)
		this.petBonus = -1;
	else
		this.petBonus = thePetBonus;

}

function resistShadowObject(theResist, thePetBonus) {

	this.effective = theResist;
	this.base = 0;
	this.diff = this.effective - this.base;
	
	if (this.diff)
		this.breakdown = " ("+ this.base +" + <i class = 'mod'>"+ this.diff +"</i>)";
	else
		this.breakdown = "";

	this.rank = calcResistText(theResist);

	this.value = theResist;

	if (thePetBonus == 0)
		this.petBonus = -1;
	else
		this.petBonus = thePetBonus;

}

  function itemObject(whichSlot, defaultText) {
	  /*
    this.slot = whichSlot;

	if (itemsArray[whichSlot] && itemsArray[whichSlot][1] != "0") {
	  this.id = itemsArray[whichSlot][0];

	  if (itemsArray[whichSlot][2] == "0" && itemsArray[whichSlot][3] != "0")
	    document.getElementById('slotOver'+whichSlot+'x').className="broken";
	} else {
	  document.getElementById("slot"+ whichSlot + "x").src = "images/pixel.gif";
	  this.id = 0;
	}
    this.mouseover = defaultText;
	*/
  }

function TTcharacterIcons(raceId,genderId,classId,raceTxt,classTxt)
{
	var tiptext = '&lt;img src="../images/icons/race/'+raceId+'-'+genderId+'.gif" align="absmiddle" /&gt;  '+raceTxt+'&lt;br/&gt;&lt;img src="../images/icons/class/'+classId+'.gif" align="absmiddle"/&gt;  '+classTxt;
	
return tiptext

}

jsLoaded=true;
