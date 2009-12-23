/*******            Resistances         ******/
var arcaneTooltip = '<span class="tooltipTitle">Arcane Resistance '+ theCharacter.resistances.arcane.value + theCharacter.resistances.arcane.breakdown +'</span><span class="tooltipContentSpecial">Increases the ability to resist arcane-based attacks, spells and abilities.<br/>Resistance against level '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.arcane.rank +'</span></span>';
var arcanePetBonus = "<span class = 'tooltipContentSpecial'>Increases your pet's Resistance by "+ theCharacter.resistances.arcane.petBonus + "</span>";

var fireTooltip = '<span class="tooltipTitle">Fire Resistance '+ theCharacter.resistances.fire.value + theCharacter.resistances.fire.breakdown +'</span><span class = "tooltipContentSpecial">Increases the ability to resist fire-based attacks, spells and abilities.<br/>Resistance against level '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.fire.rank +'</span></span>';
var firePetBonus = "<span class = 'tooltipContentSpecial'>Increases your pet's Resistance by "+ theCharacter.resistances.fire.petBonus + "</span>";

var natureTooltip = '<span class="tooltipTitle">Nature Resistance '+ theCharacter.resistances.nature.value + theCharacter.resistances.nature.breakdown +'</span><span class = "tooltipContentSpecial">Increases the ability to resist nature-based attacks, spells and abilities.<br/>Resistance against level '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.nature.rank +'</span></span>';
var naturePetBonus = "<span class = 'tooltipContentSpecial'>Increases your pet's Resistance by "+ theCharacter.resistances.nature.petBonus + "</span>";

var frostTooltip = '<span class="tooltipTitle">Frost Resistance '+ theCharacter.resistances.frost.value + theCharacter.resistances.frost.breakdown +'</span><span class = "tooltipContentSpecial">Increases the ability to resist frost-based attacks, spells and abilities.<br/>Resistance against level '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.frost.rank +'</span></span>';
var frostPetBonus = "<span class = 'tooltipContentSpecial'>Increases your pet's Resistance by "+ theCharacter.resistances.frost.petBonus + "</span>";

var shadowTooltip = '<span class="tooltipTitle">Shadow Resistance '+ theCharacter.resistances.shadow.value + theCharacter.resistances.shadow.breakdown +'</span><span class = "tooltipContentSpecial">Increases the ability to resist shadow-based attacks, spells and abilities.<br/>Resistance against level '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.shadow.rank +'</span></span>';
var shadowPetBonus = "<span class = 'tooltipContentSpecial'>Increases your pet's Resistance by "+ theCharacter.resistances.shadow.petBonus + "</span>";

/*******            Resistances End       ******/


/*******            Base Stats       ******/

var baseStatsDisplay = "Base Stats";

var baseStatsStrengthTitle = "Strength ";
var baseStatsStrengthAttack = "Increases Attack Power by "+theCharacter.baseStats.strength.attack;
var baseStatsStrengthBlock = "Increases Block by "+theCharacter.baseStats.strength.block+" <br/>";
var baseStatsStrengthDisplay = "Strength: ";

var baseStatsAgilityTitle = "Agility ";
var baseStatsAgilityAttack = "Increases Attack Power by "+theCharacter.baseStats.agility.attack;
var baseStatsAgilityCritHitPercent = "Increases Critical Hit chance by "+ theCharacter.baseStats.agility.critHitPercent +"%";
var baseStatsAgilityArmor = "Increases Armor by "+ theCharacter.baseStats.agility.armor;
var baseStatsAgilityDisplay = "Agility: ";

var baseStatsStaminaTitle = "Stamina ";
var baseStatsStaminaHealth = "Increases Health by "+ theCharacter.baseStats.stamina.health;
var baseStatsStaminaPetBonus = "Increases Pet Stamina by "+ theCharacter.baseStats.stamina.petBonus;
var baseStatsStaminaDisplay = "Stamina: ";

