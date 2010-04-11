/*******            Resistances         ******/
var arcaneTooltip = '<span class="tooltipTitle">Résistance aux Arcanes '+ theCharacter.resistances.arcane.value + theCharacter.resistances.arcane.breakdown +'</span><span class="tooltipContentSpecial">Augmente la capacité à résister aux attaques, sorts et techniques de type Arcane.<br/>Résistance contre le niveau '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.arcane.rank +'</span></span>';
var arcanePetBonus = "<span class = 'tooltipContentSpecial'>Augmente la résistance de votre familier de "+ theCharacter.resistances.arcane.petBonus + "</span>";

var fireTooltip = '<span class="tooltipTitle">Résistance au Feu '+ theCharacter.resistances.fire.value + theCharacter.resistances.fire.breakdown +'</span><span class = "tooltipContentSpecial">Augmente la capacité à résister aux attaques, sorts et techniques de type Feu.<br/>Résistance contre le niveau '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.fire.rank +'</span></span>';
var firePetBonus = "<span class = 'tooltipContentSpecial'>Augmente la résistance de votre familier de "+ theCharacter.resistances.fire.petBonus + "</span>";

var natureTooltip = '<span class="tooltipTitle">Résistance à la Nature '+ theCharacter.resistances.nature.value + theCharacter.resistances.nature.breakdown +'</span><span class = "tooltipContentSpecial">Augmente la capacité à résister aux attaques, sorts et techniques de type Nature.<br/>Résistance contre le niveau '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.nature.rank +'</span></span>';
var naturePetBonus = "<span class = 'tooltipContentSpecial'>Augmente la résistance de votre familier de "+ theCharacter.resistances.nature.petBonus + "</span>";

var frostTooltip = '<span class="tooltipTitle">Résistance au Givre '+ theCharacter.resistances.frost.value + theCharacter.resistances.frost.breakdown +'</span><span class = "tooltipContentSpecial">Augmente la capacité à résister aux attaques, sorts et techniques de type Givre.<br/>Résistance contre le niveau '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.frost.rank +'</span></span>';
var frostPetBonus = "<span class = 'tooltipContentSpecial'>Augmente la résistance de votre familier de "+ theCharacter.resistances.frost.petBonus + "</span>";

var shadowTooltip = '<span class="tooltipTitle">Résistance à l’Ombre '+ theCharacter.resistances.shadow.value + theCharacter.resistances.shadow.breakdown +'</span><span class = "tooltipContentSpecial">Augmente la capacité à résister aux attaques, sorts et techniques de type Ombre.<br/>Résistance contre le niveau '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.shadow.rank +'</span></span>';
var shadowPetBonus = "<span class = 'tooltipContentSpecial'>Augmente la résistance de votre familier de "+ theCharacter.resistances.shadow.petBonus + "</span>";

/*******            Resistances End       ******/


/*******            Base Stats       ******/

var baseStatsDisplay = "Caractéristiques de base";

var baseStatsStrengthTitle = "Force ";
var baseStatsStrengthAttack = "Augmente la puissance d’attaque de "+theCharacter.baseStats.strength.attack;
var baseStatsStrengthBlock = "Augmente le blocage de "+theCharacter.baseStats.strength.block+" <br/>";
var baseStatsStrengthDisplay = "Force&#160;: ";

var baseStatsAgilityTitle = "Agilité ";
var baseStatsAgilityAttack = "Augmente la puissance d’attaque de "+theCharacter.baseStats.agility.attack;
var baseStatsAgilityCritHitPercent = "Augmente les chances d’infliger un coup critique de "+ theCharacter.baseStats.agility.critHitPercent +"%";
var baseStatsAgilityArmor = "Augmente l’armure de "+ theCharacter.baseStats.agility.armor;
var baseStatsAgilityDisplay = "Agilité&#160;: ";

var baseStatsStaminaTitle = "Endurance ";
var baseStatsStaminaHealth = "Augmente les points de vie de "+ theCharacter.baseStats.stamina.health;
var baseStatsStaminaPetBonus = "Augmente l’endurance de votre familier de "+ theCharacter.baseStats.stamina.petBonus;
var baseStatsStaminaDisplay = "Endurance&#160;: ";

