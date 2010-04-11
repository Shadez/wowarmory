/*******            Resistances         ******/
var arcaneTooltip = '<span class="tooltipTitle">Arkanwiderstand '+ theCharacter.resistances.arcane.value + theCharacter.resistances.arcane.breakdown +'</span><span class="tooltipContentSpecial">Erhöht die Fähigkeit, auf Arkanschaden basierenden Angriffen, Zaubern und Fähigkeiten zu widerstehen.<br/>Widerstand gegen Stufe '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.arcane.rank +'</span></span>';
var arcanePetBonus = "<span class = 'tooltipContentSpecial'>Erhöht den Widerstand Eures Begleiters um "+ theCharacter.resistances.arcane.petBonus + "</span>";

var fireTooltip = '<span class="tooltipTitle">Feuerwiderstand '+ theCharacter.resistances.fire.value + theCharacter.resistances.fire.breakdown +'</span><span class = "tooltipContentSpecial">Erhöht die Fähigkeit, auf Feuerschaden basierenden Angriffen, Zaubern und Fähigkeiten zu widerstehen.<br/>Widerstand gegen Stufe '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.fire.rank +'</span></span>';
var firePetBonus = "<span class = 'tooltipContentSpecial'>Erhöht den Widerstand Eures Begleiters um "+ theCharacter.resistances.arcane.petBonus + "</span>";

var natureTooltip = '<span class="tooltipTitle">Naturwiderstand '+ theCharacter.resistances.nature.value + theCharacter.resistances.nature.breakdown +'</span><span class = "tooltipContentSpecial">Erhöht die Fähigkeit, auf Naturschaden basierenden Angriffen, Zaubern und Fähigkeiten zu widerstehen.<br/>Widerstand gegen Stufe '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.nature.rank +'</span></span>';
var naturePetBonus = "<span class = 'tooltipContentSpecial'>Erhöht den Widerstand Eures Begleiters um "+ theCharacter.resistances.arcane.petBonus + "</span>";

var frostTooltip = '<span class="tooltipTitle">Frostwiderstand '+ theCharacter.resistances.frost.value + theCharacter.resistances.frost.breakdown +'</span><span class = "tooltipContentSpecial">Erhöht die Fähigkeit, auf Frostschaden basierenden Angriffen, Zaubern und Fähigkeiten zu widerstehen.<br/>Widerstand gegen Stufe '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.frost.rank +'</span></span>'
var frostPetBonus = "<span class = 'tooltipContentSpecial'>Erhöht den Widerstand Eures Begleiters um "+ theCharacter.resistances.arcane.petBonus + "</span>";

var shadowTooltip = '<span class="tooltipTitle">Schattenwiderstand '+ theCharacter.resistances.shadow.value + theCharacter.resistances.shadow.breakdown +'</span><span class = "tooltipContentSpecial">Erhöht die Fähigkeit, auf Schattenschaden basierenden Angriffen, Zaubern und Fähigkeiten zu widerstehen.<br/>Widerstand gegen Stufe '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.shadow.rank +'</span></span>';
var shadowPetBonus = "<span class = 'tooltipContentSpecial'>Erhöht den Widerstand Eures Begleiters um "+ theCharacter.resistances.arcane.petBonus + "</span>";

/*******            Resistances End       ******/


/*******            Base Stats       ******/

var baseStatsDisplay = "Basiswerte";

var baseStatsStrengthTitle = "Stärke ";
var baseStatsStrengthAttack = "Erhöht Angriffskraft um "+theCharacter.baseStats.strength.attack;
var baseStatsStrengthBlock = "Erhöht den Blockwert um "+theCharacter.baseStats.strength.block+" <br/>";
var baseStatsStrengthDisplay = "Stärke: ";

var baseStatsAgilityTitle = "Beweglichkeit ";
var baseStatsAgilityAttack = "Erhöht Angriffskraft um "+theCharacter.baseStats.agility.attack;
var baseStatsAgilityCritHitPercent = "Erhöht die Chance auf einen kritischen Treffer um "+ theCharacter.baseStats.agility.critHitPercent +"%";
var baseStatsAgilityArmor = "Erhöht die Rüstung um "+ theCharacter.baseStats.agility.armor;
var baseStatsAgilityDisplay = "Beweglichkeit: ";

var baseStatsStaminaTitle = "Ausdauer ";
var baseStatsStaminaHealth = "Erhöht Gesundheit um "+ theCharacter.baseStats.stamina.health;
var baseStatsStaminaPetBonus = "Erhöht die Gesundheit des Begleiters um "+ theCharacter.baseStats.stamina.petBonus;
var baseStatsStaminaDisplay = "Ausdauer: ";