var baseStatsIntellectTitle = "Intellect ";
var baseStatsIntellectMana = "Increases Mana by "+ theCharacter.baseStats.intellect.mana;
var baseStatsIntellectCritHitPercent = "Increases Spell Critical Hit by "+ theCharacter.baseStats.intellect.critHitPercent + "%";
var baseStatsIntellectPetBonus = "Increases your Pet's Intellect by "+ theCharacter.baseStats.intellect.petBonus;
var baseStatsIntellectDisplay = "Intellect: ";

var baseStatsSpiritTitle = "Spirit ";
var baseStatsSpiritHealthRegen = "Increases Health Regeneration by "+ theCharacter.baseStats.spirit.healthRegen +" Per Second while not in combat";
var baseStatsSpiritManaRegen = "Increases Mana Regeneration by "+ theCharacter.baseStats.spirit.manaRegen +" Per 5 Seconds while not casting";
var baseStatsSpiritDisplay = "Spirit: ";

var baseStatsArmorTitle = "Armor ";
var baseStatsArmorReductionPercent = "Reduces Physical Damage taken by "+ theCharacter.baseStats.armor.reductionPercent +"%";
var baseStatsArmorPetBonus = "Increases your pet's Armor by "+ theCharacter.baseStats.armor.petBonus;
var baseStatsArmorDisplay = "Armor: ";

/*******            Base Stats  End     ******/


/*******            Melee     ******/

var meleeDisplay = "Melee";

var meleeMainHandTitle = "Main Hand";
var meleeOffHandTitle = "Off Hand";

var meleeExpertiseTitle = "Expertise "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.rating;
var meleeMainHandWeaponSkill = "Reduces chance to be dodged or parried by "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.percent + "%";
var meleeMainHandWeaponRating = "Expertise rating "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.value + " (+"+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.additional +" expertise)";
/*var meleeOffHandWeaponSkill = "Weapon Skill "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.value;
var meleeOffHandWeaponRating = "Weapon Skill Rating "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.rating;*/
var meleeWeaponSkillDisplay = "Expertise: ";

var meleeDamageMainHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.speed +"</span>Attack Speed (seconds):<br/>";
var meleeDamageMainHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.min +" - "+ theCharacter.melee.damage.mainHandDamage.max;
var meleeDamageMainHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.mainHandDamage.percent +"%</span>";
var meleeDamageDisplay = "Damage: ";

var meleeDamageMainHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.dps +"</span>Damage per Second:";
var meleeDamageOffHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.speed +"</span>Attack Speed (seconds):<br/>";
var meleeDamageOffHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.min +" - "+ theCharacter.melee.damage.offHandDamage.max;
var meleeDamageOffHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.offHandDamage.percent +"%</span>";
var meleeDamageOffHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.dps +"</span>Damage per Second:<br/>";

var meleeSpeedTitle = "Attack Speed ";
var meleeSpeedHaste = "Haste rating "+ theCharacter.melee.speed.mainHandSpeed.hasteRating +" ("+theCharacter.melee.speed.mainHandSpeed.hastePercent+"% haste)";
var meleeSpeedDisplay = "Speed: ";

var meleePowerTitle = "Melee Attack Power ";
var meleePowerIncreasedDps = "Increases damage with melee weapons by "+ theCharacter.melee.power.increasedDps +" damage per second.";
var meleePowerDisplay = "Power";

var meleeHitRatingTitle = "Hit Rating ";
var meleeHitRatingIncreasedHitPercent = "Increases your melee chance to hit a target of level "+ theCharacter.level +" by "+theCharacter.melee.hitRating.increasedHitPercent +"% <br/>Armor penetration rating " + theCharacter.melee.hitRating.armorPenetration + " (Enemy armor reduced by up to " + theCharacter.melee.hitRating.reducedArmorPercent + "%).";
var meleeHitRatingDisplay = "Hit Rating: ";

var meleeCritChanceTitle = "Crit Chance ";
var meleeCritChanceRating = "Crit rating "+theCharacter.melee.critChance.rating+" (+"+theCharacter.melee.critChance.plusPercent+"% crit chance)";
var meleeCritChanceDisplay = "Crit Chance: ";