var baseStatsIntellectTitle = "Intelligence ";
var baseStatsIntellectMana = "Augmente les points de mana de "+ theCharacter.baseStats.intellect.mana;
var baseStatsIntellectCritHitPercent = "Augmente le score de critiques avec les sorts de "+ theCharacter.baseStats.intellect.critHitPercent + "%";
var baseStatsIntellectPetBonus = "Augmente l’intelligence de votre familier de "+ theCharacter.baseStats.intellect.petBonus;
var baseStatsIntellectDisplay = "Intelligence&#160;: ";

var baseStatsSpiritTitle = "Esprit ";
var baseStatsSpiritHealthRegen = "Améliore la régénération de points de vie de "+ theCharacter.baseStats.spirit.healthRegen +" par seconde en dehors des combats";
var baseStatsSpiritManaRegen = "Augmente la régénération de mana de "+ theCharacter.baseStats.spirit.manaRegen +" toutes les 5 secondes quand vous ne lancez pas de sort";
var baseStatsSpiritDisplay = "Esprit&#160;: ";

var baseStatsArmorTitle = "Armure ";
var baseStatsArmorReductionPercent = "Réduit les dégâts physiques reçus de "+ theCharacter.baseStats.armor.reductionPercent +"%";
var baseStatsArmorPetBonus = "Augmente l’armure de votre familier de "+ theCharacter.baseStats.armor.petBonus;
var baseStatsArmorDisplay = "Armure&#160;: ";

/*******            Base Stats  End     ******/


/*******            Melee     ******/

var meleeDisplay = "En mêlée";

var meleeMainHandTitle = "Main droite";
var meleeOffHandTitle = "Main gauche";

var meleeExpertiseTitle = "Expertise "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.rating;
var meleeMainHandWeaponSkill = "Réduit les chances de votre adversaire d'esquiver ou de parer de "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.percent + "%";
var meleeMainHandWeaponRating = "Score d'expertise "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.value + " (+"+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.additional +" expertise)";
/*var meleeOffHandWeaponSkill = "Weapon Skill "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.value;
var meleeOffHandWeaponRating = "Weapon Skill Rating "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.rating;*/
var meleeWeaponSkillDisplay = "Expertise&#160;: ";

var meleeDamageMainHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.speed +"</span>Vitesse d’attaque (secondes)&#160;:<br/>";
var meleeDamageMainHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.min +" - "+ theCharacter.melee.damage.mainHandDamage.max;
var meleeDamageMainHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.mainHandDamage.percent +"%</span>";
var meleeDamageDisplay = "Dégâts&#160;: ";

var meleeDamageMainHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.dps +"</span>Dégâts par seconde&#160;:";
var meleeDamageOffHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.speed +"</span>Vitesse d’attaque (secondes)&#160;:<br/>";
var meleeDamageOffHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.min +" - "+ theCharacter.melee.damage.offHandDamage.max;
var meleeDamageOffHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.offHandDamage.percent +"%</span>";
var meleeDamageOffHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.dps +"</span>Dégâts par seconde&#160;:<br/>";

var meleeSpeedTitle = "Vitesse d’attaque ";
var meleeSpeedHaste = "Score de hâte "+ theCharacter.melee.speed.mainHandSpeed.hasteRating +" ("+theCharacter.melee.speed.mainHandSpeed.hastePercent+"% hâte)";
var meleeSpeedDisplay = "Vitesse&#160;: ";

var meleePowerTitle = "Puissance d’attaque en mêlée ";
var meleePowerIncreasedDps = "Augmente les points de dégâts infligés avec des armes de mêlée de "+ theCharacter.melee.power.increasedDps +" points de dégâts par seconde.";
var meleePowerDisplay = "Puissance&#160;: ";

var meleeHitRatingTitle = "Sc. toucher ";
var meleeHitRatingIncreasedHitPercent = "Augmente vos chances de toucher une cible de niveau "+ theCharacter.level +" de "+theCharacter.melee.hitRating.increasedHitPercent +"% <br/>Score de pénétration d'armure " + theCharacter.melee.hitRating.armorPenetration + " (armure ennemie réduite d'un maximum de " + theCharacter.melee.hitRating.reducedArmorPercent + "%).";
var meleeHitRatingDisplay = "Sc. toucher&#160;: ";

var meleeCritChanceTitle = "Critiques ";
var meleeCritChanceRating = "Sc. crit. "+theCharacter.melee.critChance.rating+" (+"+theCharacter.melee.critChance.plusPercent+"% de critique)";
var meleeCritChanceDisplay = "Critiques&#160;: ";