var baseStatsIntellectTitle = "Intelligenz ";
var baseStatsIntellectMana = "Erhöht Mana um "+ theCharacter.baseStats.intellect.mana;
var baseStatsIntellectCritHitPercent = "Erhöht die kritische Zaubertrefferchance um "+ theCharacter.baseStats.intellect.critHitPercent + "%";
var baseStatsIntellectPetBonus = "Erhöht die Intelligenz des Begleiters um "+ theCharacter.baseStats.intellect.petBonus;
var baseStatsIntellectDisplay = "Intelligenz: ";

var baseStatsSpiritTitle = "Willenskraft ";
var baseStatsSpiritHealthRegen = "Regeneriert außerhalb des Kampfes "+ theCharacter.baseStats.spirit.healthRegen +" Gesundheit pro Sekunde";
var baseStatsSpiritManaRegen = "Regeneriert alle 5 Sekunden "+ theCharacter.baseStats.spirit.manaRegen +" Mana, wenn kein Zauber gewirkt wird";
var baseStatsSpiritDisplay = "Willenskraft: ";

var baseStatsArmorTitle = "Rüstung ";
var baseStatsArmorReductionPercent = "Verringert jeden erlittenen physischen Schaden um "+ theCharacter.baseStats.armor.reductionPercent +"%";
var baseStatsArmorPetBonus = "Erhöht die Rüstung des Begleiters um "+ theCharacter.baseStats.armor.petBonus;
var baseStatsArmorDisplay = "Rüstung: ";

/*******            Base Stats  End     ******/


/*******            Melee     ******/

var meleeDisplay = "Nahkampf";

var meleeMainHandTitle = "Waffenhand";
var meleeOffHandTitle = "Nebenhand";

var meleeExpertiseTitle = "Waffenkunde "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.rating;
var meleeMainHandWeaponSkill = "Verringert die Chance, dass Feinde Euren Angriffen ausweichen oder sie parieren, um "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.percent + "%";
var meleeMainHandWeaponRating = "Waffenkundewertung "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.value + " (+"+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.additional +" Waffenkunde)";
/*var meleeOffHandWeaponSkill = "Waffenfertigkeit "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.value;
var meleeOffHandWeaponRating = "Waffenfertigkeitswertung "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.rating;*/
var meleeWeaponSkillDisplay = "Waffenkunde: ";

var meleeDamageMainHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.speed +"</span>Angriffstempo (Sek.):<br/>";
var meleeDamageMainHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.min +" - "+ theCharacter.melee.damage.mainHandDamage.max;
var meleeDamageMainHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.mainHandDamage.percent +"%</span>";
var meleeDamageDisplay = "Schaden: ";

var meleeDamageMainHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.dps +"</span>Schaden pro Sekunde:";
var meleeDamageOffHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.speed +"</span>Angriffstempo (Sek.):<br/>";
var meleeDamageOffHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.min +" - "+ theCharacter.melee.damage.offHandDamage.max;
var meleeDamageOffHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.offHandDamage.percent +"%</span>";
var meleeDamageOffHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.dps +"</span>Schaden pro Sekunde:<br/>";

var meleeSpeedTitle = "Angriffsgeschwindigkeit ";
var meleeSpeedHaste = "Beschleunigungswertung "+ theCharacter.melee.speed.mainHandSpeed.hasteRating +" ("+theCharacter.melee.speed.mainHandSpeed.hastePercent+"% Beschleunigung)";
var meleeSpeedDisplay = "Geschwindigkeit: ";

var meleePowerTitle = "Nahkampfangriffskraft ";
var meleePowerIncreasedDps = "Erhöht verursachten Schaden mit Nahkampfwaffen um "+ theCharacter.melee.power.increasedDps +" Schaden pro Sekunde.";
var meleePowerDisplay = "Kraft: ";

var meleeHitRatingTitle = "Trefferwertung ";
var meleeHitRatingIncreasedHitPercent = "Erhöht die Chance, ein Ziel mit Stufe "+ theCharacter.level +" zu treffen, um "+theCharacter.melee.hitRating.increasedHitPercent +"% <br/>Rüstungdurchschlagswertung " + theCharacter.melee.hitRating.armorPenetration + " (Verringert den Rüstungswert des Gegners um bis zu " + theCharacter.melee.hitRating.reducedArmorPercent + "%).";
var meleeHitRatingDisplay = "Trefferwertung: ";