/*******            Melee  End     ******/


/*******            Ranged     ******/

var rangedDisplay = "Ranged";
var rangedWeaponSkillTitle = "Weapon Skill ";
var rangedWeaponSkillRating = "Weapon Skill Rating "+ theCharacter.ranged.weaponSkill.rating;
var rangedWeaponSkillDisplay = "Weapon Skill: ";

var rangedDamageTitle = "Ranged";
var rangedDamageSpeed = "<span class='floatRight'>"+ theCharacter.ranged.damage.speed +"</span>Attack Speed (seconds):<br/>";
var rangedDamageDamage = "<span class='floatRight'>"+ theCharacter.ranged.damage.min +" - "+ theCharacter.ranged.damage.max;
var rangedDamageDamagePercent = " <span "+ theCharacter.ranged.damage.effectiveColor +"> x "+ theCharacter.ranged.damage.percent +"%</span><br/>";
var rangedDamageDisplay = "Damage: ";
var rangedDamageDps = "<span class='floatRight'>"+ theCharacter.ranged.damage.dps +"</span>Damage per Second: ";

var rangedSpeedTitle = "Attack Speed "+theCharacter.ranged.speed.value;
var rangedSpeedHaste = "Haste rating "+ theCharacter.ranged.speed.hasteRating +" ("+theCharacter.ranged.speed.hastePercent+"% haste)";
var rangedSpeedDisplay = "Speed: ";

var rangedPowerTitle = "Ranged Attack Power ";
var rangedPowerIncreasedDps = "Increases damage with ranged weapons by "+ theCharacter.ranged.power.increasedDps +" damage per second.";
var rangedPowerPetAttack = "Increases your pet's Attack Power by "+ theCharacter.ranged.power.petAttack;
var rangedPowerPetSpell = "Increases your pet's Spell Damage by "+ theCharacter.ranged.power.petSpell;
var rangedPowerDisplay = "Power: ";

var rangedHitRatingTitle = "Hit Rating ";
var rangedHitRatingIncreasedPercent = "Increases your ranged chance to hit a target of level "+ theCharacter.level +" by "+theCharacter.ranged.hitRating.increasedHitPercent +"% <br/>Armor penetration rating " + theCharacter.ranged.hitRating.armorPenetration + " (Enemy armor reduced by up to " + theCharacter.ranged.hitRating.reducedArmorPercent + "%).";
var rangedHitRatingDisplay = "Hit Rating: ";

var rangedCritChanceTitle = "Crit Chance ";
var rangedCritChanceRating = "Crit rating "+theCharacter.ranged.critChance.rating+" (+"+theCharacter.ranged.critChance.plusPercent+"% crit chance)";
var rangedCritChanceDisplay = "Crit Chance: ";

/*******            Ranged  End     ******/


/*******            Spell     ******/

var spellDisplay = "Spell";
var spellBonusDamageTitle = "Bonus Damage ";
var spellBonusDamagePetBonusFire = "<br />Your Fire Damage increases<br />your pet's Attack Power by "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />and Spell Damage by "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamagePetBonusShadow = "<br />Your Shadow Damage increases<br />your pet's Attack Power by "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />and Spell Damage by "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamageDisplay = "Bonus Damage:";

var spellBonusHealingTitle = "Bonus Healing ";
var spellBonusHealingValue = "Increases your healing by up to "+theCharacter.spell.bonusHealing.value;
var spellBonusHealingDisplay = "Bonus Healing: ";

var spellHitRatingTitle = "Hit Rating ";
var spellHitRatingIncreasedPercent = "Increases your spell chance to hit a target of level "+ theCharacter.level +" by "+theCharacter.spell.hitRating.increasedHitPercent +"%";
var spellHitRatingDisplay = "Hit Rating: ";

var spellCritChanceTitle = "Crit Rating ";
var spellCritChanceDisplay = "Crit Chance: ";