/*******            Melee  End     ******/


/*******            Ranged     ******/

var rangedDisplay = "À distance";
var rangedWeaponSkillTitle = "Comp. d’arme ";
var rangedWeaponSkillRating = "Score de compétence d’arme "+ theCharacter.ranged.weaponSkill.rating;
var rangedWeaponSkillDisplay = "Comp. d’arme&#160;: ";

var rangedDamageTitle = "À distance";
var rangedDamageSpeed = "<span class='floatRight'>"+ theCharacter.ranged.damage.speed +"</span>Vitesse d’attaque (secondes)&#160;:<br/>";
var rangedDamageDamage = "<span class='floatRight'>"+ theCharacter.ranged.damage.min +" - "+ theCharacter.ranged.damage.max;
var rangedDamageDamagePercent = " <span "+ theCharacter.ranged.damage.effectiveColor +"> x "+ theCharacter.ranged.damage.percent +"%</span><br/>";
var rangedDamageDisplay = "Dégâts&#160;: ";
var rangedDamageDps = "<span class='floatRight'>"+ theCharacter.ranged.damage.dps +"</span>Dégâts par seconde&#160;: ";

var rangedSpeedTitle = "Vitesse d’attaque "+theCharacter.ranged.speed.value;
var rangedSpeedHaste = "Score de hâte "+ theCharacter.ranged.speed.hasteRating +" ("+theCharacter.ranged.speed.hastePercent+"% hâte)";
var rangedSpeedDisplay = "Vitesse&#160;: ";

var rangedPowerTitle = "Puissance d’attaque à distance ";
var rangedPowerIncreasedDps = "Augmente les points de dégâts infligés avec des armes à distance de "+ theCharacter.ranged.power.increasedDps +" points de dégâts par seconde.";
var rangedPowerPetAttack = "Augmente la puissance d’attaque de votre familier de "+ theCharacter.ranged.power.petAttack;
var rangedPowerPetSpell = "Augmente les dégâts des sorts de votre familier de "+ theCharacter.ranged.power.petSpell;
var rangedPowerDisplay = "Puissance&#160;: ";

var rangedHitRatingTitle = "Sc. toucher ";
var rangedHitRatingIncreasedPercent = "Augmente vos chances de toucher une cible de niveau "+ theCharacter.level +" avec une attaque à distance de "+theCharacter.ranged.hitRating.increasedHitPercent +"% <br/>Score de pénétration d'armure " + theCharacter.ranged.hitRating.armorPenetration + " (armure ennemie réduite d'un maximum de " + theCharacter.ranged.hitRating.reducedArmorPercent + "%).";
var rangedHitRatingDisplay = "Sc. toucher&#160;: ";

var rangedCritChanceTitle = "Critiques ";
var rangedCritChanceRating = "Score crit. "+theCharacter.ranged.critChance.rating+" (+"+theCharacter.ranged.critChance.plusPercent+"% de critique)";
var rangedCritChanceDisplay = "Critiques&#160;: ";

/*******            Ranged  End     ******/


/*******            Spell     ******/

var spellDisplay = "Sortilèges";
var spellBonusDamageTitle = "Bon. dégâts ";
var spellBonusDamagePetBonusFire = "<br />Vos dégâts de Feu augmentent<br />la puissance d’attaque de votre familier de "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />et ses dégâts des sorts de "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamagePetBonusShadow = "<br />Vos dégâts d’Ombre augmentent<br />la puissance d’attaque de votre familier de "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />et ses dégâts des sorts de "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamageDisplay = "Bon. dégâts&#160;: ";

var spellBonusHealingTitle = "Bon. soins ";
var spellBonusHealingValue = "Augmente les soins prodigués jusqu’à "+theCharacter.spell.bonusHealing.value +" de plus.";
var spellBonusHealingDisplay = "Bon. soins&#160;:";

var spellHitRatingTitle = "Sc. toucher ";
var spellHitRatingIncreasedPercent = "Augmente les chances que vos sorts touchent une cible de niveau "+ theCharacter.level +" de "+theCharacter.spell.hitRating.increasedHitPercent +"%";
var spellHitRatingDisplay = "Sc. toucher&#160;: ";

var spellCritChanceTitle = "Critiques ";
var spellCritChanceDisplay = "Critiques&#160;: ";