var meleeCritChanceTitle = "Chance auf kritische Treffer ";
var meleeCritChanceRating = "Kritische Trefferwertung "+theCharacter.melee.critChance.rating+" (+"+theCharacter.melee.critChance.plusPercent+"% Chance auf kritische Treffer)";
var meleeCritChanceDisplay = "Kritisch: ";

/*******            Melee  End     ******/


/*******            Ranged     ******/

var rangedDisplay = "Distanzwaffen";
var rangedWeaponSkillTitle = "Distanzwaffenfertigkeit ";
var rangedWeaponSkillRating = "Distanzwaffenfertigkeitswert "+ theCharacter.ranged.weaponSkill.rating;
var rangedWeaponSkillDisplay = "Distanzwaffenfertigkeit: ";

var rangedDamageTitle = "Distanzwaffe";
var rangedDamageSpeed = "<span class='floatRight'>"+ theCharacter.ranged.damage.speed +"</span>Angriffstempo (Sek.):<br/>";
var rangedDamageDamage = "<span class='floatRight'>"+ theCharacter.ranged.damage.min +" - "+ theCharacter.ranged.damage.max;
var rangedDamageDamagePercent = " <span "+ theCharacter.ranged.damage.effectiveColor +"> x "+ theCharacter.ranged.damage.percent +"%</span><br/>";
var rangedDamageDisplay = "Schaden: ";
var rangedDamageDps = "<span class='floatRight'>"+ theCharacter.ranged.damage.dps +"</span>Schaden pro Sekunde:";

var rangedSpeedTitle = "Distanzangriffsgeschwindigkeit "+theCharacter.ranged.speed.value;
var rangedSpeedHaste = "Distanztempowertung "+ theCharacter.ranged.speed.hasteRating +" ("+theCharacter.ranged.speed.hastePercent+"% Hast)";
var rangedSpeedDisplay = "Tempo: ";

var rangedPowerTitle = "Distanzangriffskraft ";
var rangedPowerIncreasedDps = "Erhöht die Schadenswirkung mit Distanzwaffen um "+ theCharacter.ranged.power.increasedDps +" pro Sekunde.";
var rangedPowerPetAttack = "Erhöht die Angriffskraft Eures Begleiters um "+ theCharacter.ranged.power.petAttack;
var rangedPowerPetSpell = "Erhöht den Zauberschaden Eures Begleiters um "+ theCharacter.ranged.power.petSpell;
var rangedPowerDisplay = "Kraft: ";

var rangedHitRatingTitle = "Trefferwertung ";
var rangedHitRatingIncreasedPercent = "Erhöht die Trefferchance im Distanzkampf gegen ein Ziel der Stufe "+ theCharacter.level +" um "+theCharacter.ranged.hitRating.increasedHitPercent +"% <br/>Rüstungsdurchschlagwertung " + theCharacter.ranged.hitRating.armorPenetration + "(Rüstung des Ziels um bis zu " + theCharacter.ranged.hitRating.reducedArmorPercent + "% verringert).";
var rangedHitRatingDisplay = "Trefferwertung: ";

var rangedCritChanceTitle = "Kritisch ";
var rangedCritChanceRating = "Kritische Trefferwertung "+theCharacter.ranged.critChance.rating+" (+"+theCharacter.ranged.critChance.plusPercent+"% Kritisch)";
var rangedCritChanceDisplay = "Kritisch: ";

/*******            Ranged  End     ******/


/*******            Spell     ******/

var spellDisplay = "Zauber";
var spellBonusDamageTitle = "Schadensboni ";
var spellBonusDamagePetBonusFire = "<br />Euer Feuerschaden erhöht<br />die Angriffskraft Eures Begleiters um "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />und den Zauberschaden um "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamagePetBonusShadow = "<br />Euer Schattenschaden erhöht<br />die Angriffskraft Eures Begleiters um "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />und den Zauberschaden um "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamageDisplay = "Schadensboni: ";

var spellBonusHealingTitle = "Heilungsboni ";
var spellBonusHealingValue = "Erhöht die Heilung um bis zu "+theCharacter.spell.bonusHealing.value;
var spellBonusHealingDisplay = "Heilungsboni: ";

var spellHitRatingTitle = "Trefferwertung ";
var spellHitRatingIncreasedPercent = "Erhöht die Trefferchance mit Zaubern gegen ein Ziel der Stufe "+ theCharacter.level +" um "+theCharacter.spell.hitRating.increasedHitPercent +"%";
var spellHitRatingDisplay = "Trefferwertung: ";

var spellCritChanceTitle = "Kritische Trefferwertung ";
var spellCritChanceDisplay = "Kritisch: ";