var spellHasteRatingTitle = "Haste Rating";
var spellHasteRatingDisplay = "Haste Rating: ";
var spellHasteRatingTooltip = "Increases the speed that your spells cast by " + theCharacter.spell.hasteRating.percent + "%.";

var spellPenetrationTitle = "Penetration";
var spellPenetrationTooltip = "<br />Spell Penetration " + theCharacter.spell.hitRating.spellPenetration + " (Reduces enemy resistances by " + theCharacter.spell.hitRating.spellPenetration + ")";
var spellPenetrationDisplay = "Penetration: ";

var spellManaRegenTitle = "Mana Regen ";
var spellManaRegenNotCasting = theCharacter.spell.manaRegen.notCasting +" mana regenerated every 5 seconds while not casting";
var spellManaRegenCasting = theCharacter.spell.manaRegen.casting +" mana regenerated every 5 seconds while casting";
var spellManaRegenDisplay = "Mana Regen: ";

/*******            Spell  End     ******/

/*******            Defenses     ******/

var defensesDisplay = "Defense";

var defensesDefenseTitle = "Defense ";
var defensesDefenseRating = "Defense Rating "+ theCharacter.defenses.defense.rating +" (+"+ theCharacter.defenses.defense.plusDefense +" Defense)";
var defensesDefenseIncreasePercent = "Increases chance to Dodge, Block and Parry by "+ theCharacter.defenses.defense.increasePercent +"%";
var defensesDefenseDecreasePercent = "Decreases chance to be hit and critically hit by "+ theCharacter.defenses.defense.decreasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDefenseDisplay = "Defense: ";

var defensesDodgeTitle = "Dodge Rating ";
var defensesDodgePercent = "Increases your chance to Dodge by "+ theCharacter.defenses.dodge.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDodgeDisplay = "Dodge: ";

var defensesParryTitle = "Parry ";
var defensesParryPercent = "Increases your chance to Parry by "+ theCharacter.defenses.parry.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesParryDisplay ="Parry: ";

var defensesBlockTitle = "Block Rating ";
var defensesBlockPercent = "Increases your chance to Block by "+ theCharacter.defenses.block.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesBlockDisplay = "Block: ";

var defensesResilienceTitle = "Resilience ";
var defensesResilienceHitPercent = "Reduces periodic damage and chance to be critically hit by "+ theCharacter.defenses.resilience.hitPercent +"%.";
var defensesResilienceDamagePercent = "Reduces the effect of mana-drains and the damange of critical strikes by "+ theCharacter.defenses.resilience.damagePercent +"%.";
var defensesResilienceDisplay = "Resilience: ";

/*******            Defenses  End     ******/

var textNA = "N/A";
var textNotApplicable = "Not Applicable";

var textHoly = "Holy";
var textFire = "Fire";
var textNature = "Nature";
var textFrost = "Frost";
var textShadow = "Shadow";
var textArcane = "Arcane";

var textHybrid = "Hybrid";
var textUntalented = "Untalented";

var textRating = "Rating ";
var textNotRanked = "Not Ranked";
var textStandingColon = "Last Week's Rank:";
var textRatingColon = "Rating:";
var text2v2Arena = "2v2 Arena";
var text3v3Arena = "3v3 Arena";
var text5v5Arena = "5v5 Arena";
var textTeamNameColon = "Team Name:";

var textFindUpgrade = "Find an Upgrade";

var textLoading = "Loading...";


var textHead = "Head";
var textNeck = "Neck";
var textShoulders = "Shoulders";
var textBack = "Back";
var textChest = "Chest";
var textShirt = "Shirt";
var textTabard = "Tabard";
var textWrists = "Wrists";
var textHands = "Hands";
var textWaist = "Waist";
var textLegs = "Legs";
var textFeet = "Feet";
var textFinger = "Finger";
var textTrinket = "Trinket";
var textMainHand = "Main Hand";
var textOffHand = "Off Hand";
var textRanged = "Ranged";
var textRelic = "Relic";
jsLoaded=true;