var spellHasteRatingTitle = "Score de hâte";
var spellHasteRatingDisplay = "Score de hâte : ";
var spellHasteRatingTooltip = "Augmente la vitesse d'incantation de vos sorts de " + theCharacter.spell.hasteRating.percent + "%.";

var spellPenetrationTitle = "Pénétration";
var spellPenetrationTooltip = "<br />Pénétration des sorts " + theCharacter.spell.hitRating.spellPenetration + " (Réduit la résistance adverse de " + theCharacter.spell.hitRating.spellPenetration + ")";
var spellPenetrationDisplay = "Pénétration&#160;: ";

var spellManaRegenTitle = "Régén. mana ";
var spellManaRegenNotCasting = theCharacter.spell.manaRegen.notCasting +" points de mana régénérés toutes les 5 secondes sans incantation";
var spellManaRegenCasting = theCharacter.spell.manaRegen.casting +" points de mana régénérés toutes les 5 secondes pendant une incantation";
var spellManaRegenDisplay = "Régén. mana&#160;: ";

/*******            Spell  End     ******/

/*******            Defenses     ******/

var defensesDisplay = "Défense";

var defensesDefenseTitle = "Défense ";
var defensesDefenseRating = "Score de défense "+ theCharacter.defenses.defense.rating +" (+"+ theCharacter.defenses.defense.plusDefense +" Défense)";
var defensesDefenseIncreasePercent = "Augmente vos chances d’esquiver, bloquer et parer de "+ theCharacter.defenses.defense.increasePercent +"%";
var defensesDefenseDecreasePercent = "Réduit la probabilité que vous soyez touché et que vous subissiez des coups critiques de "+ theCharacter.defenses.defense.decreasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDefenseDisplay = "Défense&#160;: ";

var defensesDodgeTitle = "Score d’esquive ";
var defensesDodgePercent = "Augmente vos chances d’esquiver de "+ theCharacter.defenses.dodge.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDodgeDisplay = "Esquive&#160;: ";

var defensesParryTitle = "Score de parade ";
var defensesParryPercent = "Augmente vos chances de parer de "+ theCharacter.defenses.parry.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesParryDisplay ="Parade&#160;: ";

var defensesBlockTitle = "Score de blocage ";
var defensesBlockPercent = "Augmente vos chances de bloquer de "+ theCharacter.defenses.block.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesBlockDisplay = "Blocage&#160;: ";

var defensesResilienceTitle = "Résilience ";
var defensesResilienceHitPercent = "Diminue les dégâts des sources de dégâts périodiques et les chances de recevoir un coup critique de "+ theCharacter.defenses.resilience.hitPercent +"%.";
var defensesResilienceDamagePercent = "Diminue les dégâts des sources de dégâts périodiques et les chances de recevoir un coup critique de "+ theCharacter.defenses.resilience.damagePercent +"%.";
var defensesResilienceDisplay = "Résilience&#160;: ";

/*******            Defenses  End     ******/

var textNA = "N-A";
var textNotApplicable = "Non applicable";

var textHoly = "Sacré";
var textFire = "Feu";
var textNature = "Nature";
var textFrost = "Givre";
var textShadow = "Ombre";
var textArcane = "Arcane";

var textHybrid = "Hybride";
var textUntalented = "Sans talent";

var textRating = "Cote de ";
var textNotRanked = "Sans classement";
var textStandingColon = "Classement semaine dernière&#160;:";
var textRatingColon = "Cote&#160;:";
var text2v2Arena = "Arène 2c2";
var text3v3Arena = "Arène 3c3";
var text5v5Arena = "Arène 5c5";
var textTeamNameColon = "Équipe&#160;:";

var textFindUpgrade = "Trouver mieux";

var textLoading = "Chargement...";

/*******    ******/
var textHead = "Tête";
var textNeck = "Cou";
var textShoulders = "Épaules";
var textBack = "Dos";
var textChest = "Torse";
var textShirt = "Chemise";
var textTabard = "Tabard";
var textWrists = "Poignets";
var textHands = "Mains";
var textWaist = "Taille";
var textLegs = "Jambes";
var textFeet = "Pieds";
var textFinger = "Doigt";
var textTrinket = "Bijou";
var textMainHand = "Main droite";
var textOffHand = "Main gauche";
var textRanged = "À distance";
var textRelic = "Relique";
jsLoaded=true;