var spellHasteRatingTitle = "Tempowertung";
var spellHasteRatingDisplay = "Tempowertung: ";
var spellHasteRatingTooltip = "Erhöht die Geschwindigkeit, mit der Zauber ausgeführt werden, um " + theCharacter.spell.hasteRating.percent + "%.";

var spellPenetrationTitle = "Durchschlag ";
var spellPenetrationTooltip = "<br />Zauberdurchschlagskraft " + theCharacter.spell.hitRating.spellPenetration + " (Verringert Widerstandsarten des Gegners um " + theCharacter.spell.hitRating.spellPenetration + ")";
var spellPenetrationDisplay = "Durchschlag: ";

var spellManaRegenTitle = "Manaregeneration ";
var spellManaRegenNotCasting = "Regeneriert alle 5 Sekunden "+ theCharacter.spell.manaRegen.notCasting +" Mana, wenn kein Zauber gewirkt wird";
var spellManaRegenCasting = "Regeneriert alle 5 Sekunden "+ theCharacter.spell.manaRegen.casting +" Mana, während ein Zauber gewirkt wird";
var spellManaRegenDisplay = "Manaregeneration: ";

/*******            Spell  End     ******/

/*******            Defenses     ******/

var defensesDisplay = "Verteidigung";

var defensesDefenseTitle = "Verteidigung ";
var defensesDefenseRating = "Verteidigungswertung "+ theCharacter.defenses.defense.rating +" (+"+ theCharacter.defenses.defense.plusDefense +" Verteidigung)";
var defensesDefenseIncreasePercent = "Erhöht die Ausweich-, Block- und Parierchance um "+ theCharacter.defenses.defense.increasePercent +"%";
var defensesDefenseDecreasePercent = "Verringert die Chance, dass Ihr getroffen oder kritisch getroffen werdet, um "+ theCharacter.defenses.defense.decreasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDefenseDisplay = "Verteidigung: ";

var defensesDodgeTitle = "Ausweichwertung ";
var defensesDodgePercent = "Erhöht die Ausweichchance um "+ theCharacter.defenses.dodge.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDodgeDisplay = "Ausweichen: ";

var defensesParryTitle = "Parierwertung ";
var defensesParryPercent = "Erhöht die Parierchance um "+ theCharacter.defenses.parry.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesParryDisplay ="Parieren: ";

var defensesBlockTitle = "Blockwertung ";
var defensesBlockPercent = "Erhöht die Blockchance um "+ theCharacter.defenses.block.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesBlockDisplay = "Blocken: ";

var defensesResilienceTitle = "Abhärtung ";
var defensesResilienceHitPercent = "Verhindert regelmäßig erlittenen Schaden und die Wahrscheinlichkeit, kritisch getroffen zu werden, um "+ theCharacter.defenses.resilience.hitPercent +"%.";
var defensesResilienceDamagePercent = "Verringert den Manaentzugeffekt sowie den Schaden durch kritische Treffer um "+ theCharacter.defenses.resilience.damagePercent +"%.";
var defensesResilienceDisplay = "Abhärtung: ";

/*******            Defenses  End     ******/

var textNA = "N/A";
var textNotApplicable = "Nicht anwendbar";

var textHoly = "Heilig";
var textFire = "Feuer";
var textNature = "Natur";
var textFrost = "Frost";
var textShadow = "Schatten";
var textArcane = "Arkan";

var textHybrid = "Hybride";
var textUntalented = "Untalentiert";

var textRating = "Teamwertung ";
var textNotRanked = "Kein Rang ";
var textStandingColon = "Rang Letzte Woche:";
var textRatingColon = "Teamwertung:";
var text2v2Arena = "Arena 2v2";
var text3v3Arena = "Arena 3v3";
var text5v5Arena = "Arena 5v5";
var textTeamNameColon = "Teamname:";

var textFindUpgrade = "Upgrade suchen";

var textLoading = "Wird Geladen...";


var textHead = "Kopf";
var textNeck = "Hals";
var textShoulders = "Schultern";
var textBack = "Rücken";
var textChest = "Brust";
var textShirt = "Hemd";
var textTabard = "Wappenrock";
var textWrists = "Handgelenke";
var textHands = "Hände";
var textWaist = "Taille";
var textLegs = "Beine";
var textFeet = "Füße";
var textFinger = "Finger";
var textTrinket = "Schmuck";
var textMainHand = "Waffenhand";
var textOffHand = "Nebenhand";
var textRanged = "Distanz";
var textRelic = "Relikt";
jsLoaded=true;